<?php

use App\Models\ModuleProgress;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('only lecturer can configure google drive folder link and student form hides opsional and drive_url', function () {
    $student = User::factory()->create(['role' => 'student']);
    $lecturer = User::factory()->create(['role' => 'lecturer']);

    $this->actingAs($student)
        ->post(route('dosen.drive.update'), [
            'drive_folder_url' => 'https://drive.google.com/drive/folders/1AbCdEfGhIjK',
            'drive_note' => 'Format: NIM_Nama_JobsheetXX.pdf',
        ])
        ->assertForbidden();

    $this->actingAs($lecturer)
        ->post(route('dosen.drive.update'), [
            'drive_folder_url' => 'https://drive.google.com/drive/folders/1AbCdEfGhIjK',
            'drive_note' => 'Format: NIM_Nama_JobsheetXX.pdf',
        ])
        ->assertRedirect();

    $this->actingAs($student)
        ->get(route('laporan'))
        ->assertOk()
        ->assertSee('https://drive.google.com/drive/folders/1AbCdEfGhIjK')
        ->assertSee('Format: NIM_Nama_JobsheetXX.pdf')
        ->assertDontSee('(opsional)')
        ->assertDontSee('name="drive_url"', false);
});

test('non google drive url is rejected for folder setting and student report submission', function () {
    $student = User::factory()->create(['role' => 'student']);
    $lecturer = User::factory()->create(['role' => 'lecturer']);

    $this->actingAs($lecturer)
        ->post(route('dosen.drive.update'), [
            'drive_folder_url' => 'https://example.com/not-drive',
        ])
        ->assertSessionHasErrors('drive_folder_url');

    $this->actingAs($student)
        ->post(route('laporan.store'), [
            'module' => 'Jobsheet 01',
            'drive_url' => 'https://example.com/file.pdf',
            'report_title' => 'Laporan_01.pdf',
        ])
        ->assertSessionHasErrors('drive_url');
});

test('student confirms upload to lecturer drive folder and authorized users redirect to it', function () {
    $student = User::factory()->create(['role' => 'student']);
    $otherStudent = User::factory()->create(['role' => 'student']);
    $lecturer = User::factory()->create(['role' => 'lecturer']);

    $this->actingAs($student)
        ->post(route('laporan.store'), [
            'confirm_drive' => '1',
            'module' => 'Jobsheet 03',
            'report_title' => 'Laporan_Jobsheet03_Budi.pdf',
        ])
        ->assertSessionHasErrors('confirm_drive');

    $lecturerDriveUrl = 'https://drive.google.com/drive/folders/1LecturerFolderXYZ';

    $this->actingAs($lecturer)
        ->post(route('dosen.drive.update'), [
            'drive_folder_url' => $lecturerDriveUrl,
        ])
        ->assertRedirect();

    $this->actingAs($student)
        ->post(route('laporan.store'), [
            'confirm_drive' => '1',
            'module' => 'Jobsheet 03',
            'report_title' => 'Laporan_Jobsheet03_Budi.pdf',
        ])
        ->assertRedirect();

    $report = Report::query()->first();
    expect($report)->not->toBeNull()
        ->and($report->file_path)->toBe($lecturerDriveUrl)
        ->and($report->original_name)->toBe('Laporan_Jobsheet03_Budi.pdf')
        ->and(ModuleProgress::query()
            ->where('user_id', $student->id)
            ->where('module', 'Jobsheet 03')
            ->where('activity', 'report_submitted')
            ->exists())->toBeTrue();

    $this->actingAs($otherStudent)
        ->get(route('laporan.download', $report))
        ->assertForbidden();

    $this->actingAs($student)
        ->get(route('laporan.download', $report))
        ->assertRedirect($lecturerDriveUrl);

    $this->actingAs($lecturer)
        ->get(route('laporan.download', $report))
        ->assertRedirect($lecturerDriveUrl);
});

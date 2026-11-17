<?php

use App\Models\Report;
use App\Models\User;
use App\Support\CloudflareR2Storage;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('cloudflare r2 helper signs deterministic AWS SigV4 PUT and GET URLs', function () {
    config()->set('filesystems.disks.r2', [
        'driver' => 's3',
        'account_id' => 'demoaccount123',
        'key' => 'testaccesskey',
        'secret' => 'testsecretkey',
        'region' => 'auto',
        'bucket' => 'laporan-praktikum',
        'endpoint' => 'https://demoaccount123.r2.cloudflarestorage.com',
        'use_path_style_endpoint' => true,
    ]);

    $r2 = app(CloudflareR2Storage::class);
    $fixedNow = CarbonImmutable::parse('2026-11-17 12:00:00', 'UTC');

    expect($r2->isConfigured())->toBeTrue();

    $putUrl = $r2->presignPutUrl('reports/7/sample-laporan.pdf', 900, $fixedNow);
    $getUrl = $r2->presignGetUrl('reports/7/sample-laporan.pdf', 600, $fixedNow);

    expect($putUrl)
        ->toStartWith('https://demoaccount123.r2.cloudflarestorage.com/laporan-praktikum/reports/7/sample-laporan.pdf?')
        ->toContain('X-Amz-Algorithm=AWS4-HMAC-SHA256')
        ->toContain('X-Amz-Credential=testaccesskey%2F20261117%2Fauto%2Fs3%2Faws4_request')
        ->toContain('X-Amz-Expires=900')
        ->toContain('X-Amz-Signature=');

    expect($getUrl)
        ->toContain('X-Amz-Expires=600')
        ->toContain('X-Amz-Signature=');

    expect($r2->isValidUserReportKey(7, 'reports/7/laporan-abc.pdf'))->toBeTrue()
        ->and($r2->isValidUserReportKey(7, 'reports/8/laporan-abc.pdf'))->toBeFalse()
        ->and($r2->isValidUserReportKey(7, '../reports/7/laporan-abc.pdf'))->toBeFalse();
});

test('authenticated student can request presigned URL and store R2 report metadata', function () {
    config()->set('filesystems.disks.r2', [
        'driver' => 's3',
        'account_id' => 'demoaccount123',
        'key' => 'testaccesskey',
        'secret' => 'testsecretkey',
        'region' => 'auto',
        'bucket' => 'laporan-praktikum',
        'endpoint' => 'https://demoaccount123.r2.cloudflarestorage.com',
        'use_path_style_endpoint' => true,
    ]);

    $student = User::factory()->create(['role' => 'student']);
    $otherStudent = User::factory()->create(['role' => 'student']);
    $lecturer = User::factory()->create(['role' => 'lecturer']);

    $presignResponse = $this->actingAs($student)->postJson(route('laporan.presign'), [
        'original_name' => 'Laporan AD620.pdf',
        'content_type' => 'application/pdf',
        'size' => 1048576,
    ]);

    $presignResponse->assertOk()
        ->assertJsonStructure(['key', 'upload_url', 'max_bytes']);

    $key = $presignResponse->json('key');
    expect($key)->toStartWith("reports/{$student->id}/")->toEndWith('.pdf');

    $storeResponse = $this->actingAs($student)->postJson(route('laporan.store'), [
        'module' => 'Jobsheet 02',
        'r2_key' => $key,
        'original_name' => 'Laporan AD620.pdf',
    ]);

    $storeResponse->assertOk();

    $report = Report::query()->first();
    expect($report)->not->toBeNull()
        ->and($report->file_path)->toBe($key)
        ->and($report->original_name)->toBe('Laporan AD620.pdf');

    $this->actingAs($otherStudent)
        ->get(route('laporan.download', $report))
        ->assertForbidden();

    $this->actingAs($student)
        ->get(route('laporan.download', $report))
        ->assertRedirect();

    $this->actingAs($lecturer)
        ->get(route('laporan.download', $report))
        ->assertRedirect();
});

test('local fallback upload stores PDF on public disk when R2 is not configured', function () {
    Storage::fake('public');

    config()->set('filesystems.disks.r2.key', null);
    config()->set('filesystems.disks.r2.secret', null);
    config()->set('filesystems.disks.r2.bucket', null);

    $student = User::factory()->create(['role' => 'student']);
    $pdf = UploadedFile::fake()->create('laporan-local.pdf', 512, 'application/pdf');

    $this->actingAs($student)->post(route('laporan.store'), [
        'module' => 'Jobsheet 01',
        'report' => $pdf,
    ])->assertRedirect();

    $report = Report::query()->first();
    expect($report)->not->toBeNull();
    Storage::disk('public')->assertExists($report->file_path);

    $this->actingAs($student)
        ->get(route('laporan.download', $report))
        ->assertOk();
});

<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;

uses(RefreshDatabase::class);

beforeEach(function () {
    RateLimiter::clear('local-login');
});

function makeClassroom(User $lecturer, string $code): int
{
    return DB::table('classrooms')->insertGetId([
        'lecturer_id' => $lecturer->id,
        'name' => 'Kelas '.$code,
        'code' => $code,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

test('responses carry baseline security headers and keep web bluetooth available', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertHeader('X-Content-Type-Options', 'nosniff')
        ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
        ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');

    expect($response->headers->get('Permissions-Policy'))->toContain('bluetooth=(self)');
});

test('login is rate limited per account name and ip', function () {
    $user = User::factory()->create(['name' => 'mahasiswa uji', 'role' => 'student']);

    foreach (range(1, 5) as $attempt) {
        $this->post(route('masuk.store'), ['name' => $user->name, 'password' => 'salah-'.$attempt, 'role' => 'student'])
            ->assertSessionHasErrors('login');
    }

    $this->post(route('masuk.store'), ['name' => $user->name, 'password' => 'salah-lagi', 'role' => 'student'])
        ->assertStatus(429);
});

test('a lecturer logging in through the student form is signed out and the session is reset', function () {
    $lecturer = User::factory()->create(['name' => 'dosen uji', 'role' => 'lecturer', 'password' => 'rahasia-panjang-123']);

    $this->post(route('masuk.store'), ['name' => $lecturer->name, 'password' => 'rahasia-panjang-123', 'role' => 'student'])
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('attendance code submissions are rate limited', function () {
    $student = User::factory()->create(['role' => 'student']);

    foreach (range(1, 10) as $attempt) {
        $this->actingAs($student)->post(route('attendance.store'), ['code' => 'TEBAK'.$attempt])
            ->assertSessionHasErrors('code');
    }

    $this->actingAs($student)->post(route('attendance.store'), ['code' => 'TEBAK11'])->assertStatus(429);
});

test('lecturers cannot attach students, announcements or attendance to another lecturers classroom', function () {
    $owner = User::factory()->create(['role' => 'lecturer']);
    $intruder = User::factory()->create(['role' => 'lecturer']);
    $student = User::factory()->create(['role' => 'student']);
    $foreignClassroom = makeClassroom($owner, 'KELAS-A');

    $this->actingAs($intruder)
        ->post(route('dosen.classes.members'), ['classroom_id' => $foreignClassroom, 'user_id' => $student->id])
        ->assertSessionHasErrors('classroom_id');

    $this->actingAs($intruder)
        ->post(route('dosen.announcements.store'), ['classroom_id' => $foreignClassroom, 'title' => 'Palsu', 'body' => 'Isi'])
        ->assertSessionHasErrors('classroom_id');

    expect(DB::table('classroom_members')->count())->toBe(0)
        ->and(DB::table('announcements')->count())->toBe(0);

    $this->actingAs($owner)
        ->post(route('dosen.classes.members'), ['classroom_id' => $foreignClassroom, 'user_id' => $student->id])
        ->assertSessionHasNoErrors();

    expect(DB::table('classroom_members')->count())->toBe(1);
});

test('lecturers only see their own classes while students cannot reach lecturer pages', function () {
    $owner = User::factory()->create(['role' => 'lecturer']);
    $other = User::factory()->create(['role' => 'lecturer']);
    makeClassroom($owner, 'MILIK-SAYA');
    makeClassroom($other, 'MILIK-LAIN');

    $this->actingAs($owner)->get(route('dosen.classes'))
        ->assertOk()
        ->assertSee('MILIK-SAYA')
        ->assertDontSee('MILIK-LAIN');

    $this->actingAs(User::factory()->create(['role' => 'student']))
        ->get(route('dosen.classes'))
        ->assertForbidden();
});

test('manual attendance publishes a session, roster and announcement atomically', function () {
    $lecturer = User::factory()->create(['role' => 'lecturer']);

    $payload = [
        'module' => 'Jobsheet 01',
        'code' => 'abc123',
        'opens_at' => now()->subHour()->toDateTimeString(),
        'closes_at' => now()->addHour()->toDateTimeString(),
        'student_name' => array_map(fn (int $i) => "Mahasiswa $i", range(1, 50)),
        'status' => array_fill(0, 50, 'present'),
    ];

    $this->actingAs($lecturer)->post(route('dosen.attendance.store'), $payload)
        ->assertSessionHasNoErrors();

    expect(DB::table('attendance_sessions')->value('code'))->toBe('ABC123')
        ->and(DB::table('attendance_manual_entries')->count())->toBe(50)
        ->and(DB::table('announcements')->count())->toBe(1);

    $payload['status'][3] = 'bukan-status';
    $this->actingAs($lecturer)->post(route('dosen.attendance.store'), $payload)
        ->assertSessionHasErrors('status.3');

    expect(DB::table('attendance_sessions')->count())->toBe(1);
});

test('lecturer attendance page wires the roster inputs to the submit form', function () {
    $lecturer = User::factory()->create(['role' => 'lecturer']);

    $this->actingAs($lecturer)->get(route('dosen.attendance'))
        ->assertOk()
        ->assertSee('id="attendance-form"', false);
});

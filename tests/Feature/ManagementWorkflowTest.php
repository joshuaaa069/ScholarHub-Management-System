<?php

use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the first-step scholarship flow with continue and the final publish step', function () {
    $registrar = User::factory()->create([
        'role' => 'superadmin',
        'email' => 'registrar@example.com',
    ]);

    $this->actingAs($registrar)
        ->get('/superadmin/scholarships')
        ->assertOk()
        ->assertSee('Continue')
        ->assertSee('Publish');
});

it('hides create scholarship admin and shows account management actions', function () {
    $registrar = User::factory()->create([
        'role' => 'superadmin',
        'email' => 'registrar2@example.com',
    ]);

    User::factory()->create([
        'role' => 'Scholarship Admin',
        'email' => 'admin@example.com',
        'name' => 'Test Admin',
        'first_name' => 'Test',
        'last_name' => 'Admin',
        'scholarship_name' => 'STEM Grant',
    ]);

    $this->actingAs($registrar)
        ->get('/superadmin/usermanage')
        ->assertOk()
        ->assertDontSee('Create Scholarship Admin')
        ->assertSee('View Account')
        ->assertSee('Change Password')
        ->assertSee('Delete Account');
});

it('creates a scholarship and scholarship admin in the same registrar flow', function () {
    $registrar = User::factory()->create([
        'role' => 'superadmin',
        'email' => 'registrar3@example.com',
    ]);

    $response = $this->actingAs($registrar)->post('/superadmin/scholarships', [
        'title' => 'STEM Excellence Grant',
        'description' => 'Support students in STEM fields.',
        'provider' => 'CKC ScholarHub Office',
        'benefits' => 'Tuition support and stipend',
        'eligibility' => 'Students with strong academic standing',
        'requirements' => 'Transcript and recommendation letter',
        'deadline' => '2030-12-31',
        'slots_total' => 25,
        'status' => 'Open',
        'type' => 'Academic',
        'full_name' => 'Maria Santos',
        'admin_email' => 'maria.santos@gmail.com',
        'admin_password' => 'StrongPass123',
        'admin_password_confirmation' => 'StrongPass123',
        'admin_contact_number' => '+63 912 345 6789',
    ]);

    $response->assertRedirect('/superadmin/scholarships');

    $this->assertDatabaseHas('scholarships', [
        'title' => 'STEM Excellence Grant',
        'provider' => 'CKC ScholarHub Office',
        'status' => 'Open',
    ]);

    $this->assertDatabaseHas('users', [
        'email' => 'maria.santos@gmail.com',
        'role' => 'Scholarship Admin',
        'scholarship_name' => 'STEM Excellence Grant',
    ]);

    $this->assertDatabaseHas('users', [
        'phone' => '+63 912 345 6789',
    ]);
});

it('allows a student to apply to an open scholarship', function () {
    $student = User::factory()->create([
        'role' => 'student',
        'email' => 'student@example.com',
    ]);

    $scholarship = Scholarship::create([
        'title' => 'Tech Innovators Grant',
        'description' => 'Support students in technology.',
        'provider' => 'CKC ScholarHub Office',
        'type' => 'STEM',
        'benefits' => 'Tuition support',
        'eligibility' => 'Open to current students',
        'requirements' => 'Transcript and essay',
        'deadline' => '2030-12-31',
        'slots_total' => 20,
        'slots_left' => 20,
        'min_gpa' => 2.5,
        'status' => 'Open',
        'created_by' => $student->id,
    ]);

    $response = $this->actingAs($student)
        ->post(route('student.applications.store', $scholarship));

    $response->assertRedirect(route('student.applications'));

    $this->assertDatabaseHas('applications', [
        'user_id' => $student->id,
        'scholarship_id' => $scholarship->id,
        'status' => 'Pending',
    ]);
});

<?php

namespace Tests\Unit\Controllers\Student;

use App\Http\Controllers\Student\DailyReportController;
use App\Models\DailyReport;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DailyReportControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $internship;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        
        // Create test user with student role
        $this->user = User::factory()->create([
            'role' => 'student'
        ]);
        
        // Create an active internship for the user
        $this->internship = Internship::factory()->create([
            'student_id' => $this->user->id,
            'status' => 'ongoing'
        ]);
    }

    /**
     * Test the index method redirects when no active internship exists
     *
     * @return void
     */
    public function test_index_redirects_when_no_active_internship()
    {
        // Delete the internship created in setUp
        $this->internship->delete();
        
        // Act as the test user
        $this->actingAs($this->user);
        
        // Make request to the index method
        $response = $this->get(route('student.daily-reports.index'));
        
        // Assert that the user is redirected
        $response->assertStatus(302);
        $response->assertRedirect(route('student.internships.index'));
        $response->assertSessionHas('error', 'Anda tidak memiliki data PKL yang aktif.');
    }

    /**
     * Test the index method shows reports when active internship exists
     *
     * @return void
     */
    public function test_index_shows_reports_when_active_internship_exists()
    {
        // Create some daily reports for the internship
        $reports = DailyReport::factory()->count(3)->create([
            'internship_id' => $this->internship->id
        ]);
        
        // Act as the test user
        $this->actingAs($this->user);
        
        // Make request to the index method
        $response = $this->get(route('student.daily-reports.index'));
        
        // Assert successful response
        $response->assertStatus(200);
        $response->assertViewIs('student.daily_reports.index');
        $response->assertViewHas('internship');
        $response->assertViewHas('dailyReports');
    }

    /**
     * Test the create method redirects when no active internship exists
     *
     * @return void
     */
    public function test_create_redirects_when_no_active_internship()
    {
        // Change the internship status to completed
        $this->internship->update(['status' => 'completed']);
        
        // Act as the test user
        $this->actingAs($this->user);
        
        // Make request to the create method
        $response = $this->get(route('student.daily-reports.create'));
        
        // Assert that the user is redirected
        $response->assertStatus(302);
        $response->assertRedirect(route('student.daily-reports.index'));
        $response->assertSessionHas('error', 'Anda tidak memiliki PKL yang sedang berlangsung.');
    }

    /**
     * Test the create method redirects when report for today already exists
     *
     * @return void
     */
    public function test_create_redirects_when_report_for_today_exists()
    {
        // Create a report for today
        $today = now()->format('Y-m-d');
        $report = DailyReport::factory()->create([
            'internship_id' => $this->internship->id,
            'date' => $today
        ]);
        
        // Act as the test user
        $this->actingAs($this->user);
        
        // Make request to the create method
        $response = $this->get(route('student.daily-reports.create'));
        
        // Assert that the user is redirected to edit
        $response->assertStatus(302);
        $response->assertRedirect(route('student.daily-reports.edit', $report));
        $response->assertSessionHas('info', 'Anda sudah membuat laporan untuk hari ini. Silakan edit laporan yang sudah ada.');
    }

    /**
     * Test the create method shows the form when all conditions are met
     *
     * @return void
     */
    public function test_create_shows_form_when_conditions_met()
    {
        // Act as the test user
        $this->actingAs($this->user);
        
        // Make request to the create method
        $response = $this->get(route('student.daily-reports.create'));
        
        // Assert successful response
        $response->assertStatus(200);
        $response->assertViewIs('student.daily_reports.create');
        $response->assertViewHas('internship');
    }

    /**
     * Test the store method validates input
     *
     * @return void
     */
    public function test_store_validates_input()
    {
        // Act as the test user
        $this->actingAs($this->user);
        
        // Make request with invalid data
        $response = $this->post(route('student.daily-reports.store'), [
            'date' => '',
            'activity' => '',
        ]);
        
        // Assert validation errors
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['date', 'activity']);
    }

    /**
     * Test the store method creates a new report successfully
     *
     * @return void
     */
    public function test_store_creates_new_report_successfully()
    {
        // Act as the test user
        $this->actingAs($this->user);
        
        // Fake storage disk for file uploads
        Storage::fake('public');
        
        // Prepare test data
        $data = [
            'date' => now()->subDay()->format('Y-m-d'), // Yesterday to avoid conflict with today's date check
            'activity' => $this->faker->paragraph(),
            'problems' => $this->faker->paragraph(),
            'solutions' => $this->faker->paragraph(),
            'documentation' => UploadedFile::fake()->image('report.jpg'),
        ];
        
        // Make request with valid data
        $response = $this->post(route('student.daily-reports.store'), $data);
        
        // Assert successful creation
        $this->assertDatabaseHas('daily_reports', [
            'internship_id' => $this->internship->id,
            'date' => $data['date'],
            'activity' => $data['activity'],
            'problems' => $data['problems'],
            'solutions' => $data['solutions'],
        ]);
        
        // Get the created report
        $report = DailyReport::where('internship_id', $this->internship->id)
            ->where('date', $data['date'])
            ->first();
            
        // Assert file was stored
        Storage::disk('public')->assertExists(str_replace('public/', '', $report->documentation));
        
        // Assert user is redirected to show route with success message
        $response->assertStatus(302);
        $response->assertRedirect(route('student.daily-reports.show', $report));
        $response->assertSessionHas('success', 'Laporan harian berhasil disimpan.');
    }

    /**
     * Test the show method displays the report details
     *
     * @return void
     */
    public function test_show_displays_report_details()
    {
        // Create a daily report
        $report = DailyReport::factory()->create([
            'internship_id' => $this->internship->id,
        ]);
        
        // Act as the test user
        $this->actingAs($this->user);
        
        // Make request to the show method
        $response = $this->get(route('student.daily-reports.show', $report));
        
        // Assert successful response
        $response->assertStatus(200);
        $response->assertViewIs('student.daily_reports.show');
        $response->assertViewHas('dailyReport');
        $response->assertViewHas('internship');
    }

    /**
     * Test the show method prevents access to unauthorized reports
     *
     * @return void
     */
    public function test_show_prevents_access_to_unauthorized_reports()
    {
        // Create another user and internship
        $anotherUser = User::factory()->create(['role' => 'student']);
        $anotherInternship = Internship::factory()->create([
            'student_id' => $anotherUser->id,
            'status' => 'ongoing'
        ]);
        
        // Create a report for the other internship
        $unauthorizedReport = DailyReport::factory()->create([
            'internship_id' => $anotherInternship->id,
        ]);
        
        // Act as the test user
        $this->actingAs($this->user);
        
        // Make request to the show method for unauthorized report
        $response = $this->get(route('student.daily-reports.show', $unauthorizedReport));
        
        // Assert forbidden response
        $response->assertStatus(403);
    }

    /**
     * Test the edit method prevents editing approved reports
     *
     * @return void
     */
    public function test_edit_prevents_editing_approved_reports()
    {
        // Create an approved daily report
        $approvedReport = DailyReport::factory()->create([
            'internship_id' => $this->internship->id,
            'is_approved' => true
        ]);
        
        // Act as the test user
        $this->actingAs($this->user);
        
        // Make request to the edit method
        $response = $this->get(route('student.daily-reports.edit', $approvedReport));
        
        // Assert that the user is redirected
        $response->assertStatus(302);
        $response->assertRedirect(route('student.daily-reports.show', $approvedReport));
        $response->assertSessionHas('error', 'Laporan yang sudah disetujui tidak dapat diedit.');
    }

    /**
     * Test the edit method shows the edit form
     *
     * @return void
     */
    public function test_edit_shows_form_for_unapproved_reports()
    {
        // Create an unapproved daily report
        $unapprovedReport = DailyReport::factory()->create([
            'internship_id' => $this->internship->id,
            'is_approved' => false
        ]);
        
        // Act as the test user
        $this->actingAs($this->user);
        
        // Make request to the edit method
        $response = $this->get(route('student.daily-reports.edit', $unapprovedReport));
        
        // Assert successful response
        $response->assertStatus(200);
        $response->assertViewIs('student.daily_reports.edit');
        $response->assertViewHas('dailyReport');
        $response->assertViewHas('internship');
    }
} 
<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Field;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InternshipWorkflowTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $student;
    protected $coordinator;
    protected $supervisor;
    protected $company;
    protected $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        
        // Create users with different roles
        $this->student = User::factory()->create([
            'name' => 'Test Student',
            'email' => 'student@test.com',
            'role' => 'student',
            'nim' => '12345678'
        ]);
        
        $this->coordinator = User::factory()->create([
            'name' => 'Test Coordinator',
            'email' => 'coordinator@test.com',
            'role' => 'coordinator'
        ]);
        
        $this->supervisor = User::factory()->create([
            'name' => 'Test Supervisor',
            'email' => 'supervisor@test.com',
            'role' => 'supervisor'
        ]);
        
        // Create a company and field for internship
        $this->company = Company::factory()->create([
            'name' => 'Test Company',
            'quota' => 5
        ]);
        
        $this->field = Field::factory()->create([
            'name' => 'Web Development'
        ]);

        // Associate the field with the company
        $this->company->fields()->attach($this->field->id);
        
        // Fake storage for file uploads
        Storage::fake('public');
    }

    /**
     * Test the entire internship workflow from application to completion.
     *
     * @return void
     */
    public function test_complete_internship_workflow()
    {
        // Step 1: Student applies for internship
        $this->applyForInternship();
        
        // Step 2: Coordinator approves the application and assigns supervisor
        $this->approveInternshipApplication();
        
        // Step 3: Student submits daily reports
        $this->submitDailyReports();
        
        // Step 4: Supervisor approves reports
        $this->approveDailyReports();
        
        // Step 5: Field supervisor evaluates the student
        $this->submitFieldSupervisorEvaluation();
        
        // Step 6: Supervisor evaluates the student
        $this->submitSupervisorEvaluation();
        
        // Step 7: Student submits final report
        $this->submitFinalReport();
        
        // Step 8: Supervisor approves final report
        $this->approveFinalReport();
        
        // Step 9: Verify internship is completed
        $this->verifyInternshipCompletion();
    }

    /**
     * Student applies for internship
     */
    private function applyForInternship()
    {
        // Act as student
        $this->actingAs($this->student);
        
        // Prepare application data
        $applicationData = [
            'company_id' => $this->company->id,
            'field_id' => $this->field->id,
            'start_date' => now()->addDays(7)->format('Y-m-d'),
            'end_date' => now()->addMonths(3)->format('Y-m-d'),
            'motivation_letter' => $this->faker->paragraph(5),
            'field_supervisor_name' => $this->faker->name,
            'field_supervisor_position' => 'HR Manager',
            'field_supervisor_contact' => $this->faker->phoneNumber,
            'application_letter' => UploadedFile::fake()->create('application.pdf', 500),
            'cv' => UploadedFile::fake()->create('cv.pdf', 500),
        ];
        
        // Submit internship application
        $response = $this->post(route('student.internships.apply'), $applicationData);
        
        // Assert redirection and success message
        $response->assertStatus(302);
        $response->assertSessionHas('success');
        
        // Verify internship was created with pending status
        $this->assertDatabaseHas('internships', [
            'student_id' => $this->student->id,
            'company_id' => $this->company->id,
            'field_id' => $this->field->id,
            'status' => 'pending'
        ]);
    }

    /**
     * Coordinator approves the internship application
     */
    private function approveInternshipApplication()
    {
        // Get the pending internship
        $internship = Internship::where('student_id', $this->student->id)
            ->where('status', 'pending')
            ->first();
            
        // Act as coordinator
        $this->actingAs($this->coordinator);
        
        // Approve the application
        $response = $this->post(route('coordinator.internships.process', $internship->id), [
            'status' => 'approved',
            'supervisor_id' => $this->supervisor->id,
            'notes' => 'Application approved.'
        ]);
        
        // Assert redirection and success message
        $response->assertStatus(302);
        $response->assertSessionHas('success');
        
        // Verify internship status was updated and supervisor assigned
        $this->assertDatabaseHas('internships', [
            'id' => $internship->id,
            'status' => 'approved',
            'supervisor_id' => $this->supervisor->id
        ]);
    }

    /**
     * Student submits daily reports
     */
    private function submitDailyReports()
    {
        // Get the approved internship
        $internship = Internship::where('student_id', $this->student->id)
            ->where('status', 'approved')
            ->first();
            
        // Update the status to ongoing
        $internship->update(['status' => 'ongoing']);
        
        // Act as student
        $this->actingAs($this->student);
        
        // Submit 3 daily reports
        for ($i = 0; $i < 3; $i++) {
            $reportData = [
                'internship_id' => $internship->id,
                'date' => now()->subDays($i)->format('Y-m-d'),
                'activity_title' => 'Daily task ' . ($i + 1),
                'activity_description' => $this->faker->paragraph,
                'learning_outcomes' => $this->faker->paragraph,
                'challenges' => $this->faker->paragraph,
                'work_hours' => rand(6, 8),
                'location' => $this->faker->address,
                'attachment' => UploadedFile::fake()->image('report' . $i . '.jpg'),
            ];
            
            $response = $this->post(route('student.daily-reports.store'), $reportData);
            
            // Assert success
            $response->assertStatus(302);
            $response->assertSessionHas('success');
            
            // Verify report was created
            $this->assertDatabaseHas('daily_reports', [
                'internship_id' => $internship->id,
                'report_date' => $reportData['date'],
                'activity_title' => $reportData['activity_title'],
                'status' => 'pending',
            ]);
        }
    }

    /**
     * Supervisor approves student's daily reports
     */
    private function approveDailyReports()
    {
        // Get the internship
        $internship = Internship::where('student_id', $this->student->id)
            ->where('status', 'ongoing')
            ->first();
            
        // Get reports
        $reports = $internship->dailyReports()->where('status', 'pending')->get();
        
        // Act as supervisor
        $this->actingAs($this->supervisor);
        
        foreach ($reports as $report) {
            $response = $this->post(route('supervisor.daily-reports.verify', $report->id), [
                'status' => 'approved',
                'verification_notes' => 'Good work!'
            ]);
            
            // Assert success
            $response->assertStatus(302);
            $response->assertSessionHas('success');
            
            // Verify report was approved
            $this->assertDatabaseHas('daily_reports', [
                'id' => $report->id,
                'status' => 'approved'
            ]);
        }
    }

    /**
     * Field supervisor submits evaluation for the student
     */
    private function submitFieldSupervisorEvaluation()
    {
        // Get the internship
        $internship = Internship::where('student_id', $this->student->id)
            ->where('status', 'ongoing')
            ->first();
            
        // Simulate field supervisor submitting evaluation
        // (In a real app, this might be a separate interface, but we'll mock it)
        $evaluationData = [
            'internship_id' => $internship->id,
            'attendance_score' => 90,
            'attitude_score' => 85,
            'performance_score' => 88,
            'teamwork_score' => 92,
            'comments' => 'The student performed well during the internship.',
            'status' => 'completed'
        ];
        
        // Create field supervisor evaluation
        $internship->fieldSupervisorEvaluation()->create($evaluationData);
        
        // Verify evaluation was created
        $this->assertDatabaseHas('field_supervisor_evaluations', [
            'internship_id' => $internship->id,
            'attendance_score' => 90,
            'status' => 'completed'
        ]);
    }

    /**
     * Supervisor submits evaluation for the student
     */
    private function submitSupervisorEvaluation()
    {
        // Get the internship
        $internship = Internship::where('student_id', $this->student->id)
            ->where('status', 'ongoing')
            ->first();
            
        // Act as supervisor
        $this->actingAs($this->supervisor);
        
        $evaluationData = [
            'internship_id' => $internship->id,
            'report_quality_score' => 88,
            'problem_solving_score' => 85,
            'communication_score' => 90,
            'initiative_score' => 87,
            'comments' => 'The student showed good progress throughout the internship.',
            'grade' => 'A'
        ];
        
        $response = $this->post(route('supervisor.evaluations.store'), $evaluationData);
        
        // Assert success
        $response->assertStatus(302);
        $response->assertSessionHas('success');
        
        // Verify evaluation was created
        $this->assertDatabaseHas('supervisor_evaluations', [
            'internship_id' => $internship->id,
            'report_quality_score' => 88,
            'grade' => 'A'
        ]);
    }

    /**
     * Student submits final report
     */
    private function submitFinalReport()
    {
        // Get the internship
        $internship = Internship::where('student_id', $this->student->id)
            ->where('status', 'ongoing')
            ->first();
            
        // Act as student
        $this->actingAs($this->student);
        
        $reportData = [
            'title' => 'Final Internship Report - Web Development at ' . $this->company->name,
            'abstract' => $this->faker->paragraph(5),
            'keywords' => 'web development, laravel, internship',
            'final_report' => UploadedFile::fake()->create('final_report.pdf', 1024),
            'presentation_file' => UploadedFile::fake()->create('presentation.pdf', 512),
            'letter_of_completion' => UploadedFile::fake()->create('completion_letter.pdf', 256),
            'internship_journal' => UploadedFile::fake()->create('journal.pdf', 512),
        ];
        
        $response = $this->post(route('student.internships.final-report.submit', $internship->id), $reportData);
        
        // Assert success
        $response->assertStatus(302);
        $response->assertSessionHas('success');
        
        // Verify final report was created
        $this->assertDatabaseHas('final_reports', [
            'internship_id' => $internship->id,
            'title' => $reportData['title'],
            'status' => 'pending'
        ]);
    }

    /**
     * Supervisor approves the final report
     */
    private function approveFinalReport()
    {
        // Get the internship
        $internship = Internship::where('student_id', $this->student->id)
            ->where('status', 'ongoing')
            ->first();
            
        // Get the final report
        $finalReport = $internship->finalReport;
        
        // Act as supervisor
        $this->actingAs($this->supervisor);
        
        $response = $this->post(route('supervisor.final-reports.process', $finalReport->id), [
            'status' => 'approved',
            'comments' => 'The final report meets all requirements.'
        ]);
        
        // Assert success
        $response->assertStatus(302);
        $response->assertSessionHas('success');
        
        // Verify final report was approved
        $this->assertDatabaseHas('final_reports', [
            'id' => $finalReport->id,
            'status' => 'approved'
        ]);
    }

    /**
     * Verify internship is completed
     */
    private function verifyInternshipCompletion()
    {
        // Get the internship
        $internship = Internship::where('student_id', $this->student->id)->first();
        
        // Verify the internship is marked as completed
        $this->assertEquals('completed', $internship->fresh()->status);
        
        // Verify all necessary evaluations and reports exist
        $this->assertNotNull($internship->supervisorEvaluation);
        $this->assertNotNull($internship->fieldSupervisorEvaluation);
        $this->assertNotNull($internship->finalReport);
        $this->assertTrue($internship->dailyReports()->count() > 0);
        
        // Verify grade is assigned
        $this->assertEquals('A', $internship->supervisorEvaluation->grade);
    }
} 
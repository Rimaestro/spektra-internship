<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\DailyReport;
use App\Models\Evaluation;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Menampilkan dashboard sesuai dengan role user
     */
    public function index()
    {
        $user = Auth::user();
        
        // Redirect ke dashboard sesuai role
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isStudent()) {
            return $this->studentDashboard();
        } elseif ($user->isSupervisor()) {
            return $this->supervisorDashboard();
        } elseif ($user->isFieldSupervisor()) {
            return $this->fieldSupervisorDashboard();
        } elseif ($user->isCoordinator()) {
            return $this->coordinatorDashboard();
        }
        
        // Fallback jika role tidak dikenali
        return view('dashboard.default');
    }
    
    /**
     * Dashboard untuk admin
     */
    private function adminDashboard()
    {
        $totalUsers = User::count();
        $totalCompanies = Company::count();
        $totalInternships = Internship::count();
        $activeInternships = Internship::where('status', 'ongoing')->count();
        
        $recentUsers = User::latest()->take(5)->get();
        $recentCompanies = Company::latest()->take(5)->get();
        
        return view('dashboard.admin', compact(
            'totalUsers',
            'totalCompanies', 
            'totalInternships', 
            'activeInternships', 
            'recentUsers',
            'recentCompanies'
        ));
    }
    
    /**
     * Dashboard untuk mahasiswa
     */
    private function studentDashboard()
    {
        $user = Auth::user();
        
        $internship = Internship::where('student_id', $user->id)
            ->latest()
            ->first();
        
        if ($internship) {
            // Jika mahasiswa sudah terdaftar di PKL
            $dailyReports = DailyReport::where('internship_id', $internship->id)
                ->latest()
                ->take(5)
                ->get();
            
            $reportCount = DailyReport::where('internship_id', $internship->id)->count();
            $evaluations = Evaluation::where('internship_id', $internship->id)->get();
            
            // Hitung progress
            $progressPercentage = $internship->progress_percentage;
            
            return view('dashboard.student', compact(
                'internship', 
                'dailyReports', 
                'reportCount', 
                'evaluations',
                'progressPercentage'
            ));
        }
        
        // Jika belum ada PKL, tampilkan dashboard dengan info pendaftaran
        $availableCompanies = Company::where('is_active', true)
            ->where('quota', '>', 0)
            ->get();
        
        return view('dashboard.student', compact('availableCompanies'));
    }
    
    /**
     * Dashboard untuk dosen pembimbing
     */
    private function supervisorDashboard()
    {
        $user = Auth::user();
        
        $internships = Internship::where('supervisor_id', $user->id)
            ->with(['student', 'company'])
            ->get();
        
        $ongoingInternships = $internships->where('status', 'ongoing')->count();
        $completedInternships = $internships->where('status', 'completed')->count();
        $pendingReports = DailyReport::whereHas('internship', function ($query) use ($user) {
                $query->where('supervisor_id', $user->id);
            })
            ->where('is_approved', false)
            ->count();
        
        $recentReports = DailyReport::whereHas('internship', function ($query) use ($user) {
                $query->where('supervisor_id', $user->id);
            })
            ->latest()
            ->take(5)
            ->with(['internship.student'])
            ->get();
        
        return view('dashboard.supervisor', compact(
            'internships', 
            'ongoingInternships', 
            'completedInternships', 
            'pendingReports',
            'recentReports'
        ));
    }
    
    /**
     * Dashboard untuk pembimbing lapangan
     */
    private function fieldSupervisorDashboard()
    {
        $user = Auth::user();
        
        $internships = Internship::where('field_supervisor_id', $user->id)
            ->with(['student', 'company'])
            ->get();
        
        $ongoingInternships = $internships->where('status', 'ongoing')->count();
        $completedInternships = $internships->where('status', 'completed')->count();
        $pendingReports = DailyReport::whereHas('internship', function ($query) use ($user) {
                $query->where('field_supervisor_id', $user->id);
            })
            ->where('is_approved', false)
            ->count();
        
        $recentReports = DailyReport::whereHas('internship', function ($query) use ($user) {
                $query->where('field_supervisor_id', $user->id);
            })
            ->latest()
            ->take(5)
            ->with(['internship.student'])
            ->get();
        
        $company = $user->company;
        
        return view('dashboard.field_supervisor', compact(
            'internships', 
            'ongoingInternships', 
            'completedInternships', 
            'pendingReports',
            'recentReports',
            'company'
        ));
    }
    
    /**
     * Dashboard untuk koordinator PKL
     */
    private function coordinatorDashboard()
    {
        $totalInternships = Internship::count();
        $activeInternships = Internship::where('status', 'ongoing')->count();
        $pendingInternships = Internship::where('status', 'pending')->count();
        $completedInternships = Internship::where('status', 'completed')->count();
        
        $totalCompanies = Company::count();
        $activeCompanies = Company::where('is_active', true)->count();
        
        $recentApplications = Internship::where('status', 'pending')
            ->with(['student', 'company'])
            ->latest()
            ->take(10)
            ->get();
        
        $topCompanies = Company::withCount(['internships' => function ($query) {
                $query->whereIn('status', ['ongoing', 'completed']);
            }])
            ->orderBy('internships_count', 'desc')
            ->take(5)
            ->get();
        
        return view('dashboard.coordinator', compact(
            'totalInternships',
            'activeInternships',
            'pendingInternships',
            'completedInternships',
            'totalCompanies',
            'activeCompanies',
            'recentApplications',
            'topCompanies'
        ));
    }
}

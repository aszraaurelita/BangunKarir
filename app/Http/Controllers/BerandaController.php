<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\UserSkill;
use App\Models\InterestArea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index(Request $request)
{
    $query = User::with(['profile', 'skills']);

    if ($request->filled('nama')) {
        $query->where('name', 'like', '%' . $request->nama . '%');
    }

    if ($request->filled('prodi')) {
        $query->whereHas('profile', function ($q) use ($request) {
            $q->where('prodi', $request->prodi);
        });
    }

    if ($request->filled('interest')) {
        $query->whereHas('interestAreas', function ($q) use ($request) {
            $q->where('nama_minat', $request->interest); // sesuaikan nama field jika perlu
        });
    }

    if ($request->filled('skill')) {
        $query->whereHas('skills', function ($q) use ($request) {
            $q->where('id', $request->skill);
        });
    }

    $users = $query->get();

    // Tambahkan variabel lainnya
    $recommendedUsers = User::with('profile')
        ->where('id', '!=', Auth::id())
        ->inRandomOrder()
        ->take(20)
        ->get();

    $allInterests = InterestArea::all();
    $allSkills = UserSkill::all();
    $posts = Post::with(['user.profile', 'likes', 'comments'])->latest()->get();

    $minatKarierMap = [
            'Sistem Informasi' => [
                'Analis Sistem', 'Database Administrator', 'Business Analyst', 'IT Project Manager',
                'System Integrator', 'IT Consultant', 'ERP Specialist', 'Digital Transformation Specialist', 
                'UI/UX Designer', 'Software Requirements Engineer', 'IT Support Specialist', 'Software Developer',
            ],
            'Informatika' => [
                'Software Developer/Programmer', 'Web Developer', 'Mobile App Developer',
                'Data Scientist', 'Cybersecurity Specialist', 'AI/Machine Learning Engineer',
                'Game Developer', 'DevOps Engineer',
            ],
            'Teknik Logistik' => [
                'Supply Chain Manager', 'Logistics Coordinator', 'Warehouse Manager', 'Transportation Planner',
                'Import/Export Specialist', 'Inventory Manager', 'Distribution Manager', 'Procurement Specialist',
            ],
            'Teknik Kimia' => [
                'Process Engineer', 'Chemical Plant Engineer', 'Quality Control Engineer',
                'Research & Development Engineer', 'Environmental Engineer', 'Production Manager',
                'Safety Engineer', 'Petroleum Engineer',
            ],
            'Manajemen Rekayasa' => [
                'Industrial Engineer', 'Operations Manager', 'Process Improvement Specialist',
                'Production Planning Manager', 'Quality Assurance Manager', 'Systems Analyst',
                'Management Consultant', 'Project Engineer',
            ],
            'Manajemen' => [
                'General Manager', 'Human Resources Manager', 'Marketing Manager', 'Operations Manager',
                'Business Development Manager', 'Sales Manager', 'Entrepreneur', 'Management Trainee',
            ],
            'DKV (Desain Komunikasi Visual)' => [
                'Graphic Designer', 'UI/UX Designer', 'Brand Designer', 'Creative Director',
                'Advertising Designer', 'Web Designer', 'Illustrator', 'Motion Graphics Designer',
            ],
            'Ekonomi Syariah' => [
                'Sharia Banking Officer', 'Islamic Finance Analyst', 'Sharia Compliance Officer',
                'Islamic Investment Advisor', 'Zakat Management Officer', 'Islamic Economics Researcher',
                'Sharia Auditor', 'Microfinance Specialist',
            ],
            'Akuntansi' => [
                'Akuntan Publik', 'Internal Auditor', 'Tax Consultant', 'Financial Analyst',
                'Cost Accountant', 'Budget Analyst', 'Forensic Accountant', 'Management Accountant',
            ],
            'Teknologi Agroindustri' => [
                'Food Processing Engineer', 'Quality Control Specialist', 'Product Development Manager',
                'Agricultural Technology Consultant', 'Food Safety Inspector', 'Production Supervisor',
                'Research & Development Specialist', 'Agribusiness Manager',
            ],
        ];

    return view('beranda.index', compact(
        'users', 'recommendedUsers', 'allInterests', 'allSkills', 'posts', 'minatKarierMap'
    ));
}
}
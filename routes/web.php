<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ProfileExtensionController;
use App\Http\Controllers\OrganizationalExperienceController;
use App\Http\Controllers\ProjectExperienceController;
use App\Http\Controllers\WorkExperienceController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InterestAreaController;
use App\Http\Controllers\LandingController;


// Route default - redirect berdasarkan status auth
Route::get('/', [LandingController::class, 'index'])->name('landing');
    // Gunakan facade Auth yang pasti ada di semua versi Laravel
// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile Routes (Tahap 1)
    Route::get('/profile/setup', [ProfileController::class, 'setup'])->name('profile.setup');
    Route::post('/profile/setup', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update-photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    
    // Profile Extension Routes (Tahap 2)
    Route::get('/profile/extension', [ProfileExtensionController::class, 'index'])->name('profile.extension');
    Route::post('/profile/organization', [ProfileExtensionController::class, 'storeOrganization'])->name('profile.store-organization');
    Route::post('/profile/project', [ProfileExtensionController::class, 'storeProject'])->name('profile.store-project');
    Route::post('/profile/work-experience', [ProfileExtensionController::class, 'storeWorkExperience'])->name('profile.store-work-experience');
    Route::post('/profile/skill', [ProfileExtensionController::class, 'storeSkill'])->name('profile.store-skill');
    Route::post('/profile/certificate', [ProfileExtensionController::class, 'storeCertificate'])->name('profile.store-certificate');
    Route::post('/profile/achievement', [ProfileExtensionController::class, 'storeAchievement'])->name('profile.store-achievement');
    Route::post('/profile/portfolio', [ProfileExtensionController::class, 'storePortfolio'])->name('profile.store-portfolio');
    
    // Delete routes
    Route::delete('/profile/organization/{id}', [ProfileExtensionController::class, 'deleteOrganization'])->name('profile.delete-organization');
    Route::delete('/profile/project/{id}', [ProfileExtensionController::class, 'deleteProject'])->name('profile.delete-project');
    Route::delete('/profile/work-experience/{id}', [ProfileExtensionController::class, 'deleteWorkExperience'])->name('profile.delete-work-experience');
    Route::delete('/profile/skill/{id}', [ProfileExtensionController::class, 'deleteSkill'])->name('profile.delete-skill');
    Route::delete('/profile/certificate/{id}', [ProfileExtensionController::class, 'deleteCertificate'])->name('profile.delete-certificate');
    Route::delete('/profile/achievement/{id}', [ProfileExtensionController::class, 'deleteAchievement'])->name('profile.delete-achievement');
    Route::delete('/profile/portfolio/{id}', [ProfileExtensionController::class, 'deletePortfolio'])->name('profile.delete-portfolio');

    Route::post('/pengalaman-organisasi', [OrganizationalExperienceController::class, 'store'])->name('organizational-experience.store');
    Route::post('/profile/organizational-experiences', [OrganizationalExperienceController::class, 'store'])->name('organizational-experiences.store');
    Route::post('/projects', [ProjectExperienceController::class, 'store'])->name('projects.store');
    Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
    Route::post('/work-experiences', [WorkExperienceController::class, 'store'])->name('work-experiences.store');

    Route::resource('work-experiences', WorkExperienceController::class)->middleware('auth');
    Route::resource('skills', SkillController::class)->middleware('auth');
    Route::resource('projects', ProjectExperienceController::class)->middleware('auth');
    Route::resource('organizational-experiences', OrganizationalExperienceController::class)->middleware('auth');

    Route::post('/profile/certificate', [ProfileExtensionController::class, 'storeCertificate'])->name('profile.store-certificate');
    Route::put('/profile/certificate/{id}', [ProfileExtensionController::class, 'updateCertificate'])->name('profile.update-certificate');
    Route::delete('/profile/certificate/{id}', [ProfileExtensionController::class, 'deleteCertificate'])->name('profile.delete-certificate');

    Route::post('/profile/achievement', [ProfileExtensionController::class, 'storeAchievement'])->name('profile.store-achievement');
    Route::put('/profile/achievement/{id}', [ProfileExtensionController::class, 'updateAchievement'])->name('profile.update-achievement');
    Route::delete('/profile/achievement/{id}', [ProfileExtensionController::class, 'deleteAchievement'])->name('profile.delete-achievement');

    Route::resource('posts', PostController::class)->middleware('auth');
    Route::post('posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('posts/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/posts/{post}/comments', [PostController::class, 'showComments'])->name('posts.comments.show');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/index', [ProfileController::class, 'show'])->name('profile.index');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');

    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.profile');
    Route::resource('interest-areas', InterestAreaController::class)->middleware('auth');
    Route::get('/users/search', [BerandaController::class, 'search'])->name('users.search');
    Route::get('/hasil-pencarian', [UserController::class, 'search'])->name('users.search');

});

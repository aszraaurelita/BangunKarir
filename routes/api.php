<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectExperienceController;
use App\Http\Controllers\WorkExperienceController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\OrganizationalExperienceController;

Route::apiResource('organizational-experiences', OrganizationalExperienceController::class);
Route::apiResource('project-experiences', ProjectExperienceController::class);
Route::apiResource('work-experiences', WorkExperienceController::class);
Route::apiResource('skills', SkillController::class);

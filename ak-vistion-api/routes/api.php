<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import All Controllers
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\BlogPostController;
use App\Http\Controllers\Api\SupportFileController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\LegalPageController;
use App\Http\Controllers\Api\FormSubmissionController;
use App\Http\Controllers\Api\HomepageController;
use App\Http\Controllers\Api\AboutPageController;
use App\Http\Controllers\Api\ServicesPageController;
use App\Http\Controllers\Api\TechnologyController;
use App\Http\Controllers\Api\TeamMemberController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\StatisticController;
use App\Http\Controllers\Api\TestimonialController;

// --- PUBLIC ROUTES (for your frontend website) ---
// You would add more specific endpoints here as needed for efficiency
// For now, the admin endpoints can be used to fetch data.


// --- PUBLIC FORM SUBMISSIONS ---
Route::post('/submissions', [FormSubmissionController::class, 'store']);


// --- ADMIN AUTHENTICATION ---
Route::post('/login', [AuthController::class, 'login']);


// --- PROTECTED ADMIN ROUTES (requires authentication) ---
Route::middleware('auth:sanctum')->group(function () {
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/user', function (Request $request) { return $request->user(); });

// Full CRUD API Resources for Admin Panel
Route::apiResource('admin/products', ProductController::class);
Route::apiResource('admin/blog-posts', BlogPostController::class);
Route::apiResource('admin/support-files', SupportFileController::class);
Route::apiResource('admin/faqs', FaqController::class);
Route::apiResource('admin/submissions', FormSubmissionController::class)->only(['index', 'show', 'destroy']);
Route::apiResource('admin/technologies', TechnologyController::class);
Route::apiResource('admin/team-members', TeamMemberController::class);
Route::apiResource('admin/partners', PartnerController::class);
Route::apiResource('admin/statistics', StatisticController::class);
Route::apiResource('admin/testimonials', TestimonialController::class);

// Page Content Management (Text content, simple JSON)
Route::get('admin/pages/homepage', [HomepageController::class, 'index']);
Route::post('admin/pages/homepage', [HomepageController::class, 'update']);

Route::get('admin/pages/about', [AboutPageController::class, 'index']);
Route::post('admin/pages/about', [AboutPageController::class, 'update']);

Route::get('admin/pages/services', [ServicesPageController::class, 'index']);
Route::post('admin/pages/services', [ServicesPageController::class, 'update']);

// Legal Pages
Route::get('admin/legal-pages/{page_key}', [LegalPageController::class, 'show']);
Route::post('admin/legal-pages/{page_key}', [LegalPageController::class, 'update']);
});

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
use App\Http\Controllers\Api\FeaturedItemController;
use App\Http\Controllers\Api\NewsroomVideoController;

use App\Http\Controllers\Api\GuideController;
use App\Http\Controllers\Api\VideoController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// --- PUBLIC ROUTES (for your frontend website) ---
// These are accessible by anyone to view content.
Route::get('/products', [ProductController::class, 'index']);
Route::get('/blog-posts', [BlogPostController::class, 'index']);
Route::get('/blog-posts/{blogPost}', [BlogPostController::class, 'show']);
Route::get('/support-files', [SupportFileController::class, 'index']);
Route::get('/faqs', [FaqController::class, 'index']);
Route::get('/legal-pages/{page_key}', [LegalPageController::class, 'show']);
Route::get('/homepage-data', [HomepageController::class, 'index']);
Route::get('/about-page-data', [AboutPageController::class, 'index']);
Route::get('/services-page-data', [ServicesPageController::class, 'index']);
Route::get('/technologies', [TechnologyController::class, 'index']);
Route::get('/team-members', [TeamMemberController::class, 'index']);
Route::get('/partners', [PartnerController::class, 'index']);
Route::get('/statistics', [StatisticController::class, 'index']);
Route::get('/testimonials', [TestimonialController::class, 'index']);
 // --- THIS IS THE CORRECTED & FINAL PART ---
    Route::apiResource('admin/featured-items', FeaturedItemController::class);
    Route::apiResource('admin/newsroom-videos', NewsroomVideoController::class)->except(['show', 'update']);

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
    Route::apiResource('admin/guides', GuideController::class);
Route::apiResource('admin/videos', VideoController::class);
    Route::apiResource('admin/faqs', FaqController::class);
    Route::apiResource('admin/submissions', FormSubmissionController::class)->except(['store', 'update']);
    Route::apiResource('admin/technologies', TechnologyController::class);
   Route::apiResource('admin/team-members', TeamMemberController::class);
Route::apiResource('admin/partners', PartnerController::class);
Route::apiResource('admin/statistics', StatisticController::class);
    Route::apiResource('admin/testimonials', TestimonialController::class);
     Route::apiResource('admin/featured-items', FeaturedItemController::class);
    Route::apiResource('admin/newsroom-videos', NewsroomVideoController::class);

    // Page Content Management (GET to read, POST to update)
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

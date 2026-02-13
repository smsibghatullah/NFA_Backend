<?php

use App\Http\Controllers\Api\AboutApiPageController;
use App\Http\Controllers\Api\AboutPostApiController;
use App\Http\Controllers\Api\CandidateApiController;
use App\Http\Controllers\Api\CandidatesApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DocumentApiController;
use App\Http\Controllers\Api\DownloadApiController;
use App\Http\Controllers\Api\EligibilityApiController;
use App\Http\Controllers\Api\ForensicApiController;
use App\Http\Controllers\Api\GeneralInfoApiController;
use App\Http\Controllers\Api\JobApiController;
use App\Http\Controllers\Api\JobApplicationApiController;
use App\Http\Controllers\Api\NfaUserApiController;
use App\Http\Controllers\Api\NfaUserProfileApiController;
use App\Http\Controllers\Api\OurServiceApiController;
use App\Http\Controllers\Api\TenderApiController;
use App\Http\Controllers\Api\TrainingAndEducationApiController;
use App\Http\Controllers\Api\VisionApiController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/documents', [DocumentApiController::class, 'index']);
Route::get('/downloads', [DownloadApiController::class, 'index']);
// Route::get('/candidates', [CandidateApiController::class, 'index']); // GET /api/candidates?query=...&test_date=...
Route::get('/jobs', [JobApiController::class, 'index']);
// Public (Next.js)
Route::post('nfauser/register', [NfaUserApiController::class, 'register']);
Route::post('nfauser/login', [NfaUserApiController::class, 'login']);
Route::get('/about-post-latest', [AboutPostApiController::class, 'latest'])
    ->middleware('throttle:60,1');
Route::get('our-services', [OurServiceApiController::class, 'index']);
Route::get('our-services/latest', [OurServiceApiController::class, 'latest']);
Route::get('our-services/{id}', [OurServiceApiController::class, 'show']);
// forensic post
Route::get('/forensic-posts', [ForensicApiController::class, 'index']);
Route::get('/forensic-posts/latest', [ForensicApiController::class, 'latest']);
Route::get('/forensic-posts/{id}', [ForensicApiController::class, 'show']);


Route::get('/trainingandeducation', [TrainingAndEducationApiController::class, 'index']); // all posts
Route::get('/trainingandeducation/latest', [TrainingAndEducationApiController::class, 'latest']); // latest post
Route::get('/trainingandeducation/{id}', [TrainingAndEducationApiController::class, 'show']); // single post

Route::get('/vision', [VisionApiController::class, 'index']);
Route::get('/about-page', [AboutApiPageController::class, 'index']);
Route::get('/about-page/latest', [AboutApiPageController::class, 'latest']);
Route::get('/about-page/{id}', [AboutApiPageController::class, 'show']);

Route::get('/general-info', [GeneralInfoApiController::class, 'latest']);

// ALL TENDERS
Route::get('/tenders', [TenderApiController::class, 'index']);
// candidates
Route::get('/candidate', [CandidatesApiController::class, 'getCandidateByCnic']);

// SINGLE TENDER
Route::get('/tenders/{id}', [TenderApiController::class, 'show']);
Route::middleware('auth:sanctum')->group(function () {
    // Logged-in user ka profile fetch
    Route::get('nfauser/profile', action: [NfaUserProfileApiController::class, 'showProfile']);

    // Profile create ya update
    Route::post('nfauser/profile', [NfaUserProfileApiController::class, 'saveProfile']);
    Route::get('/check-eligibility', [EligibilityApiController::class, 'checkEligibility']);
    Route::post('/submit-application', [JobApplicationApiController::class, 'submit']);
    Route::get(
        'applications/myapplications',
        [JobApplicationApiController::class, 'myApplications']
    );
});

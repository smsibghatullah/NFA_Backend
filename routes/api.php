<?php

use App\Http\Controllers\Api\CandidateApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DocumentApiController;
use App\Http\Controllers\Api\DownloadApiController;
use App\Http\Controllers\Api\EligibilityApiController;
use App\Http\Controllers\Api\JobApiController;
use App\Http\Controllers\Api\JobApplicationApiController;
use App\Http\Controllers\Api\NfaUserApiController;
use App\Http\Controllers\Api\NfaUserProfileApiController;

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
Route::get('/candidates', [CandidateApiController::class, 'index']); // GET /api/candidates?query=...&test_date=...
Route::get('/jobs', [JobApiController::class, 'index']);
// Public (Next.js)
Route::post('nfauser/register', [NfaUserApiController::class, 'register']);
Route::post('nfauser/login', [NfaUserApiController::class, 'login']);

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


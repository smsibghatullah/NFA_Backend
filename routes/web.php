<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DownloadSectionController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\NfaUserController;

// Public routes → guest.custom middleware
Route::middleware('guest.custom:custom')->group(function () {
    Route::get('/register', [AuthController::class, 'registerView'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'loginView'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected routes → auth:custom middleware
Route::middleware('auth:custom')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/documents', [DocumentController::class, 'show'])->name('documents.show');
    Route::get('/documents/add', [DocumentController::class, 'index'])->name('documents.add');
    Route::post('/documents/store', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/view/{id}', [DocumentController::class, 'view'])->name('documents.view');
    Route::get('/downloads', [DownloadSectionController::class, 'show'])->name('downloads.show');
    Route::get('/downloads/add', [DownloadSectionController::class, 'index'])->name('downloads.add');
    Route::post('/downloads/store', [DownloadSectionController::class, 'store'])->name('downloads.store');
    Route::get('/downloads/view/{id}', [DownloadSectionController::class, 'view'])->name('downloads.view');
    Route::get('/candidates/add', [CandidateController::class, 'index'])->name('candidates.add');
    Route::post('/candidates/store', [CandidateController::class, 'store'])->name('candidates.store');
    Route::get('/candidates', [CandidateController::class, 'show'])->name('candidates.show');
    Route::get('/candidates/add', [CandidateController::class, 'index'])->name('candidates.add');
    Route::post('/candidates/store', [CandidateController::class, 'store'])->name('candidates.store');
    Route::post('/candidates/manual-store', [CandidateController::class, 'manualStore'])->name('candidates.manual.store');
    Route::get('/candidates/show', [CandidateController::class, 'show'])->name('candidates.show');
    // Candidates
    Route::get('/candidates', [CandidateController::class, 'show'])->name('candidates.show');
    Route::get('/candidates/edit/{id}', [CandidateController::class, 'edit'])->name('candidates.edit');
    Route::put('/candidates/update/{id}', [CandidateController::class, 'update'])->name('candidates.update');
    // web.php

    // Excel import
    Route::post('/candidates/store', [CandidateController::class, 'store'])->name('candidates.store');

    // Manual store
    Route::post('/candidates/manual/store', [CandidateController::class, 'manualStore'])->name('candidates.manual.store');

    // Show list
    Route::get('/candidates/show', [CandidateController::class, 'show'])->name('candidates.show');

    // Edit candidate
    Route::get('/candidates/edit/{id}', [CandidateController::class, 'edit'])->name('candidates.edit');

    // Update candidate
    Route::put('/candidates/update/{id}', [CandidateController::class, 'update'])->name('candidates.update');

    Route::get('/jobs', [JobListingController::class, 'index'])->name('job-listings.index');
    Route::get('/jobs/add', [JobListingController::class, 'create'])->name('job-listings.create');
    Route::post('/jobs/store', [JobListingController::class, 'store'])->name('job-listings.store');
    Route::get('/jobs/edit/{jobListing}', [JobListingController::class, 'edit'])->name('job-listings.edit');
    Route::put('/jobs/update/{jobListing}', [JobListingController::class, 'update'])->name('job-listings.update');
    Route::delete('/jobs/delete/{jobListing}', [JobListingController::class, 'destroy'])->name('job-listings.destroy');

      Route::get('/nfa-users', [NfaUserController::class, 'index'])->name('nfa-users.index');
Route::post('/nfa-users/{id}/block', [NfaUserController::class, 'block'])->name('nfa-users.block');
Route::post('/nfa-users/{id}/unblock', [NfaUserController::class, 'unblock'])->name('nfa-users.unblock');



Route::get('/applications', [JobApplicationController::class, 'showApplications'])->name('applications.show');


    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Root redirect
Route::get('/', fn() => redirect('/login'));

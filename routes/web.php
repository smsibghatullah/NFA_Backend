<?php

use App\Http\Controllers\AboutPostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DownloadSectionController;
use App\Http\Controllers\ForensicPostController;
use App\Http\Controllers\GeneralInfoController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\NfaUserController;
use App\Http\Controllers\OurServicesController;
use App\Http\Controllers\TrainingAndEducationController;

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
    Route::delete('/downloads/delete/{id}', [DownloadSectionController::class, 'destroy'])
        ->name('downloads.delete');
    Route::delete('/documents/delete/{id}', [DocumentController::class, 'destroy'])
        ->name('documents.delete');
    Route::put('/candidates/{id}', [CandidateController::class, 'update'])
        ->name('candidates.update');

    Route::put('/job-listings/{jobListing}', [JobListingController::class, 'update'])->name('job-listings.update');


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

    Route::get('/about-post', [AboutPostController::class, 'index'])->name('about.index');
    Route::post('/about-post/store', [AboutPostController::class, 'store'])->name('about.store');
    Route::get('/about-post/{id}', [AboutPostController::class, 'show']);
    Route::delete('/about-post/{id}', [AboutPostController::class, 'destroy']);
    Route::get('/applications', [JobApplicationController::class, 'showApplications'])->name('applications.show');
    Route::get('/forensic-posts', [ForensicPostController::class, 'index'])->name('forensic.index');
    Route::post('/forensic-posts', [ForensicPostController::class, 'store'])->name('forensic.store');
    Route::get('/forensic-post/{id}', [ForensicPostController::class, 'show']);
    Route::delete('/forensic-post/{id}', [ForensicPostController::class, 'destroy']);
    Route::prefix('trainingandeducation')->group(function () {
        Route::get('/', [TrainingAndEducationController::class, 'index'])->name('training.index');
        Route::post('/', [TrainingAndEducationController::class, 'store'])->name('training.store');
        Route::get('/{id}', [TrainingAndEducationController::class, 'show'])->name('training.show');
        Route::delete('/{id}', [TrainingAndEducationController::class, 'destroy'])->name('training.destroy');
    });
    Route::prefix('services')->group(function () {
        // Show all services + form
        Route::get('/', [OurServicesController::class, 'index'])->name('services.index');

        // Store new service
        Route::post('/', [OurServicesController::class, 'store'])->name('services.store');



        // View a single service (for modal)
        Route::get('/{id}', function ($id) {
            $service = \App\Models\OurService::findOrFail($id);
            return response()->json($service);
        });

        // Delete a service
        Route::delete('/{id}', function ($id) {
            $service = \App\Models\OurService::findOrFail($id);

            // Delete image from storage
            if ($service->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($service->image);
            }

            $service->delete();
            return response()->json(['success' => true]);
        });
    });
    Route::prefix('general-info')->group(function () {
    Route::get('/', [GeneralInfoController::class, 'index'])->name('generalinfo.index');
    Route::post('/store', [GeneralInfoController::class, 'store'])->name('generalinfo.store');
    Route::get('/edit/{id}', [GeneralInfoController::class, 'edit'])->name('generalinfo.edit');
    Route::post('/update/{id}', [GeneralInfoController::class, 'update'])->name('generalinfo.update');
    Route::delete('/delete/{id}', [GeneralInfoController::class, 'destroy'])->name('generalinfo.delete');
});

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Root redirect
Route::get('/', fn() => redirect('/login'));

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PackageController, 
    ProfileController, 
    EnrolmentController, 
    LogRequestController, 
    BillVettingController, 
    HcpHospitalsController, 
    LogDecisionController,
    UdController,
    CmController,
    MdController,
    AccountController,
    DashboardController,
    UserController,
    GmController,
    DiagnosisController,
    GlobalSearchController,
    PaMonitoringController,
    FeedbackController,
    HcpUploadController
};

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'role:admin,gm,md,ud,cm'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::middleware(['auth', 'role:admin,gm,md'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:staff,admin'])->group(function () {
    Route::get('/staff/dashboard', [DashboardController::class, 'staff'])->name('staff.dashboard');
});

Route::middleware(['auth', 'role:cc,admin'])->group(function () {
    Route::get('/cc/dashboard', [DashboardController::class, 'cc'])->name('cc.dashboard');
});

Route::middleware(['auth', 'role:cm,admin'])->group(function () {
    Route::get('/cm/dashboard', [DashboardController::class, 'cm'])->name('cm.dashboard');
});

Route::middleware(['auth', 'role:ud,admin'])->group(function () {
    Route::get('/ud/dashboard', [DashboardController::class, 'ud'])->name('ud.dashboard');
});

Route::middleware(['auth', 'role:hr,admin'])->group(function () {
    Route::get('/hr/dashboard', [DashboardController::class, 'hr'])->name('hr.dashboard');
});

Route::middleware(['auth', 'role:it,admin'])->group(function () {
    Route::get('/it/dashboard', [DashboardController::class, 'it'])->name('it.dashboard');
});

Route::middleware(['auth', 'role:md,admin'])->group(function () {
    Route::get('/md/dashboard', [DashboardController::class, 'md'])->name('md.dashboard');
});

Route::middleware(['auth', 'role:gm,admin'])->group(function () {
    Route::get('/gm/dashboard', [DashboardController::class, 'gm'])->name('gm.dashboard');
});

Route::middleware(['auth', 'role:hcp,admin,gm,md'])->group(function () {
    Route::get('/hcp/dashboard', [DashboardController::class, 'hcp'])->name('hcp.dashboard');
});

// HCP Uploads - Multi-role access
Route::middleware(['auth'])->group(function () {
    // Admin/Internal Oversight
    Route::get('/hcp-submissions', [HcpUploadController::class, 'adminIndex'])
        ->middleware('role:admin,gm,md,cm,ud,staff,it,accounts')
        ->name('hcp-uploads.admin');
        
    Route::get('/hcp-uploads/{upload}/download', [HcpUploadController::class, 'download'])
        ->name('hcp-uploads.download');

    // Standard Resource (Restricted inside Controller for security)
    Route::resource('hcp-uploads', HcpUploadController::class);
});

Route::middleware('auth')->group(function () {
    
    // --- Profile Management ---
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // --- Standard Resources ---
    Route::post('/log-requests/{id}/approve', [LogRequestController::class, 'approve'])->name('logRequests.approve');
    Route::post('/log-requests/{logRequest}/reject', [LogRequestController::class, 'reject'])->name('logRequests.reject');
    Route::resource('log-requests', LogRequestController::class)->names('logRequests');
    Route::resource('hcps', HcpHospitalsController::class);
    Route::get('/enrolments/{enrolment}/id-card', [EnrolmentController::class, 'idCard'])->name('enrolments.id-card');
    Route::resource('enrolments', EnrolmentController::class);
    Route::resource('packages', PackageController::class);
    Route::resource('diagnoses', DiagnosisController::class);
    Route::resource('monitoring', PaMonitoringController::class);
    Route::resource('feedback', FeedbackController::class);

    // --- Bill Vetting Workstation ---
    Route::get('/portal', function () {
        return view('bill-vetting.portal'); 
    })->name('bill-vetting.portal');

    // 2. Resource route for standard CRUD (exclude problematic routes)
    Route::resource('bill-vetting', BillVettingController::class)->names('bill-vetting')
        ->except(['edit', 'create', 'store', 'update', 'destroy']);

    // --- Helpers & Reports ---
    Route::get('/hcp-search', [CmController::class, 'searchHcp'])->name('hcp.search');
    Route::get('/api/hcp-search', [CmController::class, 'searchHcpApi'])->name('hcp.search.api');
    Route::get('/accounts/pdf/{pa_code}', [AccountController::class, 'generatePdf'])
        ->where('pa_code', '.*')
        ->name('bill-management.accounts.pdf');
    // --- Accounts Department ---
    Route::middleware(['role:admin,accounts'])->group(function () {
        Route::get('/bill-management/accounts', [AccountController::class, 'index'])->name('bill-management.accounts.index');
        Route::patch('/bill-management/accounts/pay/{pa_code}', [AccountController::class, 'pay'])
            ->where('pa_code', '.*')
            ->name('bill-management.accounts.pay');
        Route::get('/accounts/export-csv', [AccountController::class, 'exportCsv'])->name('bill-management.accounts.export-csv');
        
        // Accounts PDF Downloads
        Route::get('/bill-management/accounts/summary-pdf/{pa_code}', [AccountController::class, 'generateSummaryPdf'])
            ->where('pa_code', '.*')
            ->name('bill-management.accounts.summary-pdf');
        Route::get('/bill-management/accounts/comprehensive-pdf/{pa_code}', [AccountController::class, 'generateComprehensivePdf'])
            ->where('pa_code', '.*')
            ->name('bill-management.accounts.comprehensive-pdf');
        Route::get('/accounts/pdf/{pa_code}', [AccountController::class, 'generatePdf'])
            ->where('pa_code', '.*')
            ->name('bill-management.accounts.pdf');
    });

    // CM PDF Downloads
    Route::get('/bill-management/cm/summary-pdf/{pa_code}', [CmController::class, 'generateSummaryPdf'])
        ->where('pa_code', '.*')
        ->name('bill-management.cm.summary-pdf');
    Route::get('/bill-management/cm/comprehensive-pdf/{pa_code}', [CmController::class, 'generateComprehensivePdf'])
        ->where('pa_code', '.*')
        ->name('bill-management.cm.comprehensive-pdf');

    Route::get('api/enrolments/policy/{policy_no}', [EnrolmentController::class, 'getDetailsByPolicy'])
         ->where('policy_no', '.*');

    Route::get('/global-search', [GlobalSearchController::class, 'search'])->name('global.search');
});

Route::get('/bill-vetting/create', [BillVettingController::class, 'create'])->name('bill-vetting.create');
Route::get('/bill-vetting/search-pa/{pa_code}', [BillVettingController::class, 'searchPaCode'])
    ->where('pa_code', '.*')
    ->name('bill-vetting.search-pa');
Route::get('/bill-vetting/{encoded_pa_code}/edit', [BillVettingController::class, 'edit'])->name('bill-vetting.edit');
Route::post('/bill-vetting', [BillVettingController::class, 'store'])->name('bill-vetting.store');
Route::get('/bill-vetting/{encoded_pa_code}/show', [BillVettingController::class, 'show'])->name('bill-vetting.show');
Route::get('/bill-vetting/{encoded_pa_code}/delete', [BillVettingController::class, 'destroy'])->name('bill-vetting.delete');
    // UD Underwriter
    Route::get('/bill-management/ud', [UdController::class, 'index'])->name('bill-management.ud.index');
    Route::get('/bill-management/ud/{id}/show', [UdController::class, 'show'])->name('bill-management.ud.show');
    Route::get('/bill-management/ud/{id}/edit', [UdController::class, 'edit'])->name('bill-management.ud.edit');
    Route::put('/bill-management/ud/{id}', [UdController::class, 'update'])->name('bill-management.ud.update');

    // GM General Manager
    Route::get('/bill-management/gm', [GmController::class, 'index'])->name('bill-management.gm.index');
    Route::get('/bill-management/gm/{id}/edit', [GmController::class, 'edit'])->name('bill-management.gm.edit');
    Route::put('/bill-management/gm/{id}', [GmController::class, 'update'])->name('bill-management.gm.update');

    // MD Medical Director
    Route::get('/bill-management/md', [MdController::class, 'index'])->name('bill-management.md.index');
    Route::get('/bill-management/md/{id}/edit', [MdController::class, 'edit'])->name('bill-management.md.edit');
    Route::put('/bill-management/md/{id}', [MdController::class, 'update'])->name('bill-management.md.update');

    // CM Case Manager
    Route::get('/bill-management/cm', [CmController::class, 'index'])->name('bill-management.cm.index');
    Route::get('/bill-management/cm/{id}/edit', [CmController::class, 'edit'])->name('bill-management.cm.edit');
    Route::put('/bill-management/cm/{id}', [CmController::class, 'update'])->name('bill-management.cm.update');
    Route::get('/bill-management/cm/pdf/{id}', [CmController::class, 'generatePdf'])->name('bill-management.cm.pdf');
    Route::get('/bill-management/cm/export', [CmController::class, 'exportCsv'])->name('bill-management.cm.export');
    Route::get('/api/hcps/{id}', [CmController::class, 'getHcpDetails']);

require __DIR__.'/auth.php';
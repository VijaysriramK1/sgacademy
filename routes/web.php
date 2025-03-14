<?php

use App\Admin\Pages\AdminViewProfile;
use App\Admin\Pages\ViewProfile;
use App\Admin\Resources\AdmissionQueryResource\Pages\PaymentCreateRecord;
use App\Admin\Resources\FeesInvoiceResource\Pages\AddPayment;
use App\Http\Controllers\LeadIntegrstionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\User\UserPanelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/user-logout', 'App\Http\Controllers\User\UserPanelController@userLogout')->name('user.logout');

Route::get('/admin/profile', AdminViewProfile::class)->name('filament.admin.auth.profile');


Route::get('/lead_integration/{id}', [LeadIntegrstionController::class, 'index'])->name('lead_integration');


Route::post('lead-integration/lead-store', [LeadIntegrstionController::class, 'store'])->name('lead_form.store');

Route::get('/admin/feesinvoice/payments/{id}', PaymentCreateRecord::class)
    ->name('filament.admin.admission-queries.payments.create');

    Route::post('/admin/resources/fees-invoices/{record}/add-payment', [AddPayment::class, 'processPayment'])
    ->name('admin.resources.fees-invoices.add-payment.process');


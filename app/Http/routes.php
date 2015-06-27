<?php
Route::any('/member', 'MemberController@index');

/* ADMIN */
Route::any('/', 'FrontController@index');
Route::any('/admin', 'AdminController@index');

/* ADMIN / TRANSACTION */
Route::get('admin/transaction/sales', 'AdminSalesController@index');
Route::get('admin/transaction/claims', 'AdminClaimController@index');
Route::get('admin/transaction/payout', 'AdminPayoutController@index');
Route::get('admin/transaction/unilevel', 'AdminUnilevelController@index');

/* ADMIN / MAINTENANCE */
Route::get('admin/maintenance/accounts', 'AdminAccountController@index');
Route::get('admin/maintenance/accounts/data', 'AdminAccountController@data');
Route::any('admin/maintenance/accounts/add', 'AdminAccountController@add');
Route::any('admin/maintenance/accounts/edit', 'AdminAccountController@edit');

Route::post('admin/maintenance/accounts/archive', 'AdminAccountController@archive_account');
Route::post('admin/maintenance/accounts/restore', 'AdminAccountController@restore_account');

Route::any('admin/maintenance/accounts/field', 'AdminAccountController@field');
Route::get('admin/maintenance/accounts/field/delete', 'AdminAccountController@field_delete');
Route::get('admin/maintenance/codes', 'AdminCodeController@index');


Route::get('admin/maintenance/product', 'AdminProductController@index');
Route::any('admin/maintenance/product/add', 'AdminProductController@add_product');
Route::any('admin/maintenance/product/edit', 'AdminProductController@edit_product');
Route::get('admin/maintenance/product/get_product', 'AdminProductController@ajax_get_product');
Route::post('admin/maintenance/product/archive', 'AdminProductController@archive_product');
Route::post('admin/maintenance/product/restore', 'AdminProductController@restore_product');

/**
 * PRODUCT PACKAGE CONTROLLER
 */
Route::get('admin/maintenance/product_package', 'AdminProductPackageController@index');
Route::get('admin/maintenance/product_package/get', 'AdminProductPackageController@ajax_get_product_package');
Route::any('admin/maintenance/product_package/add', 'AdminProductPackageController@add_product_package');
Route::any('admin/maintenance/product_package/get_product', 'AdminProductPackageController@ajax_get_product');




Route::get('admin/maintenance/slots', 'AdminSlotController@index');
Route::get('admin/maintenance/slots/data', 'AdminSlotController@data');
Route::get('admin/maintenance/slots/add', 'AdminSlotController@add');
Route::get('admin/maintenance/slots/edit', 'AdminSlotController@edit');
Route::get('admin/maintenance/slots/archive', 'AdminSlotController@archive');
Route::get('admin/maintenance/slots/add_form', 'AdminSlotController@add_form');
Route::get('admin/maintenance/slots/edit_form', 'AdminSlotController@edit_form');
Route::post('admin/maintenance/slots/add_form_submit', 'AdminSlotController@add_form_submit');
Route::post('admin/maintenance/slots/edit_form_submit', 'AdminSlotController@edit_form_submit');
Route::get('admin/maintenance/slots/downline', 'AdminSlotController@downline');

Route::get('admin/maintenance/country', 'AdminCountryController@index');
Route::any('admin/maintenance/country/add', 'AdminCountryController@add_country');
Route::any('admin/maintenance/country/edit', 'AdminCountryController@edit_country');
Route::post('admin/maintenance/country/archive', 'AdminCountryController@archive_country');
Route::post('admin/maintenance/country/restore', 'AdminCountryController@restore_country');
Route::get('admin/maintenance/country/get_country', 'AdminCountryController@get_country');
Route::get('admin/maintenance/deduction', 'AdminDeductionController@index');
Route::get('admin/maintenance/membership', 'AdminMembershipController@index');
Route::any('admin/maintenance/membership/data', 'AdminMembershipController@data');
Route::any('admin/maintenance/membership/edit', 'AdminMembershipController@edit');
Route::any('admin/maintenance/membership/archive', 'AdminMembershipController@archive_membership');
Route::any('admin/maintenance/membership/restore', 'AdminMembershipController@restore_membership');
Route::any('admin/maintenance/membership/add', 'AdminMembershipController@add');
Route::any('admin/maintenance/membership/edit', 'AdminMembershipController@edit');

Route::get('admin/maintenance/ranking', 'AdminRankingController@index');
Route::any('admin/maintenance/ranking/data', 'AdminRankingController@data');
Route::any('admin/maintenance/ranking/edit', 'AdminRankingController@edit');
Route::any('admin/maintenance/ranking/archive', 'AdminRankingController@archive');
Route::any('admin/maintenance/ranking/add', 'AdminRankingController@add');

/* ADMIN / UTILITIES */
Route::get('admin/utilities/admin', 'AdminAdminController@index');
Route::get('admin/utilities/position', 'AdminPositionController@index');
Route::get('admin/utilities/setting', 'AdminSettingsController@index');
Route::get('admin/utilities/complan', 'AdminComplanController@index');

/* ADMIN / UTILITIES */
Route::get('admin/reports/product_sales', 'AdminReportController@product_sales');
Route::get('admin/reports/membership_sales', 'AdminReportController@membership_sales');
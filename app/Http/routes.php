<?php
Route::any('/neil', 'NeilController@index');

/* MEMBER */
Route::any('/member', 'MemberDashboardController@index');
Route::any('/member/slot', 'MemberSlotController@index');
Route::any('/member/code_vault', 'MemberCodeController@index');
Route::any('/member/encashment', 'MemberEncashmentController@index');
Route::any('/member/genealogy', 'MemberGenealogyController@index');
Route::any('/member/voucher', 'MemberVoucherController@index');
Route::any('/member/leads', 'MemberLeadController@index');
Route::any('/member/product', 'MemberProductController@index');
Route::any('/member/login', 'MemberLoginController@index');
Route::any('/member/logout', 'MemberLoginController@logout');
Route::any('/member/register', 'MemberRegisterController@index');
/* ADMIN */
Route::any('/', 'FrontController@index');
Route::any('/about', 'FrontController@about');
Route::any('/earn', 'FrontController@earn');
Route::any('/partner', 'FrontController@partner');
Route::any('/service', 'FrontController@service');
Route::any('/product', 'FrontController@product');
Route::any('/product_content', 'FrontController@product_content');
Route::any('/news', 'FrontController@news');
Route::any('/news_content', 'FrontController@news_content');
Route::any('/contact', 'FrontController@contact');
Route::any('/contact/submit', 'FrontController@contact_submit');
Route::any('/register', 'FrontController@register');
Route::get('/admin', 'AdminController@index');
Route::post('/admin','AdminController@postLogin');

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

/* PARTNER MANAGEMENT */
Route::get('admin/maintenance/partner', 'AdminPartnerController@index');
Route::get('admin/maintenance/partner/add', 'AdminPartnerController@add');
Route::any('admin/maintenance/partner/add_submit', 'AdminPartnerController@add_submit');
Route::get('admin/maintenance/partner/edit', 'AdminPartnerController@edit');
Route::any('admin/maintenance/partner/edit_submit', 'AdminPartnerController@edit_submit');
Route::any('admin/maintenance/partner/delete', 'AdminPartnerController@delete');

/* TESTIMONY MANAGEMENT */
Route::get('admin/maintenance/testimony', 'AdminTestimonyController@index');
Route::get('admin/maintenance/testimony/add', 'AdminTestimonyController@add');
Route::any('admin/maintenance/testimony/add_submit', 'AdminTestimonyController@add_submit');
Route::get('admin/maintenance/testimony/edit', 'AdminTestimonyController@edit');
Route::any('admin/maintenance/testimony/edit_submit', 'AdminTestimonyController@edit_submit');
Route::any('admin/maintenance/testimony/delete', 'AdminTestimonyController@delete');

/* SLIDE MANAGEMENT */
Route::get('admin/maintenance/slide', 'AdminSlideController@index');
Route::get('admin/maintenance/slide/add', 'AdminSlideController@add');
Route::any('admin/maintenance/slide/add_submit', 'AdminSlideController@add_submit');
Route::get('admin/maintenance/slide/edit', 'AdminSlideController@edit');
Route::any('admin/maintenance/slide/edit_submit', 'AdminSlideController@edit_submit');
Route::any('admin/maintenance/slide/delete', 'AdminSlideController@delete');


/* NEWS MANAGEMENT */
Route::get('admin/maintenance/news', 'AdminNewsController@index');
Route::get('admin/maintenance/news/add', 'AdminNewsController@add');
Route::any('admin/maintenance/news/add_submit', 'AdminNewsController@add_submit');
Route::get('admin/maintenance/news/edit', 'AdminNewsController@edit');
Route::any('admin/maintenance/news/edit_submit', 'AdminNewsController@edit_submit');
Route::any('admin/maintenance/news/delete', 'AdminNewsController@delete');

/* EARN MANAGEMENT */
Route::get('admin/maintenance/earn', 'AdminEarnController@index');
Route::get('admin/maintenance/earn/add', 'AdminEarnController@add');
Route::any('admin/maintenance/earn/add_submit', 'AdminEarnController@add_submit');
Route::get('admin/maintenance/earn/edit', 'AdminEarnController@edit');
Route::any('admin/maintenance/earn/edit_submit', 'AdminEarnController@edit_submit');
Route::any('admin/maintenance/earn/delete', 'AdminEarnController@delete');

/* Team MANAGEMENT */
Route::get('admin/maintenance/team', 'AdminTeamController@index');
Route::get('admin/maintenance/team/add', 'AdminTeamController@add');
Route::any('admin/maintenance/team/add_submit', 'AdminTeamController@add_submit');
Route::get('admin/maintenance/team/edit', 'AdminTeamController@edit');
Route::any('admin/maintenance/team/edit_submit', 'AdminTeamController@edit_submit');
Route::any('admin/maintenance/team/delete', 'AdminTeamController@delete');

/**
 * MEMBERSHIP CODE GENERATOR
 */
Route::get('admin/maintenance/codes', 'AdminCodeController@index');
Route::any('admin/maintenance/codes/add', 'AdminCodeController@add_code');
Route::any('admin/maintenance/codes/edit', 'AdminCodeController@edit_code');
Route::get('admin/maintenance/codes/get', 'AdminCodeController@ajax_get_membership_code');
Route::post('admin/maintenance/codes/block', 'AdminCodeController@block');
Route::post('admin/maintenance/codes/transfer_code', 'AdminCodeController@transfer_code');
Route::get('admin/maintenance/codes/verify_code', 'AdminCodeController@verify_code');

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
Route::any('admin/maintenance/product_package/edit', 'AdminProductPackageController@edit_product_package');
Route::any('admin/maintenance/product_package/get_product', 'AdminProductPackageController@ajax_get_product');
Route::post('admin/maintenance/product_package/archive', 'AdminProductPackageController@archive_product_package');
Route::post('admin/maintenance/product_package/restore', 'AdminProductPackageController@restore_product_package');


/* SLOTS MAINTENANCE */
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
Route::get('admin/maintenance/slots/delete', 'AdminSlotController@delete');

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
Route::any('admin/maintenance/ranking/edit', 'AdminRankingController@edit_ranking');
Route::any('admin/maintenance/ranking/delete', 'AdminRankingController@delete_ranking');
Route::any('admin/maintenance/ranking/add', 'AdminRankingController@add_ranking');

/* MAINTENANCE / INVENTORY */
Route::get('admin/maintenance/inventory', 'AdminInventoryController@index');


/* ADMIN / UTILITIES */
Route::get('admin/utilities/admin_maintenance', 'AdminAdminController@index');
Route::get('admin/utilities/admin_maintenance/data','AdminAdminController@data');
Route::get('admin/utilities/admin_maintenance/add','AdminAdminController@admin_add');
Route::post('admin/utilities/admin_maintenance/add','AdminAdminController@create_admin');
Route::get('admin/utilities/admin_maintenance/edit','AdminAdminController@admin_edit');
Route::post('admin/utilities/admin_maintenance/edit','AdminAdminController@update_admin');
Route::post('admin/utilities/admin_maintenance/delete','AdminAdminController@delete_admin');
Route::get('admin/utilities/position', 'AdminPositionController@index');
Route::get('admin/utilities/position/data', 'AdminPositionController@data');
Route::get('admin/utilities/position/add', 'AdminPositionController@add');
Route::post('admin/utilities/position/add', 'AdminPositionController@create');
Route::any('admin/utilities/position/edit', 'AdminPositionController@edit');
Route::post('admin/utilities/position/edit', 'AdminPositionController@update');
Route::post('admin/utilities/position/delete', 'AdminPositionController@delete');

Route::get('admin/utilities/setting', 'AdminSettingsController@index');
Route::get('admin/utilities/complan', 'AdminComplanController@index');

/* ADMIN / UTILITIES */
Route::get('admin/reports/product_sales', 'AdminReportController@product_sales');
Route::get('admin/reports/membership_sales', 'AdminReportController@membership_sales');


Route::any('admin/login', 'AdminLoginController@index');
Route::any('admin/account/logout', 'AdminProfileController@logout');

Route::get('cart', 'CartController@index');
Route::post('cart/add', 'CartController@add_to_cart');
Route::post('cart/remove', 'CartController@remove_to_cart');
Route::get('cart/checkout', 'MemberCheckoutController@checkout');
Route::post('cart/checkout', 'MemberCheckoutController@checkout');

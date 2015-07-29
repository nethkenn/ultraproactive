<?php
// Route::any('/neil', 'NeilController@index');

/* MEMBER */
Route::any('/member', 'MemberDashboardController@index');
Route::any('/member/notification', 'MemberDashboardController@notification');
Route::any('/member/slot', 'MemberSlotController@index');
Route::any('/member/code_vault', 'MemberCodeController@index');
Route::any('/member/code_vault/use_product_code', 'MemberCodeController@use_product_code');
Route::any('/member/code_vault/check', 'MemberCodeController@add_form_submit');
Route::any('/member/code_vault/get', 'MemberCodeController@get');
Route::post('/member/code_vault/lock', 'MemberCodeController@set_active');
Route::post('/member/code_vault/lock2', 'MemberCodeController@set_active2');
Route::any('/member/encashment', 'MemberEncashmentController@index');
Route::any('/member/genealogy', 'MemberGenealogyController@index');
Route::any('/member/genealogy/tree', 'MemberGenealogyController@tree');
Route::any('/member/genealogy/downline', 'MemberGenealogyController@downline');

Route::any('/member/voucher', 'MemberVoucherController@index');
Route::get('/member/voucher/product', 'MemberVoucherController@showVoucherProduct');

Route::any('/member/settings', 'MemberAccountSettingsController@index');
Route::any('/member/settings/upload', 'MemberAccountSettingsController@upload');

Route::any('/member/leads', 'MemberLeadController@index');
Route::any('/member/leads/{slug}', 'MemberLeadController@link');
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
Route::get('admin/transaction/sales/data', 'AdminSalesController@get_sales');
Route::get('admin/transaction/sales/process', 'AdminSalesController@process_sale');
Route::post('admin/transaction/sales/add_to_cart', 'AdminSalesController@add_to_cart');
Route::get('admin/transaction/sales/get_cart', 'AdminSalesController@get_cart');
Route::post('admin/transaction/sales/remove_to_cart', 'AdminSalesController@remove_to_cart');
Route::post('admin/transaction/sales/edit_cart', 'AdminSalesController@edit_cart');
Route::post('admin/transaction/sales/process/member', 'AdminSalesController@process_member');
Route::post('admin/transaction/sales/process/non-member', 'AdminSalesController@process_nonMember');
Route::get('admin/transaction/sales/process/get_slots', 'AdminSalesController@get_slot');
/**
 * ADMIN TRANSACTION CLAIMS
 */
Route::get('admin/transaction/claims', 'AdminClaimController@index');
Route::get('admin/transaction/claims/data', 'AdminClaimController@data');
Route::any('admin/transaction/claims/check', 'AdminClaimController@check');
Route::post('admin/transaction/claims/claim', 'AdminClaimController@claim');
Route::post('admin/transaction/claims/void', 'AdminClaimController@void');
Route::get('admin/transaction/claims/show_product', 'AdminClaimController@show_product');

Route::any('admin/transaction/payout', 'AdminPayoutController@index');
Route::any('admin/transaction/payout/data', 'AdminPayoutController@data');
Route::any('admin/transaction/payout/edit', 'AdminPayoutController@edit');
Route::any('admin/transaction/payout/add', 'AdminPayoutController@add');
Route::any('admin/transaction/payout/archive', 'AdminPayoutController@archive');
Route::any('admin/transaction/payout/restore', 'AdminPayoutController@restore');

Route::any('admin/transaction/unilevel', 'AdminUnilevelController@index');
Route::any('admin/transaction/unilevel/dynamic', 'AdminUnilevelController@indexs');
Route::any('admin/transaction/unilevel/dynamic/setting', 'AdminUnilevelController@setting');

/* ADMIN / MAINTENANCE */
Route::get('admin/maintenance/accounts', 'AdminAccountController@index');
Route::get('admin/maintenance/accounts/data', 'AdminAccountController@data');
Route::any('admin/maintenance/accounts/add', 'AdminAccountController@add');
Route::any('admin/maintenance/accounts/edit', 'AdminAccountController@edit');

Route::post('admin/maintenance/accounts/archive', 'AdminAccountController@archive_account');
Route::post('admin/maintenance/accounts/restore', 'AdminAccountController@restore_account');

Route::any('admin/maintenance/accounts/field', 'AdminAccountController@field');
Route::get('admin/maintenance/accounts/field/delete', 'AdminAccountController@field_delete');

/* PRODUCT CATEGORY */
Route::get('admin/maintenance/product_category', 'AdminProductCategoryController@index');
Route::get('admin/maintenance/product_category/add', 'AdminProductCategoryController@add');
Route::any('admin/maintenance/product_category/add_submit', 'AdminProductCategoryController@add_submit');
Route::get('admin/maintenance/product_category/edit', 'AdminProductCategoryController@edit');
Route::any('admin/maintenance/product_category/edit_submit', 'AdminProductCategoryController@edit_submit');
Route::any('admin/maintenance/product_category/delete', 'AdminProductCategoryController@delete');

/* SERVICES MANAGEMENT */
Route::get('admin/content/service', 'AdminServiceController@index');
Route::get('admin/content/service/add', 'AdminServiceController@add');
Route::any('admin/content/service/add_submit', 'AdminServiceController@add_submit');
Route::get('admin/content/service/edit', 'AdminServiceController@edit');
Route::any('admin/content/service/edit_submit', 'AdminServiceController@edit_submit');
Route::any('admin/content/service/delete', 'AdminServiceController@delete');

/* ABOUT MANAGEMENT */
Route::get('admin/content/about/', 'AdminAboutController@index');
Route::any('admin/content/about/submit', 'AdminAboutController@submit');

/* PARTNER MANAGEMENT */
Route::get('admin/content/partner', 'AdminPartnerController@index');
Route::get('admin/content/partner/add', 'AdminPartnerController@add');
Route::any('admin/content/partner/add_submit', 'AdminPartnerController@add_submit');
Route::get('admin/content/partner/edit', 'AdminPartnerController@edit');
Route::any('admin/content/partner/edit_submit', 'AdminPartnerController@edit_submit');
Route::any('admin/content/partner/delete', 'AdminPartnerController@delete');

/* TESTIMONY MANAGEMENT */
Route::get('admin/content/testimony', 'AdminTestimonyController@index');
Route::get('admin/content/testimony/add', 'AdminTestimonyController@add');
Route::any('admin/content/testimony/add_submit', 'AdminTestimonyController@add_submit');
Route::get('admin/content/testimony/edit', 'AdminTestimonyController@edit');
Route::any('admin/content/testimony/edit_submit', 'AdminTestimonyController@edit_submit');
Route::any('admin/content/testimony/delete', 'AdminTestimonyController@delete');

/* SLIDE MANAGEMENT */
Route::get('admin/content/slide', 'AdminSlideController@index');
Route::get('admin/content/slide/add', 'AdminSlideController@add');
Route::any('admin/content/slide/add_submit', 'AdminSlideController@add_submit');
Route::get('admin/content/slide/edit', 'AdminSlideController@edit');
Route::any('admin/content/slide/edit_submit', 'AdminSlideController@edit_submit');
Route::any('admin/content/slide/delete', 'AdminSlideController@delete');


/* NEWS MANAGEMENT */
Route::get('admin/content/news', 'AdminNewsController@index');
Route::get('admin/content/news/add', 'AdminNewsController@add');
Route::any('admin/content/news/add_submit', 'AdminNewsController@add_submit');
Route::get('admin/content/news/edit', 'AdminNewsController@edit');
Route::any('admin/content/news/edit_submit', 'AdminNewsController@edit_submit');
Route::any('admin/content/news/delete', 'AdminNewsController@delete');

/* EARN MANAGEMENT */
Route::get('admin/content/earn', 'AdminEarnController@index');
Route::get('admin/content/earn/add', 'AdminEarnController@add');
Route::any('admin/content/earn/add_submit', 'AdminEarnController@add_submit');
Route::get('admin/content/earn/edit', 'AdminEarnController@edit');
Route::any('admin/content/earn/edit_submit', 'AdminEarnController@edit_submit');
Route::any('admin/content/earn/delete', 'AdminEarnController@delete');

/* Team MANAGEMENT */
Route::get('admin/content/team', 'AdminTeamController@index');
Route::get('admin/content/team/add', 'AdminTeamController@add');
Route::any('admin/content/team/add_submit', 'AdminTeamController@add_submit');
Route::get('admin/content/team/edit', 'AdminTeamController@edit');
Route::any('admin/content/team/edit_submit', 'AdminTeamController@edit_submit');
Route::any('admin/content/team/delete', 'AdminTeamController@delete');

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
Route::get('admin/maintenance/codes/or', 'AdminCodeController@show_sale_or');


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
Route::any('admin/maintenance/slots/view', 'AdminSlotController@info');

Route::get('admin/maintenance/country', 'AdminCountryController@index');
Route::any('admin/maintenance/country/add', 'AdminCountryController@add_country');
Route::any('admin/maintenance/country/edit', 'AdminCountryController@edit_country');
Route::post('admin/maintenance/country/archive', 'AdminCountryController@archive_country');
Route::post('admin/maintenance/country/restore', 'AdminCountryController@restore_country');
Route::get('admin/maintenance/country/get_country', 'AdminCountryController@get_country');
Route::any('admin/maintenance/deduction', 'AdminDeductionController@index');
Route::any('admin/maintenance/deduction/add', 'AdminDeductionController@add');
Route::any('admin/maintenance/deduction/edit', 'AdminDeductionController@edit');
Route::any('admin/maintenance/deduction/archive', 'AdminDeductionController@archive');
Route::any('admin/maintenance/deduction/restore', 'AdminDeductionController@restore');
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
Route::any('admin/maintenance/inventory', 'AdminInventoryController@index');
Route::any('admin/maintenance/inventory/get_inventory', 'AdminInventoryController@ajax_get_product');


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
Route::post('admin/utilities/position/restore', 'AdminPositionController@restore');

/* ADMIN / SETTINGS */
Route::get('admin/utilities/setting', 'AdminSettingsController@index');
Route::any('admin/utilities/setting/submit', 'AdminSettingsController@submit');

Route::get('admin/utilities/complan', 'AdminComplanController@index');

/* ADMIN / UTITLITIES / COMPTATION */
Route::get('admin/utilities/binary', 'AdminComplanController@binary');
Route::any('admin/utilities/binary/edit', 'AdminComplanController@binary_edit');
Route::any('admin/utilities/binary/add', 'AdminComplanController@binary_add');
Route::any('admin/utilities/binary/delete', 'AdminComplanController@binary_delete');
Route::any('admin/utilities/binary/membership/edit', 'AdminComplanController@binary_membership_edit');
Route::any('admin/utilities/binary/product/edit', 'AdminComplanController@binary_product_edit');

Route::any('admin/utilities/matching', 'AdminComplanController@matching');
Route::any('admin/utilities/matching/edit', 'AdminComplanController@matching_edit');

Route::any('admin/utilities/direct', 'AdminComplanController@direct');
Route::any('admin/utilities/direct/edit', 'AdminComplanController@direct_edit');

Route::any('admin/utilities/indirect', 'AdminComplanController@indirect');
Route::any('admin/utilities/indirect/edit', 'AdminComplanController@indirect_edit');

Route::any('admin/utilities/unilevel', 'AdminComplanController@unilevel');
Route::any('admin/utilities/unilevel/edit', 'AdminComplanController@unilevel_edit');


Route::any('admin/utilities/rank', 'AdminComplanController@rank');
Route::any('admin/utilities/rank/edit', 'AdminComplanController@rank_edit');

/* ADMIN / REPORTS */
Route::any('admin/reports/product_sales', 'AdminReportController@product_sales');
Route::any('admin/reports/membership_sales', 'AdminReportMembershipController@index');

Route::any('admin/account/settings/profile', 'AdminAccountSettingsController@settings');
Route::any('admin/account/settings/change_pass', 'AdminAccountSettingsController@changepass');

Route::any('admin/login', 'AdminLoginController@index');
Route::any('admin/account/logout', 'AdminProfileController@logout');

Route::get('cart', 'CartController@index');
Route::post('cart/add', 'CartController@add_to_cart');
Route::post('cart/remove', 'CartController@remove_to_cart');
Route::get('cart/checkout', 'MemberCheckoutController@checkout');
Route::post('cart/checkout', 'MemberCheckoutController@checkout');
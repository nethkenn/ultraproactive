<?php
// Route::any('/neil', 'NeilController@index');

/* Developer's Area*/
Route::any('admin/developer/migration', 'AdminDevelopersController@migration');
Route::any('admin/migration/disable', 'AdminDevelopersController@area_disable');
Route::any('admin/developer/re_entry', 'AdminDevelopersController@re_entry');
Route::any('admin/developer/re_adjust_cd', 'AdminDevelopersController@re_adjust_cd');
Route::any('admin/developer/adjust_gc', 'AdminDevelopersController@adjust_gc');
// Route::any('admin/developer/negativecd', 'AdminDevelopersController@negativecd');
/* INCOME PROJECTION */
Route::any('/projection', 'ProjectionController@index');

/* MEMBER */
Route::any('/member', 'MemberDashboardController@index');
Route::any('/member/notification', 'MemberDashboardController@notification');
Route::any('/member/slot', 'MemberSlotController@index');
Route::any('/member/slot/changeslot', 'MemberSlotController@changeslot');
Route::any('/member/code_vault', 'MemberCodeController@index');
Route::any('/member/code_vault/use_product_code', 'MemberCodeController@use_product_code');
Route::any('/member/code_vault/check', 'MemberCodeController@add_form_submit');
Route::any('/member/code_vault/get', 'MemberCodeController@get');
Route::post('/member/code_vault/lock', 'MemberCodeController@set_active');
Route::post('/member/code_vault/lock2', 'MemberCodeController@set_active2');
Route::any('/member/encashment', 'MemberEncashmentController@index');
Route::any('/member/redeem', 'MemberEncashmentController@redeem');
Route::any('/member/genealogy', 'MemberGenealogyController@index');
Route::any('/member/genealogy/add_form', 'MemberGenealogyController@add_form');
Route::any('/member/genealogy/add_form_message', 'MemberGenealogyController@add_form_message');
Route::any('/member/genealogy/tree', 'MemberGenealogyController@tree');
Route::any('/member/genealogy/get', 'MemberGenealogyController@get');
// Route::any('/member/genealogy/getsponsor', 'MemberGenealogyController@getsponsor');
Route::any('/member/genealogy/downline', 'MemberGenealogyController@downline');
Route::any('/member/reports/income_breakdown', 'MemberReportController@breakdown');
Route::any('/member/reports/income_summary', 'MemberReportController@summary');
Route::any('/member/reports/genealogy_list', 'MemberReportController@genealogy_list');
Route::any('/member/gene/genealogy_list', 'MemberReportController@genealogy_list');
Route::any('/member/reports/encashment_history', 'MemberReportController@encashment_history');
Route::any('/member/reports/upcoin_report', 'MemberReportController@upcoin_report');


/* Transfer wallet */
// Route::any('/member/transfer_wallet', 'MemberTransferWalletController@index');
// Route::any('/member/transfer_wallet/get', 'MemberTransferWalletController@get');

/* Voucher */
Route::any('/member/voucher', 'MemberVoucherController@index');
Route::get('/member/voucher/product', 'MemberVoucherController@showVoucherProduct');

/* Settings */
Route::any('/member/settings', 'MemberAccountSettingsController@index');
Route::any('/member/settings/upload', 'MemberAccountSettingsController@upload');

Route::any('/member/leads', 'MemberLeadController@index');
Route::post('/member/leads/manual-add', 'MemberLeadController@saveLeadManual');
// Route::any('/member/leads/', 'MemberLeadController@link');
Route::any('/member/product', 'MemberProductController@index');
Route::any('/member/login', 'MemberLoginController@index');
Route::any('/member/logout', 'MemberLoginController@logout');
Route::any('/member/register', 'MemberRegisterController@index');
/* ADMIN */
Route::any('/', 'FrontController@index');
Route::any('/about', 'FrontController@about');
Route::any('/opportunity', 'FrontController@opportunity');
Route::any('/mindsync', 'FrontController@mindsync');
Route::any('/stories', 'FrontController@stories');
Route::any('/product', 'FrontController@product');
Route::any('/product_content', 'FrontController@product_content');
Route::any('/news', 'FrontController@news');
Route::any('/news_content', 'FrontController@news_content');
Route::any('/contact', 'FrontController@contact');
Route::any('/contact/submit', 'FrontController@contact_submit');
Route::any('/faq', 'FrontController@faq');
Route::any('/foodcart', 'FrontController@foodcart');
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
Route::any('admin/transaction/sales/process/sale_or', 'AdminSalesController@sale_or' );


/* ADMIN TRANSFER REQUEST SLOT */
Route::any('admin/transaction/sales/transfer_slot_request', 'AdminTransferRequestSlotController@index');
Route::any('admin/transaction/sales/transfer_slot_request/transfer', 'AdminTransferRequestSlotController@transfer_get');
Route::any('admin/transaction/sales/transfer_slot_request/transfer_decline', 'AdminTransferRequestSlotController@transfer_get_decline');

/* ADMIN / TRANSACTION / REDEEM */
Route::get('admin/transaction/redeem', 'AdminRedeemController@index');
Route::get('admin/transaction/redeem/data', 'AdminRedeemController@get_redeem');
Route::get('admin/transaction/redeem/claim/{id}', 'AdminRedeemController@claim');

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
Route::any('admin/transaction/payout/checked', 'AdminPayoutController@checked');

/* Unilevel Compression*/
// Route::any('admin/transaction/unilevel-distribution/dynamic', 'AdminUnilevelController@indexs');
// Route::any('admin/transaction/unilevel-distribution', 'AdminUnilevelController@index');

// Route::any('admin/transaction/unilevel-distribution/dynamic/setting', 'AdminUnilevelController@setting');
/* Global Pool Sharing - Admin */
Route::any('admin/transaction/global_pool_sharing', 'AdminGlobalPoolSharingController@index');
Route::any('admin/transaction/global_pool_sharing/delete/{id}', 'AdminGlobalPoolSharingController@delete_gps');
Route::any('admin/transaction/global_pool_sharing/details/{id}', 'AdminGlobalPoolSharingController@details');

/* ADMIN / MAINTENANCE */
Route::any('admin/maintenance/accounts', 'AdminAccountController@index');
Route::get('admin/maintenance/accounts/data', 'AdminAccountController@data');
Route::any('admin/maintenance/accounts/add', 'AdminAccountController@add');
Route::any('admin/maintenance/accounts/edit', 'AdminAccountController@edit');

Route::post('admin/maintenance/accounts/archive', 'AdminAccountController@archive_account');
Route::post('admin/maintenance/accounts/restore', 'AdminAccountController@restore_account');

Route::any('admin/maintenance/accounts/field', 'AdminAccountController@field');
Route::get('admin/maintenance/accounts/field/delete', 'AdminAccountController@field_delete');

Route::any('admin/maintenance/account_block', 'AdminAccountBlockController@index');
Route::any('admin/maintenance/account_block/blocked', 'AdminAccountBlockController@index');
Route::any('admin/maintenance/account_block/data', 'AdminAccountBlockController@data');
Route::any('admin/maintenance/account_block/block', 'AdminAccountBlockController@block');
Route::any('admin/maintenance/account_block/unblock', 'AdminAccountBlockController@unblock');

/* FOODCART */
Route::get('admin/content/foodcart', 'AdminFoodCartController@index');
Route::get('admin/content/foodcart/add', 'AdminFoodCartController@add');
Route::any('admin/content/foodcart/add_submit', 'AdminFoodCartController@add_submit');
Route::get('admin/content/foodcart/edit', 'AdminFoodCartController@edit');
Route::any('admin/content/foodcart/edit_submit', 'AdminFoodCartController@edit_submit');
Route::any('admin/content/foodcart/delete', 'AdminFoodCartController@delete');

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

/* FAQ MANAGEMENT */
Route::get('admin/content/faq', 'AdminFaqController@index');
Route::any('admin/content/faq/add', 'AdminFaqController@add');
Route::any('admin/content/faq/edit', 'AdminFaqController@edit');
Route::any('admin/content/faq/delete', 'AdminFaqController@delete');

/* MINDSYNC MANAGEMENT */
Route::get('admin/content/mindsync', 'AdminMindSyncController@index');
Route::get('admin/content/mindsync/video', 'AdminMindSyncController@video');
Route::get('admin/content/mindsync/image', 'AdminMindSyncController@image');
Route::get('admin/content/mindsync/testimony', 'AdminMindSyncController@testimony');
Route::get('admin/content/mindsync/video/add', 'AdminMindSyncController@video_add');
Route::any('admin/content/mindsync/video/add_submit', 'AdminMindSyncController@video_add_submit');
Route::get('admin/content/mindsync/video/edit', 'AdminMindSyncController@video_edit');
Route::any('admin/content/mindsync/video/edit_submit', 'AdminMindSyncController@video_edit_submit');
Route::any('admin/content/mindsync/video/delete', 'AdminMindSyncController@video_delete');
Route::get('admin/content/mindsync/image/add', 'AdminMindSyncController@image_add');
Route::any('admin/content/mindsync/image/add_submit', 'AdminMindSyncController@image_add_submit');
Route::get('admin/content/mindsync/image/edit', 'AdminMindSyncController@image_edit');
Route::any('admin/content/mindsync/image/edit_submit', 'AdminMindSyncController@image_edit_submit');
Route::any('admin/content/mindsync/image/delete', 'AdminMindSyncController@image_delete');
Route::get('admin/content/mindsync/testimony/add', 'AdminMindSyncController@testimony_add');
Route::any('admin/content/mindsync/testimony/add_submit', 'AdminMindSyncController@testimony_add_submit');
Route::get('admin/content/mindsync/testimony/edit', 'AdminMindSyncController@testimony_edit');
Route::any('admin/content/mindsync/testimony/edit_submit', 'AdminMindSyncController@testimony_edit_submit');
Route::any('admin/content/mindsync/testimony/delete', 'AdminMindSyncController@testimony_delete');

/* STORIES MANAGEMENT */
Route::get('admin/content/stories', 'AdminStoriesController@index');
Route::get('admin/content/stories/add', 'AdminStoriesController@add');
Route::any('admin/content/stories/add_submit', 'AdminStoriesController@add_submit');
Route::get('admin/content/stories/edit', 'AdminStoriesController@edit');
Route::any('admin/content/stories/edit_submit', 'AdminStoriesController@edit_submit');
Route::any('admin/content/stories/delete', 'AdminStoriesController@delete');

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
Route::any('admin/content/team/sort', 'AdminTeamController@sort');
Route::any('admin/content/team/sort_submit', 'AdminTeamController@sort_submit');
Route::any('admin/content/team/delete', 'AdminTeamController@delete');

/**
 * MEMBERSHIP CODE GENERATOR
 */
Route::get('admin/maintenance/codes/load-product-package', 'AdminCodeController@load_product_package');
Route::get('admin/maintenance/codes', 'AdminCodeController@index');
Route::get('admin/maintenance/codes/add', 'AdminCodeController@add_code');
Route::post('admin/maintenance/codes/add', 'AdminCodeController@addCodePost');
Route::any('admin/maintenance/codes/edit', 'AdminCodeController@edit_code');
Route::get('admin/maintenance/codes/get', 'AdminCodeController@ajax_get_membership_code');
Route::post('admin/maintenance/codes/block', 'AdminCodeController@block');
Route::post('admin/maintenance/codes/unblock', 'AdminCodeController@unblock');
Route::post('admin/maintenance/codes/transfer_code', 'AdminCodeController@transfer_code');
Route::get('admin/maintenance/codes/verify_code', 'AdminCodeController@verify_code');
Route::any('admin/maintenance/codes/or', 'AdminCodeController@show_sale_or');
Route::post('admin/maintenance/codes/add-to-cart', 'AdminCodeController@addToCart');
Route::get('admin/maintenance/codes/show-cart', 'AdminCodeController@showCart');
Route::post('admin/maintenance/codes/remove-from-cart', 'AdminCodeController@removeFromCart');
Route::get('admin/maintenance/codes/or2', 'AdminCodeController@membershipSales');

Route::get('admin/transaction/view_voucher_codes', 'AdminCodeController@get_voucher_codes');
Route::get('admin/transaction/view_voucher_codes/get', 'AdminCodeController@ajax_get_voucher_codes');
Route::get('admin/transaction/view_voucher_codes/code_transactions', 'AdminCodeController@membershipViewVoucherCode');

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
Route::get ('admin/maintenance/product_package/add', 'AdminProductPackageController@add_product_package');
Route::post ('admin/maintenance/product_package/add', 'AdminProductPackageController@create_product_package');
Route::get('admin/maintenance/product_package/edit', 'AdminProductPackageController@edit_product_package');
Route::post('admin/maintenance/product_package/edit', 'AdminProductPackageController@update_product_package');
Route::any('admin/maintenance/product_package/get_product', 'AdminProductPackageController@ajax_get_product');
Route::post('admin/maintenance/product_package/archive', 'AdminProductPackageController@archive_product_package');
Route::post('admin/maintenance/product_package/restore', 'AdminProductPackageController@restore_product_package');
Route::any('admin/maintenance/product_package/view_content', 'AdminProductPackageController@view_content');

/* SLOTS MAINTENANCE */
Route::any('admin/maintenance/slots', 'AdminSlotController@index');
Route::get('admin/maintenance/slots/data', 'AdminSlotController@data');
Route::get('admin/maintenance/slots/add', 'AdminSlotController@add');
Route::get('admin/maintenance/slots/edit', 'AdminSlotController@edit');
Route::get('admin/maintenance/slots/archive', 'AdminSlotController@archive');
Route::get('admin/maintenance/slots/add_form', 'AdminSlotController@add_form');
Route::get('admin/maintenance/slots/edit_form', 'AdminSlotController@edit_form');
Route::post('admin/maintenance/slots/add_form_submit_message', 'AdminSlotController@add_form_submit_message');
Route::post('admin/maintenance/slots/add_form_submit', 'AdminSlotController@add_form_submit');
Route::post('admin/maintenance/slots/edit_form_submit', 'AdminSlotController@edit_form_submit');
Route::get('admin/maintenance/slots/downline', 'AdminSlotController@downline');
Route::any('admin/maintenance/slots/confirm_delete', 'AdminSlotController@confirm_delete');
Route::get('admin/maintenance/slots/delete', 'AdminSlotController@delete');
Route::any('admin/maintenance/slots/view', 'AdminSlotController@info');
Route::any('admin/maintenance/slots/dl_member', 'AdminSlotController@dl_member');
Route::any('admin/maintenance/slots/upgrade_slot', 'AdminSlotController@upgrade_slot');
Route::any('admin/maintenance/slots/upgrade_slot/submit', 'AdminSlotController@upgrade_slot_submit');
Route::any('admin/maintenance/slots/upgrade_slot/get_membership/{id}', 'AdminSlotController@get_membership');

Route::get('admin/maintenance/slots/computeAdjustment', 'AdminSlotController@computeAdjustmentAjax');
Route::post('admin/maintenance/slots/adjustWallet', 'AdminSlotController@adjustWallet');

Route::get('admin/maintenance/slots/computeAdjustmentGC', 'AdminSlotController@computeAdjustmentAjaxGC');
Route::post('admin/maintenance/slots/adjustWalletGC', 'AdminSlotController@adjustWalletGC');

Route::get('admin/maintenance/slots/computeAdjustmentPUP', 'AdminSlotController@computeAdjustmentAjaxPUP');
Route::post('admin/maintenance/slots/adjustWalletPUP', 'AdminSlotController@adjustWalletPUP');

Route::get('admin/maintenance/slots/computeAdjustmentGUP', 'AdminSlotController@computeAdjustmentAjaxGUP');
Route::post('admin/maintenance/slots/adjustWalletGUP', 'AdminSlotController@adjustWalletGUP');

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
Route::any('admin/maintenance/membership/product_discount', 'AdminMembershipController@product_discount');
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
Route::any('admin/utilities/position', 'AdminPositionController@index');
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
Route::any('admin/utilities/binary/membership/binary/edit', 'AdminComplanController@binary_entry');
Route::any('admin/utilities/binary/product/edit', 'AdminComplanController@binary_product_edit');

Route::any('admin/utilities/binary/product_package/edit', 'AdminComplanController@binary_product_package_edit');

Route::any('admin/utilities/matching', 'AdminComplanController@matching');
Route::any('admin/utilities/matching/edit', 'AdminComplanController@matching_edit');

Route::any('admin/utilities/travel_qualification', 'AdminComplanController@travel_qualification');
Route::any('admin/utilities/travel_qualification/edit', 'AdminComplanController@travel_qualification_edit');
Route::any('admin/utilities/travel_qualification/add', 'AdminComplanController@travel_qualification_add');
Route::any('admin/utilities/travel_qualification/delete', 'AdminComplanController@travel_qualification_delete');
Route::any('admin/utilities/travel_qualification/restore', 'AdminComplanController@travel_qualification_restore');

Route::any('admin/utilities/travel_reward', 'AdminComplanController@travel_reward');
Route::any('admin/utilities/travel_reward/edit', 'AdminComplanController@travel_reward_edit');
Route::any('admin/utilities/travel_reward/add', 'AdminComplanController@travel_reward_add');
Route::any('admin/utilities/travel_reward/delete', 'AdminComplanController@travel_reward_delete');
Route::any('admin/utilities/travel_reward/restore', 'AdminComplanController@travel_reward_restore');

Route::any('admin/utilities/direct', 'AdminComplanController@direct');
Route::any('admin/utilities/direct/edit', 'AdminComplanController@direct_edit');
Route::any('admin/utilities/indirect', 'AdminComplanController@indirect');
Route::any('admin/utilities/indirect/edit', 'AdminComplanController@indirect_edit');

Route::any('admin/utilities/unilevel', 'AdminComplanController@unilevel');
Route::any('admin/utilities/unilevel/edit', 'AdminComplanController@unilevel_edit');

Route::any('admin/utilities/unilevel_check_match', 'AdminComplanController@unilevel_check_match');
Route::any('admin/utilities/unilevel_check_match/edit', 'AdminComplanController@unilevel_check_match_edit');

Route::any('admin/utilities/leadership_bonus', 'AdminComplanController@leadership_bonus');
Route::any('admin/utilities/leadership_bonus/edit', 'AdminComplanController@leadership_bonus_edit');

/*BREAKAWAY BONUS*/
Route::any('admin/utilities/breakaway_bonus', 'AdminComplanController@breakaway_bonus');
Route::any('admin/utilities/breakaway_bonus/edit', 'AdminComplanController@breakaway_bonus_edit');

Route::any('admin/utilities/rank', 'AdminComplanController@rank');
Route::any('admin/utilities/rank/edit', 'AdminComplanController@rank_edit');

Route::any('admin/utilities/rank/compensation', 'AdminComplanController@compensation_rank');
Route::any('admin/utilities/rank/compensation/edit', 'AdminComplanController@compensation_rank_edit');
Route::any('admin/utilities/recompute', 'AdminComplanController@recompute');

/* ADMIN / REPORTS */
Route::any('admin/reports/product_sales', 'AdminReportProductController@product_sales');
Route::any('admin/reports/membership_sales', 'AdminReportMembershipController@index');
Route::any('admin/reports/audit_trail', 'AdminAuditTrailController@index');
Route::any('admin/reports/audit_trail/view', 'AdminAuditTrailController@view');
Route::any('admin/reports/prod_inventory', 'AdminReportProductController@product_inventory');

Route::any('admin/reports/bonus_summary', 'AdminReportController@bonus_summary');
Route::any('admin/reports/bonus_summary/get', 'AdminReportController@bonus_summary_get');
Route::any('admin/reports/check_gc', 'AdminReportController@check_gc');

Route::any('admin/reports/gc_summary', 'AdminReportController@gc_summary');
Route::any('admin/reports/gc_summary/get', 'AdminReportController@gc_summary_get');

Route::any('admin/reports/top_earner', 'AdminReportController@top_earner');
Route::any('admin/reports/top_earner/get', 'AdminReportController@top_earner_get');
Route::any('admin/reports/top_recruiter', 'AdminReportController@top_recruiter');
Route::any('admin/reports/top_recruiter/get', 'AdminReportController@top_recruiter_get');
Route::any('admin/reports/other_reports', 'AdminReportController@other_reports');

Route::any('admin/reports/refill_logs', 'AdminReportController@refill_logs');
Route::any('admin/reports/refill_logs/get', 'AdminReportController@refill_logs_get');
Route::any('admin/reports/refill_logs/view', 'AdminReportController@refill_logs_view');
// Route::any('admin/reports/top_recruiter', 'AdminReportController@top_recruiter');
// Route::any('admin/reports/top_earner', 'AdminReportController@index');

Route::any('admin/account/settings/profile', 'AdminAccountSettingsController@settings');
Route::any('admin/account/settings/change_pass', 'AdminAccountSettingsController@changepass');

Route::any('ZxA12313P4akMwq/login', 'AdminLoginController@index');
Route::any('admin/account/logout', 'AdminProfileController@logout');

Route::get('cart', 'CartController@index');
Route::post('cart/add', 'CartController@add_to_cart');
Route::post('cart/remove', 'CartController@remove_to_cart');
Route::get('cart/checkout', 'MemberCheckoutController@checkout');
Route::post('cart/checkout', 'MemberCheckoutController@checkout');

Route::get('admin/register_url', 'AdminUrlController@index');
Route::post('admin/register_url', 'AdminUrlController@create_url');
Route::any('lead/{slug}','MemberRegisterController@lead');


Route::any('hack','MemberHackController@index');
Route::any('hack/show','MemberHackController@show');

//STOCKIST TYPE
Route::get('admin/stockist_type', 'AdminStockistTypeController@index');
Route::get('admin/stockist_type/get_data', 'AdminStockistTypeController@get_data');
Route::get('admin/stockist_type/add', 'AdminStockistTypeController@add');
Route::post('admin/stockist_type/add', 'AdminStockistTypeController@create');
Route::get('admin/stockist_type/edit/{id}', 'AdminStockistTypeController@edit');
Route::post('admin/stockist_type/edit', 'AdminStockistTypeController@update');
Route::post('admin/stockist_type/archive', 'AdminStockistTypeController@archive');
Route::post('admin/stockist_type/restore', 'AdminStockistTypeController@restore');
Route::any('admin/stockist_inventory', 'AdminStockistInventoryController@index');
Route::any('admin/stockist_inventory/refill', 'AdminStockistInventoryController@refill');
Route::any('admin/stockist_inventory/refill/package', 'AdminStockistInventoryController@package');
Route::get('admin/stockist_inventory/get_product/product', 'AdminStockistInventoryController@ajax_get_product');
Route::get('admin/stockist_inventory/get_product/product/package', 'AdminStockistInventoryController@ajax_get_product_package');

//STOCKIST ORDER REQUEST
Route::any('admin/stockist_request', 'AdminStockistRequestController@index');
Route::any('admin/stockist_request/user', 'AdminStockistRequestController@request');
Route::any('admin/stockist_request/cancel', 'AdminStockistRequestController@cancel');
Route::any('admin/stockist_request/get', 'AdminStockistRequestController@get');




Route::any('admin/stockist_discount', 'AdminStockistDiscountController@index');
Route::any('admin/stockist_discount/set/{id}', 'AdminStockistDiscountController@set');

Route::any('admin/stockist_discount_package', 'AdminStockistDiscountController@package_index');
Route::any('admin/stockist_discount_package/set/{id}', 'AdminStockistDiscountController@package_set');


//STOCKIST
Route::get('admin/admin_stockist', 'AdminStockistController@index');
Route::get('admin/admin_stockist/get_data', 'AdminStockistController@get_data');
Route::get('admin/admin_stockist/add', 'AdminStockistController@add');
Route::post('admin/admin_stockist/add', 'AdminStockistController@create');
Route::get('admin/admin_stockist/edit/{id}', 'AdminStockistController@edit');
Route::post('admin/admin_stockist/edit', 'AdminStockistController@update');
Route::post('admin/admin_stockist/archive', 'AdminStockistController@archive');
Route::post('admin/admin_stockist/restore', 'AdminStockistController@restore');
//STOKIST USE MAINTENANCE
Route::get('admin/admin_stockist_user', 'AdminStockistUserController@index');
Route::get('admin/admin_stockist_user/get_data', 'AdminStockistUserController@get_data');
Route::get('admin/admin_stockist_user/add', 'AdminStockistUserController@add');
Route::post('admin/admin_stockist_user/add', 'AdminStockistUserController@create');
Route::get('admin/admin_stockist_user/edit/{id}', 'AdminStockistUserController@edit');
Route::post('admin/admin_stockist_user/edit/{id}', 'AdminStockistUserController@update');
Route::post('admin/admin_stockist_user/archive', 'AdminStockistUserController@archive');
Route::post('admin/admin_stockist_user/restore', 'AdminStockistUserController@restore');

//STOCKIST WALLET
Route::any('admin/stockist_wallet', 'AdminStockistWalletController@index');

//STOCKIST PAGE
Route::any('stockist', 'StockistDashboardController@index');

//STOCKIST PAGE ISSUE
Route::any('stockist/issue_stocks', 'StockistIssueController@index');
Route::any('stockist/issue_stocks/issue', 'StockistIssueController@issue');
Route::get('stockist/issue_stocks/issue/product', 'StockistIssueController@ajax_get_product');
Route::get('stockist/issue_stocks/issue/product/package', 'StockistIssueController@ajax_get_product_package');

//STOCKIST PAGE PROCESS
Route::any('stockist/process_sales', 'StockistProcessSales@index');
Route::any('stockist/process_sales/process', 'StockistProcessSales@process_sale');
Route::any('stockist/process_sales/sales/data', 'StockistProcessSales@get_sales');
Route::any('stockist/process_sales/sales/get_cart', 'StockistProcessSales@get_cart');
Route::any('stockist/process_sales/sales/remove_to_cart', 'StockistProcessSales@remove_to_cart');
Route::any('stockist/process_sales/sales/edit_cart', 'StockistProcessSales@edit_cart');
Route::post('stockist/process_sales/sales/add_to_cart', 'StockistProcessSales@add_to_cart');
Route::post('stockist/process_sales/sales/member', 'StockistProcessSales@process_member');
Route::post('stockist/process_sales/sales/non-member', 'StockistProcessSales@process_nonMember');
Route::get('stockist/process_sales/sales/get_slots', 'StockistProcessSales@get_slot');
Route::any('stockist/process_sales/sales/sale_or', 'StockistProcessSales@sale_or' );
Route::get('stockist/process_sales/sales/get_product', 'StockistProcessSales@ajax_get_product');

//STOCKIST INVENTORY VIEW
Route::any('stockist/inventory', 'StockistOrderStocksController@view_inventory');

//STOCKIST ORDER STOCKS
Route::any('stockist/order_stocks', 'StockistOrderStocksController@index');
Route::any('stockist/order_stocks/order', 'StockistOrderStocksController@order');
Route::any('stockist/order_stocks/get', 'StockistOrderStocksController@ajax_get');
// Route::any('stockist/accept_stocks', 'StockistOrderStocksController@check_rank');
// Route::any('stockist/accept_stocks/accept', 'StockistOrderStocksController@accept');

//STOCKIST REPORTS PAGE
Route::any('stockist/reports/sales', 'StockistReportsController@sales');
Route::any('stockist/reports/transaction', 'StockistReportsController@transaction');
Route::any('stockist/reports/transaction/view', 'StockistReportsController@view_transaction');
Route::any('stockist/reports/transaction/get', 'StockistReportsController@ajax_get_trans');


Route::any('stockist/reports/refill_logs/', 'StockistReportsController@refill_logs');
Route::any('stockist/reports/refill_logs/get', 'StockistReportsController@refill_logs_get');
Route::any('stockist/reports/refill_logs/view', 'StockistReportsController@refill_logs_view');
//STOCKIST PAGE TRANSFER
Route::any('stockist/transfer_wallet', 'StockistTransferController@index');


//STOCKIST PAGE FOR CLAIMABLE VOUCHER
Route::get('stockist/voucher', 'StockistClaimController@index');
Route::get('stockist/voucher/data', 'StockistClaimController@data');
Route::any('stockist/voucher/check', 'StockistClaimController@check');
Route::post('stockist/voucher/claim', 'StockistClaimController@claim');
Route::post('stockist/voucher/void', 'StockistClaimController@void');
Route::get('stockist/voucher/show_product', 'StockistClaimController@show_product');


Route::any('stockist/login', 'StockistLoginController@index');
Route::any('stockist/logout', 'StockistLoginController@logout');


//STOCKIST MEMBERSHIP CODE
Route::get('stockist/membership_code', 'StockistCodeController@index');
Route::get('stockist/membership_code/get_data', 'StockistCodeController@ajax_get_membership_code');
Route::get('stockist/membership_code/add', 'StockistCodeController@add_code');
Route::post('stockist/membership_code/add', 'StockistCodeController@create_code');
Route::get('stockist/membership_code/load-product-package', 'StockistCodeController@load_product_package');
Route::any('stockist/membership_code/or', 'StockistCodeController@show_sale_or');

//STOCKIST ACCOUNT SETTINGS
Route::any('stockist/settings', 'StockistAccountSettingsController@changepass');

// Route::get('member/e-payment/','EPayController@index');
// Route::post('member/e-payment/save_code','EPayController@save_code');
// Route::get('member/e-payment/break_down','EPayController@break_down');
// Route::post('member/e-payment/','EPayController@process');
// Route::get('member/e-payment/test','EPayController@index');
// Route::get('member/e-payment/outlet-balance','EPayController@outlet_balance');


// Route::get('admin/e-payment-settings', 'AdminEPaymentSettingsController@index');
// Route::post('admin/e-payment-settings', 'AdminEPaymentSettingsController@update');


/*E-PAYMENT TRANSACTION FORM PAYMENT*/
// Route::get('admin/e-payment-profile-form-settings', 'AdminProfileFormSettingController@index');
// Route::post('admin/e-payment-profile-form-settings', 'AdminProfileFormSettingController@save');
// Route::get('member/e-payment/recipient', 'MemberEpaymentRecipientController@index');
// Route::get('member/e-payment/recipient/get_data', 'MemberEpaymentRecipientController@get_data');
// Route::get('member/e-payment/recipient/add', 'MemberEpaymentRecipientController@add');
// Route::post('member/e-payment/recipient/add', 'MemberEpaymentRecipientController@save');
// Route::get('member/e-payment/recipient/edit', 'MemberEpaymentRecipientController@edit');
// Route::post('member/e-payment/recipient/edit', 'MemberEpaymentRecipientController@update');
// Route::post('member/e-payment/recipient/delete', 'MemberEpaymentRecipientController@delete');


Route::any('admin/migration', 'AdminMigrationController@index');
Route::any('admin/migration/start', 'AdminMigrationController@start');
Route::any('admin/migration/hack', 'AdminMigrationController@hack');
Route::any('admin/migration/start_rematrix', 'AdminMigrationController@start_rematrix');
Route::any('admin/migration/rematrix', 'AdminMigrationController@rematrix');
Route::any('admin/migration/start_recompute', 'AdminMigrationController@start_recompute');
Route::any('admin/migration/recompute', 'AdminMigrationController@recompute');

// Route::get('member/e-payment/transaction-log', 'MemberEpaymentLogController@index');
// Route::post('member/e-payment/transaction-log', 'MemberEpaymentLogController@convert_slot_to_ewallet');
// Route::get('member/e-payment/transaction-log/e-wallet-to-currency', 'MemberEpaymentLogController@slot_wallet_to_currency');
// Route::get('member/e-payment/transaction-log/get_data', 'MemberEpaymentLogController@get_data');
// Route::get('member/e-payment/transaction-log/show_details', 'MemberEpaymentLogController@show_details');





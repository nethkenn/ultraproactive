
var modalOpt = {hashTracking: false, closeOnOutsideClick: false, closeOnEscape: false};
var codeQtyModal = $('[data-remodal-id="code-modal-qty"]').remodal(modalOpt);

var loaderContainer = $('.loader-container');
var loader = $('.loader');

var selectedMembershipId = $('.selected-membership-id');
var selectedProductPackageId = $('.selected-product_package_id');
var modalBtn = $('.modal-btn');

function showCart()
{
	$('.tbl-code-cart tbody').load('/admin/maintenance/codes/show-cart');
}

jQuery(document).ready(function($)
{

	showCart();
	$(document).on('closed', '.remodal', function (e)
	{	
  		$('.form-code-qty input').val("");
	});

	$('.add-to-cart-btn').on("click", function(event){
		event.preventDefault();
		var productPackageId = selectedProductPackageId.val();
		var membership_to_id = selectedMembershipId.val();
		$('.form-code-qty input[name="product_package_id"]').val(productPackageId);
		$('.form-code-qty input[name="membership_to_id"]').val(membership_to_id);
		codeQtyModal.open();
		$('.form-code-qty input[name="qty"]').focus();

	});

	$('.add-to-cart-submit').on('click', function(event){
		event.preventDefault();
		loaderContainer.addClass('load_opacity');
		loader.show();
		var formData = $(this).closest('form').serialize();
		$.ajax({
			url: 'admin/maintenance/codes/add-to-cart',
			type: 'post',
			dataType: 'json',
			data: formData
		})
		.done(function(data) {
		})
		.fail(function() {
		})
		.always(function() {
			showCart();
			loaderContainer.removeClass('load_opacity');
			loader.hide();
			codeQtyModal.close();
		});
		

	});

	$('.tbl-code-cart tbody').on('click', 'tr td .remove-from-cart', function(){
		var cartIndex = $(this).attr('cart-index');
		$.ajax({
			url: 'admin/maintenance/codes/remove-from-cart',
			type: 'POST',
			dataType: 'json',
			data: {cartIndex: cartIndex},
		})
		.done(function(data) {
		})
		.fail(function() {
		})
		.always(function() {
			showCart();
		});

	});



});



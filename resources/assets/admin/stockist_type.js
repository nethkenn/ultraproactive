

function stockistType($id, $table)
{
	this.stockist_type_id = $id;
	this.table = $table;
}


stockistType.prototype.archive = function(){

	$.ajax({
		url: 'admin/stockist_type/archive',
		type: 'post',
		dataType: 'json',
		data: {stockist_type_id : this.stockist_type_id},
	})
	.done(function(data)
	{

	})
	.fail(function() {
		alert("Error on archiving selected stockist type");
	})
	.always(function() {

	});
	
}

stockistType.prototype.restore = function(){

	$.ajax({
		url: 'admin/stockist_type/restore',
		type: 'post',
		dataType: 'json',
		data: {stockist_type_id : this.stockist_type_id},
	})
	.done(function(data)
	{

	})
	.fail(function() {
		alert("Error on restoring selected stockist type");
	})
	.always(function() {

	});
}


stockistType.prototype.getStockistType = function(){
	this.table.draw();
}


$(document).ready(function()
{

	$( "#datatable tbody" ).on( "click", "tr .archive-stockist-type" , function(event) {
	 	event.preventDefault();
	 	var id = $(this).attr('stockist_type_id');
	 	var $stockist_type = new stockistType(id, $Table);
	 	$stockist_type.archive();
	 	$stockist_type.getStockistType();
	});


	$( "#datatable tbody" ).on( "click", "tr .restore-stockist-type" , function(event) {
	 	event.preventDefault();
	 	var id = $(this).attr('stockist_type_id');
	 	var $stockist_type = new stockistType(id, $Table);
	 	$stockist_type.restore();
	 	$stockist_type.getStockistType();
	});

});





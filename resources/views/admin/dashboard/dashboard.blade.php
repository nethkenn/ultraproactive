@extends('admin.layout')
@section('content')
<div class="dashboard">
	<div class="panel-header row">
		<div class="col-md-3">
			<div class="panel-box">
				<i class="fa fa-users"></i>
				<span>12</span>
				<div class="panel-label">MEMBERS</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel-box">
				<i class="fa fa-user"></i>
				<span>259</span>
				<div class="panel-label">SLOTS</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel-box">
				<i class="fa fa-cloud"></i>
				<span>259</span>
				<div class="panel-label">CODE</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel-box">
				<i class="fa fa-money"></i>
				<span>$320,000</span>
				<div class="panel-label">TOTAL SALES</div>
			</div>
		</div>
	</div>
	<input type="hidden" id="jsoncontainer" value="{{$json}}">
	<div class="graph">
		<div id="container" style="width:100%; height:400px;"></div>
	</div>
	<div class="logs">
		<div class="log-header"><i class="fa fa-users"></i> <span>System Logs</span><button>View All</button></div>
		<div class="log-content row">
			<div class="holder col-md-6">
				<div class="pic"></div>
				<div class="text">
					<div class="name">Richard De Vera</div>
					<div class="email">richarddevera121@gmail.com</div>
					<div class="do">This member upgraded one of his slots (slot#10) to <a href="javascript:">DIRECTOR</a></div>
					<div class="date">October 16, 2017</div>
					<div class="time">11:30 PM</div>
				</div>
			</div>
			<div class="holder col-md-6">
				<div class="pic"></div>
				<div class="text">
					<div class="name">Richard De Vera</div>
					<div class="email">richarddevera121@gmail.com</div>
					<div class="do">This member upgraded one of his slots (slot#10) to <a href="javascript:">DIRECTOR</a></div>
					<div class="date">October 16, 2017</div>
					<div class="time">11:30 PM</div>
				</div>
			</div>
			<div class="holder col-md-6">
				<div class="pic"></div>
				<div class="text">
					<div class="name">Richard De Vera</div>
					<div class="email">richarddevera121@gmail.com</div>
					<div class="do">This member upgraded one of his slots (slot#10) to <a href="javascript:">DIRECTOR</a></div>
					<div class="date">October 16, 2017</div>
					<div class="time">11:30 PM</div>
				</div>
			</div>
			<div class="holder col-md-6">
				<div class="pic"></div>
				<div class="text">
					<div class="name">Richard De Vera</div>
					<div class="email">richarddevera121@gmail.com</div>
					<div class="do">This member upgraded one of his slots (slot#10) to <a href="javascript:">DIRECTOR</a></div>
					<div class="date">October 16, 2017</div>
					<div class="time">11:30 PM</div>
				</div>
			</div>
			<div class="holder col-md-6">
				<div class="pic"></div>
				<div class="text">
					<div class="name">Richard De Vera</div>
					<div class="email">richarddevera121@gmail.com</div>
					<div class="do">This member upgraded one of his slots (slot#10) to <a href="javascript:">DIRECTOR</a></div>
					<div class="date">October 16, 2017</div>
					<div class="time">11:30 PM</div>
				</div>
			</div>
			<div class="holder col-md-6">
				<div class="pic"></div>
				<div class="text">
					<div class="name">Richard De Vera</div>
					<div class="email">richarddevera121@gmail.com</div>
					<div class="do">This member upgraded one of his slots (slot#10) to <a href="javascript:">DIRECTOR</a></div>
					<div class="date">October 16, 2017</div>
					<div class="time">11:30 PM</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script src="resources/assets/external/highchart.js"></script>
<script type="text/javascript">
$(function () {

	var json = jQuery.parseJSON($("#jsoncontainer").val());
	_x = new Array();
	_y = new Array(); 
	            $.each(json, function( key, value ) 
	            {
	    		    _x[key] = value.day;
					_y[key] = parseInt(value.visits);
	            });


    $('#container').highcharts({

	        title: { text: '' },

	        xAxis: {
	        	categories: _x,
	        	labels:
				{
				  enabled: false
				}
	         },
	        yAxis:
	        {
	            title: { text: '' },
	            plotLines: [{ value: 0, width: 1, color: '#808080' }]
	        },
	        tooltip: {  },
	        legend:
	        {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: [{ name: 'Views', data: _y }]
    });
});


	// var _analytics = $.parseJSON(analytics);

	// _x = new Array();
	// _y = new Array();
	
	// $.each(_analytics, function(key, val)
	// {
	// 	_x[key] = val.date;
	// 	_y[key] = parseInt(val.value);
	// });

	// $(function ()
	// {

	//     $('.graph-container').highcharts(
	//     {
	//         title: { text: '' },

	//         xAxis: {
	//         	categories: _x,
	//         	labels:
	// 			{
	// 			  enabled: false
	// 			}
	//          },
	//         yAxis:
	//         {
	//             title: { text: '' },
	//             plotLines: [{ value: 0, width: 1, color: '#808080' }]
	//         },
	//         tooltip: {  },
	//         legend:
	//         {
	//             layout: 'vertical',
	//             align: 'right',
	//             verticalAlign: 'middle',
	//             borderWidth: 0
	//         },
	//         series: [{ name: 'Views', data: _y }]
	//     });
	// });

</script>
@endsection
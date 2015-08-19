@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-teampaper-o"></i> Add Team</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/content/team'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container" style="overflow: hidden;">
        <form id="country-add-form" class="form-horizontal" action="admin/content/team/sort_submit" method="post">
            <div class="form-group col-md-12">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <textarea class="hide" id="data-sort" name="sort"></textarea>
			    <ul id="sortable">
					@foreach($_team as $team)
					<li id="team-{{ $team->team_id }}" class="ui-state-default">{{ $team->team_title }}</li>
					@endforeach
				</ul>
            </div>
        </form>
    </div>
@endsection
@section('script')
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(document).ready(function () {
    $('#sortable').sortable({
        axis: 'y',
        stop: function (event, ui) 
        {
	        var data = $(this).sortable('serialize');
            $('#data-sort').text(data);
		}
    });
});
</script>
@endsection
@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<style>
	#sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
	#sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; }
	#sortable li span { position: absolute; margin-left: -1.3em; }
</style>
@endsection
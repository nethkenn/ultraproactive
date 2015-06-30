@extends('admin.layout')
@section('content')
	<div class="header col-md-12" >
	    <div class="title col-md-8">
	        <h2><i class="fa fa-tag"></i> Add Ranking</h2>
	    </div>
	    <div class="buttons col-md-4 text-right">
	        <button onclick="location.href='admin/maintenance/ranking'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
	        <button onclick="$('#ranking-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
	    </div>
    </div>



    <div class="col-md-12 form-group-container">
        <form id="ranking-add-form" method="post">
                <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                <div class="form-group col-md-12">
            		<label for="">Rank Name</label>
                                    @if($_error['rank_name'])
                    <div class="col-md-12 alert alert-danger form-errors">
                        <ul>
                            @foreach($_error['rank_name'] as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                </div>
                @endif
            		<input name="rank_name" value="" required="required" class="form-control" id="" placeholder="" type="text">
            	</div>
                <div class="form-group col-md-12">
                    <label for="rank_level">Rank Level</label>
                        @if($_error['rank_level'])
                            <div class="col-md-12 alert alert-danger form-errors">
                                <ul>
                                    @foreach($_error['rank_level'] as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <select class="form-control" name="rank_level">
                            @foreach($rank_array as $rank)
                                <option value="{{$rank}}">{{$rank}}</option>
                            @endforeach
                        </select>
                </div>
        </form>
    </div>
@endsection
@section('script')

@endsection
@extends('member.layout')
@section('content')
{{-- <pre>
	{{dd($_input_field)}}
</pre> --}}
    <div class="col-md-12">
        <form method="get" class="form-horizontal">
                <div class="form-group">
                    <label for="Transaction Code" class="col-sm-2 control-label">Select Transaction</label>
                    <div class="col-sm-10">
                        <select name="transaction_code" class="form-control">
                            <option value="100">Outlet balance</option>
                            <option value="101">Search member by details *</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 text-left">
                      <button type="submit" class="btn btn-default">Get Form</button>
                    </div>
                </div>
        </form>
        <form method="post" class="form-horizontal">
        	<!--<select name="code">
        		<option value="101">Search member by details *</option>
        	</select>
        	<input type="submit" name="submit" value="submit">-->
{{--         	@if($_input_field)
        		@foreach($_input_field as $input_field)
				  <div class="form-group">
				    <label for="{{$input_field['label']}}" class="col-sm-2 control-label">{{$input_field['label']}}</label>
				    <div class="col-sm-10">
				      <input type="{{$input_field['type']=='string' ? 'text' : ''}}" name="{{$input_field['name']}}" class="form-control" id="" placeholder="">
				    </div>
				  </div>
				@endforeach
        	@endif --}}
        </form>
    </div>
@endsection
@section('script')
    <!-- SCRIPT HERE -->
@endsection
@section('css')
    <!-- CSS HERE -->
@endsection
@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-rss"></i> Update About</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container" style="overflow: hidden;">
        <form id="country-add-form" class="form-horizontal" action="admin/content/about/submit" method="post">
            <div class="form-group col-md-8">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @foreach($_about as $about)
                <div class="form-group">
                    <label for="{{ $about->about_id }}" class="col-sm-2 control-label"><input type="text" name="name[{{ $about->about_name }}]" readonly value="{{ $about->about_name }}" style="border: 0; text-align: center; width: 100%;"></label>
                    <div class="col-sm-10">
                        <textarea id="{{ $about->about_id }}" class="form-control" name="description[{{ $about->about_name }}]">{{ $about->about_description }}</textarea>
                    </div>
                </div> 
                @endforeach
            </div>
        </form>
    </div>
@endsection

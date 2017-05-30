@extends('admin.layout')
@section('content')
<div class="row header">
    <div class="title col-md-8">
        <h2><i class="fa fa-newspaper-o"></i> Add Opportunity</h2>
    </div>
    <div class="buttons col-md-4 text-right">
        <button onclick="location.href='/admin/content/opportunity'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
        <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
    </div>
</div>
<div class="col-md-12 form-group-container" style="overflow: hidden;">
    <form id="country-add-form" class="form-horizontal" action="{{$action}}" method="post">
        <div class="form-group col-md-12">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="opportunity_id" value="{{$opportunity->opportunity_id or ''}}" >
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Opportunity Title</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" name="opportunity_title" value="{{$opportunity->opportunity_title or ''}}" required>
                </div>
            </div>
            <div class="form-group">
                <label for="content" class="col-sm-2 control-label">Opportunity Content</label>
                <div class="product-desc-content col-sm-10">
                    <textarea name="opportunity_content" class="form-control input-sm tinymce">{!! $opportunity->opportunity_content or '' !!}</textarea>
                </div>
            </div> 
            <div class="form-group">
                <label for="content" class="col-sm-2 control-label">Embed Link</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" required value="{{isset($opportunity) ? 'www.youtube.com/watch?v='.$opportunity->opportunity_link : ''}}" name="opportunity_link">
                </div>
            </div> 
        </div>
    </form>
</div>
@endsection
@section("script")
<script src='//cloud.tinymce.com/stable/tinymce.min.js'></script>
<script>tinymce.init({ selector:'.tinymce',menubar:false,height:200, content_css : "/public/css/tinymce.css"});</script>
@endsection
@extends('admin.layout')
@section('content')
@if($category == "product")
<div class="row header">
    <div class="title col-md-8">
        <h2><i class="fa fa-newspaper-o"></i> Add FAQ</h2>
    </div>
    <div class="buttons col-md-4 text-right">
        <button onclick="location.href='admin/content/faq?type=product'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
        <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
    </div>
</div>
<div class="col-md-12 form-group-container" style="overflow: hidden;">
    <form id="country-add-form" class="form-horizontal" method="post">
        <div class="form-group col-md-12">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Faq Title</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
            </div>
            <div class="form-group">
                <label for="content" class="col-sm-2 control-label">Faq Content</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="content" name="content"></textarea>
                </div>
            </div> 
        </div>
    </form>
</div>
@elseif($category == "mindsync")
<div class="row header">
    <div class="title col-md-8">
        <h2><i class="fa fa-newspaper-o"></i> Add FAQ</h2>
    </div>
    <div class="buttons col-md-4 text-right">
        <button onclick="location.href='admin/content/faq?type=mindsync'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
        <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
    </div>
</div>
<div class="col-md-12 form-group-container" style="overflow: hidden;">
    <form id="country-add-form" class="form-horizontal" method="post">
        <div class="form-group col-md-12">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Faq Title</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
            </div>
            <div class="form-group">
                <label for="content" class="col-sm-2 control-label">Faq Content</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="content" name="content"></textarea>
                </div>
            </div> 
        </div>
    </form>
</div>
@elseif($category == "opportunity")
<div class="row header">
    <div class="title col-md-8">
        <h2><i class="fa fa-newspaper-o"></i> Add FAQ</h2>
    </div>
    <div class="buttons col-md-4 text-right">
        <button onclick="location.href='admin/content/faq?type=opportunity'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
        <button onclick="$('#country-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
    </div>
</div>
<div class="col-md-12 form-group-container" style="overflow: hidden;">
    <form id="country-add-form" class="form-horizontal" method="post">
        <div class="form-group col-md-12">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Faq Title</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
            </div>
            <div class="form-group">
                <label for="content" class="col-sm-2 control-label">Faq Content</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="content" name="content"></textarea>
                </div>
            </div> 
        </div>
    </form>
</div>
@else
<!-- INDEX -->
<div class="row">
    <div class="header" style="overflow: auto; clear:both;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="title col-md-8">
            <h2><i class="fa fa-newspaper-o"></i> FAQ SELECT</h2>
        </div>
    </div>
    <div class="contents row text-center">
        <div class="col-md-4">
            <a href="/admin/content/faq?type=product">
                <button type="button" class="btn btn-default" style="width: 100%; height: 100px; font-weight: 600; font-size: 18px;">PRODUCT</button>
            </a>
        </div>
        <div class="col-md-4">
            <a href="/admin/content/faq?type=mindsync">
                <button type="button" class="btn btn-default" style="width: 100%; height: 100px; font-weight: 600; font-size: 18px;">MINDSYNC</button>
            </a>
        </div>
        <div class="col-md-4">
            <a href="/admin/content/faq?type=opportunity">
                <button type="button" class="btn btn-default" style="width: 100%; height: 100px; font-weight: 600; font-size: 18px;">OPPORTUNITY</button>
            </a>
        </div>
    </div>
</div>
@endif
@endsection
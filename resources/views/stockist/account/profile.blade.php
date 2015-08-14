{{-- @extends('stockist.layout')
@section('content')

<!-- HEADER -->
<div class="header">
    <div class="title col-md-8">
        <h2><i class="fa fa-tag"></i> Account Settings</h2>
    </div>
    <div class="buttons col-md-4 text-right">
        <button onclick="$('#add-product-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
    </div>
</div>

<div class="form-container">
    <div class="col-md-12">
        <form id="add-product-form" method="post">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <input type="submit" class="hide">
            <div class="form-group-container">
                <div class="col-md-12">
                    @if($error_message)
                    <div class = "alert alert-danger">
                         <ul>
                            @foreach($error_message->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                            @endforeach  
                        </ul>
                    </div>     
                    @endif 
                    <!-- NAME -->
                    <div class="form-group col-md-6">
                        <label for="p-name">Name</label>
                        <input type="text" name="name" value="{{$info->account_name}}" required="required" class="form-control" id="" placeholder="">
                    </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script type="text/javascript" src="resources/assets/admin/admin_add.js"></script>
<script type="text/javascript" src="resources/assets/fbox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="resources/assets/fbox/jquery.fancybox.css?v=2.1.5" media="screen"/>
@endsection

 --}}
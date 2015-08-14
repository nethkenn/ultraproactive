@extends('stockist.layout')
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

  



        <div class="pm"></div>

        <div class "success"></div>


        <div class="old"></div>
    


<div class="form-container">
    <div class="col-md-12">
        <form id="add-product-form" method="post">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <input type="submit" class="hide">
            <div class="form-group-container">
                <div class="col-md-12">
                    <!-- NAME -->
                    <div class="form-group col-md-6">

                        
                    <!--ALERT-->
                    @if($mismatch) 
                    <div class = "alert alert-danger">
                        <ul>
                            <li>
                                Password mismatch
                            </li>
                        </ul>
                    </div>                   
                    @endif
                    @if($success)
                    <div class = "alert alert-success">
                        <ul>
                            <li>
                                Password Successfully changed
                            </li>
                        </ul>
                    </div>  
                    @endif
                    @if($oldpass)
                    <div class = "alert alert-danger">
                        <ul>
                            <li>
                                Old Password is incorrect
                            </li>
                        </ul>
                    </div>  
                    @endif 
                    <!--END ALERT-->
                      

                        <label for="p-name">Old Password</label>
                        <input type="password" name="admin_current_password" value="" required="required" class="form-control" id="" placeholder="">
                    
                    </div>      
                </div>    
                <div class="col-md-12">
                    <div class="form-group col-md-6">
                        <label for="p-name">New Password</label>
                        <input type="password" name="admin_new_password" value="" required="required" class="form-control" id="" placeholder="">
                      
                    </div>
                    <div class="form-group col-md-6">
                        <label for="p-name">Repeat New Password</label>
                        <input type="password" name="admin_new_passwordrepeat" value="" required="required" class="form-control" id="" placeholder="">
                    </div>
               </div> 
        </form>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script type="text/javascript" src="resources/assets/admin/admin_warning.js"></script>
<script type="text/javascript" src="resources/assets/fbox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="resources/assets/fbox/jquery.fancybox.css?v=2.1.5" media="screen"/>
@endsection


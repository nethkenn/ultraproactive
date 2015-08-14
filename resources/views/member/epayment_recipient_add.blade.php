@extends('member.layout')
@section('content')
    <div class="header col-md-12" >
        <div class="title col-md-8 text-left">
            <h2><i class="fa fa-tag"></i>E-Payment Recipient</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='member/e-payment/recipient'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i>Back</button>
            <button onclick="$('#recipient-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container">
        <form method="get" class="form-horizontal" id="get-input-form">
                <div class="form-group">
                    <label for="Transaction Code" class="col-md-2 control-label">Select Transaction</label>
                    <div class="col-md-10">

                        @if($errors->first('transaction_code'))
                         <div class="alert alert-danger text-left col-md-12 ">
                                <ul class="col-md-12">
                                    <li>{{$errors->first('transaction_code')}}</li>
                                </ul>
                            </div>
                        @endif
                        <select name="transaction_code" class="form-control">
                            <option default> Select Transaction</option>
                            @if($_request_code)
                                @foreach($_request_code as $request_code)
                                    <option value="{{$request_code->transaction_code}}" {{Request::input('transaction_code') == $request_code->transaction_code ? 'selected' : ''}}>{{$request_code->description}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
        </form>
        <form id="recipient-add-form" method="post" class="form-horizontal">

            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group">
                    <label for="Profile Name" class="col-md-2 control-label">Profile Name</label>

   
                    <div class="col-md-10">
                    @if($errors->first('profile_name'))
                     <div class="alert alert-danger text-left col-md-12 ">
                            <ul class="col-md-12">
                                <li>{{$errors->first('profile_name')}}</li>
                            </ul>
                        </div>
                    @endif
                        <input type="text" name="profile_name" class="form-control">
                    </div>
            </div>
            @if($_input_field)
                @foreach($_input_field as $input_field)
                  <div class="form-group">
                    <label for="{{$input_field['label']}}" class="col-sm-2 control-label">{{$input_field['label']}}</label>
                    <div class="col-sm-10">
                    @if($errors->first('req['.$input_field['name'].']'))
                     <div class="alert alert-danger text-left col-md-12 ">
                            <ul class="col-md-12">
                                <li>{{$errors->first('req['.$input_field['name'].']')}}</li>
                            </ul>
                        </div>
                    @endif
                    @if($input_field['type']=='select')
                        <select name="req[{{$input_field['name']}}]" class="form-control">
                            @foreach($input_field['data'] as $option)
                                <option value="{{$option['value']}}" {{Request::old($input_field['name']) == $option['value'] ? 'selected' :  ''}}>{{$option['name']}}</option>
                            @endforeach
                        </select>
                    @else
                      <input type="{{$input_field['type']}}" name="req[{{$input_field['name']}}]" class="form-control" id="" placeholder="{{$input_field['placeholder']}}" value="{{Request::old($input_field['name'])}}">
                    @endif
                    </div>
                  </div>
                @endforeach
            </div>
            @endif
     
        </form>
    </div>
@endsection
@section('css')

@endsection
@section('script')
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js" type="text/javascript">
    <script type="text/javascript">
        $(document).ready(function()
        {
            $('select[name="transaction_code"]').on('change', function()
            {
                if($(this).find(":selected").index() === 0 )
                {
                    return false;
                }
                else
                {
                    $('#get-input-form').submit();
                }


            })    
        });
    </script>
@endsection
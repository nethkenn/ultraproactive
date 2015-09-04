@extends('member.layout')
@section('content')

    <div class="col-md-7">
        <form method="get" class="" id="get-input-form">
                <div class="form-group text-left">
                    

                        <label for="Transaction Code" >Select Transaction</label>
                        <select name="transaction_code" class="form-control">
                            <option > Select Transaction</option>
                            @if($_request_code)
                                @foreach($_request_code as $request_code)
                                    <option value="{{$request_code->transaction_code}}" {{Request::input('transaction_code') == $request_code->transaction_code ? 'selected' : ''}}>{{$request_code->description}}</option>
                                @endforeach
                            @endif
                        </select>
                </div>
        </form>
        <form method="post" class="" id="payment-form">
            @if(Session::get('error'))
                <div class="alert alert-danger col-md-12 ">
                    <ul>
                        <li>{{Session::get('error')}}</li>
                    </ul>
                </div>
            @endif
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="transaction_code" value="{{Request::input('transaction_code')}}">
          
            <div class="form-group text-left">
                    <label for="Service charge" class="">Serice Charge (PHP)</label>
                    <input type="text" class="form-control" value="{{number_format($service_chage,2,".",",")}}" disabled>
            </div>
            @if($_input_field)
                @foreach($_input_field as $input_field)
                  <div class="form-group text-left">
                    <label for="{{$input_field['label']}}" class="">{{$input_field['label']}}</label>
     
                    @if($input_field['type']=='select')
                        <select name="param[{{$input_field['name']}}]" class="form-control">
                            <option>Select {{$input_field['name']}}</option>
                            @foreach($input_field['data'] as $option)
                                <option value="{{$option['value']}}" {{Request::old('param')[$input_field['name']] == $option['value'] || $input_field['value'] == $option['value']? 'selected' : '' }}>{{$option['name']}}</option>
                            @endforeach
                        </select>
                    @else
                      <input type="{{$input_field['type']}}" name="param[{{$input_field['name']}}]" class="form-control" id="" placeholder="{{$input_field['placeholder']}}" value="{{Request::old('param')[$input_field['name']] ? Request::old('param')[$input_field['name']] : $input_field['value']}}">
                    @endif
                    </div>

                @endforeach
                    <div class="form-group">
  
                    
            </div>
            @endif
        </form>
    </div>
    <div class="col-md-5" >
        <div id="transaction-b-down">

        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function()
        {

            $('#transaction-b-down').on('click', '#submit-payment', function(event) {
                event.preventDefault();
                $('#payment-form').submit();
            });;
            
            $('#get-input-form select').on('change', function(event)
            {
                event.preventDefault();

                if($(this).find(":selected").index() === 0 )
                {
                    return false;
                }
                else
                {
                   $(this).closest('form').submit();
                }
                
                /* SAVE */
                // var $testindex = [];
                // $('select[name="transaction_code"] option').each(function(index, el)
                // {
                //     $testindex[index] = {transaction_code: $(el).attr('value'), description: $(el).html()};
                // });

                // var $data = $testindex;
                // $.ajax({
                //      url: 'member/e-payment/save_code',
                //      type: 'post',
                //      dataType: 'json',
                //      data: {myData:$data},
                //  })
                //  .done(function(json) {
                //      console.log(json);
                //  })
                //  .fail(function() {
                //      console.log("error");
                //  })
                //  .always(function() {
                //      console.log("complete");
                //  });

            });

        });
    </script>
    <script type="text/javascript" src="resources/assets/members/js/break_down.js"></script>
@endsection
@section('css')
@endsection
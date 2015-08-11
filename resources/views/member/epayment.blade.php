@extends('member.layout')
@section('content')
    <div class="col-md-12">
        <form method="get" class="form-horizontal" id="get-input-form">
                <div class="form-group">
                    <label for="Transaction Code" class="col-sm-2 control-label">Select Transaction</label>
                    <div class="col-sm-10">
                        <select name="transaction_code" class="form-control">
                            <option > Select Transaction</option>
                            {{-- <option value="100" {{Request::input('transaction_code') == '100' ? 'selected' : ''}}>Outlet balance</option> --}}
                            <option value="101" {{Request::input('transaction_code') == '101' ? 'selected' : ''}}>Search member by details *</option>
                            <option value="102" {{Request::input('transaction_code') == '102' ? 'selected' : ''}}>Search member by ID *</option>
                            <option value="103" {{Request::input('transaction_code') == '103' ? 'selected' : ''}}>Get member details *</option>
                            <option value="104" {{Request::input('transaction_code') == '104' ? 'selected' : ''}}>Get members transaction history *</option>
                            <option value="105" {{Request::input('transaction_code') == '105' ? 'selected' : ''}}>Update member details *</option>
                            <option value="106" {{Request::input('transaction_code') == '106' ? 'selected' : ''}}>PhilHealth via OTC payment **</option>
                            <option value="109" {{Request::input('transaction_code') == '109' ? 'selected' : ''}}>Pag-IBIG savings payment</option>
                            <option value="110" {{Request::input('transaction_code') == '110' ? 'selected' : ''}}>Pag-IBIG MP2 payment</option>
                            <option value="111" {{Request::input('transaction_code') == '111' ? 'selected' : ''}}>Pag-IBIG short-term loan payment</option>
                            <option value="112" {{Request::input('transaction_code') == '112' ? 'selected' : ''}}>Pag-IBIG housing loan payment</option>
                            <option value="113" {{Request::input('transaction_code') == '113' ? 'selected' : ''}}>SSS contribution payment</option>
                            <option value="114" {{Request::input('transaction_code') == '114' ? 'selected' : ''}}>SSS short-term loan payment</option>
                            <option value="115" {{Request::input('transaction_code') == '115' ? 'selected' : ''}}>SSS real-estate loan payment</option>
                            <option value="116" {{Request::input('transaction_code') == '116' ? 'selected' : ''}}>SSS Miscellaneous payment</option>
                            <option value="117" {{Request::input('transaction_code') == '117' ? 'selected' : ''}}>MedPadala voucher</option>
                            <option value="118" {{Request::input('transaction_code') == '118' ? 'selected' : ''}}>Bills payment – Meralco</option>
                            <option value="119" {{Request::input('transaction_code') == '119' ? 'selected' : ''}}>Bills payment – BayanTel</option>
                            <option value="120" {{Request::input('transaction_code') == '120' ? 'selected' : ''}}>Bills payment – Destiny/Sky Cable</option>
                            <option value="121" {{Request::input('transaction_code') == '121' ? 'selected' : ''}}>Bills payment – Digitel</option>
                            <option value="122" {{Request::input('transaction_code') == '122' ? 'selected' : ''}}>Bills payment – Smart</option>
                            <option value="123" {{Request::input('transaction_code') == '123' ? 'selected' : ''}}>Bills payment – PhilAm Life</option>
                            <option value="124" {{Request::input('transaction_code') == '124' ? 'selected' : ''}}>Bills payment – Globe</option>
                            <option value="125" {{Request::input('transaction_code') == '125' ? 'selected' : ''}}>Bills payment – Manulife Philippines</option>
                            <option value="126" {{Request::input('transaction_code') == '126' ? 'selected' : ''}}>Bills payment – Manila Water</option>
                            <option value="127" {{Request::input('transaction_code') == '127' ? 'selected' : ''}}>Bills payment – Pilipino Cable</option>
                            <option value="128" {{Request::input('transaction_code') == '128' ? 'selected' : ''}}>Bills payment – PLDT</option>
                            <option value="129" {{Request::input('transaction_code') == '129' ? 'selected' : ''}}>Bills payment – Maynilad</option>
                            <option value="130" {{Request::input('transaction_code') == '130' ? 'selected' : ''}}>Bills payment – Cable Link</option>
                            <option value="131" {{Request::input('transaction_code') == '131' ? 'selected' : ''}}>Bills payment – iBlaze</option>
                            <option value="132" {{Request::input('transaction_code') == '132' ? 'selected' : ''}}>Bills payment – Bankard</option>
                            <option value="133" {{Request::input('transaction_code') == '133' ? 'selected' : ''}}>Bills payment – Innove Product</option>
                            <option value="134" {{Request::input('transaction_code') == '134' ? 'selected' : ''}}>Bills payment – Sun Life</option>
                            <option value="135" {{Request::input('transaction_code') == '135' ? 'selected' : ''}}>Bills payment – Central CATV</option>
                            <option value="136" {{Request::input('transaction_code') == '136' ? 'selected' : ''}}>Bills payment – Asialink Finance</option>
                            <option value="137" {{Request::input('transaction_code') == '137' ? 'selected' : ''}}>Bills payment – Manile Memorial Park</option>
                            <option value="138" {{Request::input('transaction_code') == '138' ? 'selected' : ''}}>Bills payment – Prime Water</option>
                            <option value="139" {{Request::input('transaction_code') == '139' ? 'selected' : ''}}>Bills payment – Pangasinan III Electric Cooperative, Inc</option>
                            <option value="140" {{Request::input('transaction_code') == '140' ? 'selected' : ''}}>Bills payment – Meycauayan Water</option>
                            <option value="141" {{Request::input('transaction_code') == '141' ? 'selected' : ''}}>Bills payment – Click Broadband</option>
                            <option value="142" {{Request::input('transaction_code') == '142' ? 'selected' : ''}}>Bills payment – National Home Mortgage Finance Corp</option>
                            <option value="143" {{Request::input('transaction_code') == '143' ? 'selected' : ''}}>Bills payment – Sta. Lucia Waterworks</option>
                            <option value="144" {{Request::input('transaction_code') == '144' ? 'selected' : ''}}>Bills payment – Wi-Tribe</option>
                            <option value="145" {{Request::input('transaction_code') == '145' ? 'selected' : ''}}>Bills payment – Veco</option>
                            <option value="146" {{Request::input('transaction_code') == '146' ? 'selected' : ''}}>Bills payment – NSO</option>
                            <option value="147" {{Request::input('transaction_code') == '147' ? 'selected' : ''}}>PayRemit Online Wallet</option>
                            <option value="148" {{Request::input('transaction_code') == '148' ? 'selected' : ''}}>PayRemit OTC payment</option>
                        </select>
                    </div>
                </div>
        </form>
        <form method="post" class="form-horizontal">
            @if(Session::get('error'))
                <div class="alert alert-danger col-md-offset-2 col-md-10 ">
                    <ul>
                        <li>{{Session::get('error')}}</li>
                    </ul>
                </div>
            @endif
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="transaction_code" value="{{Request::input('transaction_code')}}">

            @if($_input_field)
                @foreach($_input_field as $input_field)
                  <div class="form-group">
                    <label for="{{$input_field['label']}}" class="col-sm-2 control-label">{{$input_field['label']}}</label>
                    <div class="col-sm-10">
                        <!--{{$input_field['true_type'] .'=='. $input_field['type']}}-->
                    @if($input_field['type']=='select')
                        <select name="{{$input_field['name']}}" class="form-control">
                            <option>Select {{$input_field['name']}}</option>
                            @foreach($input_field['data'] as $option)
                                <option value="{{$option['value']}}">{{$option['name']}}</option>
                            @endforeach
                        </select>
                    @else
                      <input type="{{$input_field['type']}}" name="{{$input_field['name']}}" class="form-control" id="" placeholder="{{$input_field['placeholder']}}" value="{{Request::old($input_field['name'])}}">
                    @endif
                    </div>
                  </div>
                @endforeach
                            <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 text-left">
                      <button type="submit" class="btn btn-default">Submit</button>
                    </div>
            </div>
            @endif
        </form>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function()
        {
            $('#get-input-form select').on('change', function(event)
            {
                event.preventDefault();
                $(this).closest('form').submit();

            });
        });
    </script>
@endsection
@section('css')
@endsection
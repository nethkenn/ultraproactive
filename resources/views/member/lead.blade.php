@extends('member.layout')
@section('content')
<div class="encashment voucher code-vault">
        @if(Session::has('message'))
            <div class="alert alert-danger">
                <ul>
                        <li>{{ $error }}</li>
                </ul>
            </div>
        @endif
        @if(Session::has('success'))
            <div class="alert alert-success">
                <ul>
                        <li>{{ $success }}</li>
                </ul>
            </div>
        @endif
    <div class="table">
        <div class="table-head para">
            <div class="col-md-6 aw">
                <img src="/resources/assets/frontend/img/icon-lead.png">
                Leads ( {{$leadcount}} )
            </div>
            <div class="col-md-6 ew">
                <a style="cursor: pointer;" class="genlead">
                    <div class="button">How to Generate Leads?</div>
                </a>

                <a style="cursor: pointer;" class="manual-add-btn">
                    <span class="button">Manual Add</span>
                </a>
              <!--  <a style="cursor: pointer;" class="a_lead">

                    <div class="button">Add Leads ( Manually )</div>
                </a> -->
            </div>
        </div>
        <table class="footable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th data-hide="phone">Email</th>
                    <th data-hide="phone">Join Date</th>
                    <th data-hide="phone"></th>
                </tr>
            </thead>
            <tbody>
                @if($lead)
                    @foreach($lead as $l)
                    <tr class="tibolru">
                        <td>{{$l->account_name}}</td>
                        <td>{{$l->account_email}}</td>
                        <td>{{$l->join_date}}</td>
                        <td> </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>


<!--<div class="remodal create-slot" data-remodal-id="add_lead" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-plis.png">
        Add Leads
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal" method="POST">
            <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
            <div class="form-group para">
                <label for="una" class="col-sm-3 control-label">Username</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="una" name="name">
                </div>
            </div>
            <div class="form-group para">
                <label for="pangalawa" class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="pangalawa" name="email">
                </div>
            </div> 
    </div>
    <br>
    <button class="button" type="button" data-remodal-action="cancel">Cancel</button>
    <button class="button" type="submit" name="addlead">Add Lead</button>
    </form>
</div> -->


<div class="remodal create-slot" data-remodal-id="generate_lead" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-how.png">
        How to Generate Leads
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div style="color: #77818e; font-size: 12p.5x;">You might invite people using this link. </br>People who gives their information using your link become your Leads</div>
    <div>
        @if($acc->account_email)
             <input style="color: #f47265; font-size: 12.5px; width: 80%; margin: 20px auto; padding: 10px; text-align: center; border: 1px solid #eeeeee;" type="text" value="{{$_SERVER['SERVER_NAME']}}/lead/{{$acc->account_username}}"></div>
        @else
             <input style="color: #f47265; font-size: 12.5px; width: 80%; margin: 20px auto; padding: 10px; text-align: center; border: 1px solid #eeeeee;" type="text" value="Please add your email first in your account settings."></div>
        @endif
    <br>
    <button class="button" data-remodal-action="confirm">Close</button>
</div>
<div class="remodal" data-remodal-id="add-leads-manual-modal"
  data-remodal-options="hashTracking: true, closeOnOutsideClick: false, closeOnEscape: false">
  <button data-remodal-action="close" class="remodal-close btn-remodal"></button>
  <h3>Add Lead Manually</h3>
<form class="form-horizontal" action="/member/leads/manual-add/" method="POST">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
  <div class="form-group">
    <label for="first_name" class="col-sm-2 control-label">First Name</label>
    <div class="col-sm-10">
        @if($errors->first('first_name'))
            <p class="text-danger text-left">*{{$errors->first('first_name')}}</p>
        @endif
        <input type="text" class="form-control" placeholder="" value="{{Request::old('first_name')}}" name="first_name">
    </div>
  </div>
  <div class="form-group">
    <label for="middle_name" class="col-sm-2 control-label">Middle Name</label>
    <div class="col-sm-10">
        @if($errors->first('middle_name'))
            <p class="text-danger text-left">*{{$errors->first('middle_name')}}</p>
        @endif
        <input type="text" class="form-control" placeholder="" value="{{Request::old('middle_name')}}" name="middle_name">
    </div>
  </div>

    <div class="form-group">
    <label for="last_name" class="col-sm-2 control-label">Last Name</label>
    <div class="col-sm-10">
        @if($errors->first('last_name'))
            <p class="text-danger text-left">*{{$errors->first('last_name')}}</p>
        @endif
        <input type="text" class="form-control" placeholder="" value="{{Request::old('last_name')}}" name="last_name">
    </div>
  </div>
  <div class="form-group text-left">
        <label for="gender" class="col-sm-2 control-label">Gender</label>
        <div class="col-sm-10">
           @if($errors->first('gender'))
                <p class="text-danger text-left">*{{$errors->first('gender')}}</p>
            @endif

            <label class="radio-inline">
              <input type="radio" name="gender" id="" value="male" {{Request::old('male') ? 'seleected' : ''}}> Male
            </label>
                <label class="radio-inline">
              <input type="radio" name="gender" id="" value="female" {{Request::old('female') ? 'seleected' : ''}}> Female
            </label>
          </div>
      </div>

  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">Email</label>

    <div class="col-sm-10">
        @if($errors->first('email'))
            <p class="text-danger text-left">*{{$errors->first('email')}}</p>
        @endif
        <input type="email" class="form-control" placeholder="" value="{{Request::old('email')}}" name="email">
    </div>
  </div>

    <div class="form-group">
    <label for="cellphone_number" class="col-sm-2 control-label">Cellphone Number</label>
    <div class="col-sm-10">
        @if($errors->first('cellphone_number'))
            <p class="text-danger text-left">*{{$errors->first('cellphone_number')}}</p>
        @endif
        <input type="text" class="form-control" placeholder="" value="{{Request::old('cellphone_number')}}" name="cellphone_number">
    </div>
  </div>

      <div class="form-group">
    <label for="telephone_number" class="col-sm-2 control-label">Telephone Number</label>
    <div class="col-sm-10">
        @if($errors->first('telephone_number'))
            <p class="text-danger text-left">*{{$errors->first('telephone_number')}}</p>
        @endif
        <input type="text" class="form-control" placeholder="" value="{{Request::old('telephone_number')}}" name="telephone_number">
    </div>
  </div>

  <div class="form-group">
    <label for="birthday" class="col-sm-2 control-label">birthday</label>
    <div class="col-sm-10">
        @if($errors->first('birthday'))
            <p class="text-danger text-left">*{{$errors->first('birthday')}}</p>
        @endif
        <input id="datepicker" type="date" class="form-control" placeholder="" value="{{Request::old('birthday')}}" name="birthday">
    </div>
  </div>

    <div class="form-group">
    <label for="Address" class="col-sm-2 control-label">Address</label>
    <div class="col-sm-10">
        @if($errors->first('address'))
            <p class="text-danger text-left">*{{$errors->first('address')}}</p>
        @endif
        <textarea class="form-control" name="address">{{Request::old('address')}}</textarea>
    </div>
  </div>

<div class="form-group">
    <label for="Country" class="col-sm-2 control-label">Country</label>
    <div class="col-sm-10">
        @if($errors->first('country'))
            <p class="text-danger text-left">*{{$errors->first('country')}}</p>
        @endif
        <select class="form-control" name="country">
            <option value="2" {{Request::old('country') == 2 ? 'selected' : ''}}>Philippines</option>
        </select>
    </div>
  </div>

    <div class="form-group">
    <label for="username" class="col-sm-2 control-label">Username</label>
    <div class="col-sm-10">
        @if($errors->first('username'))
            <p class="text-danger text-left">*{{$errors->first('username')}}</p>
        @endif
        <input type="text" class="form-control" placeholder="" value="{{Request::old('username')}}" name="username" >
    </div>
  </div>
      <div class="form-group">
    <label for="Password" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
        @if($errors->first('password'))
            <p class="text-danger text-left">*{{$errors->first('password')}}</p>
        @endif
        <input type="password" class="form-control" placeholder="" value="{{Request::old('password')}}" name="password">
    </div>
  </div>

    <div class="form-group">
    <label for="confirm_password" class="col-sm-2 control-label">Confirm Password</label>
    <div class="col-sm-10">
        @if($errors->first('confirm_password'))
            <p class="text-danger text-left">*{{$errors->first('confirm_password')}}</p>
        @endif
        <input type="password" class="form-control" placeholder="" value="{{Request::old('confirm_password')}}" name="confirm_password">
    </div>
  </div>
  <div class="form-group">
        <button data-remodal-action="cancel" class="remodal-cancel btn-remodal">Cancel</button>
        <button class="remodal-confirm btn-remodal">OK</button>
  </div>
</form>

</div>
@endsection
@section('script')
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $( "#datepicker" ).datepicker(
        {
            changeMonth: true,
            changeYear: true,
            dateFormat:'yy-mm-dd',
            yearRange: "-100:+0",
            value: "{{Request::old('birthday')}}"

        });
    });
</script>
<script type="text/javascript" src="/resources/assets/frontend/js/lead.js"></script>
@endsection
@section('css')

@endsection
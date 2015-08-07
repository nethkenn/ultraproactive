@extends('member.layout')
@section('content')
<!-- <div class="encashment voucher code-vault">





<div class="table">
<div class="table-head para">
<div class="col-md-6 aw">
Account Settings
</div>

</div>




<form action="/member/settings/upload" method="post" enctype="multipart/form-data">
Select image to upload:
<input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
<input type="file" name="fileToUpload" id="fileToUpload">
<input type="submit" value="Change Image" name="submit" required>
</form>


<form method="POST">
    <div class="container">
    <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
    <div class="vc_col-md-6 columnz">
        <div class="column-title">
            <span>Personal Details</span>
        </div>
        <img src="/resources/assets/frontend/img/line.png">
        <div class="teybol">
            <div class="form-group">
                <div class="labelz">Name*</div>
                <div class="inputz"><input type="text" name="fname" value="{{$acc->account_name}}"></div>
            </div>

            <div class="form-group">
                <div class="labelz">Gender*</div>
                <div class="inputz" name="gender">
                    <input name="gender" type="radio" value="Male" {{$acc->gender == "Male" ? "checked" : ""}}><span>Male</span>
                    <input name="gender" type="radio" value="Female" {{$acc->gender == "Female" ? "checked" : ""}}><span>Female</span>
                </div>
            </div>
            <div class="form-group">
                <div class="labelz">Email*</div>
                <div class="inputz"><input type="text" name="email" value="{{$acc->account_email}}"></div>
            </div>

            <div class="form-group">
                <div class="labelz">Phone Number*</div>
                <div class="inputz"><input type="text" name="cp" value="{{$acc->account_contact_number}}"></div>
            </div>
            <div class="form-group">
                <div class="labelz">Telephone Number*</div>
                <div class="inputz"><input type="text" name="tp" value="{{$acc->telephone}}"></div>
            </div>
            <div class="form-group">
                <div class="labelz">Birthday*</div>
                <div class="inputz">
                    <div class="vc_col-md-4">
                        <select name="rmonth" >
                            <option {{ $customer_birthday[1] == "1" ? 'selected' : '' }} value="1">January</option>
                            <option {{ $customer_birthday[1] == "2" ? 'selected' : '' }} value="2">February</option>
                            <option {{ $customer_birthday[1] == "3" ? 'selected' : '' }} value="3">March</option>
                            <option {{ $customer_birthday[1] == "4" ? 'selected' : '' }} value="4">April</option>
                            <option {{ $customer_birthday[1] == "5" ? 'selected' : '' }} value="5">May</option>
                            <option {{ $customer_birthday[1] == "6" ? 'selected' : '' }} value="6">June</option>
                            <option {{ $customer_birthday[1] == "7" ? 'selected' : '' }} value="7">July</option>
                            <option {{ $customer_birthday[1] == "8" ? 'selected' : '' }} value="8">August</option>
                            <option {{ $customer_birthday[1] == "9" ? 'selected' : '' }} value="9">September</option>
                            <option {{ $customer_birthday[1] == "10" ? 'selected' : '' }} value="10">October</option>
                            <option {{ $customer_birthday[1] == "11" ? 'selected' : '' }} value="11">November</option>
                            <option {{ $customer_birthday[1] == "12" ? 'selected' : '' }} value="12">December</option>
                        </select>
                    </div>
                    <div class="vc_col-md-4">
                            <select id = "dbirthday" name = "rday" required = "required">   
                                    @for($birthday = 1; $birthday <= 31; $birthday++)
                                        <option value="{{$birthday}}" {{ $customer_birthday[2] == $birthday ? 'selected' : '' }}> 
                                            {{ $birthday }}
                                        </option>
                                    @endfor             
                            </select>
                    </div>
                    <div class="vc_col-md-4">
                        <select id = "ybirthday" name = "ryear">
                            <option value = '' disabled selected style = 'display:none;'>Year</option>      
                                @for($birthday=(date("Y")-120);$birthday<=date("Y");$birthday++)
                                    <option value="{{$birthday}}" {{ (date("Y")-18) == $birthday ? 'selected' : '' }}>
                                        {{ $birthday }}
                                    </option>
                                @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="labelz">Address</div>
                <div class="inputz"><textarea name="address">{{$acc->address}}</textarea></div>
            </div>
            <div class="form-group">
                <div class="labelz">Country*</div>
                <div class="inputz">
                    <select name="country">
                        @foreach($country as $c)
                        <option value="{{$c->country_id}}" {{$acc->account_country_id == $c->country_id ? "selected" : ""}}>{{$c->country_name}}</option>
                        @endforeach
                    </select>
                </div>  
            </div>
        </div>
    </div>
    <div class="vc_col-md-12">
        <input type="submit" name="submit" value="Register Now" class="register-button">
    </div>
</div>
</form>
</tbody>
</table>
</div>
</div> -->
                       <!--     <div class="vc_col-md-6 columnz">
                                <div class="column-title">
                                    <span>Account Details</span>
                                </div>
                                <img src="/resources/assets/frontend/img/line.png">
                                <div class="teybol">
                                    <div class="form-group">
                                        <div class="labelz">User Name*</div>
                                        <div class="inputz"><input type="text" name="user"></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="labelz">Password*</div>
                                        <div class="inputz"><input type="password" name="pass"></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="labelz">Re-type Password*</div>
                                        <div class="inputz"><input type="password" name="rpass"></div>
                                    </div>
                                </div>
                            </div> -->



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

<div class="setting-header"><i class="fa fa-cog"></i> <span>Account Settings</span></div>
<div class="setting">
    <form method="POST" id="settings">
        <input type="hidden" name="forsubmit" value="Submit">
        <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
        <div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="fname" value="{{$acc->account_name}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <div class="radio">
                        <label class="radio-inline">
                          <input name="gender" type="radio" value="Male" {{$acc->gender == "Male" ? "checked" : ""}}><span>Male</span>
                        </label>
                        <label class="radio-inline">
                          <input name="gender" type="radio" value="Female" {{$acc->gender == "Female" ? "checked" : ""}}><span>Female</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" value="{{$acc->account_email}}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="cp" value="{{$acc->account_contact_number}}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="telephone">Telephone Number</label>
                    <input type="text" name="tp" value="{{$acc->telephone}}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Birthday</label>
                    <div class="row">
                        <div class="col-md-4">
                            <select name="rmonth" class="form-control">
                                <option {{ $customer_birthday[1] == "1" ? 'selected' : '' }} value="1">January</option>
                                <option {{ $customer_birthday[1] == "2" ? 'selected' : '' }} value="2">February</option>
                                <option {{ $customer_birthday[1] == "3" ? 'selected' : '' }} value="3">March</option>
                                <option {{ $customer_birthday[1] == "4" ? 'selected' : '' }} value="4">April</option>
                                <option {{ $customer_birthday[1] == "5" ? 'selected' : '' }} value="5">May</option>
                                <option {{ $customer_birthday[1] == "6" ? 'selected' : '' }} value="6">June</option>
                                <option {{ $customer_birthday[1] == "7" ? 'selected' : '' }} value="7">July</option>
                                <option {{ $customer_birthday[1] == "8" ? 'selected' : '' }} value="8">August</option>
                                <option {{ $customer_birthday[1] == "9" ? 'selected' : '' }} value="9">September</option>
                                <option {{ $customer_birthday[1] == "10" ? 'selected' : '' }} value="10">October</option>
                                <option {{ $customer_birthday[1] == "11" ? 'selected' : '' }} value="11">November</option>
                                <option {{ $customer_birthday[1] == "12" ? 'selected' : '' }} value="12">December</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select id = "dbirthday" name = "rday" required = "required" class="form-control">   
                                    @for($birthday = 1; $birthday <= 31; $birthday++)
                                        <option value="{{$birthday}}" {{ $customer_birthday[2] == $birthday ? 'selected' : '' }}> 
                                            {{ $birthday }}
                                        </option>
                                    @endfor             
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select id = "ybirthday" name = "ryear" class="form-control">
                                <option value = '' disabled selected style = 'display:none;'>Year</option>      
                                    @for($birthday=(date("Y")-120);$birthday<=date("Y");$birthday++)
                                        <option value="{{$birthday}}" {{ $customer_birthday[0] == $birthday ? 'selected' : '' }}>
                                            {{ $birthday }}
                                        </option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea name="address" class="form-control">{{$acc->address}}</textarea>
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <select name="country" class="form-control">
                        @foreach($country as $c)
                        <option value="{{$c->country_id}}" {{$acc->account_country_id == $c->country_id ? "selected" : ""}}>{{$c->country_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
            <div class="col-md-6 lefty">
                <div class="form-group">
                    <label for="file">Upload Picture</label>
                    <div class="profile-pic">
                        @if($member->image != "")
                        <img src="{{$member->image}}" style="max-width: 100%;">
                        @else
                        <img src="/resources/assets/img/default-image.jpg" style="max-width: 100%;">
                        @endif
                        <div class="borders"></div>
                    </div>
                    <div>
                        <form action="/member/settings/upload" method="post" enctype="multipart/form-data">
                        <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
                        <div style="margin: 20px 0;">
                            <input type="file" name="fileToUpload" id="fileToUpload">
                        </div>
                        <input type="submit" class="btn btn-warning" value="Change Image" name="submit" required>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 righty">
                <button class="genlead btn btn-info text-right">Change Pass</button>
                <button class="btn btn-success text-right" onclick="$('#settings').submit();">Update</button>
            </div>
        </div>
    
</div>




<div class="remodal create-slot" data-remodal-id="cpass">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        Change Pass
    </div>
    <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto">
    <div class="col-md-10 col-md-offset-1 para">
        <form class="form-horizontal" method="POST">
            <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
            <div class="form-group para">
                <label for="una" class="col-sm-3 control-label">Old Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="una" name="old">
                </div>
            </div>
            <div class="form-group para">
                <label for="pangalawa" class="col-sm-3 control-label">New Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="pangalawa" name="new">
                </div>
            </div>

            <div class="form-group para">
                <label for="pangatlo" class="col-sm-3 control-label">Repeat Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="pangatlo" name="rnew">
                </div>
            </div>
    </div>
    <br>
    <button class="button" type="button" data-remodal-action="cancel">Cancel</button>
    <button class="button" type="submit" name="cpass">Change pass</button>
    </form>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript" src="/resources/assets/members/js/account.js"></script>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/setting.css">
@endsection



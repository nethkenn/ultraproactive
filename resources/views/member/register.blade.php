@extends('front.layout')
@section('content')

<div class="register top_wrapper no-transparent">
	<div class="title-header">User Registration Form</br><span>register here to become a member of our website.</span></div>

	@if(Session::has('message'))
		<div class="alert alert-danger">
			<ul>
				@foreach ($error->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

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
					<div class="labelz">First Name*</div>
					<div class="inputz"><input type="text" name="fname"></div>
				</div>
				<div class="form-group">
					<div class="labelz">Middle Name*</div>
					<div class="inputz"><input type="text" name="mname"></div>
				</div>
				<div class="form-group">
					<div class="labelz">Last Name*</div>
					<div class="inputz"><input type="text" name="lname"></div>
				</div>
				<div class="form-group">
					<div class="labelz">Gender*</div>
					<div class="inputz">
						<input name="gender" type="radio"><span>Male</span>
						<input name="gender" type="radio"><span>Female</span>
					</div>
				</div>
				<div class="form-group">
					<div class="labelz">Email*</div>
					<div class="inputz"><input type="text" name="email"></div>
				</div>
				<div class="form-group">
					<div class="labelz">Confirm Email*</div>
					<div class="inputz"><input type="text" name="remail"></div>
				</div>
				<div class="form-group">
					<div class="labelz">Phone Number*</div>
					<div class="inputz"><input type="text" name="contact"></div>
				</div>
				<div class="form-group">
					<div class="labelz">Telephone Number*</div>
					<div class="inputz"><input type="text"></div>
				</div>
				<div class="form-group">
					<div class="labelz">Birthday*</div>
					<div class="inputz">
						<div class="vc_col-md-4"><select></select></div>
						<div class="vc_col-md-4"><select></select></div>
						<div class="vc_col-md-4"><select></select></div>
					</div>
				</div>
				<div class="form-group">
					<div class="labelz">Address</div>
					<div class="inputz"><textarea></textarea></div>
				</div>
				<div class="form-group">
					<div class="labelz">Country*</div>
					<div class="inputz">
						<select name="country">
							@foreach($country as $c)
							<option value="{{$c->country_id}}">{{$c->country_name}}</option>
							@endforeach
						</select>
					</div>	
				</div>
			</div>
		</div>
		<div class="vc_col-md-6 columnz">
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
		</div>
		<div class="vc_col-md-12">
			<input type="submit" name="submit" value="Register Now" class="register-button">
		</div>
		</div>
	</form>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="/resources/assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/resources/assets/remodal/src/jquery.remodal.js"></script>
<script type="text/javascript" src="/resources/assets/jquery-ui/jquery-ui.js"></script>
@endsection
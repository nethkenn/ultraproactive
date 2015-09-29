@extends('front.layout')
@section('content')
<div class="register top_wrapper no-transparent rw" style="background-color: #fff; margin: 0 -15px;">
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
		<div class="col-md-6 columnz">
			<div class="column-title">
				<span>Personal Details</span>
			</div>
			<img src="/resources/assets/frontend/img/line.png">
			<div class="teybol">
				<div class="form-group">
					<div class="labelz">First Name*</div>
					<div class="inputz"><input type="text" name="fname" value="{{Request::old('fname')}}"></div>
				</div>
				<div class="form-group">
					<div class="labelz">Middle Name*</div>
					<div class="inputz"><input type="text" name="mname" value="{{Request::old('mname')}}"></div>
				</div>
				<div class="form-group">
					<div class="labelz">Last Name*</div>
					<div class="inputz"><input type="text" name="lname" value="{{Request::old('lname')}}"></div>
				</div>
				<div class="form-group">
					<div class="labelz">Gender*</div>
					<div class="inputz" name="gender">
						<input name="gender" type="radio" value="Male" checked><span>Male</span>
						<input name="gender" type="radio" value="Female"><span>Female</span>
					</div>
				</div>
				<div class="form-group">
					<div class="labelz">Email*</div>
					<div class="inputz"><input type="text" name="email" value="{{Request::old('email')}}"></div>
				</div>
				<div class="form-group">
					<div class="labelz">Confirm Email*</div>
					<div class="inputz"><input type="text" name="remail" value="{{Request::old('remail')}}"></div>
				</div>
				<div class="form-group">
					<div class="labelz">Phone Number*</div>
					<div class="inputz"><input type="text" name="cp" value="{{Request::old('cp')}}"></div>
				</div>
				<div class="form-group">
					<div class="labelz">Telephone Number*</div>
					<div class="inputz"><input type="text" name="tp" value="{{Request::old('tp')}}"></div>
				</div>
				<div class="form-group">
					<div class="labelz">Birthday*</div>
					<div class="inputz" style="margin: 0">
						<div class="col-md-4">
								<select name="rmonth" id="mbirthday">
									<option value="1">January</option>
									<option value="2">February</option>
									<option value="3">March</option>
									<option value="4">April</option>
									<option value="5">May</option>
									<option value="6">June</option>
									<option value="7">July</option>
									<option value="8">August</option>
									<option value="9">September</option>
									<option value="10">October</option>
									<option value="11">November</option>
									<option value="12">December</option>
	 							</select>
	 				    </div>
	 					<div class="col-md-4">
								<select id = "dbirthday" name = "rday" required = "required">	
	 									@for($birthday = 1; $birthday <= 31; $birthday++)
											<option value="{{$birthday}}"> 
												{{ $birthday }}
											</option>
										@endfor				
	 							</select>
	 					</div>
						<div class="col-md-4">
							<select id = "ybirthday" name = "ryear">
		 							@for($birthday=(date("Y")-120);$birthday<=date("Y");$birthday++)
										<option value="{{$birthday}}">
											{{ $birthday }}
										</option>
									@endfor
	 						</select>
	 					</div>
					</div>
				</div>
				<div class="form-group">
					<div class="labelz">Address</div>
					<div class="inputz"><textarea name="address">{{Request::old('address')}}</textarea></div>
				</div>
				<div class="form-group">
					<div class="labelz">Country*</div>
					<div class="inputz">
						<select name="country">
							@foreach($country as $c)
							<option value="{{$c->country_id}}" {{Request::old('country') == $c->country_id ? 'selected' : '' }}>{{$c->country_name}}</option>
							@endforeach
						</select>
					</div>	
				</div>
			</div>
		</div>
		<div class="col-md-6 columnz">
			<div class="column-title">
				<span>Account Details</span>
			</div>
			<img src="/resources/assets/frontend/img/line.png">
			<div class="teybol">
				<div class="form-group">
					<div class="labelz">User Name*</div>
					<div class="inputz"><input type="text" name="user" value="{{Request::old('user')}}"></div>
				</div>
				<div class="form-group">
					<div class="labelz">Password*</div>
					<div class="inputz"><input type="password" name="pass" value="{{Request::old('pass')}}"></div>
				</div>
				<div class="form-group">
					<div class="labelz">Re-type Password*</div>
					<div class="inputz"><input type="password" name="rpass" value="{{Request::old('rpass')}}"></div>
				</div>
				<div class="hide">
					<div class="form-group text-center">
						<strong>Beneficiary</strong>
					</div>
					<div class="form-group">
						<div class="labelz">First Name</div>
						<div class="inputz"><input type="text" name="f_name" value="{{Request::old('f_name')}}"></div>
					</div>

					<div class="form-group">
						<div class="labelz">Middle Name</div>
						<div class="inputz"><input type="text" name="m_name" value="{{Request::old('m_name')}}"></div>
					</div>

					<div class="form-group"> 
						<div class="labelz">Last Name</div>
						<div class="inputz"><input type="text" name="l_name" value="{{Request::old('l_name')}}"></div>
					</div>
					<div class="form-group">
						<div class="labelz">
							Beneficiary Gender</div>
						<div class="inputz">
							<select name="beneficiary_gender">
								<option value="1" {{Request::old('beneficiary_gender') == '1' ? 'selected' : ''}}>Male</option>
								<option value="0" {{Request::old('beneficiary_gender') == '0' ? 'selected' : ''}}>Female</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="labelz">
							Relationship</div>
						<div class="inputz">
							<select id="add-relation" name="beneficiary_rel" required>
								<option>Add Relation</option>
								@if($_beneficiary_rel)
									@foreach($_beneficiary_rel as $beneficiary_rel)
										<option value = "{{$beneficiary_rel->relation}}" {{Request::old('beneficiary_rel_id') == $beneficiary_rel->relation ? 'selected' : ''}}>{{$beneficiary_rel->relation}}</option>
									@endforeach
								@endif
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12" style="margin-top: 20px;">
			<input type="submit" name="submit" value="Register Now" class="register-button">
		</div>
		</div>
	</form>
</div>

<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="/resources/assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/resources/assets/remodal/src/jquery.remodal.js"></script>
<script type="text/javascript" src="/resources/assets/jquery-ui/jquery-ui.js"></script> -->
<script type="text/javascript">
	;(function($)
	{

		

		$('#add-relation').on('change', function()
		{

			var $index  = document.getElementById("add-relation").selectedIndex;
			var $last_index = $('#add-relation option').length - 1;
			// console.log($index);
			// console.log($last_index);
			// var test = $(this).val();
			// console.log(test);
			if($index == $last_index)
			{
				$(this).replaceWith("<input type='text' name='beneficiary_rel'>");
			}
			



			 
		});


		$('#add-relation').trigger('change');

	})(jQuery);
</script>
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="/resources/assets/frontend/css/registration.css">
@endsection






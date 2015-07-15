<!DOCTYPE html>
<html lang="en-US" class="css3transitions">
@if (count($errors) > 0)
	<div class="alert alert-danger">
		<strong>Whoops!</strong> There were some problems with your input.<br><br>
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif
<form method="POST">
	<div class="bg">
		<div class="wrapper">
			<div class="content para">
				<input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
				<div class="input">
	                <input type="text" name="name" placeholder="Name" required>
	            </div>
	            <div class="input">
	                <input type="email" name="email" placeholder="Email" required>
	            </div>
	            <div class="input">
	                <input type="text" name="user" placeholder="Username" required>
	            </div>
	            <div class="input">
	                <input type="password" name="pass" placeholder="Password" required>
	            </div>
	            <div class="input">
	                <input type="password" name="rpass" placeholder="Repeat Password" required>
	            </div>
	            <div class="input">
	                <input type="text" name="contact" placeholder="Contact No." required>
	            </div>
	            <div class="input">
	                <select name="country">
	                	@if($country)
		                	@foreach($country as $c)
		                		<option value="{{$c->country_id}}">{{$c->country_name}}</option>
		                	@endforeach
		                @endif	
	                </select>
	            </div>
	            <div class="input">
	                <input type="text" name="custom" placeholder="Custom" required>
	            </div>
	                <input type="submit" name="submit" placeholder="Password" value="Register">
			</div>
		</div>
	</div>
</form>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="/resources/assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/resources/assets/remodal/src/jquery.remodal.js"></script>
<script type="text/javascript" src="/resources/assets/jquery-ui/jquery-ui.js"></script>
</html>
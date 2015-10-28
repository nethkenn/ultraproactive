
<div style="font-family: arial;">
	<form method="post" >
		<div>Pay-In Per Slot</div>
		<div><input name="payin" type= "text"></div>
		<div>Binary - Income Per Pair</div>
		<div><input name="per_pair" type= "text"></div>
		<div>Direct Referral Income</div>
		<div><input name="direct" type= "text"></div>
		<input type="submit" value="Compute">
		<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
	</form>
</div>
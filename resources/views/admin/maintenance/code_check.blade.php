<div class="form-group">
	<label>Code Status</label>
	<input class="form-control text-center" type="text" value="{{$code->stat}}" name="code_status" disabled>
</select>
</div>
<div class="form-group">
	<label>Used by/ Own By</label>
	<input class="form-control text-center" type="text" value="{{$code->account_name}}" name="used_by" disabled>
</select>
</div>
<div class="form-group">
	<label>Slot# Generated</label>
	<input class="form-control text-center" type="text" value="" name="slot_generated" disabled>
</select>
</div>
<div class="form-group">
	<label>Code Issued By</label>
	<input class="form-control text-center" type="text" value="" name="code_issued_by" disabled>
</select>
</div>
<div class="form-group">
	<label>Claimable Voucher</label>
	<input class="form-control text-center" type="text" value="{{$code->inventory_update_type_name}}" name="claimable_voucher" disabled>
</select>
</div>


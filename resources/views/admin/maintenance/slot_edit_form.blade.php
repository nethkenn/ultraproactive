<script type="text/javascript">
    $(document).ready(function()
    {
        var config = {
          '.chosen-select' : {}
        }
        for (var selector in config) {
          $(selector).chosen(config[selector]);
        }

        $(".chosen-container").css('width','95%');
    });
</script>


<div class="form">
    <form class="submit-update-slot" method="post">
        <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" class="token" name="slot_id" value="{{ Request::input('slot_id') }}">

        <div class="fieldset">
            <div class="label">SLOT OWNER</div>
            <div class="field">
                <select class="slot_owner_change chosen-select" name="account_id">
                    @foreach($_account as $account)
                    <option {{ $account->account_id == $slot->slot_owner ? 'selected="selected"' : '' }} value="{{ $account->account_id }}">{{ $account->account_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="fieldset">
            <div class="label">MEMBERSHIP</div>
            <div class="field">
                <select name="slot_membership">
                    @foreach($_membership as $memberhsip)
                    <option {{ $memberhsip->membership_id == $slot->slot_membership ? 'selected="selected"' : '' }} value="{{ $memberhsip->membership_id }}">{{ $memberhsip->membership_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="fieldset">
            <div class="label">RANK</div>
            <div class="field">
                <select name="rank">
                    @foreach($_rank as $rank)
                    <option {{ $rank->rank_id == $slot->slot_rank ? 'selected="selected"' : '' }} value="{{ $rank->rank_id }}">{{ $rank->rank_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="fieldset">
            <div class="label">SLOT TYPE</div>
            <div class="field">
                <select name="slot_type">
                    <option {{ $slot->slot_type == "PS" ? 'selected="selected"' : '' }} value="PS">PAID SLOT</option>
                    <option {{ $slot->slot_type == "FS" ? 'selected="selected"' : '' }} value="FS">FREE SLOT</option>
                    <option {{ $slot->slot_type == "CD" ? 'selected="selected"' : '' }} value="CD">COMISSION DEDUCTABLE</option>
                </select>
            </div>
        </div>
        <div class="fieldset">
            <div class="label">AVAILABLE BALANCE</div>
            <div class="field"><input name="wallet" type="text" value="{{ $slot->slot_wallet }}"></div>
        </div>
        <div class="fieldset">
            <div class="label">UPGRADE POINTS</div>
            <div class="field"><input name="upgrade_points" type="text" value="{{ $slot->slot_upgrade_points }}"></div>
        </div>
        <div class="fieldset">
            <div class="label">BINARY POINTS LEFT</div>
            <div class="field"><input name="binary_left" type="text" value="{{ $slot->slot_binary_left }}"></div>
        </div>
        <div class="fieldset">
            <div class="label">BINARY POINTS RIGHT</div>
            <div class="field"><input name="binary_right" type="text" value="{{ $slot->slot_binary_right }}"></div>
        </div>
        <div class="fieldset">
            <div class="label">PERSONAL PV</div>
            <div class="field"><input name="personal_pv" type="text" value="{{ $slot->slot_personal_points }}"></div>
        </div>
        <div class="fieldset">
            <div class="label">GROUP PV</div>
            <div class="field"><input name="group_pv" type="text" value="{{ $slot->slot_group_points }}"></div>
        </div>
        <div class="fieldset">
            <div class="label">TOTAL EARNINGS</div>
            <div class="field"><input name="total_earning" type="text" value="{{ $slot->slot_total_earning }}"></div>
        </div>
        <div class="fieldset">
            <div class="label">TOTAL WITHRAWAL</div>
            <div class="field"><input name="total_withrawal" type="text" value="{{ $slot->slot_total_withrawal }}"></div>
        </div>
        <button>UPDATE SLOT</button>
    </form>
<div>
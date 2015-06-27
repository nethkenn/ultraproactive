<div class="form">
    <form class="submit-add-save" method="post">
        <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">
        <div class="fieldset">
            <div class="label">SLOT OWNER</div>
            <div class="field">
                <select class="slot_owner_change" name="account_id">
                    <option value="0">NEW ACCOUNT</option>
                    @foreach($_account as $account)
                    <option value="{{ $account->account_id }}">{{ $account->account_name }} ({{ $account->account_username }})</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="fieldset">
            <div class="label">SLOT NUMBER</div>
            <div class="field"><input name="slot_number" type="text" value="{{ $slot_number }}"></div>
        </div>
        <div class="account-info">
            <div class="fieldset">
                <div class="label">FULL NAME</div>
                <div class="field"><input name="name" type="text" value=""></div>
            </div>
            <div class="fieldset">
                <div class="label">COUNTRY</div>
                <div class="field">
                    <select name="country">
                        @foreach($_country as $country)
                        <option value="{{ $country->country_id }}">{{ $country->country_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="fieldset">
                <div class="label">USERNAME</div>
                <div class="field"><input autocomplete="off" name="un" type="text" value=" "></div>
            </div>
            <div class="fieldset">
                <div class="label">PASSWORD</div>
                <div class="field"><input name="pw" type="password" value=""></div>
            </div>
        </div>
        <div class="fieldset">
            <div class="label">SPONSOR</div>
            <div class="field"><input name="sponsor" type="text" value="{{ $placement }}"></div>
        </div>
        <div class="fieldset">
            <div class="label">PLACEMENT</div>
            <div class="field"><input name="placement" type="text" value="{{ $placement }}"></div>
        </div>
        <div class="fieldset">
            <div class="label">POSITION</div>
            <div class="field">
                <select name="slot_position">
                    <option {{ ($position == "left" ? "selected='selected'" : "") }}>LEFT</option>
                    <option {{ ($position == "right" ? "selected='selected'" : "") }}>RIGHT</option>
                </select>
            </div>
        </div>
        <div class="fieldset">
            <div class="label">MEMBERSHIP</div>
            <div class="field">
                <select name="slot_membership">
                    @foreach($_membership as $memberhsip)
                    <option value="{{ $memberhsip->membership_id }}">{{ $memberhsip->membership_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="fieldset">
            <div class="label">RANK</div>
            <div class="field">
                <select name="rank">
                    @foreach($_rank as $rank)
                    <option value="{{ $memberhsip->rank_id }}">{{ $rank->rank_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="fieldset">
            <div class="label">SLOT TYPE</div>
            <div class="field">
                <select name="slot_type">
                    <option value="PS">PAID SLOT</option>
                    <option value="FS">FREE SLOT</option>
                    <option value="CD">COMISSION DEDUCTABLE</option>
                </select>
            </div>
        </div>
        <div class="fieldset">
            <div class="label">AVAILABLE BALANCE</div>
            <div class="field"><input name="wallet" type="text" value="0"></div>
        </div>
        <div class="fieldset">
            <div class="label">UPGRADE POINTS</div>
            <div class="field"><input name="upgrade_points" type="text" value="0"></div>
        </div>
        <div class="fieldset">
            <div class="label">BINARY POINTS LEFT</div>
            <div class="field"><input name="binary_left" type="text" value="0"></div>
        </div>
        <div class="fieldset">
            <div class="label">BINARY POINTS RIGHT</div>
            <div class="field"><input name="binary_right" type="text" value="0"></div>
        </div>
        <div class="fieldset">
            <div class="label">PERSONAL PV</div>
            <div class="field"><input name="personal_pv" type="text" value="0"></div>
        </div>
        <div class="fieldset">
            <div class="label">GROUP PV</div>
            <div class="field"><input name="group_pv" type="text" value="0"></div>
        </div>
        <div class="fieldset">
            <div class="label">TOTAL EARNINGS</div>
            <div class="field"><input name="total_earning" type="text" value="0"></div>
        </div>
        <div class="fieldset">
            <div class="label">TOTAL WITHRAWAL</div>
            <div class="field"><input name="total_withrawal" type="text" value="0"></div>
        </div>
        <button>CREATE SLOT</button>
    </form>
<div>
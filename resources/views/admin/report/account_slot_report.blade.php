    <style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td {
        padding: 5px;
        text-align: left;
    }
    </style>
    <table id="table" class="table table-bordered">
        <tr>
            <th>
                Slot
            </th>
            <th>
                Owner
            </th>
            <th>
                Placement
            </th>
            <th>
                Position
            </th>
            <th>
                Sponsor
            </th>
            <th>
                Type
            </th>
            <th>
                Wallet
            </th>
            <th>
                GC
            </th>
            <th>
                P UP
            </th>
            <th>
                G UP
            </th>
            <th>
                Rank
            </th>
        </tr>
        @foreach($_slot as $slot)
            <tr>
                <th>
                    {{$slot->slot_id}}
                </th>
                <th>
                    {{$slot->account_name}}
                </th>
                <th>
                    {{App\Tbl_slot::id($slot->slot_placement)->account()->first() == null ? "---" : "Slot #".App\Tbl_slot::id($slot->slot_placement)->account()->first()->slot_id."(".App\Tbl_slot::id($slot->slot_placement)->account()->first()->account_name.")"}}
                </th>
                <th>
                    {{$slot->slot_position}}
                </th>
                <th>
                    {{App\Tbl_slot::id($slot->slot_sponsor)->account()->first() == null ? "---" : "Slot #".App\Tbl_slot::id($slot->slot_sponsor)->account()->first()->slot_id."(".App\Tbl_slot::id($slot->slot_sponsor)->account()->first()->account_name.")"}}
                </th>
                <th>
                    {{$slot->slot_type}}
                </th>
                <th>
                    {{App\Tbl_wallet_logs::id($slot->slot_id)->wallet()->sum("wallet_amount") == null ? "0" : App\Tbl_wallet_logs::id($slot->slot_id)->wallet()->sum("wallet_amount") }}
                </th>
                <th>
                    {{App\Tbl_wallet_logs::id($slot->slot_id)->GC()->sum("wallet_amount") == null ? "0" : App\Tbl_wallet_logs::id($slot->slot_id)->GC()->sum("wallet_amount")}}
                </th>
                <th>
                    {{App\Tbl_pv_logs::where("owner_slot_id",$slot->slot_id)->where("used_for_redeem",0)->where("type","PPV")->sum("amount") != 0 && $slot->slot_type != "CD" ? App\Tbl_pv_logs::where("owner_slot_id",$slot->slot_id)->where("used_for_redeem",0)->where("type","PPV")->sum("amount") : 0}}
                </th>
                <th>
                    {{App\Classes\Compute::count_gpv($slot->slot_id)}}
                </th>
                <th>
                    {{App\Tbl_compensation_rank::where("compensation_rank_id",$slot->permanent_rank_id)->first()->compensation_rank_name}}
                </th>
            </tr>
        @endforeach   
    </table>
    


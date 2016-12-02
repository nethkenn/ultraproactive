@extends('member.layout')
@section('content')


<div class="header row">
    <div class="title col-md-8">
        <h2><i class="fa fa-table"></i> Genealogy List </h2>
    </div>
</div>
    
<div class="form-container">
            <table id="table" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th class="text-center">Lvl</th>
                        <th class="text-center">Name</th>   
                        <th class="text-center">Slot</th>   
                        <th class="text-center">Group</th>   
                        <th class="text-center">Status</th>   
                        <th class="text-center">Personal UPcoins</th>   
                        <th class="text-center">Genealogy</th>   
                    </tr>
                </thead>
                <tbody>
                    @foreach($_tree as $tree)
                        <tr>
                            <td>{{$tree->placement_tree_level}}</td>
                            <td>{{$tree->account_name}}</td>
                            <td>{{$tree->slot_id}}</td>
                            <td>{{strtoupper($tree->placement_tree_position)}}</td>
                            <td>{{$tree->slot_type}}</td>
                            <td>{{number_format(DB::table("tbl_pv_logs")->where("owner_slot_id",$tree->slot_id)->where("used_for_redeem",0)->where("type","PPV")->sum("amount"),2)}}</td>
                            <td><a href="/member/genealogy/tree?mode=binary&view_id={{$tree->slot_id}}">Genealogy</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
</div>

@endsection

@section('script')

@endsection
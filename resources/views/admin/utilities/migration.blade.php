@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-users"></i>  Migration</h2>
        </div>
        <div class="buttons col-md-4 text-right">
             <button type="button" class="btn btn-primary start-migration"><i class="fa fa-refresh"></i> START MIGRATION</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container" style="overflow: hidden;">
        <form id="country-add-form" class="form-horizontal" action="" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">

                <label for="inputEmail3" class="col-sm-2 control-label">Hack Sheet Count</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="admin_position_name" value="{{ $hack_count }}" required>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Number of Slots</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="level" name="admin_position_rank" value="{{ $slot_count }}" required>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Slots with Hack Reference</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="level" name="admin_position_rank" value="{{ $slot_hack_count }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Migration Status</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control status" id="level" name="admin_position_rank" value="waiting" required>
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Migration Count</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control count-migrate" id="level" name="admin_position_rank" value="0" required>
                </div>
            </div>        
        </form>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    var tbl_hack;
    var ctr = 0;

    $(".start-migration").click(function()
    {
        $(".status").val("Getting Ready!");

        $.ajax(
        {
            url:"admin/migration/start",
            dataType:"json",
            data:"",
            type:"post",
            success: function(data)
            {
                tbl_hack = data;
                migrate(tbl_hack[ctr].hack_id);
                $(".status").val("Initializing");
            }
        });
    });

    function migrate($hack_id)
    {
        ctr++;

        $.ajax(
        {
            url:"admin/migration/hack",
            dataType:"json",
            data:{hack_id:$hack_id},
            type:"get",
            success: function(data)
            {
                if(tbl_hack[ctr])
                {
                    migrate(tbl_hack[ctr].hack_id);    
                    $(".status").val("Migration - " + tbl_hack[ctr].full_name);   
                    $(".count-migrate").val(ctr);   
                }
                else
                {
                    $(".status").val("Done!");
                }
            }
        });
    }
</script>
@endsection
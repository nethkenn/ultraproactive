@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-users"></i>  Migration</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button type="button" class="btn btn-primary start-rematrix"><i class="fa fa-refresh"></i> REMATRIX</button>
            <button type="button" class="btn btn-primary start-migration"><i class="fa fa-refresh"></i> MIGRATION</button>
            <button type="button" class="btn btn-primary start-recompute"><i class="fa fa-refresh"></i> RECOMPUTE</button>
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
    var tbl_slot;
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
                migrate(tbl_hack[ctr].id_code);
                $(".status").val("Initializing");
            }
        });
    });


    function migrate($hack_id)
    {
        $.ajax(
        {
            url:"admin/migration/hack",
            dataType:"json",
            data:{hack_id:$hack_id},
            type:"get",
            success: function(data)
            {
                ctr++;
                if(tbl_hack[ctr])
                {
                    migrate(tbl_hack[ctr].id_code);    
                    $(".status").val("Migration - " + tbl_hack[ctr].username);   
                    $(".count-migrate").val(ctr);   
                }
                else
                {
                    $(".status").val("Done!");
                }
            },
            error: function()
            {
                ctr++;
                migrate(tbl_hack[ctr].id_code);    
                $(".status").val("Migration - " + tbl_hack[ctr].username);   
                $(".count-migrate").val(ctr);   
            }
        });
    }


        $(".start-rematrix").click(function()
    {
        $(".status").val("Getting Ready!");

        $.ajax(
        {
            url:"admin/migration/start_rematrix",
            dataType:"json",
            data:"",
            type:"post",
            success: function(data)
            {
                tbl_slot = data;
                rematrix(tbl_slot[ctr].slot_id);
                $(".status").val("Initializing");
            }
        });
    });

    // $(".start-recompute").click(function()
    // {
    //     $(".status").val("Getting Ready!");

    //     $.ajax(
    //     {
    //         url:"admin/migration/start_recompute",
    //         dataType:"json",
    //         data:"",
    //         type:"post",
    //         success: function(data)
    //         {
    //             tbl_slot = data;
    //             recompute(tbl_slot[ctr].slot_id);
    //             $(".status").val("Initializing");
    //         }
    //     });
    // });

    // function recompute($slot_id)
    // {
    //     $.ajax(
    //     {
    //         url:"admin/migration/recompute",
    //         dataType:"json",
    //         data:{slot_id:$slot_id},
    //         type:"get",
    //         success: function(data)
    //         {
    //             ctr++;
    //             if(tbl_slot[ctr])
    //             {
    //                 recompute(tbl_slot[ctr].slot_id);    
    //                 $(".status").val("Recompute - " + tbl_slot[ctr].slot_id);   
    //                 $(".count-migrate").val(ctr);   
    //             }
    //             else
    //             {
    //                 $(".status").val("Done!");
    //             }
    //         },
    //         error: function()
    //         {
    //         }
    //     });
    // }

    function rematrix($slot_id)
    {
        $.ajax(
        {
            url:"admin/migration/rematrix",
            dataType:"json",
            data:{slot_id:$slot_id},
            type:"get",
            success: function(data)
            {
                ctr++;
                if(tbl_slot[ctr])
                {
                    rematrix(tbl_slot[ctr].slot_id);    
                    $(".status").val("Rematrix - " + tbl_slot[ctr].slot_id);   
                    $(".count-migrate").val(ctr);   
                }
                else
                {
                    $(".status").val("Done!");
                }
            },
            error: function()
            {  
            }
        });
    }
</script>
@endsection
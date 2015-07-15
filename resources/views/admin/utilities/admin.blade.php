@extends('admin.layout')
@section('content')
	Under Development (Admin)
    <div class="row">
        <div class="header">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="title col-md-8">
                <h2><i class="fa fa-users"></i> ADMINISTRATORS</h2>
            </div>
            <div class="buttons col-md-4 text-right">
                <button onclick="location.href='admin/utilities/admin_maintenance/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i>Add New Administrator</button>
            </div>
        </div>
        <div class="filters ">
        </div>
    </div>
    <div class="filters ">
        <div class="col-md-8">
        </div>
    </div>
    <div class="col-md-12">
        <table id="table" class="table table-bordered">
            <thead>
            <tr class="text-center">
                <th>Admin ID</th>
                <th>Account Name</th>
                <th>Email </th>
                <th>Position</th>
                <th>Admin Level</th>
                <th>Own Slot/s</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
$(function()
{
   var $adminTable = $('#table').DataTable({
        processing: true,
        serverSide: true,
         ajax:{
                url:'admin/utilities/admin_maintenance/data',
                data:{
                   }
            },
        columns: [
            { data: 'admin_id', name: 'admin_id' },
            { data: 'account_name', name: 'account_name' },
            { data: 'account_email', name: 'account_email' },
            { data: 'admin_position_name', name: 'admin_position_name' },
            { data: 'admin_position_rank', name: 'admin_position_rank' },
            { data: 'slot_count', name: 'slot_count' },
            { data: 'edit_delete', name: 'admin_id' },


        ],
        "lengthMenu": [[8, 10, 25, 50, -1], [10, 25, 50, "All"]],
        "oLanguage": 
            {
                "sSearch": "",
                "sProcessing": ""
            },
        stateSave: true,
    });


    $adminTable.on( 'draw.dt', function ()
    {
        // alert( 'Table redrawn' );

        $('.delete-admin').on('click' , function(event)
        {
            /* Act on the event */
            event.preventDefault();
            $admin_id = $(this).attr('admin-id');
            $_token = $('meta[name="_token"]').attr('content');
            // console.log($_token);
            // console.log($admin_id);

            $.ajax({
                url: 'admin/utilities/admin_maintenance/delete',
                type: 'post',
                dataType: 'json',
                data: {_token: $_token,
                    admin_id: $admin_id
                },
            })
            .done(function() {
                // console.log("success");
                $adminTable.draw();

            })
            .fail(function() {
                console.log("error");
                alert('Error deleting admin.');
                $adminTable.draw();
            })
            .always(function() {
                console.log("complete");
                $adminTable.draw();
            });
            
        });
    });





});
    </script>


@endsection
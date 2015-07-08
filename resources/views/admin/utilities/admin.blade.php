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
                <button onclick="location.href='admin/maintenance/accounts/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i>Add new Administrator</button>
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
                <th>Account id</th>
                <th>Admin position id</th>
            </tr>
            </thead>
        </table>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'admin/utilities/admin/data'
        });
    </script>


@endsection
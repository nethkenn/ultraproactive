@extends('admin.layout')
@section('content')
    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-users"></i>  Add Admin</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/utilities/position'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#admin-add-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container" style="overflow: hidden;">
        <form id="admin-add-form" class="form-horizontal" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-group col-md-12" >
                <label for="Member Name">Membr Name</label>
                @if ($errors->has('account_id')) 
                <div class="alert alert-danger col-md-12">
                    <ul>
                        @foreach ($errors->get('account_id') as $message)
                            <li>{{$message}}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <select class="form-control chosen-select" name="account_id" >

                    <option>Select Admin</option>
                    @if($_account)
                    @foreach ($_account as $element)
                        <option value="{{$element->account_id}}" {{Session::get('_old_input')['account_id'] == $element->account_id ? 'selected' : '' }} >{{$element->account_name}}</option>
                    @endforeach
                    @endif
                </select>
              </div>
            <div class="form-group col-md-12" >
                <label for="Position">Position</label>
                @if ($errors->has('admin_position_id')) 
                <div class="alert alert-danger col-md-12">
                    <ul>
                        @foreach ($errors->get('admin_position_id') as $message)
                            <li>{{$message}}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <select class="form-control chosen-select-2" name="admin_position_id">
                    <option>Select Position</option>
                    @if($_position)
                    @foreach ($_position as $element)
                        <option value="{{$element->admin_position_id}}" {{Session::get('_old_input')['admin_position_id'] == $element->admin_position_id ? 'selected' : ''}} >{{$element->admin_position_name}}</option>
                    @endforeach
                    @endif
                </select>
              </div>
        </form>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="resources/assets/chosen_v1.4.2/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href="resources/assets/chosen_v1.4.2/chosen.css">
    <script type="text/javascript">
        $(".chosen-select").chosen();
        $(".chosen-select-2").chosen();
    </script>
@endsection

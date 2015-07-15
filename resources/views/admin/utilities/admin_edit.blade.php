@extends('admin.layout')
@section('content')

    <div class="row header">
        <div class="title col-md-8">
            <h2><i class="fa fa-users"></i>  Edit Admin</h2>
        </div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/utilities/position'" type="button" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back</button>
            <button onclick="$('#admin-edit-form').submit();" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
        </div>
    </div>
    <div class="col-md-12 form-group-container" style="overflow: hidden;">
        <form id="admin-edit-form" class="form-horizontal" method="post">
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
                <select class="form-control" name="account_id" disabled>
                    <option>Select Admin</option>
                    @if($_account)
                    @foreach ($_account as $element)
                        <option value="{{$element->account_id}}" {{$selected = $_admin->account_id == $element->account_id ? 'selected="selected"' : ''}}>{{$element->account_name}}</option>
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
                <select class="form-control" name="admin_position_id">
                    <option>Select Position</option>
                    @if($_position)
                    @foreach ($_position as $element)
                        <option value="{{$element->admin_position_id}}" {{$selected = $_admin->admin_position_id == $element->admin_position_id ? 'selected="selected"' : ''}}>{{$element->admin_position_name}}</option>
                    @endforeach
                    @endif
                </select>
              </div>
        </form>
    </div>
@endsection
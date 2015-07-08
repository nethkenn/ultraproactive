@extends('admin.layout')
@section('content')
This is the dashboard.
    <form method="post">
        <fieldset>
            <legend>Admin Login</legend>
            Username: <input type = 'text'name='username'> <br>
            Password: <input type = 'password'name='password'> <br>
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <input type ='submit'value='login'>
        </fieldset>
    </form>
@endsection
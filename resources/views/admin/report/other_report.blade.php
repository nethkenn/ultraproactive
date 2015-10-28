@extends('admin.layout')
@section('content')
  <div class="row">
    <div class="header">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="title col-md-8">
        <h2><i class="fa fa-users"></i> {{$title}}</h2>
      </div>
    </div>
    <div class="filters "></div>
  </div>
    </div>
  <form method="POST" form action="admin/maintenance/accounts" target="_blank">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="col-md-12">
      <table id="table" class="table table-bordered">
        <thead>
          <tr class="text-center">
            <th>Slot Id</th>      
            <th>Slot Owner</th>
            <th>Wallet from Old System</th>
            <th>Sponsor</th>
            <th>Match</th>
            <th>Mentors</th>
            <th>Bonus from Dynamic Compression</th>
            <th>Total Earned</th>
            <th>Total Encashed</th>          
            <th>Total Wallet</th>
          </tr>
        </thead>
      </table>
  </div>
  </form>
@endsection

@section('script')
<script type="text/javascript">
$(function() {
   $accountTable = $('#table').DataTable({
        processing: true,
        serverSide: true,
         ajax:{
            url:'admin/reports/bonus_summary/get',
            data:{
                archived : "{{$archived = Request::input('archived') ? 1 : 0 }}"
               }
        },
        columns: [
            {data: 'slot_id', name: 'slot_id'},
            {data: 'account_name', name: 'account_name'},
            {data: 'old', name: 'old'},
            {data: 'sponsor', name: 'sponsor'},
            {data: 'matching', name: 'sponsor'},
            {data: 'mentor', name: 'mentor'},
            {data: 'dynamic', name: 'dynamic'},
            {data: 'subtotal', name: 'subtotal'},
            {data: 'encash', name: 'encash'},
            {data: 'total', name: 'total'},
        ],
        "lengthMenu": [[8, 10, 25, 50, -1], [10, 25, 50, "All"]],
        "oLanguage": 
          {
            "sSearch": "",
            "sProcessing": ""
          },
        stateSave: true,
    });
});
</script>


@endsection
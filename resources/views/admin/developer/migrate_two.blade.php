@extends('admin.layout')
@section('content')

<div class="row">
    <div class="header">
        <div class="col-md-8">
            <h2><i class="fa fa-exchange"></i> Migrate to 2.0 MLM </h2>
        </div>
        <div class="col-md-4">
            <h2><button type="button" class="btn btn-primary pull-right ready_migration">Ready Migration</button></h2>
        </div>
    </div> 
</div>

<div class="col-md-12 migrate_two">
    <div class="col-md-12 top-part">
            <h1><span class="out_of">0</span> out of {{$total_slot}}</h1>
    </div>
    <div class="col-md-12 middle-part with_loaders" style="display:none;">
            <div class="col-md-2">
                <div class="lds-facebook"><div></div><div></div><div></div></div>
            </div>
            <div class="col-md-8">
                <h2>Status: Migrating...</h2>
            </div>
            <div class="col-md-2">
                <div class="lds-facebook"><div></div><div></div><div></div></div>
            </div>
    </div>
    <div class="col-md-12 middle-part with_no_loaders">
            <div class="col-md-2">

            </div>
            <div class="col-md-8">
                <h2>Status: Ready to process</h2>
            </div>
            <div class="col-md-2">

            </div>
    </div>
    <div class="col-md-12 bottom-part">
        <table class="table">
              <thead>
                    <tr>
                      <th>#</th>
                      <th>Slot No</th> 
                      <th>Owner</th>
                      <th>Email</th>
                    </tr>
             </thead>

             <tbody class="to_append_this"> 

             </tbody>
        </table>
    </div>
</div>


<div class="remodal create-slot" data-remodal-id="migrate_two">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        <img src="/resources/assets/frontend/img/icon-plis.png">
        Migrate Confirmation
        <h2><button type="button" class="btn btn-primary start_migration">Start Migration</button></h2>
    </div>
    <!-- <img src="/resources/assets/frontend/img/sobranglupet.png" style="max-width: 100%; margin: 20px auto"> -->
    <div class="col-md-12 para">

    </div>
</div>
@endsection

@section('script')
  <script type="text/javascript">
      var migrate_two = new migrate_two();
      var ctr         = 1;
      function migrate_two()
      {
          init();
          function init()
          {
              $(document).ready(function()
              {
                  $(".ready_migration").click(function()
                  {
                      var inst = $('[data-remodal-id=migrate_two]').remodal();
                      inst.open(); 
                  });
                  $(".start_migration").click(function()
                  {
                      var inst = $('[data-remodal-id=migrate_two]').remodal();
                      inst.close(); 

                      $(".with_loaders").show();
                      $(".with_no_loaders").hide();

                      $(".ready_migration").attr("disabled", true);

                      get_slot();
                  });
              });
          }

          function get_slot()
          {   
              $.ajax(
              {
                  url: "admin/developer/migrate_get_next_slot",
                  type: "post",
                  dataType : "json",
                  success: function( data ) 
                  {

                    if(data.count != 0)
                    {
                        var str =      "<tr>";
                            str = str +   "<td>"+ctr+"</td>";
                            str = str +   "<td>"+data.slot.slot_id+"</td> ";
                            str = str +   "<td>"+data.slot.account_name+"</td> ";
                            str = str +   "<td>"+data.slot.account_email+"</td> ";
                            str = str +"</tr>";

                            $(".to_append_this").prepend(str);
                            $(".out_of").text(ctr);

                            process_slot(data.slot.slot_id);

                            ctr++;
                    }
                    else
                    {
                        alert("SUCCESS");
                        $(".with_loaders").hide();
                        $(".with_no_loaders").show();
                    }

                  },
                  error: function( xhr, status, errorThrown ) 
                  {
                    get_slot();
                  }
              });

              // $(".forhistory").click(function()
              // {
              //     var inst = $('[data-remodal-id=encashment_history]').remodal();
              //     inst.open(); 
              // });
          }


          function process_slot(slot_id)
          {  
              $.ajax(
              {
                  url: "admin/developer/migrate_two_process",
                  type: "post",
                  data: 
                  {
                      slot_id: slot_id
                  },
                  dataType : "json",
                  success: function( data ) 
                  {
                    if(data == "success")
                    {
                      get_slot();
                    }
                    else
                    {
                      alert("Something went wrong..");
                    }
                  },
                  error: function( xhr, status, errorThrown ) 
                  {
                    process_slot(slot_id);
                  }
              });
          }
      }

  </script>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/encashment.css">
<style type="text/css">
    .migrate_two
    {
        background-color: white;
        min-height: 500px;
        padding-left:30px;
        padding-right:30px;
    }

    .top-part
    {
        padding-top:20px;
        border-bottom: 1px solid;
        min-height: 100px;
        text-align: center;
    }

    .middle-part
    {
        padding-top:20px;
        border-bottom: 1px solid;
        min-height: 50px;
        text-align: center;
    }

    .bottom-part
    {
        margin-top:150px;
    }

    .lds-facebook {
      display: inline-block;
      position: relative;
      width: 64px;
      height: 64px;
    }
    .lds-facebook div {
      display: inline-block;
      position: absolute;
      left: 6px;
      width: 13px;
      background: black;
      animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
    }
    .lds-facebook div:nth-child(1) {
      left: 6px;
      animation-delay: -0.24s;
    }
    .lds-facebook div:nth-child(2) {
      left: 26px;
      animation-delay: -0.12s;
    }
    .lds-facebook div:nth-child(3) {
      left: 45px;
      animation-delay: 0;
    }
    @keyframes lds-facebook {
      0% {
        top: 6px;
        height: 51px;
      }
      50%, 100% {
        top: 19px;
        height: 26px;
      }
    }


</style>
@endsection
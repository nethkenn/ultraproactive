var order = new order();
var order_id;
var current_info;
var measure;

function order()
{
   init();
   function init()
   {
      $(document).ready(function()
      {
         document_ready();

      });
   }
   function document_ready()
   {
      show_modal_on_click();
      single_show_modal_on_click();
      selectall();
   }
   function show_modal_on_click()
   {  
      $(".bulk").bind("click", function(e)
      {
        $('.bulkcontainers').empty();



                $('#test input:checked').each(function() 
                {
                      var opt="";
                      var checkid = $(this).attr('numb');

                                
                                  var str =   '<tr>'+ '<td class="text-center">'+$(this).attr('ingname')+'<input type="hidden" name="ingrid[]" value='+$(this).attr('ids')+'>'+'</td>'+
                                   ' <td class="text-center">'+$(this).attr('amount')+'</td>'+
                                   '<td class="text-center"><input type="" name="amt[]" required="required"></td>'+
                                   '</tr>';

                                    $('.bulkcontainers').append(str); 
                               
                   
                });
            var inst = $('[data-remodal-id=bulk]').remodal();
            inst.open();   

      });
   }


   function single_show_modal_on_click()
   {  
      $(".adjustlink").bind("click", function(e)
      {
         $('.singleunitcontainer').empty();
         $('.kontainer').empty();
         $('#singlename').val("");
         $('#reason').val("");

         var opt="";
         var checkid = $(this).attr('numb');

                              
                    var str = '<input type="hidden" name="ingrid" value='+$(this).attr('ids')+'>';
                                


                    $('.singleunitcontainer').append(opt);
                    $('.kontainer').append(str);

           var inst = $('[data-remodal-id=single]').remodal();
            inst.open(); 

      });
   }




   function selectall()
   {
    $('#allcheck').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
   }


   



}
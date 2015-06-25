var product_view = new product_view()
function product_view()
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
        initialize_data_table();
        initialize_fancy_box();
        add_feature_click_event();
        add_event_active_product();
        add_data_table_search();
        add_event_delete_product();
    }
    function add_data_table_search()
    {
        $(".input-sm").attr("placeholder", "Search");
    }
    function initialize_data_table()
    {
        oTable = $('#data-table').DataTable(
        {
            "lengthMenu": [[8, 10, 25, 50, -1], [10, 25, 50, "All"]],
            "oLanguage": { "sSearch": "" },
            stateSave: true
        });
        
        $(".data-table").on( 'draw.dt', function ()
        {
            setTimeout(function()
            {
                add_feature_click_event();
                add_event_active_product();
            });
        });   
    }
    function add_event_active_product()
    {
        $(".product-active").unbind("click");
        $(".product-active").bind("click", function(e)
        {
            $product_id = $(e.currentTarget).closest("tr").attr("product_id");
            if($(e.currentTarget).hasClass("active"))
            {
                $(e.currentTarget).removeClass("active");
                set_active($product_id, 0);
            }
            else
            {
                $(e.currentTarget).addClass("active");    
                set_active($product_id, 1);
            }
        });
    }
    function set_active($product_id, $value)
    {
        $.ajax(
        {
            url:"admin/product/set_active",
            dataType:"json",
            data:{ "product_id":$product_id, "value": $value, "_token": $(".token").val() },
            type:"post",
            success: function(data)
            {
            }
        })
    }
    function add_feature_click_event()
    {
        $(".featured").unbind("click");
        $(".featured").bind("click", function(e)
        {
            $product_id = $(e.currentTarget).closest("tr").attr("product_id");
            if($(e.currentTarget).hasClass("active"))
            {
                $(e.currentTarget).removeClass("active");
                set_featured($product_id, 0);
            }
            else
            {
                $(e.currentTarget).addClass("active");    
                set_featured($product_id, 1);
            }
        });
    }
    function set_featured($product_id, $value)
    {
        $.ajax(
        {
            url:"admin/product/set_featured",
            dataType:"json",
            data:{ "product_id":$product_id, "value": $value, "_token": $(".token").val() },
            type:"post",
            success: function(data)
            {
            }
        })
    }
    
    function initialize_fancy_box()
    {
        $('.fancybox').fancybox();   
    }


    function add_event_delete_product()
    {
        $('.prod-delete').on('click', function(e)
        {
            e.preventDefault();
            var $this = $(this);
            var $prod_id = $(this).attr('prod-id');
            var $token = $('input.token').val();
            var $archived = $(this).attr('archived-val');

            // alert($token);
             
            
            var $confirm = 'Are you sure to archive the product?';

            if($archived != 0 )
            {
                $confirm = 'Are you sure to retrieve the product?';
            }

            var r = confirm($confirm);
            // console.log('test: ' + r);
            if (r == false)
            {
                return false;
            }
               

                
            $.ajax(
            {
             
                
                url: "admin/archived_prod",
             
                
                data: {
                    prod_id: $prod_id,
                    archived: $archived,
                    _token: $token
                },
             
                
                type: "POST",
             
                
                dataType : "json",
             
                success: function( data )
                {
                    if(data==1)
                    {
                        $this.closest('tr').remove();
                    }
                    else
                    {
                        alert('Error archiving product!');

                    }
                },
             
                error: function( xhr, status, errorThrown )
                {
                    alert('Error archiving product!');
                },
                complete: function( xhr, status )
                {
                    
                }
            });

            
        });
    }
}




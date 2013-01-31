(function($){
    $('document').ready(function(){
        $('#newAuction').on('show', function(){

        })
        
        $('a[href="#newAuction"]').click(function(){
            $.ajax({
               url:'index.php',
               type:'POST',
               dataType:'json',
               data:{
                   r:'product/productinfo',
                   product_id:$(this).attr('product_id')
               },
               success:function(obj){
                   $('#newAuction form #intro_desc').text(obj.intro_desc);
                   $('#newAuction form #image').attr('src','images/thumb_bw/'+obj.name_image);
                   $('#newAuction form #product_id').val(obj.product_id);
                   $('#newAuction form #price').val(obj.current_price);
               },
               error:function(obj){
                   console.log(obj);
               }
            });
        });
        
        $('#save_auction').click(function(){
            var product_id = $('#newAuction form #product_id').val();
            var price = $('#newAuction form #price').val();
            
            $.ajax({
                url:'index.php',
                type:'POST',
                data:{
                    r:'user/newauction',
                    product_id:product_id,
                    price:price
                },
                success:function(obj){
                    console.log(obj);
                },
                error:function(obj){
                    console.log(obj);
                }
            });
        });
    });
})(jQuery)
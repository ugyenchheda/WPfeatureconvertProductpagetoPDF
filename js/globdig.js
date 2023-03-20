function product_favorite(product_id,add_rem, modal = '') {
jQuery('#gdfav_id'+product_id).html('<i class="fa fa-spinner"></i>');

//jQuery('#gdfav_id'+product_id+ 'button').html('<div.product-grid><button class="btn"><i class="fa fa-spinner"></i> Loading...</button></div>');


  jQuery.ajax({
    url  : woocommerce_params.ajax_url,
    type : 'post',
    dataType: "json",
    data : {
      action : 'productfav',
      post_id : product_id,
      add_rem : add_rem,
      modal : modal
    },
    success : function( response ) {
      if(jQuery('#gdfav_id'+product_id).length!==0){
        jQuery('#gdfav_id'+product_id).html(response.fragment);
        jQuery('span#favCount').html(response.count_wishlist);
      }else {
        jQuery('#gdfav_id').html(response.fragment);
        jQuery('span#favCount').html(response.count_wishlist);
      }
    }
  });
}


function favorite_remove(product_id) {
  jQuery.ajax({
    url  : woocommerce_params.ajax_url,
    type : 'post',
    dataType: "json",
    data : {
      action : 'favoriteremove',
      post_id : product_id,

    },
    success : function( response ) {
      //jQuery('#msg').show();
      //jQuery('#msg').html(response.message).fadeOut( 5000 );
      jQuery('#'+response.rid).hide( );
      jQuery('span#favCount').html(response.count_wishlist);
    }
  });
}


jQuery( function($) {
  /*$('#sortable').sortable({
    stop: function (event, ui) {
      var orderoptn = [];
      $("ul#sortable li").each(function() {
        orderoptn.push($(this).attr('product_id'))
      });


      // POST to server using $.post or $.ajax
      jQuery.ajax({
        url  : woocommerce_params.ajax_url,
        type : 'post',
        dataType: "json",
        data : {
          action : 'productfav_order',
          prod_id : orderoptn

        },
        success : function( response ) {
          //jQuery('#msg').show();
          //jQuery('#msg').html(response.message).fadeOut( 5000 );
        }
      });
    }
  });*/
} );

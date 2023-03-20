(function ($) {

  var site_url = palmer_obj.blog_url;
   $('.velg').each(function(){
    var placeholder = $(this).data('placeholder');
    $(this).select2( {
    placeholder: placeholder,
    allowClear: true,
  });
   });

   var minprice,maxprice;

  // Set option selected onchange
  $('.price_selection').change(function(){
    var value = $(this).val();
    if(value != ''){
    var arr = value.split('-');
    if(arr[0] == 'inntil'){
      minprice = '0';
      maxprice = arr[1];
    }else if(arr[0] == "over"){
      minprice = arr[1];
      maxprice = '99999';
    }else{
      minprice = arr[0];
      maxprice = arr[1];
    }
    $(this).closest('div.form-group').append('<input type="hidden" class="priceattr" name="min_price" value="'+minprice+'"/>');
    $(this).closest('div.form-group').append('<input type="hidden" class="priceattr" name="max_price" value="'+maxprice+'"/>');
   }else{
    $(this).closest('div.form-group').find('.priceattr').remove();
   }
  });
console.log(44);
   $('.cat_selection').change(function(){
       var cat_val = $(this).val();
       console.log(cat_val);
       $(this).closest('form').attr('action',site_url+cat_val);
  });




/*  $(".hvaskal").select2( {
    placeholder: "Hva skal spises ?",
    allowClear: true
  });

  $("#velgpris").select2( {
    placeholder: "Velg pris",
    allowClear: true
  });*/

})(jQuery);

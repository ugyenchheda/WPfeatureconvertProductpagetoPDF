jQuery(document).ready(function($) {
    var palmer_params = window.palmer_params;
    var site_url = palmer_params.blog_url;
    /* Search filter Start */
    $('.velg').each(function() {
        var placeholder = $(this).data('placeholder');
        $(this).select2({
            placeholder: placeholder,
            allowClear: true,
        });
    });

    var minprice, maxprice;

    // Set option selected onchange
    $('.price_selection').change(function() {
        var value = $(this).val();
        if (value != '') {
            var arr = value.split('-');
            if (arr[0] == 'inntil') {
                minprice = '0';
                maxprice = arr[1];
            } else if (arr[0] == "over") {
                minprice = arr[1];
                maxprice = '99999';
            } else {
                minprice = arr[0];
                maxprice = arr[1];
            }
            $(this).closest('div.form-group').append('<input type="hidden" class="priceattr" name="min_price" value="' + minprice + '"/>');
            $(this).closest('div.form-group').append('<input type="hidden" class="priceattr" name="max_price" value="' + maxprice + '"/>');
        } else {
            $(this).closest('div.form-group').find('.priceattr').remove();
        }
    });

    $('.cat_selection').change(function() {
        var cat_val = $(this).val();
        $(this).closest('form').attr('action', site_url + cat_val);
    });

    $('.filter_land').change(function() {
        var landvalue = $(this).val();
        if (landvalue != '') {
            $(this).closest('div.form-group').append('<input type="hidden" class="filterattr_land" name="filter_land" value="' + landvalue + '"/>');
        } else {
            $(this).closest('div.form-group').find('.filterattr_land').remove();
        }
    });

    $('.filter_passertil01').change(function() {
        var passertilvalue = $(this).val();
console.log(passertilvalue);
        if (passertilvalue != '') {
            $(this).closest('div.form-group').append('<input type="hidden" class="filter_passertil" name="filter_passertil01" value="' + passertilvalue + '"/>');
        } else {
            $(this).closest('div.form-group').find('.filter_passertil').remove();
        }
    });
    /* Search filter end */



    if ($("#home_banner_price").length > 0) {
        var home_banner_price = document.getElementById('home_banner_price');
        var min_price_range = parseInt(palmer_params.slider_price_min);
        var max_price_range = parseInt(palmer_params.slider_price_max) + 1;

        noUiSlider.create(home_banner_price, {
            start: [min_price_range, max_price_range],
            connect: true,
            range: {
                min: min_price_range,
                max: max_price_range
            }
        });

        home_banner_price.noUiSlider.on('change.one', function() {
            filter_results('filter');
        });

        home_banner_price.noUiSlider.on('update', function(values, handle) {
            values[handle] = parseInt(values[handle]);
            if (handle) {
                $('.banner_max_price').html('Kr ' + values[handle]);
            } else {
                $('.banner_min_price').html('Kr ' + values[handle]);
            }
        });

    }

    $('.view-more').on("click", function() {
        var p_id = $(this).attr('rel');
        $('.pop-' + p_id).addClass('visible');

    });

    $('.pop_close').on("click", function() {
        $('.pop_wrap').removeClass('visible');
        $('.bg_wrap').hide();
    });

    $('#owl-demo').owlCarousel({
        navigation: false, // Show next and prev buttons
        slideSpeed: 300,
        paginationSpeed: 400,
        items: 1,
        singleItem: true,
    });

    // Last mer 
    $('.btn_palmer_load_more').on("click", function() {
        filter_results('load_more');
    });

    /* Product Filter
    ----------------------------  */
    $('#filter_product_cat').on("change", function() {
        $('#t_id').val($(this).val());
        filter_results('filter');
    });

    $('#filter_country').on("change", function() {
        filter_results('filter');
    });

    $('#filter_volume').on("change", function() {
        filter_results('filter');
    });

    $('#filter_district').on("change", function() {
        filter_results('filter');
    });

    $('#filter_pris').on("change", function() {
        filter_results('filter');
    });

    $('.button-search').on("click", function() {
        filter_results('filter');
    });

    $('#filter_orderby').on("change", function() {
        filter_results('filter');
    });

    // Reset Search form 
    $('.reset_search_form').on("click", function() {
        $('#search_query').val('');

        $('#filter_product_cat').val('');
        $('#filter_volume').val('');
        $('#filter_country').val('');
        $('#filter_district').val('');

        $('#home_banner_price')[0].noUiSlider.set([palmer_params.slider_price_min, palmer_params.slider_price_max]);

        $("#filter_product_cat").trigger("chosen:updated");
        $("#filter_volume").trigger("chosen:updated");
        $("#filter_country").trigger("chosen:updated");
        $("#filter_pris").trigger("chosen:updated");
        $("#filter_district").trigger("chosen:updated");

        filter_results('filter');
    });


    // if(!$('body').hasClass('home')){
    //   filter_results('filter');
    // }


    function filter_results(opt_mode = 'filter') {
        var search_param = '';
        var land = getSearchParams('land');
        var category = getSearchParams('category');
        var passertil = getSearchParams('passer-til');
        var price = getSearchParams('price');
        var filter_volume = getSearchParams('volume');

        $('.btn_palmer_load_more').html('Laster...');
        $('.pre-loader').show();
        $('.btn_palmer_load_more').prop("disabled", true);

        if (opt_mode == 'filter') {
            $('#paged').val(2);
        }

        var posts_per_page = ($('#posts_per_page').length) ? $('#posts_per_page').val() : 6;
        var paged = ($('#paged').length) ? $('#paged').val() : 1;
        var taxonomy = ($('#taxonomy').length) ? $('#taxonomy').val() : '';


        var filter_district = ($('#filter_district').length) ? $('#filter_district').val() : '';
        var search_query = ($('#search_query').length) ? $('#search_query').val() : '';
        var filter_orderby = ($('#filter_orderby').length) ? $('#filter_orderby').val() : '';

        if (typeof filter_volume !== 'undefined' && filter_volume !== null && filter_volume != '') {
            var filter_volume = filter_volume;
        } else {
            var filter_volume = ($('#filter_volume').length) ? $('#filter_volume').val() : '';
        }

        if (typeof price !== 'undefined' && price !== null && price != '') {
            var filter_pris = price.replace('Kr ', '');
        } else {
            var banner_min_price = $('.banner_min_price').html();
            banner_min_price = banner_min_price.replace('Kr ', '');
            var banner_max_price = $('.banner_max_price').html();
            banner_max_price = banner_max_price.replace('Kr ', '');
            var filter_pris = banner_min_price + '-' + banner_max_price;
        }

        if (typeof land !== 'undefined' && land !== null && land != '') {
            var filter_country = land;
        } else {
            var filter_country = ($('#filter_country').length) ? $('#filter_country').val() : '';
        }
        if (typeof filter_country !== 'undefined' && filter_country !== null && filter_country != '') {
            search_param = search_param + '&land=' + filter_country;
        }

        if (typeof category !== 'undefined' && category !== null && category != '') {
            var t_id = category;
        } else {
            var t_id = ($('#t_id').length) ? $('#t_id').val() : ''; //category
        }
        if (typeof t_id !== 'undefined' && t_id !== null && t_id != '') {
            search_param = search_param + '&category=' + t_id;
        }

        if (typeof passertil !== 'undefined' && passertil !== null && passertil != '') {
            var passertil = passertil;
        } else {
            var passertil = '';
        }
        if (typeof passertil !== 'undefined' && passertil !== null && passertil != '') {
            search_param = search_param + '&passer-til=' + passertil;
        }

        if (typeof filter_pris !== 'undefined' && filter_pris !== null && filter_pris != '') {
            search_param = search_param + '&price=' + filter_pris;
        }

        if (typeof filter_volume !== 'undefined' && filter_volume !== null && filter_volume != '') {
            search_param = search_param + '&volume=' + filter_volume;
        }

        if (typeof filter_district !== 'undefined' && filter_district !== null && filter_district != '') {
            search_param = search_param + '&district=' + filter_district;
        }
        // Add Push state to update url in browser      
        window.history.pushState("object or string", palmer_params.site_name, palmer_params.search_url + '?' + search_param);

        // ajax
        $.ajax({
            type: "POST",
            dataType: "json",
            url: palmer_params.admin_ajax_url,
            data: {
                'action': 'palmer_filter_product',
                'posts_per_page': posts_per_page,
                'taxonomy': taxonomy,
                't_id': t_id,
                'paged': paged,
                'opt_mode': opt_mode,
                'passertil': passertil,
                'filter_country': filter_country,
                'filter_volume': filter_volume,
                'filter_district': filter_district,
                'search_query': search_query,
                'filter_pris': filter_pris,
                'filter_orderby': filter_orderby,

            },
            success: function(data) {
                if (opt_mode == 'load_more') {

                    if (data.content == '') {
                        $('.btn_palmer_load_more').html('Ikke mer produkt');
                    } else {
                        $('.palmer_product_wrapper').append(data.content);
                        $('#paged').val(parseInt(paged) + 1);
                        $('.btn_palmer_load_more').html('Last mer Produkter');
                    }

                } else {

                    if (data.content == '') {
                        $('.palmer_product_wrapper').empty();
                    } else {
                        $('.palmer_product_wrapper').html(data.content);
                    }

                    $('#paged').val('2');
                    $('.btn_palmer_load_more').html('Last mer Produkter');
                    $('.total_record').html(data.total_record);

                }

                $('.btn_palmer_load_more').prop("disabled", false);
                $('.pre-loader').hide();
                return false;
            }
        });
        return false;


    }

    function getSearchParams(k) {
        var p = {};
        location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(s, k, v) { p[k] = v })
        return k ? p[k] : p;
    }

    $('#filter_product_cat').chosen();
    $('#filter_volume').chosen();
    $('#filter_country').chosen();
    $('#filter_district').chosen();
    $('#price_range').chosen();
    $('#filter_product').chosen();
    $('#filter_pris').chosen();

    /* Wishlist ajax */
    $(document).on("click", ".basel-wishlist-btn a.button", function(e) {
        var product_id = $(this).data('product-id');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: palmer_params.admin_ajax_url,
            data: {
                'action': 'save_wishlist',
                'product_id': product_id,
            },
            success: function(response) {
                console.log(response.status);

            }
        });
    });

    $(document).on("click", ".basel-remove-button-wrap a.basel-remove-button", function(e) {
        var product_id = $(this).data('product-id');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: palmer_params.admin_ajax_url,
            data: {
                'action': 'remove_wishlist',
                'product_id': product_id,
            },
            success: function(response) {
                console.log(response.message);

            }
        });
    });

    /* Events calendar */
    var start_date = $('.edac-date').data('from-date');
    var end_date = $('.edac-date').data('to-date');
    var language = $('.edac-date').data('language');
    var from_date = parseInt(start_date);
    var to_date = parseInt(end_date)-from_date;
    if($('.edac-dates').length > 0){
        var ids_s = $('.edac-dates').val();
        var ids_array = ids_s.split(',');
        var eventDates = {};
        for(var i=0; i<ids_array.length; i++){
            var date_array = ids_array[i];
            eventDates[ new Date( date_array )] = new Date( date_array );
        }
         var ids_s1 = $('.edac-dates-all').val();
         var ids_arr = ids_s1.split(',');
         var eventDates2 = [];
        for(var i=0; i<ids_arr.length; i++){
            var date_arr2 = ids_arr[i];
            eventDates2.push(date_arr2);
        }
        $.edacpicker.setDefaults( $.edacpicker.regional[ language ] );
        $('.edac-av-calendar').edacpicker({
           changeMonth: true,
           changeYear: true,
           inline: true,
           prevText: "Forrige",
           nextText: "Neste",
           beforeShowDay: function( date ) {
                var highlight = eventDates[date];
                if( highlight ) {
                     return [true, "event", highlight];
                } else {
                     return [true, '', ''];
                }
             },
            onChangeMonthYear: function(year, month, inst){
                call_ajax_calendar_by_monthyear(month,year);
            }
        },$.edacpicker.regional[ language ]);
      } 

    function call_ajax_calendar_by_monthyear(month,year){
             $('.event-list-wrapper').html('');
             $('#loadergif').show();
             $.ajax({
                type: "POST",
                dataType: "json",
                url: palmer_params.admin_ajax_url,
                data: {
                    'action': 'palmer_event_calendar_button',
                    'month': month,
                    'year': year,
                    'category': 'events',
                },
                success: function(resp) {
                  $('#loadergif').hide();
                  $('.event-list-wrapper').html(resp.html_data);
                    
                }
            });
      }
});

<?php
    // function palmer_land_tax() {

    //     $labels = array(
    //           'name'                       => _x( 'Land', 'method General Name', 'kystpiscus' ),
    //           'singular_name'              => _x( 'Land', 'method Singular Name', 'kystpiscus' ),
    //           'menu_name'                  => __( 'Land', 'kystpiscus' ),
    //           'all_items'                  => __( 'All Items', 'kystpiscus' ),
    //           'parent_item'                => __( 'Parent Land', 'kystpiscus' ),
    //           'parent_item_colon'          => __( 'Parent Land:', 'kystpiscus' ),
    //           'new_item_name'              => __( 'New Land Name', 'kystpiscus' ),
    //           'add_new_item'               => __( 'Add New Land', 'kystpiscus' ),
    //           'edit_item'                  => __( 'Edit Land', 'kystpiscus' ),
    //           'update_item'                => __( 'Update Land', 'kystpiscus' ),
    //           'view_item'                  => __( 'View Land', 'kystpiscus' ),
    //           'separate_items_with_commas' => __( 'Separate Land with commas', 'kystpiscus' ),
    //           'add_or_remove_items'        => __( 'Add or remove Land', 'kystpiscus' ),
    //           'choose_from_most_used'      => __( 'Choose from the most used', 'kystpiscus' ),
    //           'popular_items'              => __( 'Land', 'kystpiscus' ),
    //           'search_items'               => __( 'Search Land', 'kystpiscus' ),
    //           'not_found'                  => __( 'Not Found', 'kystpiscus' ),
    //           'no_terms'                   => __( 'No items', 'kystpiscus' ),
    //           'items_list'                 => __( 'Land list', 'kystpiscus' ),
    //           'items_list_navigation'      => __( 'Land list navigation', 'kystpiscus' ),
    //       );
      
    //     register_taxonomy('land', array( 'product' ), array(
    //       'hierarchical' => true,
    //       'labels' => $labels,
    //       'show_ui' => true,
    //       'public' => true,
    //       'show_admin_column' => true,
    //       'query_var' => true,
    //       'rewrite' => array( 'slug' => 'land' ),
    //     ));
      
      
    //   }
    //   add_action( 'init', 'palmer_land_tax' );


    //   function palmer_passer_til() {

    //     $labels = array(
    //           'name'                       => _x( 'Passer til', 'method General Name', 'kystpiscus' ),
    //           'singular_name'              => _x( 'Passer til', 'method Singular Name', 'kystpiscus' ),
    //           'menu_name'                  => __( 'Passer til', 'kystpiscus' ),
    //           'all_items'                  => __( 'All Items', 'kystpiscus' ),
    //           'parent_item'                => __( 'Parent Passer til', 'kystpiscus' ),
    //           'parent_item_colon'          => __( 'Parent Passer til:', 'kystpiscus' ),
    //           'new_item_name'              => __( 'New Passer til Name', 'kystpiscus' ),
    //           'add_new_item'               => __( 'Add New Passer til', 'kystpiscus' ),
    //           'edit_item'                  => __( 'Edit Passer til', 'kystpiscus' ),
    //           'update_item'                => __( 'Update Passer til', 'kystpiscus' ),
    //           'view_item'                  => __( 'View Passer til', 'kystpiscus' ),
    //           'separate_items_with_commas' => __( 'Separate Passer til with commas', 'kystpiscus' ),
    //           'add_or_remove_items'        => __( 'Add or remove Passer til', 'kystpiscus' ),
    //           'choose_from_most_used'      => __( 'Choose from the most used', 'kystpiscus' ),
    //           'popular_items'              => __( 'Passer til', 'kystpiscus' ),
    //           'search_items'               => __( 'Search Passer til', 'kystpiscus' ),
    //           'not_found'                  => __( 'Not Found', 'kystpiscus' ),
    //           'no_terms'                   => __( 'No items', 'kystpiscus' ),
    //           'items_list'                 => __( 'Passer til list', 'kystpiscus' ),
    //           'items_list_navigation'      => __( 'Passer til list navigation', 'kystpiscus' ),
    //       );
      
    //     register_taxonomy('Passertil', array( 'product' ), array(
    //       'hierarchical' => true,
    //       'labels' => $labels,
    //       'show_ui' => true,
    //       'public' => true,
    //       'show_admin_column' => true,
    //       'query_var' => true,
    //       'rewrite' => array( 'slug' => 'Passer_til' ),
    //     ));
      
      
    //   }
    //   add_action( 'init', 'palmer_passer_til' );


      function palmer_producer() {

        $labels = array(
              'name'                       => _x( 'Producer', 'method General Name', 'kystpiscus' ),
              'singular_name'              => _x( 'Producer', 'method Singular Name', 'kystpiscus' ),
              'menu_name'                  => __( 'Producer', 'kystpiscus' ),
              'all_items'                  => __( 'All Items', 'kystpiscus' ),
              'parent_item'                => __( 'Parent Producer', 'kystpiscus' ),
              'parent_item_colon'          => __( 'Parent Producer:', 'kystpiscus' ),
              'new_item_name'              => __( 'New Producer Name', 'kystpiscus' ),
              'add_new_item'               => __( 'Add New Producer', 'kystpiscus' ),
              'edit_item'                  => __( 'Edit Producer', 'kystpiscus' ),
              'update_item'                => __( 'Update Producer', 'kystpiscus' ),
              'view_item'                  => __( 'View Producer', 'kystpiscus' ),
              'separate_items_with_commas' => __( 'Separate Producer with commas', 'kystpiscus' ),
              'add_or_remove_items'        => __( 'Add or remove Producer', 'kystpiscus' ),
              'choose_from_most_used'      => __( 'Choose from the most used', 'kystpiscus' ),
              'popular_items'              => __( 'Producer', 'kystpiscus' ),
              'search_items'               => __( 'Search Producer', 'kystpiscus' ),
              'not_found'                  => __( 'Not Found', 'kystpiscus' ),
              'no_terms'                   => __( 'No items', 'kystpiscus' ),
              'items_list'                 => __( 'Producer list', 'kystpiscus' ),
              'items_list_navigation'      => __( 'Producer list navigation', 'kystpiscus' ),
          );
      
        register_taxonomy('producer', array( 'product' ), array(
          'hierarchical' => true,
          'labels' => $labels,
          'show_ui' => true,
          'public' => true,
          'show_admin_column' => true,
          'query_var' => true,
          'rewrite' => array( 'slug' => 'producer' ),
        ));
      
      
      }
      add_action( 'init', 'palmer_producer' );
?>
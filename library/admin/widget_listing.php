<?php
/**
 * Widget API: WP_Nav_Menu_Widget class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */
/**
 * Core class used to implement the Custom Menu widget.
 *
 * @since 3.0.0
 *
 * @see WP_Widget
 */
class My_Widget_Categories extends WP_Widget {

    function My_Widget_Categories() {
        $widget_ops = array( 'classname' => 'widget_categories', 'description' => __( "Display posts of event category by dato " ) );
        $this->WP_Widget('postcat_bydato', __('Event Posts Display By Dato'), $widget_ops);
    }

  /**
     * Outputs the content for the current Custom Menu widget instance.
     *
     * @since 3.0.0
     * @access public
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Custom Menu widget instance.
     */
    public function widget( $args, $instance ) {

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        echo $args['before_widget'];    

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number ) {
            $number = 5;
        }
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        /**
         * Filters the arguments for the Recent Posts widget.
         *
         * @since 3.4.0
         * @since 4.9.0 Added the `$instance` parameter.
         *
         * @see WP_Query::get_posts()
         *
         * @param array $args     An array of arguments used to retrieve the recent posts.
         * @param array $instance Array of settings for the current widget.
         */
        $r = new WP_Query(
            apply_filters(
                'widget_posts_args',
                array(
                    'posts_per_page'      => $number,
                    'no_found_rows'       => true,
                    'post_status'         => 'publish',
                    'ignore_sticky_posts' => true,
                    'cat'                 => $instance['cat'],
                    'meta_key'            => 'dato',
                    'orderby'             => 'meta_value',
                    'order' => 'ASC'
                    
                ),
                $instance
            )
        );

        if ( ! $r->have_posts() ) {
            return;
        }
        ?>      
        <div class="basel-recent-posts">
        <?php
        if ( !empty($instance['title']) ) {
            echo $args['before_title'] . $instance['title'] . $args['after_title'];
          }
    
        ?>
            <ul class="basel-recent-posts-list">
                <?php 
                /*echo "<pre>";
                print_r( $r->posts);*/
                foreach ( $r->posts as $recent_post ) : ?>
                    <?php
                    $post_title = get_the_title( $recent_post->ID );
                    $title      = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)' );
                    $feature_image = get_the_post_thumbnail($recent_post->ID, 'widget_size_thumbnail','', array( "class" => "img-fluid" ) );
                    ?>
                    <li> 
                        <div class="event-left-section">
                        <a class="recent-posts-thumbnail" href="<?php the_permalink($recent_post->ID); ?>" rel="bookmark"> 
                           <?php 
                           if (has_post_thumbnail($recent_post->ID)) {
                             echo $feature_image; 
                            } else {
                                echo '<img src="'. get_stylesheet_directory_uri(). '/assets/no_img.png'.'" />';
                            }   
                           ?>
                        </a>
                       </div>
                        <div class="event-right-section">
                            <h5 class="entry-title">
                                <a href="<?php the_permalink($recent_post->ID); ?>"><?php echo $title; ?></a>
                            </h5>
                            <time class="recent-posts-time">
                                <?php 
                                    $date_val = get_post_meta( $recent_post->ID, 'dato', true );
                                    // Check if the custom field has a value.
                                    if ( ! empty( $date_val ) ) {
                                        $date = new DateTime($date_val);
                                        echo $date->format('F j, Y');
                                    }
                                    ?></time>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Handles updating settings for the current Custom Menu widget instance.
     *
     * @since 3.0.0
     * @access public
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Updated settings to save.
     */
    public function update( $new_instance, $old_instance ) {

        $instance              = $old_instance;
        $instance['title']            = strip_tags( $new_instance['title'] );
        $instance['number']    = (int) $new_instance['number'];
        $instance['cat'] = strip_tags( $new_instance['cat'] );
        $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : '';

       
      return $instance;
    }

   /**
     * Outputs the settings form for the Custom Menu widget.
     *
     * @since 3.0.0
     * @access public
     *
     * @param array $instance Current settings.
     */
    public function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $cat       = isset( $instance['cat'] ) ? absint( $instance['cat'] ) : '';
       // $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
      
     ?>
     
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p>
            <select id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>" class="widefat" style="width:100%;">
                <option><?php _e( 'All Caterogies:' ); ?></option>
                <?php
                
                $args = array(          
                    'hide_empty' => true,            
                    'order' => 'DESC',
                    'parent' => 0       
                );
                    foreach(get_terms('category', $args) as $term) {
                        $selected = '';
                        if($cat == $term->term_id) {
                            $selected = 'selected';
                        }
                        echo "  <option value = '$term->term_id' $selected>". $term->name. "</option>";
                        $args = array(
                            'hide_empty' => true,
                            'parent' => $term->term_id,                                                              
                            'order' => 'DESC'
                        );
                        $child_terms = get_terms('category', $args );                                               
                        foreach ($child_terms as $child) {  
                            $selected = '';
                            if($cat == $child->term_id) {
                                $selected = 'selected';
                            }
                            echo  "  <option value = '$child->term_id' $selected>&nbsp; -  ".$child->name."</option>";
                            $args = array(
                                'hide_empty' => true,
                                'parent' => $child->term_id,                                                                      
                                'order' => 'DESC'
                    
                            );
                            $next_child = get_terms('category', $args); 
                            echo "<ul style='padding-left:10px'>";                          
                            foreach ($next_child as $next) {
                                $selected = '';
                                if($cat == $next->term_id) {
                                    $selected = 'selected';
                                }
                                echo  " <option value = '$next->term_id' $selected>&nbsp;&nbsp; --  ".$next->name."</option>";
                            }
                        }
                    }
                     

                ?>
                
                  
            </select>
        </p>


        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
        <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>
         <p><label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Show Dato?' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" type="checkbox" step="1" min="1" value="true" <?php checked( $instance['show_date'] ); ?>/></p>
<?php
    }

}

add_action('widgets_init', create_function('', "register_widget('My_Widget_Categories');"));
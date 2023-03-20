<?php 
	global $product;
?>
<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	
	<div class="product-list-image product-element-top">
		<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php
				/**
				 * woocommerce_before_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_show_product_loop_sale_flash - 10
				 * @hooked basel_template_loop_product_thumbnail - 10
				 */
				do_action( 'woocommerce_before_shop_loop_item_title' );
			?>
		</a>
		<?php basel_hover_image(); ?>
		<?php basel_quick_view_btn( get_the_ID() ); ?>
	</div>

	<div class="product-list-content">
		<div class="product-list-info">
			<?php
				/**
				 * woocommerce_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_product_title - 10
				 */
				do_action( 'woocommerce_shop_loop_item_title' );
				$cnt = get_post_meta(get_the_ID(),'produksjonsmetode',true);
				if(!empty($cnt)) {
					echo  wp_trim_words($cnt, 25, '....');
				} else {
					 echo wp_trim_words( get_the_content(), 25, '....' ); 					
				}				
			?>
			
			<?php basel_product_brands_links(); ?>
			<?php woocommerce_template_single_rating(); ?>
			<?php woocommerce_template_single_excerpt(); ?>
			<?php basel_swatches_list(); ?>
			<?php if ( basel_loop_prop( 'progress_bar' ) ): ?>
				<?php basel_stock_progress_bar(); ?>
			<?php endif ?>
			<?php if ( basel_loop_prop( 'timer' ) ): ?>
				<?php basel_product_sale_countdown(); ?>
			<?php endif ?>
		</div>

		
		<div class="product-list-buttons">
			<?php woocommerce_template_loop_price(); ?>
			<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
			<?php do_action( 'basel_product_action_buttons' ); ?>
			<?php basel_compare_btn(); ?>
		</div>
	</div>
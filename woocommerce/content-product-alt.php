<?php 
	global $product;
?>
<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
<div class="product-element-top">
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
	<div class="basel-buttons">
		<?php do_action( 'basel_product_action_buttons' ); ?>
		<?php //basel_compare_btn(); ?>
		<?php basel_quick_view_btn( get_the_ID() ); ?>
	</div>
</div>
<?php
	/**
	 * woocommerce_shop_loop_item_title hook
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );
?>

<?php basel_product_brands_links(); ?>

<div class="wrap-price">
	<div class="wrapp-swap">
		<div class="swap-elements">
			<?php
				/**
				 * woocommerce_after_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_rating - 5
				 * @hooked woocommerce_template_loop_price - 10
				 */
				do_action( 'woocommerce_after_shop_loop_item_title' );
			?>		
			
			<div class="btn-add">
				<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
			</div>
		</div>
	</div>
	<?php 
		basel_swatches_list();
	?>
</div>

<?php if ( basel_loop_prop( 'progress_bar' ) ): ?>
	<?php basel_stock_progress_bar(); ?>
<?php endif ?>

<?php if ( basel_loop_prop( 'timer' ) ): ?>
	<?php basel_product_sale_countdown(); ?>
<?php endif ?>
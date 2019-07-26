<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$general_options = get_option( 'whmc_general_data' );

$cart_calss = isset($general_options['whmc_field_cart_position']) ? $general_options['whmc_field_cart_position'] : '';

?>

<div class="shopping-cart-wrapper">
	<div class="shopping-cart-canvas <?php echo esc_attr($cart_calss);?>">
	<div class="shopping_cart">
		<div class="shopping_cart-top-bar d-flex justify-content-between">
			<h6>Shopping Cart</h6>
			<a class="shopping-cart-close" href="javascript:void(0)">
				<i class="flaticon-close"></i>
			</a>
		</div><!-- shopping cart top bar -->
		<div class="shopping_cart-list-items mt-30">
			<ul class="cart_list product_list_widget <?php echo WC()->cart->is_empty() ? 'empty' : ''; ?>">

			<?php if ( ! WC()->cart->is_empty() ) : ?>
				<?php
				     foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						 $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						 $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

					     if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
							 $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key);

							 $cover_image = $_product->get_image_id(); // Get the ID of the product image
							 $cover_image_link = wp_get_attachment_thumb_url($cover_image); // Address of the product image

							 $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
							 $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
							 $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
							 ?>
							 <li class="woocommerce-mini-cart-item <?php echo esc_attr(apply_filters('woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key)); ?>">
								 <div class="single-shopping-cart media">
									 <div class="cart-image">
										 <img src="<?php echo $cover_image_link; ?>" alt="Cart">
									 </div>
									 <div class="cart-content media-body">
										 <h6><a href="<?php echo $product_permalink; ?>"><?php echo $product_name; ?></a></h6>
										 <span class="quality">QTY: 01</span>
										 <span class="price">$205.00</span>
										 <?php
										 echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
											 '<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><i class="flaticon-close"></i></a>',
											 esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
											 __( 'Remove this item', 'wphobby-woo-mini-cart' ),
											 esc_attr( $product_id ),
											 esc_attr( $cart_item_key ),
											 esc_attr( $_product->get_sku() )
										 ), $cart_item_key );
										 ?>
									 </div>
								 </div> <!-- single shopping cart -->
							 </li>
							 <?php
						 }
					 }
					?>

			<?php else : ?>

			<li class="empty"><?php esc_html_e( 'No products in the cart.', 'wphobby-woo-mini-cart' ); ?></li>

			<?php endif; ?>
			</ul><!-- end product list -->
		</div>
		<?php if ( ! WC()->cart->is_empty() ) : ?>
		<div class="shopping_cart-btn">
			<div class="total">
				<h5 class="subtotal-title"><?php esc_html_e( 'Subtotal', 'wphobby-woo-mini-cart' ); ?>:</h5>
				<p class="subtotal-amount"><?php echo WC()->cart->get_cart_subtotal(); ?></p>
			</div>
			<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

			<div class="cart-btn pt-25">
				<a class="main-btn wc-forward" href="<?php echo esc_url( wc_get_cart_url() ); ?>">View Cart</a>
				<a class="main-btn main-btn-2 checkout wc-forward" href="<?php echo esc_url( wc_get_checkout_url() ); ?>"><?php esc_html_e( 'Checkout', 'wphobby-woo-mini-cart' ); ?></a>
			</div>
		</div>
		<?php endif; ?>

	</div> <!-- shopping_cart -->
    </div>
	<div class="whmc-overlay"></div>
</div>

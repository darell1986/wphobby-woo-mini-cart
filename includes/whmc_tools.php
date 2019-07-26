<?php
//================================================================================
// Update local storage with cart counter each time
//================================================================================

add_filter('woocommerce_add_to_cart_fragments', 'whmc_shopping_bag_items_number');
function whmc_shopping_bag_items_number( $fragments )
{
    global $woocommerce;
    ob_start(); ?>
    <span class="shopping_bag_items_number"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
    <?php
    $fragments['.shopping_bag_items_number'] = ob_get_clean();
    return $fragments;
}


add_filter('woocommerce_add_to_cart_fragments', 'whmc_mini_cart');
function whmc_mini_cart( $fragments )
{

    global $woocommerce;
    ob_start();
    include_once(WHMC_DIR . 'cart/mini-cart.php'); ?>
    <script type="text/javascript">
        jQuery(function($) {
            $('.shopping-cart-open').on('click', function(){
                $('.shopping-cart-canvas').addClass('open');
                $('.whmc-overlay').addClass('open');
            });

            $('.shopping-cart-close').on('click', function(){
                $('.shopping-cart-canvas').removeClass('open');
                $('.whmc-overlay').removeClass('open');
            });
        });
    </script>
    <?php
    $fragments['.shopping-cart-canvas'] = ob_get_clean();
    return $fragments;
}

function whmc_cart_item_removed( $item_id ) {
?>
    <script type="text/javascript">
        jQuery(function($) {
            $('.shopping-cart-canvas').addClass('open');
        });
    </script>
<?php
};

// add the action
add_action( 'woocommerce_cart_item_removed', 'whmc_cart_item_removed' );

// define the woocommerce_get_remove_url callback
function filter_woocommerce_get_remove_url( $var ) {
    $shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
    return $shop_page_url;
};

// add the filter
add_filter( 'woocommerce_get_remove_url', 'filter_woocommerce_get_remove_url', 10, 1 );
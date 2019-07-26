<?php
/**
 * WHobby WooCommerce Product Filter Panel
 */
?>
<h2 class="nav-tab-wrapper">
    <?php
    $url = admin_url().'admin.php?page=whmc-panel';
    $premium_url = 'https://codecanyon.net/item/wphobby-woocommerce-mini-cart/24201931';
    ?>
    <a href="<?php echo esc_url($url); ?>" class="nav-tab <?php echo ($_GET[ 'page' ] == 'whmc-panel' && !isset($_GET[ 'tab' ]) )? 'nav-tab-active' : ''; ?>"><?php _e('General', 'whmc-admin' ); ?></a>
    <a href="<?php echo esc_url($premium_url); ?>" target="_blank" class="nav-tab <?php echo $_GET[ 'tab' ] == 'premium' ? 'nav-tab-active' : ''; ?>"><?php _e('Premium Version', 'whmc-admin' ); ?></a>
</h2>
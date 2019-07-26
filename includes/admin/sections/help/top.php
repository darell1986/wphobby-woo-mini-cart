<?php
/**
 * WHobby WooCommerce Product Filter Panel
 */
?>
<h2 class="nav-tab-wrapper">
    <?php $url = admin_url().'admin.php?page=whmc-help' ?>
    <a href="<?php echo esc_url($url); ?>" class="nav-tab <?php echo ($_GET[ 'page' ] == 'whmc-panel' && !isset($_GET[ 'tab' ]) )? 'nav-tab-active' : ''; ?>"><?php _e('Help & Guide', 'whmc-admin' ); ?></a>
    <a href="<?php echo esc_url($url.'&tab=change-log'); ?>" class="nav-tab <?php echo $_GET[ 'tab' ] == 'change-log' ? 'nav-tab-active' : ''; ?>"><?php _e('Change Log', 'whmc-admin' ); ?></a>
</h2>
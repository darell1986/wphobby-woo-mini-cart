<?php
/**
 * WHMC Admin class
 *
 * @author  WPHobby
 * @package WPHobby WooCommerce Mini Cart
 * @version 1.0.0
 */
if( ! class_exists( 'WHMC_Admin' ) ) {
    class WHMC_Admin {
        // =============================================================================
        // Construct
        // =============================================================================
        public function __construct() {
            add_action( 'admin_init', array( $this, 'whmc_register_settings' ) );
            add_action( 'admin_menu', array( $this, 'whmc_register_menu' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'whmc_admin_styles_scripts' ) );
        }

        /**
         * Load welcome admin css and js
         * @return void
         * @since  1.0.0
         */
        public function whmc_admin_styles_scripts() {
            if ( is_admin() ) {
                wp_enqueue_style('font-awesome', WHMC_URL . 'assets/css/font-awesome.min.css', false, WHMC_VERSION );
                wp_enqueue_style( 'whmc-admin-style', WHMC_URL . 'assets/css/admin.css', false, WHMC_VERSION );
            }
        }

        /*
         * Display admin messages
         */
        public function whmc_display_message(){
            if ( isset( $_GET['settings-updated'] ) ) {
                echo "<div class='updated'><p>".__( 'Settings updated successfully.', 'wphobby-woo-mini-cart' )."</p></div>";
            }
        }

        /**
         * Register admin menus
         * @return void
         * @since  1.0.0
         */
        public function whmc_register_menu(){
            add_menu_page( 'WPHobby WooCommerce Mini Cart', 'Mini Cart', 'manage_options', 'whmc-panel', array( $this, 'whmc_panel_general' ), WHMC_URL . '/assets/images/icon.svg', '2');
            add_submenu_page('whmc-panel', 'Help & Guide', 'Help & Guide', 'manage_options', 'whmc-help', array( $this, 'whmc_panel_help' ) );
        }

        /**
         * The admin panel content
         * @since 1.0.0
         */
        public function whmc_panel_general() {
            $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';
            ?>
            <div class="whmc-panel">
                <div class="wrap">
                    <?php require_once( WHMC_DIR . '/includes/admin/sections/general/top.php' ); ?>
                    <?php $this->whmc_display_message(); ?>
                    <?php
                    if( $active_tab == 'general' ){
                        require_once( WHMC_DIR . '/includes/admin/sections/general/tab-general.php' );
                    }
                    ?>
                </div>
            </div>
            <?php
        }

        /**
         * The admin panel help
         * @since 1.0.0
         */
        public function whmc_panel_help() {
            $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'help';
            ?>
            <div class="whmc-panel">
                <div class="wrap">
                    <?php require_once( WHMC_DIR . '/includes/admin/sections/help/top.php' ); ?>
                    <?php $this->whmc_display_message(); ?>
                    <?php
                    if( $active_tab == 'help' ){
                        require_once( WHMC_DIR . '/includes/admin/sections/help/tab-help.php' );
                    }else if($active_tab == 'change-log'){
                        require_once( WHMC_DIR . '/includes/admin/sections/help/tab-change-log.php' );
                    }
                    ?>
                </div>
            </div>
            <?php
        }

        /**
         * Register Settings
         * @since 1.0.0
         */
        public function whmc_register_settings() {
            register_setting(
                'whmc_general', // A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()
                'whmc_general_data'
            );

            add_settings_section( 'whmc_section_general', '', array( $this, 'whmc_section_general_output' ), 'whmc_panel_general' );
            add_settings_field( 'whmc_field_cart_position', esc_html__("Mini Cart Position", "wphobby-woo-mini-cart"), array( $this, 'whmc_cart_position_output' ), 'whmc_panel_general', 'whmc_section_general' );
            add_settings_field( 'whmc_field_cart_icon', esc_html__("Display Shop Cart Icon", "wphobby-woo-mini-cart"), array( $this, 'whmc_cart_icon_output' ), 'whmc_panel_general', 'whmc_section_general' );
        }

        public function whmc_section_general_output() {
            echo esc_html__( 'This is where general display settings.', 'wphobby-woo-mini-cart' );
        }

        public function whmc_cart_position_output() {
            $options = get_option( 'whmc_general_data' );
            ?>
            <select name='whmc_general_data[whmc_field_cart_position]'> 
                <option value='left' <?php if(isset($options['whmc_field_cart_position'])){selected( $options['whmc_field_cart_position'], 'left' );} ?>>Left</option> 
                <option value='right' <?php if(isset($options['whmc_field_cart_position'])){selected( $options['whmc_field_cart_position'], 'right' );} ?>>Right</option> 
            </select>
            <?php
        }

        public function whmc_cart_icon_output() {
            $options = get_option( 'whmc_general_data' );
            $value = 1;
            $checked = $options['whmc_field_cart_icon']== '1' ? 'checked' : '';
            ?>
            <label class="switch">
                <input type="checkbox" value='<?php echo esc_attr($value); ?>' name='whmc_general_data[whmc_field_cart_icon]' <?php echo esc_attr($checked); ?> />
                <span class="slider round"></span>
            </label>
            <?php
        }

    }

    new WHMC_Admin;
}
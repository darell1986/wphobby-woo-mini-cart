<?php
/**
 * WHMC class
 *
 * @author  WPHobby
 * @package WPHobby WooCommerce Mini Cart
 * @version 1.0.0
 */
class WHMC {

    public $options;

    /**
     * @var bool Check WooCommerce Version
     * @since 1.0.0
     */
    public $current_wc_version  = false;
    public $is_wc_older_2_1     = false;
    public $is_wc_older_2_6     = false;

    public function __construct() {
        $this->options = get_option(WHMC_OPTIONS);

        /**
         * WooCommerce Version Check
         */
        $this->current_wc_version = WC()->version;
        $this->is_wc_older_2_1    = version_compare( $this->current_wc_version, '2.1', '<' );
        $this->is_wc_older_2_6    = version_compare( $this->current_wc_version, '2.6', '<' );

        /* Enqueue Style and Scripts */
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );
        /* Add Cart Button before Shop Page */
        add_action( 'woocommerce_before_main_content', array( $this, 'whmc_cart_button' ), 10 );
        /* Add Filter HTML Elements after footer */
        add_action( 'wp_footer', array( $this, 'elements_after_footer' ) );

    }

    public function activate(){
        //plugin default opts
        $init_opts = array(
            'version' => WHMC_VERSION
        );

        if(!empty($this->options)){
            // update existed options
            update_option(WHMC_OPTIONS, $init_opts);
        }else{
            // add the init options
            add_option(WHMC_OPTIONS, $init_opts);
        }
    }

    public function initialize(){
    }

    public function deactivate(){
    }

    /**
     * Add Cart Button before Shop Page
     */
    public function whmc_cart_button(){
        $general_options = get_option( 'whmc_general_data' );
        if(isset($general_options['whmc_field_cart_icon'])&&$general_options['whmc_field_cart_icon']){
        ?>
        <div class="cart-section">
            <a class="shopping-cart-open" href="javascript:void(0)">
                <i class="flaticon-paper-bag"></i>
                <span class="shopping_bag_items_number"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
            </a>
        </div>
        <?php
        }
    }

    /**
     * Enqueue Styles and Scripts
     */
    public function enqueue_styles_scripts() {
        wp_enqueue_style('font-awesome', WHMC_URL . 'assets/css/font-awesome.min.css', false, WHMC_VERSION );
        wp_enqueue_style('whmc-flaticon', WHMC_URL . 'assets/css/flaticon.css', false, WHMC_VERSION );
        wp_enqueue_style( 'whmc-frontend-style', WHMC_URL . 'assets/css/frontend.css', false, WHMC_VERSION );
        wp_enqueue_script( 'whmc-frontend-script', WHMC_URL . 'assets/js/frontend.js', array( 'jquery' ), WHMC_VERSION, true );
    }

    /**
     * Add Filter HTML Elements after footer
     */
    public function elements_after_footer(){
    ?>
        <div class="wc-notification-wrapper">
        </div>
    <?php
        include_once(WHMC_DIR . 'cart/mini-cart.php');
    }
}
?>
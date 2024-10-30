<?php
/**
* Plugin Name: Chargely Free Subscriptions For Woocommerce
* Plugin URI: https://chargely.com/plugins/woocommerce
* Description: Start your Subscription Business in minutes with Chargely. Chargely provides PCI Certified Payment page for your card processing. So that you don't need a PCI Certification.
* Version: 1.0
* Author: Chargely
* Author URI: https://chargely.com/
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

// If this file is called directly, abort!!!

if (!defined("ABSPATH"))
    exit;
if (!defined("CHARGELY_WOOCOMMERNCE_PLUGIN_DIR_PATH"))
    define("CHARGELY_WOOCOMMERNCE_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
if (!defined("CHARGELY_WOOCOMMERNCE_PLUGIN_URL"))
    define("CHARGELY_WOOCOMMERNCE_PLUGIN_URL", plugins_url() . "/chargely-free-subscriptions-for-woocommerce");

if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )return;

add_action('admin_notices', 'chargely_admin_notices');
function chargely_admin_notices() {
    if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
        echo "<div class='error'><p>Woocommerce Plugin Is  Not Activate</p></div>";
    }
}

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'chargely_setting_action_links' );
function chargely_setting_action_links( $links ) {
	$plugin_links = array(
		'<a href="' . admin_url( 'admin.php?page=login' ) . '">' . __( 'Settings', 'chargely-woocommerce-plugin' ) . '</a>',
		'<a href="' . admin_url( 'admin.php?page=login' ) . '">' . __( 'Backup', 'chargely-woocommerce-plugin' ) . '</a>',
	);

	// Merge our new link with the default ones
	return array_merge( $plugin_links, $links );	
}

function chargely_plugin_menus(){
    add_menu_page('Chargely Woocommerce', 'Chargely Woocommerce', 'manage_options', 'login', 'chargely_login', '', 10);
    add_submenu_page( 'login', 'Dashboard', 'Dashboard', 'manage_options', 'dashboard', 'chargely_dashboard');
    add_submenu_page( 'login', 'Setting', 'Setting', 'manage_options', 'setting', 'chargely_settings');
    add_submenu_page( 'login', 'Subscriptions', 'Subscriptions', 'manage_options', 'subscription', 'chargely_subscriptions');
    add_submenu_page( 'login', 'Transactions', 'Transactions', 'manage_options', 'transactions', 'chargely_transactions');
    add_submenu_page( 'login', null, null, 'manage_options', 'test', 'chargely_test');
}
add_action('admin_menu', 'chargely_plugin_menus');       
       
function chargely_login() {
    include_once CHARGELY_WOOCOMMERNCE_PLUGIN_DIR_PATH . "/views/admin/login.php";
}
    
function chargely_dashboard(){
    include_once CHARGELY_WOOCOMMERNCE_PLUGIN_DIR_PATH."/views/admin/dashboard.php";
}
    
function chargely_settings(){
    include_once CHARGELY_WOOCOMMERNCE_PLUGIN_DIR_PATH."/views/admin/setting.php";
}
      
function chargely_test(){
    include_once CHARGELY_WOOCOMMERNCE_PLUGIN_DIR_PATH."/views/admin/edit_product.php";
}

function chargely_subscriptions(){
    include_once CHARGELY_WOOCOMMERNCE_PLUGIN_DIR_PATH."/views/admin/subscriptions.php";
}

function chargely_transactions(){
    include_once CHARGELY_WOOCOMMERNCE_PLUGIN_DIR_PATH."/views/admin/transactions.php";
}

function chargely_plugin_assets(){
	// styles
    wp_enqueue_style("datatable", CHARGELY_WOOCOMMERNCE_PLUGIN_URL . "/css/jquery.dataTables.min.css", '', true);
    wp_enqueue_style("notifybar", CHARGELY_WOOCOMMERNCE_PLUGIN_URL . "/css/jquery.notifyBar.css", '', true);
    wp_enqueue_style("style", CHARGELY_WOOCOMMERNCE_PLUGIN_URL . "/css/mystyle.css", '', true);

    //scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('validation.min.js', CHARGELY_WOOCOMMERNCE_PLUGIN_URL . '/js/jquery.validate.min.js', '', true);
    wp_enqueue_script('datatable.min.js', CHARGELY_WOOCOMMERNCE_PLUGIN_URL . '/js/jquery.dataTables.min.js', '', true);
    wp_enqueue_script('jquery.notifyBar.js', CHARGELY_WOOCOMMERNCE_PLUGIN_URL . '/js/jquery.notifyBar.js', '', true);
    wp_enqueue_script('script.js', CHARGELY_WOOCOMMERNCE_PLUGIN_URL . "/js/myscript.js", '', true);
    wp_localize_script("script.js", "myplanajaxurl", admin_url("admin-ajax.php"));  
    flush_rewrite_rules();
}
add_action("init", "chargely_plugin_assets");

add_action( 'woocommerce_order_item_add_action_buttons', 'chargely_refund_action_buttons_callback', 10, 1 );
function chargely_refund_action_buttons_callback( $order ) {
    include_once 'views/admin/refund.php';
}

/**
 * Chargely Payment Gateway.
 *
 * Provides a Chargely Payment Gateway, mainly for testing purposes.
 */
add_action('plugins_loaded', 'init_chargely_gateway_class');
function init_chargely_gateway_class(){

    class WC_Gateway_Chargely extends WC_Payment_Gateway {

        public $domain;

        /**
         * Constructor for the gateway.
         */
        public function __construct() {

            $this->domain = 'chargely_payment';
            $this->id                 = 'chargely';
            $this->icon               = apply_filters('woocommerce_chargely_gateway_icon', '');
            $this->has_fields         = false;
            $this->method_title       = __( 'Chargely', $this->domain );
            $this->method_description = __( 'Allows payments with Chargely gateway.', $this->domain );

            // Load the settings.
            $this->init_form_fields();
            $this->init_settings();

            // Define user set variables
            $this->title = $this->get_option( 'title' );
            $this->description  = $this->get_option( 'description' );

        }

        /**
         * Initialise Gateway Settings Form Fields.
         */
        public function init_form_fields() {

            $this->form_fields = array(
                'enabled' => array(
                    'title'   => __( 'Enable/Disable', $this->domain ),
                    'type'    => 'checkbox',
                    'label'   => __( 'Enable Chargely Payment', $this->domain ),
                    'disabled'    => true,
                    'default' => 'yes'
                ),
                'title' => array(
                    'title'       => __( 'Title', $this->domain ),
                    'type'        => 'text',
                    'description' => __( 'This controls the title which the user sees during checkout.', $this->domain ),
                    'default'     => __( 'Chargely', $this->domain ),
                    'desc_tip'    => true,
                    'disabled'    => true
                )
            );
        }

        public function payment_fields(){
            // include_once 'views/card.php';
        }
    }
}

add_filter( 'woocommerce_payment_gateways', 'add_chargely_gateway_class' );
function add_chargely_gateway_class( $methods ) {
    $methods[] = 'WC_Gateway_Chargely'; 
    return $methods;
}

/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'chargely_checkout_field_display_admin_order_meta', 10, 1 );
function chargely_checkout_field_display_admin_order_meta($order){
    $method = get_post_meta( $order->id, '_payment_method', true );
    if($method != 'chargely')
        return;
}

/*
 * Set permlinks on theme activate
 */
function set_chargely_custom_permalinks() {
    $current_setting = get_option('permalink_structure');

    // Abort if already saved to something else
    if($current_setting) {
        return;
    }

    // Save permalinks to a custom setting, force create of rules file
    global $wp_rewrite;
    update_option("rewrite_rules", FALSE);
    $wp_rewrite->set_permalink_structure('/news/%postname%/');
    $wp_rewrite->flush_rules(true);
}
add_action('after_switch_theme', 'set_chargely_custom_permalinks');

add_action( 'init', 'add_chargely_admin_tools_account_endpoint' );
function add_chargely_admin_tools_account_endpoint() {
    add_rewrite_endpoint( 'chargely-subscriptions', EP_PAGES );
}

add_filter ( 'woocommerce_account_menu_items', 'chargely_custom_account_menu_items', 10 );
function chargely_custom_account_menu_items( $menu_links ){
        $menu_links = array_slice( $menu_links, 0, 3, true )
        + array( 'chargely-subscriptions' => __('Subscriptions') )
        + array_slice( $menu_links, 3, NULL, true );
    unset($menu_links['subscriptions']); // Subscriptions
    return $menu_links;
}

add_action( 'woocommerce_account_chargely-subscriptions_endpoint', 'chargely_admin_tools_account_endpoint_content' );
function chargely_admin_tools_account_endpoint_content() {
    require_once 'views/frontend/subscription_menu.php';    
}

add_action( 'woocommerce_view_order', 'chargely_order_pay_button' );
function chargely_order_pay_button( $order_id ){
    include_once 'views/frontend/pay_for_order_in_view.php';
}

add_action( 'after_woocommerce_pay', 'chargely_pay_for_order' );
function chargely_pay_for_order( ){
    include_once 'views/frontend/pay.php';
}

function chargely_direct_checkout_button() {
    include_once 'views/frontend/add_to_cart.php';
}
add_action( 'woocommerce_after_add_to_cart_button', 'chargely_direct_checkout_button', 20 );

add_filter( 'woocommerce_loop_add_to_cart_link', 'chargely_replacing_add_to_cart_button', 10, 2 );
function chargely_replacing_add_to_cart_button( $button, $product  ) {
    $button_text = __("View product", "woocommerce");
    $button = '<a class="button wp-element-button" href="' . $product->get_permalink() . '">' . $button_text . '</a>';
    return $button;
}

add_filter( 'woocommerce_order_button_html', 'chargely_rename_place_order_button_alt', 9999 );
function chargely_rename_place_order_button_alt() {
    require_once 'views/frontend/checkout.php';
}

// Set custom data as custom cart data in the cart item
add_filter( 'woocommerce_add_cart_item_data', 'save_chargely_data_in_cart_object', 30, 3 );
function save_chargely_data_in_cart_object( $cart_item_data, $product_id, $variation_id ) {
    if( ! isset($_REQUEST['product_name']) || ! isset($_REQUEST['currency']) || ! isset($_REQUEST['billing_cycle']) || ! isset($_REQUEST['frequency']) || ! isset($_REQUEST['isOneTypePayment']))
        return $cart_item_data; // Exit

    // Get the data from the GET request
    $product_name          = sanitize_text_field($_REQUEST['product_name']);
    $currency          = sanitize_text_field($_REQUEST['currency']);
    $billing_cycle          = sanitize_text_field($_REQUEST['billing_cycle']);
    $frequency          = sanitize_text_field($_REQUEST['frequency']);
    $isOneTypePayment = sanitize_text_field($_REQUEST['isOneTypePayment']);
    $product_type = sanitize_text_field($_REQUEST['product_type']);
    
    // Set the data as custom cart data for the cart item
    $cart_item_data['custom_data']['product_name'] = sanitize_text_field($_REQUEST['product_name']);
    $cart_item_data['custom_data']['currency'] = sanitize_text_field($_REQUEST['currency']);
    $cart_item_data['custom_data']['billing_cycle'] = sanitize_text_field($_REQUEST['billing_cycle']);
    $cart_item_data['custom_data']['frequency'] = sanitize_text_field($_REQUEST['frequency']);
    $cart_item_data['custom_data']['isOneTypePayment'] = sanitize_text_field($_REQUEST['isOneTypePayment']);
    $cart_item_data['custom_data']['product_type'] = sanitize_text_field($_REQUEST['product_type']);

    return $cart_item_data;
}

// Optionally display Custom data in cart and checkout pages
add_filter( 'woocommerce_get_item_data', 'chargely_data_on_cart_and_checkout', 99, 2 );
function chargely_data_on_cart_and_checkout( $cart_data, $cart_item = null ) {
    
    if( isset( $cart_item['custom_data']['product_type'] ) )
    if ($cart_item['custom_data']['product_type'] === "Subscription") {
        # code...
        $cart_data[] = array(
            'name' => $cart_item['custom_data']['product_type'],
            'value' => $cart_item['custom_data']['frequency'] . ' ' . $cart_item['custom_data']['billing_cycle']
        );
    }

    return $cart_data;
}

// Save cart item custom data as order item meta data and display it everywhere in Orders and email notifications
add_action('woocommerce_checkout_create_order_line_item', 'save_as_chargely_order_item_meta_data', 10, 4 );
function save_as_chargely_order_item_meta_data( $item, $cart_item_key, $values, $order ) {
    $keys = array('0','','2','3','4','5','6','7','8','9','10'); // Fields numbers part keys array()
    
    // Loop through Fields numbers part keys array
    foreach( $keys as $key ) {
        if ($values['custom_data']['product_type'.$key] == "Subscription") {
            $item->update_meta_data( $values['custom_data']['product_type'.$key], $values['custom_data']['frequency'.$key].' '.$values['custom_data']['billing_cycle'.$key]);
        }
    }
}

add_filter( 'woocommerce_available_payment_gateways', 'chargely_gateway_diable' );

function chargely_gateway_diable( $gateways ) {

    if( is_admin() ) {
		return $gateways;
	}

    unset( $gateways[ 'cod' ] );
	unset( $gateways[ 'paypal' ] );
	unset( $gateways[ 'stripe' ] );
	unset( $gateways[ 'bacs' ] );
	unset( $gateways[ 'cheque' ] );
	unset( $gateways[ 'authorize' ] );
	unset( $gateways[ 'officeguy' ] );
	unset( $gateways[ 'authorizenet' ] );
	unset( $gateways[ 'payu_in' ] );
	unset( $gateways[ 'amazon_payments_advanced' ] );
	unset( $gateways[ 'amazon_payments_advanced_express' ] );
	unset( $gateways[ 'woocommerce_payments' ] );
	return $gateways;
}

add_filter( 'woocommerce_add_cart_item' , 'set_csw_prices');
add_filter( 'woocommerce_get_cart_item_from_session',  'set_chargely_prices', 20 , 3 );


function set_csw_prices( $woo_data ) {
  if ( ! isset( ($_REQUEST['price']) ) || empty ( $_REQUEST['price'] ) ) { return $woo_data; }
  $woo_data['data']->set_price( sanitize_text_field($_REQUEST['price']) );
  $woo_data['my_price'] = sanitize_text_field($_REQUEST['price']);
  return $woo_data;
}

function  set_chargely_prices ( $woo_data , $values , $key ) {
    if ( ! isset( $woo_data['my_price'] ) || empty ( $woo_data['my_price'] ) ) { return $woo_data; }
    $woo_data['data']->set_price( $woo_data['my_price'] );
    return $woo_data;
}

// Database
// plugin table

function chargely_credentials() {
    global $wpdb;
    return $wpdb->prefix . "chargely_woocommernce_plugin"; //wp_my_plans
}

function create_plugin_tables() {
    global $wpdb;
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $create_table = "  CREATE TABLE `". chargely_credentials() . "` (
        `id` int(11) NOT NULL,
        `merchant_id` varchar(255) DEFAULT NULL,
        `api_key` varchar(255) DEFAULT NULL,
        `url_endpoint` varchar(255) DEFAULT NULL,
        `consumer_key` varchar(255) DEFAULT NULL,
        `consumer_secret` varchar(255) DEFAULT NULL,
        `cancel_subscription` varchar(255) DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    dbDelta($create_table);
}
register_activation_hook(__FILE__, "create_plugin_tables");
	
function drop_table_plugin_tables() {
    global $wpdb;
    $wpdb->query("DROP TABLE IF EXISTS " . chargely_credentials());
}
register_deactivation_hook(__FILE__, "drop_table_plugin_tables");
// register_uninstall_hook(__FILE__,"drop_table_plugin_tables");
 
add_action("wp_ajax_myplanlibrary","chargely_credentials_ajax_handler");
function chargely_credentials_ajax_handler(){
 global $wpdb;
 if(sanitize_text_field($_REQUEST['param'])=="save_id"){
    // save data to db table
    $wpdb->insert(chargely_credentials(), array(
     "id"=> sanitize_text_field($_REQUEST['id']),
     "merchant_id"=>sanitize_text_field($_REQUEST['merchant_id']),
     "api_key"=>sanitize_text_field($_REQUEST['api_key']),
     "url_endpoint"=>sanitize_text_field($_REQUEST['url_endpoint']),
     "consumer_key"=>sanitize_text_field($_REQUEST['consumer_key']),
     "consumer_secret"=>sanitize_text_field($_REQUEST['consumer_secret']),
     "cancel_subscription"=>sanitize_text_field($_REQUEST['cancel_subscription'])
    )); 
    echo json_encode(array("status"=>1,"message"=>"Connected Successfully"));
 }elseif (sanitize_text_field($_REQUEST['param']) == "updated_plugin") {
    $wpdb->Update(chargely_credentials(), array(
        "id"=> sanitize_text_field($_REQUEST['id']),
        "merchant_id"=> sanitize_text_field($_REQUEST['merchant_id']),
        "api_key"=> sanitize_text_field($_REQUEST['api_key']),
        "url_endpoint"=> sanitize_text_field($_REQUEST['url_endpoint']),
        "consumer_key"=> sanitize_text_field($_REQUEST['consumer_key']),
        "consumer_secret"=> sanitize_text_field($_REQUEST['consumer_secret']),
        "cancel_subscription"=> sanitize_text_field($_REQUEST['cancel_subscription'])
     ), array(
        "id" => 1
    ));
    echo json_encode(array("status" => 1, "message" => "Updated successfully"));  
 }elseif(sanitize_text_field($_REQUEST['param']) == "delete_plan"){
    $wpdb->delete(chargely_credentials(), array(
        "id"=>1
    ));
    echo json_encode(array("status"=>1,"message"=>"Deleted successfully"));
  }
 wp_die();
}

// product table
function chargely_product_table_name() {
    global $wpdb;
    return $wpdb->prefix . "chargely_woocommernce_product"; //wp_my_plans
}
  
function create_chargely_product_tables() {
    global $wpdb;
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $sql = "  CREATE TABLE `". chargely_product_table_name() . "` (
        `product_id` int(11) NOT NULL,
        `product_id_uniqid` varchar(255) DEFAULT NULL,       
        `product_name` varchar(255) DEFAULT NULL,
        `price` int(11) NOT NULL,
        `percentage` int(11) NOT NULL,
        `updated_price` float(11) NOT NULL,
        `billing_period` varchar(255) DEFAULT NULL,
        `billing_period_type` varchar(255) DEFAULT NULL,
        `status` varchar(255) DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`product_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    dbDelta($sql);
}
register_activation_hook(__FILE__, "create_chargely_product_tables");

function drop_chargely_product_table() {
    global $wpdb;
    $wpdb->query("DROP TABLE IF EXISTS " . chargely_product_table_name());
}
register_deactivation_hook(__FILE__, "drop_chargely_product_table");
// register_uninstall_hook(__FILE__,"drop_chargely_product_table");

add_action("wp_ajax_myproductlibrary","chargely_product_ajax_handler");
function chargely_product_ajax_handler(){
 global $wpdb;
 if(sanitize_text_field($_REQUEST['param'])=="save_product"){
    // save data to db table
    $wpdb->insert(chargely_product_table_name(), array(
     "product_id"=> sanitize_text_field($_REQUEST['product_id']),
     "product_id_uniqid"=> sanitize_text_field($_REQUEST['product_id_uniqid']),
     "product_name"=> sanitize_text_field($_REQUEST['product_name_create']),
     "price"=> sanitize_text_field($_REQUEST['price_create']),
     "percentage"=> sanitize_text_field($_REQUEST['percentage_create']),
     "updated_price"=> sanitize_text_field($_REQUEST['updated_price_create']),
     "billing_period"=> sanitize_text_field($_REQUEST['billing_period_create']),
     "billing_period_type"=> sanitize_text_field($_REQUEST['billing_period_type_create']),
     "status"=> "Active"
    )); 
    echo json_encode(array("status"=>1,"message"=>"Created Successfully"));
 }elseif (sanitize_text_field($_REQUEST['param']) == "edit_plan") {
    $wpdb->Update(chargely_product_table_name(), array(
        "product_name"=> sanitize_text_field($_REQUEST['product_name_edit']),
        "price"=> sanitize_text_field($_REQUEST['price_edit']),
        "percentage"=> sanitize_text_field($_REQUEST['percentage_edit']),
        "updated_price"=> sanitize_text_field($_REQUEST['updated_price_edit']),
        "billing_period"=> sanitize_text_field($_REQUEST['billing_period_edit']),
        "billing_period_type"=> sanitize_text_field($_REQUEST['billing_period_type_edit']),
        "status"=> sanitize_text_field($_REQUEST['status'])
     ), array(
        "product_id" => sanitize_text_field($_REQUEST['product_id'])
    ));
    echo json_encode(array("status" => 1, "message" => "Updated successfully"));  
  }
 wp_die();
}

add_action( 'rest_api_init', 'chargely_add_callback_url_endpoint' );

function chargely_add_callback_url_endpoint(){
    register_rest_route(
        'chargely/v1/', // Namespace
        'receive-callback', // Endpoint
        array(
            'methods'  => 'POST',
            'callback' => 'chargely_receive_callback'
        )
    );
}

function chargely_receive_callback( $request_data ) {
    $data = array();

    $subscription = array();
    
    $parameters = $request_data->get_params();
    
    $key_id     = $parameters['key_id'];
    $user_id = $parameters['user_id'];
    $consumer_key = $parameters['consumer_key'];
    $consumer_secret = $parameters['consumer_secret'];
    $key_permissions = $parameters['key_permissions'];
    

    $order_id = $parameters['order_id'];

    if ( isset($key_id) && isset($user_id) && isset($consumer_key) && isset($consumer_secret) && isset($key_permissions)) {
        
        $data['status'] = 'OK';
    
        $data = array(
            'key_id'     => $key_id,
            'user_id' => $user_id,
            'consumer_key' => $consumer_key,
            'consumer_secret' => $consumer_secret,
            'key_permissions' => $key_permissions,
        );
        
        $data['message'] = 'You have reached the server';
            
            global $wpdb;
            $wpdb->insert(chargely_credentials(), array(
                "id" => 1,
                "merchant_id" => sanitize_text_field($_COOKIE['Chargely_Woocommernce_Merchant_id']),
                "api_key" => sanitize_text_field($_COOKIE['Chargely_Woocommernce_Api_Key']),
                "url_endpoint" => sanitize_text_field($_COOKIE['Chargely_Woocommernce_Url_Endpoint']),
                "consumer_key"=> $data['consumer_key'],
                "consumer_secret"=> $data['consumer_secret'],
            ));
            ?>
            <script>
                var consumer_key = '<?php print $data['consumer_key'] ?>';
                localStorage.setItem("Chargely_Woocommernce_consumer_key" , consumer_key);
            </script>
            <?php
    } else {
        
        $data['status'] = 'Failed';
        $data['message'] = 'Parameters Missing!';
        
    }


    // subscription

    if (isset($order_id)){
        $subscription['status'] = 'OK';
        $subscription = array(
            'order_id'     => $order_id,
        );
        $subscription['message'] = 'You have reached the server';

        global $wpdb;
        $getallplans = $wpdb->get_results(
            $wpdb->prepare("SELECT * from ".chargely_credentials()." ORDER BY id desc ","")
        );

        $test_db = json_encode($getallplans);
        ?>
        <script>
            let auth = <?php print $test_db ?>;
            var order_id = <?php print $subscription['order_id'] ?>;
            var consumer_key = auth[0].consumer_key;
            var consumer_secret = auth[0].consumer_secret;

            var xhr = new XMLHttpRequest();
            xhr.withCredentials = true;

            xhr.addEventListener("readystatechange", function() {
                if(this.readyState === 4) {
                    var response = JSON.parse(this.responseText);
                    var billing = response.billing;
                    var shipping = response.shipping;

                    var shipping_lines = response.shipping_lines;
                    let shipping_line_obj = {
                        "method_id": shipping_lines[0].method_id,
                        "method_title": shipping_lines[0].method_title,
                        "total": shipping_lines[0].total
                    }
    
                    shipping_line.push(shipping_line_obj);

                    var line_items = response.line_items;
                    for (let index = 0; index < line_items.length; index++) {
                        const element = line_items[index];
                        let meta_data = element.meta_data;
                        if (meta_data != 0) {

                            let line_item_obj = {
                                "product_id": line_items[index].product_id,
                                "variation_id": line_items[index].variation_id,
                                "quantity": line_items[index].quantity
                            }

                            line_item.push(line_item_obj);

                            let meta_data_subcription_value = line_items[index].meta_data;
                            for (let index = 0; index < meta_data_subcription_value.length; index++) {
                                const element = meta_data_subcription_value[index];
                                let meta_data_subcription_value_arr = element.value;
                                let meta_data_subcription_value_split = meta_data_subcription_value_arr.split(" ");
                                let cal = JSON.parse(meta_data_subcription_value_split[0]);

                                for (let index = 0; index < line_items[index].meta_data.length; index++) {
                                    const element = line_items[index].meta_data[index];
                                    let value = element.value;
                                    let split_value = value.split(" ");
                                
                                    var data = JSON.stringify({
                                        "payment_method": "Chargely",
                                        "payment_method_title": "Chargely",
                                        "set_paid": true,
                                        "billing": billing,
                                        "shipping": shipping,
                                        "line_items": line_item,
                                        "shipping_lines": shipping_line,
                                        "meta_data": [
                                            {
                                                "key":element.key,
                                                "value": split_value[0] + ' ' + split_value[1]
                                            }
                                        ],
                                    });
                                }
                    
                                var xhr = new XMLHttpRequest();
                                xhr.withCredentials = true;

                                xhr.addEventListener("readystatechange", function() {
                                    if(this.readyState === 4) {
                                        var data = JSON.stringify({
                                            "status": "processing"
                                        });

                                        var xhr = new XMLHttpRequest();
                                        xhr.withCredentials = true;

                                        xhr.addEventListener("readystatechange", function() {
                                            if(this.readyState === 4) {
                                            }
                                        });

                                        xhr.open("PUT", auth[0].url_endpoint + "/wp-json/wc/v3/orders/" + JSON.parse(this.responseText).id);
                                        xhr.setRequestHeader("Authorization", "Basic " + btoa(consumer_key + ":" + consumer_secret));
                                        xhr.setRequestHeader("Content-Type", "application/json");
                                        xhr.send(data);
                                    }
                                });

                                xhr.open("POST", auth[0].url_endpoint + "/wp-json/wc/v3/orders");
                                xhr.setRequestHeader("Authorization", "Basic " + btoa(consumer_key + ":" + consumer_secret));
                                xhr.setRequestHeader("Content-Type", "application/json");
                                xhr.send(data);

                            }
                        }
                    }     
                }
            });

            xhr.open("GET", auth[0].url_endpoint + "/wp-json/wc/v3/orders/" + order_id);
            xhr.setRequestHeader("Authorization", "Basic " + btoa(consumer_key + ":" + consumer_secret));
            xhr.send();
        </script>
        <?php
    } else {
        $subscription['status'] = 'Failed';
        $subscription['message'] = 'Parameters Missing!';
    }
    
    return $subscription['order_id'];

}
<input type="hidden" id="nonce" name="_nonce" value="<?php print wp_create_nonce("wc_store_api")?>">
<img src="<?php print plugins_url('images/cards.png' , __FILE__) ?>" alt="" srcset="">
<p>You will be redirected to Payment Page to complete the payment.</p>
<button type="submit" class="button alt wp-element-button" name="woocommerce_checkout_place_order" id="place_order" value="CONTINUE" data-value="CONTINUE">CONTINUE</button>
<div class="loader" id="loader"></div>
<style>
    .woocommerce-page ul.wc_payment_methods li.wc_payment_method, .woocommerce-page ul.woocommerce-shipping-methods li.wc_payment_method{
        display:none;
    }
    .hide-loader{
        display:none;
    }
    .woocommerce-terms-and-conditions-wrapper {
        display: none;
    }
    .woocommerce-page input[type=radio].shipping_method:checked+label::before, .woocommerce-page input[type=radio][name=payment_method]:checked+label::before{
        display: none;
    }
    dl{
        width: 200px;
    }

    .error_overlay {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        transition: opacity 500ms;
        visibility: hidden;
        opacity: 0;
        z-index: 9000;
    }

    .error_overlay:target {
        visibility: visible;
        opacity: 1;
    }

    .error_popup {
        margin: 70px auto;
        padding: 0px 20px;
        background: #f7a7a3;
        border-radius: 5px;
        width: 30%;
        position: relative;
        transition: all 5s ease-in-out;
    }

    .error_popup .error_content {
        margin-top: 0;
        color: darkred;
        font-family: Tahoma, Arial, sans-serif;
    }

    .error_popup .error_close {

        transition: all 200ms;
        font-size: 30px;
        font-weight: initial;
        text-decoration: none;
        color: darkred;
        cursor: pointer;
    }

    .error_popup .error_content {
        max-height: 30%;
        overflow: auto;
        text-align: center;
        font-size: 16px;
        font-weight: 500;
        overflow: hidden;
    }

    .error_popup .error_content-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .error_left_line {
        width: 4px;
        height: 48px;
        background: darkred;
        position: absolute;
        float: left;
        left: 0px;
        border-radius: 5px 0 0 5px;
    }
</style>
<script>

    jQuery('#loader').addClass("hide-loader");
    
    var AmagiLoader = {
        __loader: null,
        show: function () {

            if (this.__loader == null) {
                var divContainer = document.createElement('div');
                divContainer.style.position = 'fixed';
                divContainer.style.left = '0';
                divContainer.style.top = '0';
                divContainer.style.width = '100%';
                divContainer.style.height = '100%';
                divContainer.style.zIndex = '9998';
                divContainer.style.backgroundColor = 'white';
                
                var div = document.createElement('div');
                div.style.position = 'absolute';
                div.style.left = '50%';
                div.style.top = '50%';
                div.style.zIndex = '9999';
                div.style.height = '64px';
                div.style.width = '64px';
                div.style.margin = '-76px 0 0 -76px';
                div.style.border = '8px solid #e1e1e1';
                div.style.borderRadius = '50%';
                div.style.borderTop = '8px solid #5D64EA';
                div.animate([
                    { transform: 'rotate(0deg)' },
                    { transform: 'rotate(360deg)' }
                ], {
                    duration: 2000,
                    iterations: Infinity
                });
                divContainer.appendChild(div);
                this.__loader = divContainer
                document.body.appendChild(this.__loader);
            }
            this.__loader.style.display="";
        },
        hide: function(){
            if(this.__loader!=null)
            {
                this.__loader.style.display="none";
            }
        }
    }

    var arr = [];
    var woo_com = [];
    var woo_com_meta_arr = [];
    var shipping_amount_arr = [];
    var shipping_details_arr = [];

    <?php
    global $product;
    global $woocommerce;
    global $wpdb;

    $getallplans = $wpdb->get_results(
        $wpdb->prepare("SELECT * from ".chargely_credentials()." ORDER BY id desc ","")
    );

    $plugin_db_encode = json_encode($getallplans);

    $total_amount =  $woocommerce->cart->total;
    $currency_code = get_woocommerce_currency();
    $currency_code_encode = json_encode($currency_code);

    $getallproduct = $wpdb->get_results(
        $wpdb->prepare("SELECT * from ".chargely_product_table_name()." ORDER BY product_id desc ","")
    );

    $product_db_encode = json_encode($getallproduct);

    $total_amount =  preg_replace( '#[^\d.]#', '', WC()->cart->get_total());

    foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ){
        $product_id = $cart_item['product_id']; 
        $product_obj = wc_get_product($product_id); 
        $product_qty = $cart_item['quantity']; 
        $product_price = $cart_item['data']->price; 
        $product_total_stock = $cart_item['data']->total_stock; 
        $product_type = $cart_item['data']->product_type; 
        $product_name = $cart_item['data']->post->post_title; 
        $product_slug = $cart_item['data']->post->post_name; 
        $product_description = $cart_item['data']->post->post_content; 
        $product_excerpt = $cart_item['data']->post->post_excerpt; 
        $product_post_type = $cart_item['data']->post->post_type;    
        $cart_line_total = $cart_item['line_total']; 
        $cart_line_tax = $cart_item['line_tax']; 
        $cart_line_subtotal = $cart_item['line_subtotal']; 
        $cart_line_subtotal_tax = $cart_item['line_subtotal_tax']; 
        $cart_my_price = $cart_item['my_price']; 
        
        $variation_id = $cart_item['variation_id']; 
        if($variation_id != 0){
            $product_variation_obj = wc_get_product($variation_id); 
            $variation_array = $cart_item['variation']; 
        }

        $cart_line_total_encode = json_encode($cart_line_total);
        $total_amount_encode = json_encode($total_amount);
        $product_id_encode = json_encode($product_id);
        $product_qty_encode = json_encode($product_qty);
        $product_name_encode = json_encode($product_name);
        $cart_item_data = json_encode($cart_item);

        ?>

        var currency_code = <?php print $currency_code_encode ?>;

        var cart_line_total = <?php print $cart_line_total_encode ?>;

        var total_amount = <?php print $total_amount_encode ?>;
        
        var product_id = <?php print $product_id_encode ?>;
        
        var product_qty = <?php print $product_qty_encode ?>;

        var plugin_db = <?php print $plugin_db_encode?>;

        var product_db = <?php print $product_db_encode?>;

        var cart_item_data = <?php print $cart_item_data ?>;

        var product_name = <?php print $product_name_encode ?>;

        woo_com.push(cart_item_data);

        <?php
    }

    ?>

    woo_com.forEach(cart => {
        var obj = {
            name: cart.custom_data.product_name,
            amount: JSON.parse(cart.line_total),
            currency: currency_code,
            plan_id: cart.product_id,
            billing_cycle: cart.custom_data.billing_cycle,
            frequency: cart.custom_data.frequency,
            isOneTypePayment: JSON.parse(cart.custom_data.isOneTypePayment)
        };
        arr.push(obj);
    });

    <?php
    $chosen_shipping_method_price = WC()->session->get('cart_totals')['shipping_total'];
    $current_shipping_method = WC()->session->get( 'chosen_shipping_methods' );
    $packages = WC()->shipping()->get_packages();
    $package = $packages[0];
    $available_methods = $package['rates'];
    foreach ($available_methods as $key => $method) {
        if($current_shipping_method[0] == $method->id){
        ?>
        var shipping_obj = {
            method_id: '<?php print $method->id ?>',
            method_title: '<?php print $method->label ?>',
            total: '<?php print $chosen_shipping_method_price ?>'
        }
        shipping_amount_arr.push(shipping_obj);
        <?php
        }
    }
    ?>
    
    var chargely_payment_btn = document.getElementById("place_order");

    var api_url_checkout;
    for (let index = 0; index < plugin_db.length; index++) {
        const element = plugin_db[index];
        api_url_checkout = element.url_endpoint;
    }

    chargely_payment_btn.addEventListener("click", (e) =>{
        e.preventDefault()
        AmagiLoader.show();

        var billing_details = {
            first_name : document.getElementById("billing_first_name").value,
            last_name : document.getElementById("billing_last_name").value,
            address_1 : document.getElementById("billing_address_1").value,
            address_2 : document.getElementById("billing_address_2").value,
            company : document.getElementById("billing_company").value,
            city : document.getElementById("billing_city").value,
            state : document.getElementById("billing_state").value,
            postcode : document.getElementById("billing_postcode").value,
            country : document.getElementById("billing_country").value,
            email : document.getElementById("billing_email").value,
            phone : document.getElementById("billing_phone").value,
        }

        var shipping_details = {
            first_name : document.getElementById("billing_first_name").value,
            last_name : document.getElementById("billing_last_name").value,
            address_1 : document.getElementById("billing_address_1").value,
            address_2 : document.getElementById("billing_address_2").value,
            company : document.getElementById("billing_company").value,
            city : document.getElementById("billing_city").value,
            state : document.getElementById("billing_state").value,
            postcode : document.getElementById("billing_postcode").value,
            country : document.getElementById("billing_country").value,
        }

        var nonce_woocom = document.getElementById("nonce");
        var request = new XMLHttpRequest();
        request.open("POST", `${api_url_checkout}/wp-json/wc/store/v1/checkout`, true);
        request.setRequestHeader('Content-Type', 'application/json');
        request.setRequestHeader('X-WC-Store-API-Nonce', nonce_woocom.value);
        request.onreadystatechange = () => {
            var res  = request.response;
            var status  = request.status;
            var response = JSON.parse(res);
            var order_id_store = response.order_id;
            var customer_email = response.billing_address.email;
            var billing_address = response.billing_address;
            var shipping_address = response.shipping_address;
            var payment_method = response.payment_method;
            var payment_result = response.payment_result;
            
            if (status == 400) {
                document.cookie = `cookie1=${order_id_store}; path=/`;        
                window.location.reload();
                for (var index = 0; index < plugin_db.length; index++) {
                    const element = plugin_db[index];  
                    var chosen_shipping_method_price = <?php print $chosen_shipping_method_price ?>;
                    var data = {
                        plan_object: arr,
                        shipping_amount: chosen_shipping_method_price,
                        order_id: order_id_store,
                        customer_email : customer_email,
                        billing_details: billing_address,
                        shipping_details: shipping_address,
                        role: "woocommerce_plugin",
                        merchant_id: element.merchant_id,
                        merchant_callbackurl: element.url_endpoint + "/wp-json/chargely/v1/receive-callback",
                        cancel_url: "https://chargely.com/consumer/billing/",
                        redirect_url: `${element.url_endpoint}/checkout/`    
                    }
                }

                var send_data = window.btoa(JSON.stringify(data));
                var URL = "https://chargely.com/consumer/billing/" + send_data;
                AmagiLoader.show();
                window.location.href = URL;   
            }
        }
        var payload = {
            "billing_address": billing_details,
            "shipping_address": shipping_details,
            "payment_method": "chargely"
        }
        request.send(JSON.stringify(payload));

    });

    var u = new URLSearchParams(window.location.search);

    if (u?.get('payment_status') === "success") {
        AmagiLoader.show();

        <?php
        $order_id_check = sanitize_text_field($_COOKIE['cookie1']);
        $test_db = json_encode($getallplans);
        ?>

        let auth = <?php print $test_db ?>;
        var order_id_check = '<?php print $order_id_check ?>';

        var settings = {
            "url": `https://chargely.com/api/get/merchant/app/transactions/${auth[0]?.merchant_id}`,
            "method": "GET",
            "timeout": 0,
        };

        jQuery.ajax(settings).done(function (response) {
            if (response.success === true) {
                var result_data = response.message;
                result_data.forEach(element => {
                    if (parseInt(element.order_id) === parseInt(order_id_check)) {
                        <?php
                            if(count($getallplans)>0){
                                foreach($getallplans as $key=>$value){

                                    // Update Order

                                    $oauthVersion = "1.0";
                                    $oauthSignatureMethod = "HMAC-SHA1"; 
                                    $oauthTimestamp = time();
                                    $consumer_key = $value->consumer_key;
                                    $consumer_secret = $value->consumer_secret;
                                    $nonce = uniqid();

                                    $sigKey = $consumer_secret . "&"; 

                                    $requestTokenUrlOrder = $value->url_endpoint."/wp-json/wc/v3/orders/".$order_id_check; 

                                    $sigBaseOrder = "PUT&" . rawurlencode($requestTokenUrlOrder) . "&"
                                        . rawurlencode("oauth_consumer_key=" . rawurlencode($consumer_key)
                                        . "&oauth_nonce=" . rawurlencode($nonce)
                                        . "&oauth_signature_method=" . rawurlencode($oauthSignatureMethod)
                                        . "&oauth_timestamp=" . $oauthTimestamp
                                        . "&oauth_version=" . $oauthVersion);
                                        
                                    $oauthSigOrder = base64_encode(hash_hmac("sha1", $sigBaseOrder, $sigKey, true));
                                        
                                    $oauth_signatureorder_ = rawurlencode($oauthSigOrder);
                                }
                            }
                        ?>
                                
                        var api_url_order = '<?php print $requestTokenUrlOrder ?>';
                        var consumer_key_order = '<?php print $consumer_key ?>';
                        var oauth_signature_Order = '<?php print $oauth_signatureorder_ ?>';
                        var timestampOrder = '<?php print $oauthTimestamp ?>';
                        var nonceOrder = '<?php print $nonce ?>';
                        var oauthSignatureMethodOrder = '<?php print $oauthSignatureMethod ?>';
                        var oauthVersionorder = '<?php print $oauthVersion ?>';

                        if (api_url_order && consumer_key_order && oauth_signature_Order && timestampOrder && nonceOrder && oauthSignatureMethodOrder && oauthVersionorder) {
                            var UPDATE_ORDER_URLL = api_url_order + "?oauth_consumer_key=" + encodeURIComponent(consumer_key_order) + "&oauth_signature_method=" + encodeURIComponent(oauthSignatureMethodOrder) + "&oauth_timestamp=" + encodeURIComponent(timestampOrder) + "&oauth_nonce=" + encodeURIComponent(nonceOrder) + "&oauth_version=" + encodeURIComponent(oauthVersionorder) + "&oauth_signature=" + encodeURIComponent(oauth_signature_Order);
                            var update_order_request = new XMLHttpRequest();
                            update_order_request.open("PUT", UPDATE_ORDER_URLL , true);
                            update_order_request.setRequestHeader('Content-Type', 'application/json');
                            update_order_request.onreadystatechange=()=>{
                                var res_api  = JSON.parse(update_order_request.response);
                                let order_id_res = res_api.id;
                                let order_key_res = res_api.order_key;
                                
                                setTimeout(myGreeting, 3000);

                                function myGreeting() {
                                    window.location.href = `${api_url_checkout}/checkout/order-received/${order_id_res}/?key=${order_key_res}`;
                                    AmagiLoader.hide();
                                }
                            }

                            var update_order_payload = {
                                "status": "processing",
                                "payment_method": `Chargely (${element.payment_gateway})`
                            }

                            update_order_request.send(JSON.stringify(update_order_payload));
                        }
                    }
                });
            }
        
        });
    }
</script>

<div id="error_popup" class="error_overlay">
    <div class="error_popup">
        <div class="error_left_line"></div>
        <div class="error_content-container">
            <div class="error_content" id="err_msg">if we try to buy the items in the cart which has been added by the customer a long time ago, an error will pop up please remove the items from the cart and add them again to move forward with your purchase</div>
            <div  id="err_close">
                <a href="#" class="error_close" onclick="history.go(-1)">x</a>
            </div>
        </div>
    </div>
</div>

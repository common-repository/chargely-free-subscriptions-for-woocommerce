<style>
    .woocommerce-page #payment #place_order{
        display : none;
    }
    .woocommerce .woocommerce-error{
        display : none;
    }
</style>
<button type="submit" class="button alt wp-element-button" id="chargely_place_order" value="Pay for order" data-value="Pay for order">Pay for order</button>
<script>
    var chargely_pay_arr = [];
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
    <?php
    global $wp;

    $order_id_api;

    global $wpdb;

    $getallplans = $wpdb->get_results(
        $wpdb->prepare("SELECT * from ".chargely_credentials()." ORDER BY id desc ","")
    );

    $plugin_db_test = json_encode($getallplans);

    if ( isset($wp->query_vars['order-pay']) && absint($wp->query_vars['order-pay']) > 0 ) {
        $order_id = absint($wp->query_vars['order-pay']); 
        
        $order    = wc_get_order( $order_id ); 

        $order_idd = $order->get_id();
        $order_id_api = $order_idd;

        foreach ( $order->get_items() as $item_id => $item ) {

        ?>
            var order = <?php print $order ?>;

            var item = <?php print $item ?>;
            

            var customer_email = order.billing.email;
            if (item.meta_data.length>0) {
                if (item.meta_data[0]?.key === "Subscription") {
                    var billing_cycle = item.meta_data[0].value;
                    var split = billing_cycle.split(" ");
                    var product_object = {
                        name: item.name,
                        amount: JSON.parse(item.total),
                        currency: order.currency,
                        plan_id: item.product_id,
                        billing_cycle: split[1],
                        frequency: split[0],
                        isOneTypePayment: false
                    }
                    chargely_pay_arr.push(product_object);
                }
            }
            if (item.meta_data.length == 0) {
                var product_object = {
                    name: item.name,
                    amount: JSON.parse(item.total),
                    currency: order.currency,
                    plan_id: item.product_id,
                    billing_cycle: "null",
                    frequency: "null",
                    isOneTypePayment: true
                }
                chargely_pay_arr.push(product_object);
            }
            <?php
        }
    }
    ?>

    var plugin_db = <?php print $plugin_db_test ?>;
    
    var data = {
        plan_object: chargely_pay_arr,
        shipping_amount: JSON.parse(order.shipping_total),
        order_id: order.id,
        customer_email : customer_email,
        billing_details: order.billing,
        shipping_details: order.shipping,
        role: "woocommerce_plugin",
        merchant_id: plugin_db[0].merchant_id,
        merchant_callbackurl: plugin_db[0].url_endpoint + "/wp-json/chargely/v1/receive-callback",
        cancel_url: "https://chargely.com/consumer/billing/",
        redirect_url: `${plugin_db[0].url_endpoint}/checkout/order-pay/${order.id}/pay_for_order=true&key=${order.order_key}`   
    }

    var send_data = window.btoa(JSON.stringify(data));
    var URL = "https://chargely.com/consumer/billing/" + send_data;

    var chargely_place_order = document.getElementById('chargely_place_order');
    if (chargely_place_order) {
        chargely_place_order.addEventListener('click', (e) =>{
            AmagiLoader.show();
            window.location.href = URL;  
        });
    }

    var u = new URLSearchParams(window.location.search);

    if (u?.get('payment_status') === "success") {
        AmagiLoader.show();

        <?php
        $order_id_check = $order_id_api;
        ?>

        var order_id_check = <?php print $order_id_check ?>;

        var settings = {
            "url": `https://chargely.com/api/get/merchant/app/transactions/${plugin_db[0]?.merchant_id}`,
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
                                
                                setTimeout(myGreeting, 2000);

                                function myGreeting() {
                                    window.location.href = `${plugin_db[0]?.url_endpoint}/checkout/order-received/${order_id_res}/?key=${order_key_res}`;
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
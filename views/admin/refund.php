<style>
    .chargely_refund_btn {
        color: #2271b1;
        border-color: #2271b1;
        background: #f6f7f7;
        text-decoration: none;
        font-size: 13px;
        line-height: 2.15384615;
        height: 30px;
        padding: 0 10px;
        cursor: pointer;
        border-width: 1px;
        border-style: solid;
        border-radius: 3px;
        box-sizing: border-box;
        float: left;
    }
    .overlay {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        transition: opacity 500ms;
        visibility: hidden;
        opacity: 0;
        z-index: 9999999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .overlay:target {
        visibility: visible;
        opacity: 1;
    }

    .popup {
        margin: 70px auto;
        padding: 12px;
        background: #f0f0f0;
        border-radius: 5px;
        width: 40%;
        position: relative;
        transition: all 5s ease-in-out;
        max-height: 300px;
        overflow-y: scroll;
    }

    .popup h2 {
        margin-top: 0;
        color: #333;
        font-family: Tahoma, Arial, sans-serif;
    }

    .popup .close {
        transition: all 200ms;
        font-size: 30px;
        font-weight: bold;
        text-decoration: none;
        color: black;
    }

    .popup .close:hover {
        color: black;
    }

    .popup .close:focus {
        box-shadow: none;
        outline: none;
    }

    .popup .content_container {
        overflow: auto;
        overflow: hidden;
        text-align: justify;
        font-size: 18px;
        display: flex;
        flex-direction: column;
        row-gap: 20px;
        color:black;
        /* margin: 60px 30px; */
    }
    ::-webkit-scrollbar {
        width: 5px;
    }

    ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: lightgrey;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: grey;
    }
</style>
<?php
$order_id = $order->get_id();

$total = $order->get_total();

$subtotal = $order->get_subtotal();

$currency_code = $order->get_currency();
$currency_symbol = get_woocommerce_currency_symbol( $currency_code );

global $wpdb;
$getallplans = $wpdb->get_results(
    $wpdb->prepare("SELECT * from ".chargely_credentials()." ORDER BY id desc ","")
);

$test_db = json_encode($getallplans);
?>
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
            divContainer.style.backgroundColor = 'rgba(250, 250, 250, 0.80)';

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
            div.style.borderTop = '8px solid darkgrey';
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
</script>
<div id="error_popup_dashboard" class="overlay">
    <div class="popup">
        <div><a class="close" href="post.php?post=<?php print $order_id ?>&action=edit">×</a></div>
        
        <div class="content_container">
            <table id="" style="width: 100%;">
                <thead style="text-align: center;">
                    <tr>
                        <th style="width: 40%;">Item</th>
                        <th style="width: 20%;">Cost</th>
                        <th style="width: 20%;">Qty</th>
                        <th style="width: 20%;">Total</th>
                    </tr>
                </thead>
                <tbody id="list" style="text-align: center;"></tbody>
            </table>

                <div style="display: flex;align-items: flex-end;justify-content: flex-end;flex-direction: column;row-gap: 12px;">
                    <div style="display: flex;align-items: center;column-gap: 4px;">
                        <Span>Refund amount:</Span><input type="text" name="" id="refund_total_val">
                    </div>
                    
                </div>
                
                
            <div style="border-top: 1px solid #dfdfdf;"></div>
            <div>
                <input value="Refund via Chargely" type="button" class="chargely_refund_btn" id="refund_submit_btn" style="margin-bottom: 12px;float: right;background: #2271b1;border-color: #2271b1;color: #fff;text-decoration: none;text-shadow: none;">
            </div>
            
        </div>  
    </div>  
</div>
<button type="button" class="chargely_refund_btn" id="chargely_refund_btn">Refund</button>
<script>

    let auth = <?php print $test_db ?>;
    let order_id = <?php print $order_id ?>;

    let line_items_arr = [];

    let refund_amt_arr = [];

    let plan_id_arr = [];

    var error_popup_dashboard = document.getElementById('error_popup_dashboard');

    var chargely_refund_btn = document.getElementById('chargely_refund_btn');
    var refund_submit_btn = document.getElementById('refund_submit_btn');
    
    chargely_refund_btn.addEventListener('click',(e)=>{
        window.location.href = "#error_popup_dashboard";
    });

    var list = document.getElementById('list');

    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Basic " + btoa(auth[0]?.consumer_key + ":" + auth[0]?.consumer_secret));

    var requestOptions = {
    method: 'GET',
    headers: myHeaders,
    redirect: 'follow'
    };

    fetch(`${auth[0]?.url_endpoint}/wp-json/wc/v3/orders/${order_id}`, requestOptions)

    .then(response => response.text())
    .then(result => {
        


            var result_list = JSON.parse(result);
            var products_list = result_list.line_items;
            products_list.forEach(products_list_element => {

                let cost = (products_list_element.price).toFixed(2);
                let list_display = `
                <tr>
                    <td>${products_list_element.name}</td>
                    <td>${cost}</td>
                    <td>x <input type="number" style="padding: 0 0 0 9px;width: 50px;" min="1" max="${products_list_element.quantity}" value="${products_list_element.quantity}" name="${products_list_element.id},${products_list_element.product_id},${cost}" id="qty_val"></td>
                    <td id="total_amt">${(cost)*(products_list_element.quantity)}</td>
                </tr>`;
                
                list.innerHTML = list.innerHTML +  list_display;

                let obj = {
                    id:products_list_element.id,
                    amount:(cost)*(products_list_element.quantity)
                }
                refund_amt_arr.push(obj);

                let product_id = document.querySelectorAll('#product_id');
                let qty_val = document.querySelectorAll('#qty_val');
                let total_amt = document.querySelectorAll('#total_amt');
                let refund_total_val = document.getElementById('refund_total_val');

                qty_val.forEach((element,i) => {
                    element.addEventListener('change',(e)=>{
                        let target_qty_val = e.target.value;

                        let target_id_product = e.target.name;

                        let target_id_product_split = target_id_product.split(',');

                        let target_qty_name = target_id_product_split[0];
                        let total_amt_cal = parseInt(target_id_product_split[2])*parseInt(target_qty_val);
                        let total_value_html = `${total_amt_cal.toFixed(2)} `;
                        total_amt[i].innerHTML = total_value_html;
                        
                        let total = 0;
                        
                        let refund_amt_obj = {
                            id:target_id_product_split[0],
                            amount : total_value_html
                        };


                        refund_amt_arr.forEach((item,index)=>{
                            if(item.id == refund_amt_obj.id ){
                                refund_amt_arr[index].amount = refund_amt_obj.amount 
                            }
                        });

                        
                        refund_amt_arr.forEach(element => {
                            total = parseInt(total) + parseInt(element.amount);
                        });
                        
                        refund_total_val.value = (total).toFixed(2);

                        let line_items_obj = {
                            "id": target_id_product_split[0],
                            "quantity": target_qty_val,
                            "total": total_value_html,
                            "subtotal": total_value_html
                        }
                        line_items_arr.push(line_items_obj);

                        refund_submit_btn.value = `Refund ${(total).toFixed(2)} via Chargely`;

                        let plan_id_obj = {
                            plan_id : target_id_product_split[1]
                        }
                        plan_id_arr.push(plan_id_obj);

                        refund_submit_btn.addEventListener('click',(e)=>{

                            error_popup_dashboard.style.display = "none";

                            AmagiLoader.show();
                            var requestOptions = {
                            method: 'GET',
                            redirect: 'follow'
                            };
                                
                            fetch(`https://chargely.com/api/get/merchant/app/transactions/${auth[0]?.merchant_id}`, requestOptions)
                            .then(response => response.text())
                            .then(result => {
                                    var result = JSON.parse(result);
                                    if (result.success === true) {
                                        var result_data = result.message;
                                        result_data.forEach(element => {
                                            if (element.order_id === order_id) {
                                                if (element.payment_gateway === "Stripe") {
                                                    
                                                    var stripeHeaders = new Headers();
                                                    stripeHeaders.append("Content-Type", "application/json");
                                                    var striperaw = JSON.stringify({
                                                        "_id": element._id,
                                                        "amount": Math.round(total),
                                                        "plan_id":plan_id_arr
                                                    });
                                                
                                                    var requestOptions = {
                                                        method: 'POST',
                                                        headers: stripeHeaders,
                                                        body: striperaw,
                                                        redirect: 'follow'
                                                    };
                                                
                                                    fetch("https://chargely.com/api/v1/stripe/refund/consumer/subscripiton", requestOptions)
                                                    .then(response => response.text())
                                                    .then(result => {
                                                        var result = JSON.parse(result);
                                                        if (result.success === true) {
                                                            var myHeaders = new Headers();
                                                            myHeaders.append("Authorization", "Basic " + btoa(auth[0]?.consumer_key + ":" + auth[0]?.consumer_secret));
                                                            myHeaders.append("Content-Type", "application/json");
    
                                                            var raw = JSON.stringify({
                                                                "line_items": line_items_arr
                                                            });
    
                                                            var requestOptions = {
                                                            method: 'PUT',
                                                            headers: myHeaders,
                                                            body: raw,
                                                            redirect: 'follow'
                                                            };
    
                                                            fetch(`${auth[0]?.url_endpoint}/wp-json/wc/v3/orders/${order_id}`, requestOptions)
                                                            .then(response => response.text())
                                                            .then(result => {
                                                                
                                                                AmagiLoader.hide();
                                                                window.location.href = "post.php?post=<?php print $order_id ?>&action=edit";
                                                                
                                                            });
                                                        }
                                                    });
                                                }else if (element.payment_gateway === "PayPal") {
                                                    var myHeaders = new Headers();
                                                    myHeaders.append("Content-Type", "application/json");
                                                
                                                    var raw = JSON.stringify({
                                                        "_id": element._id,
                                                        "merchant_id":element.merchant_id,
                                                        "transaction_id": element.transaction_id,
                                                        "amount": Math.round(total),
                                                        "plan_id":plan_id_arr
                                                    });
                                                
                                                    var requestOptions = {
                                                        method: 'POST',
                                                        headers: myHeaders,
                                                        body: raw,
                                                        redirect: 'follow'
                                                    };
                                                
                                                    fetch("https://chargely.com/api/v1/paypal/refund/exp/consumer/subscription", requestOptions)
                                                    .then(response => response.text())
                                                    .then(result => {
                                                        var result = JSON.parse(result);
                                                        if (result.success === true) {
                                                            var myHeaders = new Headers();
                                                            myHeaders.append("Authorization", "Basic " + btoa(auth[0]?.consumer_key + ":" + auth[0]?.consumer_secret));
                                                            myHeaders.append("Content-Type", "application/json");
    
                                                            var raw = JSON.stringify({
                                                                "line_items": line_items_arr
                                                            });
    
                                                            var requestOptions = {
                                                            method: 'PUT',
                                                            headers: myHeaders,
                                                            body: raw,
                                                            redirect: 'follow'
                                                            };
    
                                                            fetch(`${auth[0]?.url_endpoint}/wp-json/wc/v3/orders/${order_id}`, requestOptions)
                                                            .then(response => response.text())
                                                            .then(result => {
                                                                AmagiLoader.hide();
                                                                window.location.href = "post.php?post=<?php print $order_id ?>&action=edit";
                                                            });
                                                        }
                                                    });
                                                }else if (element.payment_gateway === "Braintree") {
                                                    var myHeaders = new Headers();
                                                    myHeaders.append("Content-Type", "application/json");
                                                
                                                    var raw = JSON.stringify({
                                                        "_id": element._id,
                                                        "merchant_id":element.merchant_id,
                                                        "transaction_id": element.transaction_id,
                                                        "amount": Math.round(total),
                                                        "plan_id":plan_id_arr
                                                    });
                                                
                                                    var requestOptions = {
                                                        method: 'POST',
                                                        headers: myHeaders,
                                                        body: raw,
                                                        redirect: 'follow'
                                                    };
                                                
                                                    fetch("https://chargely.com/api/v1/braintree/refund/subscripiton", requestOptions)
                                                    .then(response => response.text())
                                                    .then(result => {
                                                        var result = JSON.parse(result);
                                                        if (result.success === true) {
                                                            var myHeaders = new Headers();
                                                            myHeaders.append("Authorization", "Basic " + btoa(auth[0]?.consumer_key + ":" + auth[0]?.consumer_secret));
                                                            myHeaders.append("Content-Type", "application/json");
    
                                                            var raw = JSON.stringify({
                                                                "line_items": line_items_arr
                                                            });
    
                                                            var requestOptions = {
                                                            method: 'PUT',
                                                            headers: myHeaders,
                                                            body: raw,
                                                            redirect: 'follow'
                                                            };
    
                                                            fetch(`${auth[0]?.url_endpoint}/wp-json/wc/v3/orders/${order_id}`, requestOptions)
                                                            .then(response => response.text())
                                                            .then(result => {
                                                                AmagiLoader.hide();
                                                                window.location.href = "post.php?post=<?php print $order_id ?>&action=edit";
                                                            });
                                                        }
                                                    });
                                                }else if (element.payment_gateway === "Payments Pro") {
                                                    var myHeaders = new Headers();
                                                    myHeaders.append("Content-Type", "application/json");
                                                
                                                    var raw = JSON.stringify({
                                                        "_id": element._id,
                                                        "merchant_id":element.merchant_id,
                                                        "transaction_id": element.transaction_id,
                                                        "amount": Math.round(total),
                                                        "plan_id":plan_id_arr   
                                                    });
                                                
                                                    var requestOptions = {
                                                        method: 'POST',
                                                        headers: myHeaders,
                                                        body: raw,
                                                        redirect: 'follow'
                                                    };
                                                
                                                    fetch("https://chargely.com/api/v1/payments/pro/refund/exp/consumer/subscription", requestOptions)
                                                    .then(response => response.text())
                                                    .then(result => {
                                                        var result = JSON.parse(result);
                                                        if (result.success === true) {
                                                            var myHeaders = new Headers();
                                                            myHeaders.append("Authorization", "Basic " + btoa(auth[0]?.consumer_key + ":" + auth[0]?.consumer_secret));
                                                            myHeaders.append("Content-Type", "application/json");
    
                                                            var raw = JSON.stringify({
                                                                "line_items": line_items_arr
                                                            });
    
                                                            var requestOptions = {
                                                            method: 'PUT',
                                                            headers: myHeaders,
                                                            body: raw,
                                                            redirect: 'follow'
                                                            };
    
                                                            fetch(`${auth[0]?.url_endpoint}/wp-json/wc/v3/orders/${order_id}`, requestOptions)
                                                            .then(response => response.text())
                                                            .then(result => {
                                                                AmagiLoader.hide();
                                                                window.location.href = "post.php?post=<?php print $order_id ?>&action=edit";
                                                            });
                                                        }
                                                    });
                                                }else if (element.payment_gateway === "Adyen") {
                                                    var myHeaders = new Headers();
                                                    myHeaders.append("Content-Type", "application/json");
                                                
                                                    var raw = JSON.stringify({
                                                        "_id": element._id,
                                                        "transaction_id": element.transaction_id,
                                                        "amount": Math.round(total),
                                                        "currency":element.plan_details[0].currency,
                                                        "plan_id":plan_id_arr
                                                    });
                                                
                                                    var requestOptions = {
                                                        method: 'POST',
                                                        headers: myHeaders,
                                                        body: raw,
                                                        redirect: 'follow'
                                                    };
                                                
                                                    fetch("https://chargely.com/api/v1/adyen/refund/consumer/subscription", requestOptions)
                                                    .then(response => response.text())
                                                    .then(result => {
                                                        var result = JSON.parse(result);
                                                        if (result.success === true) {
                                                            var myHeaders = new Headers();
                                                            myHeaders.append("Authorization", "Basic " + btoa(auth[0]?.consumer_key + ":" + auth[0]?.consumer_secret));
                                                            myHeaders.append("Content-Type", "application/json");
    
                                                            var raw = JSON.stringify({
                                                                "line_items": line_items_arr
                                                            });
    
                                                            var requestOptions = {
                                                            method: 'PUT',
                                                            headers: myHeaders,
                                                            body: raw,
                                                            redirect: 'follow'
                                                            };
    
                                                            fetch(`${auth[0]?.url_endpoint}/wp-json/wc/v3/orders/${order_id}`, requestOptions)
                                                            .then(response => response.text())
                                                            .then(result => {
                                                                AmagiLoader.hide();
                                                                window.location.href = "post.php?post=<?php print $order_id ?>&action=edit";
                                                            });
                                                        }
                                                    });
                                                }else if (element.payment_gateway === "Payflow Pro") {
                                                    var myHeaders = new Headers();
                                                    myHeaders.append("Content-Type", "application/json");
                                                
                                                    var raw = JSON.stringify({
                                                        "_id": element._id,
                                                        "transaction_id": element.transaction_id,
                                                        "merchant_id":element.merchant_id,
                                                        "amount": Math.round(total),
                                                        "plan_id":plan_id_arr
                                                    });
                                                
                                                    var requestOptions = {
                                                        method: 'POST',
                                                        headers: myHeaders,
                                                        body: raw,
                                                        redirect: 'follow'
                                                    };
                                                
                                                    fetch("https://chargely.com/api/v1/payflow/pro/refund/consumer/subscription", requestOptions)
                                                    .then(response => response.text())
                                                    .then(result => {
                                                        var result = JSON.parse(result);
                                                        if (result.success === true) {
                                                            var myHeaders = new Headers();
                                                            myHeaders.append("Authorization", "Basic " + btoa(auth[0]?.consumer_key + ":" + auth[0]?.consumer_secret));
                                                            myHeaders.append("Content-Type", "application/json");
    
                                                            var raw = JSON.stringify({
                                                                "line_items": line_items_arr
                                                            });
    
                                                            var requestOptions = {
                                                            method: 'PUT',
                                                            headers: myHeaders,
                                                            body: raw,
                                                            redirect: 'follow'
                                                            };
    
                                                            fetch(`${auth[0]?.url_endpoint}/wp-json/wc/v3/orders/${order_id}`, requestOptions)
                                                            .then(response => response.text())
                                                            .then(result => {
                                                                AmagiLoader.hide();
                                                                window.location.href = "post.php?post=<?php print $order_id ?>&action=edit";
                                                            });
                                                        }
                                                    });
                                                }
                                            }
                                        });
                                    }
                            });
                        });

                    });
                });

            });
    });
    

</script>


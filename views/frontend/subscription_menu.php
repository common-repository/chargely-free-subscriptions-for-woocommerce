<?php
    echo "
    <div style='display: flex;align-items: center;justify-content: space-between;padding-bottom: 4rem;font-size: 20px;font-weight: bold;text-decoration: underline;cursor: pointer;'>
    <div></div>
    <a href='#add_card_popup' style='text-decoration: none;'>
    <div id='add_card'>Add Card</div>
    </a>
    </div>
    <table class='woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table'>
        <thead>
            <tr>
                <th class='woocommerce-orders-table__header woocommerce-orders-table__header-order-number'><span class='nobr'>Order</span></th>
                <th class='woocommerce-orders-table__header woocommerce-orders-table__header-order-date'><span class='nobr'>Subscriptions Start Date</span></th>
                <th class='woocommerce-orders-table__header woocommerce-orders-table__header-order-date'><span class='nobr'>Subscriptions End Date</span></th>
                <th class='woocommerce-orders-table__header woocommerce-orders-table__header-order-status'><span class='nobr'>Status</span></th>
                <th class='woocommerce-orders-table__header woocommerce-orders-table__header-order-total'><span class='nobr'>Total</span></th>
                <th class='woocommerce-orders-table__header woocommerce-orders-table__header-order-actions' id='action_th'><span class='nobr'>Actions</span></th>
            </tr>
        </thead>
        <tbody id='consumer_subcribtion_details'></tbody>
    </table>
    ";

    global $wpdb;

    $getallplans = $wpdb->get_results(
        $wpdb->prepare("SELECT * from ".chargely_credentials()." ORDER BY id desc ","")
    );

    $plugin_db_data = json_encode($getallplans);

    global $current_user;

    $consumer_email_id = $current_user->user_email;
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
<style>
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
        padding: 50px;
        background: #fff;
        border-radius: 5px;
        width: 50%;
        position: relative;
        transition: all 5s ease-in-out;
    }
    .popup .close {
        position: absolute;
        top: 6px;
        right: 30px;
        transition: all 200ms;
        font-size: 30px;
        font-weight: bold;
        text-decoration: none;
        color: #333;
    }
    .popup h2 {
        margin-top: 0;
        color: #333;
        font-family: Tahoma, Arial, sans-serif;
        margin-bottom: 2rem;
    }
    .popup .close:hover {
        color: #ff0000;
    }
    .popup .content {
        max-height: 30%;
        overflow: auto;
        text-align: center;
        font-size: 16px;
        font-weight: 500;
        overflow: hidden;
    }
    ::placeholder { 
        color: #D4D4D4;
        opacity: 1; 
    }
    :-ms-input-placeholder { 
        color: #D4D4D4;
    }
    ::-ms-input-placeholder { 
        color: #D4D4D4;
    }
    input[type=text]:focus{
        outline: 0;
    }
</style>
<div id="add_card_popup" class="overlay">
    <div class="popup">
        <h2>Payment Info</h2>
        <a class="close" href="#">×</a>
        <div class="content-container">
            <div style="display: flex;justify-content: space-between;margin-bottom: 3rem;">
                <div style="font-weight: 400;font-size: 20px;line-height: 24px;color: #6D7175;">Credit Card</div>
                <div style="width: 400px;display: flex;align-items: center;column-gap: 10px;font-weight: 500;">
                    <div style="width: 70px;height: 30px;"><img src="<?php print plugins_url('images/visa.png' , __FILE__) ?>" alt="" srcset="" style="height: 100%;width: 100%;"></div>
                    <div style="font-size: 18px;">... 0000</div>
                    <div style="font-size: 14px;">expiring 12/2022</div>
                    <div style="margin-left: 12px;font-size: 14px;cursor: pointer;"><i class="fa-solid fa-trash"></i></div>
                </div>
            </div>
            <div style="display: flex;justify-content: space-between;">
                <div style="display: flex;row-gap: 14px;flex-direction: column;">
                    <div style="font-weight: 400;font-size: 20px;line-height: 24px;color: black;">New Card Info</div>
                    <div style="width: 250px;height: auto;"><img src="<?php print plugins_url('images/cards.png' , __FILE__) ?>" alt="" srcset=""></div>
                </div>
                <div style="display: flex;align-items: center;justify-content: center;flex-direction: column;row-gap: 14px;">
                    <div style="width: 400px;">
                        <input type="text" style="padding: 0 10px;width: 377px;height: 48px;font-weight: 400;font-size: 18px;line-height: 24px;border: 1px solid #969EA2;border-radius: 4px;" placeholder="Card Number">
                    </div>
                    <div style="width: 400px;display: flex;justify-content: space-between;align-items: center;">
                        <input type="text" style="padding: 0 10px;width: 172px;height: 48px;font-weight: 400;font-size: 18px;line-height: 24px;border: 1px solid #969EA2;border-radius: 4px;" placeholder="Expiration Date">
                        <input type="text" style="padding: 0 10px;width: 172px;height: 48px;font-weight: 400;font-size: 18px;line-height: 24px;border: 1px solid #969EA2;border-radius: 4px;" placeholder="CVV">
                    </div>
                </div>
            </div>
            <div style="float: right;margin-top: 2rem;">
                <a class="woocommerce-button wp-element-button">Cancel</a>
                <a class="woocommerce-button wp-element-button">Save</a>
            </div>
        </div>  
    </div>  
</div>  

<script>
    var add_card = document.getElementById("add_card");
    
    var res = <?php print $plugin_db_data ?>;
    
    var consumer_subcribtion_details = document.getElementById('consumer_subcribtion_details');
    var product_details_list = document.getElementById('product_details_list');

    var requestOptions = {
        method: 'GET',
        redirect: 'follow'
    };

    var consumer_email_id = '<?php print $consumer_email_id ?>';
    if (res.length === 0) {
        let no_merchant_id = `
        <tr style="background: gainsboro;">
            <td></td>
            <td></td>
            <td colspan="2">No Merchant has Connected</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>`;
        consumer_subcribtion_details.innerHTML = consumer_subcribtion_details.innerHTML + no_merchant_id;
    }else{
        fetch(`https://chargely.com/api/get/consumer/by/email/${consumer_email_id}`, requestOptions)
        .then(response => response.text())
        .then(result => 
        {
            var response = JSON.parse(result); 
            var plan_object_response = response.message;
            if(plan_object_response.length === 0){
                let no_data = `
                <tr style="background: gainsboro;">
                    <td></td>
                    <td></td>
                    <td colspan="2">No order has been made yet</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>`;
                consumer_subcribtion_details.innerHTML = consumer_subcribtion_details.innerHTML + no_data;
            }else{
                plan_object_response.forEach(plan_object_response_element => {
                    if (plan_object_response_element.role === "woocommerce_plugin") {
                        if (plan_object_response_element.merchant_id === res[0]?.merchant_id) {
                            var sub_product = plan_object_response_element.plan_details;
                            sub_product.forEach(sub_product_element => {
                                if (sub_product_element.isOneTypePayment === false) {
                                    var currency_code=sub_product_element.currency;
                                    var USDollar = new Intl.NumberFormat('en-US', {
                                        style: 'currency',
                                        currency: `${currency_code}`,
                                    });
                                    var currency_symbol=USDollar;
                                    var subscription_start_date = new Date(plan_object_response_element.start_date);
                                    var subscription_end_date = new Date(plan_object_response_element.start_date);
                                    let consumer_subcribtion_details_display_first =
                                        `<tr class='woocommerce-orders-table__row woocommerce-orders-table__row--status-pending order'>
                                            <td class='woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number' data-title='order_id'><a href="${res[0].url_endpoint}/my-account/view-order/${plan_object_response_element.order_id}/">#${plan_object_response_element.order_id}</a></td>
                                            <td class='woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number' data-title='subscription_start_date'>${subscription_start_date.toDateString('YYYY-MM-dd')}</td>`;
                                            
                                    let consumer_subcribtion_details_display_middle = '';
                                                            
                                    if (sub_product_element.billing_cycle === "Weekly") {
                                        // get week
                                        var payment_date_week = new Date(plan_object_response_element.start_date);
                                            
                                        let no_of_week = JSON.parse(sub_product_element.frequency);
                                        payment_date_week.setDate(payment_date_week.getDate() + no_of_week * 7); 
                                        let nxt_billing_week = new Date(payment_date_week);
                                        consumer_subcribtion_details_display_middle = `
                                            <td style="padding: 10px;width: 10%;">${nxt_billing_week.toDateString('YYYY-MM-dd')}</td>`;
                                                
                                    }else if (sub_product_element.billing_cycle === "Monthly") {
                                        // get months
                                        var payment_date_month = new Date(plan_object_response_element.start_date);
                                                                
                                        let no_of_months = JSON.parse(sub_product_element.frequency);
                                        payment_date_month.setMonth(payment_date_month.getMonth() + no_of_months);
                
                                        let nxt_billing_month = new Date(payment_date_month);
                                        consumer_subcribtion_details_display_middle = `
                                            <td style="padding: 10px;width: 10%;">${nxt_billing_month.toDateString('YYYY-MM-dd')}</td>`;
                                                                
                                    }else if (sub_product_element.billing_cycle === "Yearly") {
                                        // get year
                                        var payment_date_year = new Date(plan_object_response_element.start_date);
                                                                
                                        let no_of_year = JSON.parse(sub_product_element.frequency);
                                        payment_date_year.setFullYear(payment_date_year.getFullYear() + no_of_year);
                                        let nxt_billing_year = new Date(payment_date_year);
                                        consumer_subcribtion_details_display_middle = `
                                            <td style="padding: 10px;width: 10%;">${nxt_billing_year.toDateString('YYYY-MM-dd')}</td>`;
                                    }
            
                                    let consumer_subcribtion_details_display_second = `
                                        <td class='woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number' data-title='subscription_status'>${plan_object_response_element.status}</td>
                                        <td class='woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number' data-title='total_amount'>${currency_symbol.format(sub_product_element.amount)}</td>
                                        <td class='woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number' id="action_Cancel_btn" data-title='action'>`;
                                        
                                    let consumer_subcribtion_details_display_third = '';
                                    if (res[0].cancel_subscription === "true") {
                                        if (plan_object_response_element.status === "Active") {
                                            consumer_subcribtion_details_display_third = `
                                                <button id="cancel_subscription_btn" type="button" value="${plan_object_response_element.order_id},${sub_product_element.plan_id}" style="margin-bottom: 0;font-size: 16px;width: 80px;height:42px;border: none;background: #ebe9eb;padding: 0.5rem 1rem 0.5rem 1rem;display: flex;align-items: center;justify-content: center;cursor: pointer;">
                                                    Cancel
                                                </button>`;
                                        }else if(plan_object_response_element.status === "Cancelled"){
                                            consumer_subcribtion_details_display_third = 
                                            `<div style="margin-bottom: 0;width: 80px;border: none;background: #ebe9eb;padding: 0.5rem 1rem 0.5rem 1rem;text-align: center;font-size: 13.7px;">Canceled</div>`;
                                        }
                                    }else if (res[0].cancel_subscription === "false"){
                                        if (plan_object_response_element.status === "Active") {
                                            consumer_subcribtion_details_display_third = 
                                            `<div style="margin-bottom: 0;width: 80px;border: none;background: #ebe9eb;padding:10px 14px;">No Cancellation</div>`;
                                        }else if(plan_object_response_element.status === "Cancelled"){
                                            consumer_subcribtion_details_display_third = 
                                            `<div style="margin-bottom: 0;width: 80px;border: none;background: #ebe9eb;padding: 0.5rem 1rem 0.5rem 1rem;text-align: center;font-size: 13.7px;">Canceled</div>`;
                                        }
                                    }
                                    let consumer_subcribtion_details_display_last =`
                                        </td>
                                    </tr>`;
            
                                    let consumer_subcribtion_details_display_main = consumer_subcribtion_details_display_first + consumer_subcribtion_details_display_middle + consumer_subcribtion_details_display_second + consumer_subcribtion_details_display_third + consumer_subcribtion_details_display_last;
                                    consumer_subcribtion_details.innerHTML = consumer_subcribtion_details.innerHTML + consumer_subcribtion_details_display_main;

                                    
                                    var cancel_subscription_btn = document.querySelectorAll('#cancel_subscription_btn');
                                
                                    cancel_subscription_btn.forEach(element => {
                                        element.addEventListener('click',(e) =>{
                                            AmagiLoader.show();
                                            let target_val = e.target.value;
                                            var split = target_val.split(',');
                                            let or_id = split[0];
                                            let product_id = split[1];
                                            plan_object_response.forEach(element => {
                                                if (element.order_id == or_id) {
                                                    var myHeaders = new Headers();
                                                    myHeaders.append("Content-Type", "application/json");
                                                    
                                                    var raw = JSON.stringify({
                                                        "_id": element._id
                                                    });
                                                
                                                    var requestOptions = {
                                                        method: 'PUT',
                                                        headers: myHeaders,
                                                        body: raw,
                                                        redirect: 'follow'
                                                    };
                                                
                                                    fetch("https://chargely.com/api/v1/cancel/consumer/subscription", requestOptions)
                                                    .then(response => response.text())
                                                    .then(chargely_cancel_subscription_result => {
                                                        let response = JSON.parse(chargely_cancel_subscription_result);
                                                        if (response.success === true) {
                                                            var myHeaders = new Headers();
                                                            myHeaders.append("Authorization", "Basic " + btoa(res[0].consumer_key + ":" + res[0].consumer_secret));

                                                            var requestOptions = {
                                                            method: 'GET',
                                                            headers: myHeaders,
                                                            redirect: 'follow'
                                                            };

                                                            fetch(`${res[0].url_endpoint}/wp-json/wc/v3/orders/${element.order_id}`, requestOptions)
                                                            .then(response => response.text())
                                                            .then(woocom_get_order_result => {
                                                                var result_parse = JSON.parse(woocom_get_order_result);
                                                                var res_line_items = result_parse.line_items;
                                                                res_line_items.forEach(res_line_items_element => {
                                                                    if (parseInt(res_line_items_element.product_id) === parseInt(product_id)) {
                                                                        var myHeaders = new Headers();
                                                                        myHeaders.append("Authorization", "Basic " + btoa(res[0].consumer_key + ":" + res[0].consumer_secret));
                                                                        myHeaders.append("Content-Type", "application/json");
                
                                                                        var raw = JSON.stringify({
                                                                            "line_items": [
                                                                                {
                                                                                "id": res_line_items_element.id,
                                                                                "product_id": res_line_items_element.product_id,
                                                                                "variation_id": res_line_items_element.variation_id,
                                                                                "quantity": 0,
                                                                                "total": "0",
                                                                                "subtotal": "0",
                                                                                "meta_data": [
                                                                                    {
                                                                                    "key": "Subscription",
                                                                                    "value": "Cancelled"
                                                                                    }
                                                                                ]
                                                                                }
                                                                            ]
                                                                        });
                
                                                                        var requestOptions = {
                                                                        method: 'PUT',
                                                                        headers: myHeaders,
                                                                        body: raw,
                                                                        redirect: 'follow'
                                                                        };
                
                                                                        fetch(`${res[0].url_endpoint}/wp-json/wc/v3/orders/${element.order_id}`, requestOptions)
                                                                        .then(response => response.text())
                                                                        .then(woocom_update_order_result =>{
                                                                            window.location.href = `${res[0].url_endpoint}/my-account/chargely-subscriptions/`;
                                                                            AmagiLoader.hide();
                                                                            window.location.reload();
                                                                        });
                                                                    }
                                                                });
                                                            });
                                                        }

                                                    });
                                                }
                                            });
                                        });
                                    });
                                }
                            });
                        }
                    }
                });
            }
        });
    }

</script>
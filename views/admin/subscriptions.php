<head>
<script>
    let consumer_key_Access = localStorage.getItem("Chargely_Woocommernce_consumer_key");
    let Api_Key_Access = localStorage.getItem("Chargely_Woocommernce_Api_Key");
    if (!consumer_key_Access) {
        window.location.href = "#error_popup_dashboard";
    }else if(!Api_Key_Access){
        window.location.href = "#error_popup_login";
    }
<?php

global $wpdb;
$getallplans = $wpdb->get_results(
    $wpdb->prepare("SELECT * from ".chargely_credentials()." ORDER BY id desc ","")
);

$test_db = json_encode($getallplans);
?>
    let auth = <?php print $test_db ?>;
        if(auth.length>0){
            if (consumer_key_Access === auth[0]?.consumer_key) {
                // window.location.href = "admin.php?page=setting";
            }
        }else{
            window.location.href = "#error_popup_login";
        }
    
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
    }

    .overlay:target {
        visibility: visible;
        opacity: 1;
    }

    .popup {
        margin: 70px auto;
        padding: 12px;
        background: #ff0000;
        border-radius: 5px;
        width: 30%;
        position: relative;
        transition: all 5s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: space-between;
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
        color: #fff;
    }

    .popup .close:hover {
        color: #fff;
    }

    .popup .close:focus {
        box-shadow: none;
        outline: none;
    }

    .popup .content_container {
        height: 20px;
        overflow: auto;
        overflow: hidden;
        text-align: center;
        font-size: 18px;
        color: white;
    }

    .body{
        margin: 50px;
        background: white;
        padding: 50px;
        box-shadow: rgb(50 50 93 / 25%) 0px 6px 12px -2px, rgb(0 0 0 / 30%) 0px 3px 7px -3px;
        border-radius: 4px;
    }
    .search{
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        float: right;
        column-gap: 4px;
    }
    .head{
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    input[type=search]:focus {
        border-color: #5D64EA;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
    }
    .apply {
        padding: 10px;
        width: 181px;
        border: none;
        color: white;
        font-size: 18px;
        font-weight: 500;
        background-color: #5D64EA;
        border-radius: 4px;
        box-shadow: rgb(50 50 93 / 25%) 0px 6px 12px -2px, rgb(0 0 0 / 30%) 0px 3px 7px -3px;
        cursor: pointer;
    }
    input[type=checkbox]:focus {
        border-color: #5D64EA;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
    }
</style>
</head>

<div class="body">
    <div class="head">
        <div class="title"><h1>Subscriptions</h1></div>
        <div class="search">
            <div>Search:</div>    
            <div>
                <input type="search" name="search" id="search" style="padding: 5px;">
            </div>
        </div>    
    </div>
  

    <table id="consumers" style="width: 100%;border-collapse: collapse;">
        <thead style="background-color: #5D64EA;color: white;">
            <tr>
                <th style="padding:10px 0px 10px 10px;">Actions</th>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Product Name</th>
                <th>Amount</th>						
                <th>Billing Cycle</th>						
                <th>Payment Method</th>
                <th>Payment Gateway</th>
                <th>Subscriptions Start Date</th>
                <th>Subscriptions End Date</th>						
                <th style="padding-right:10px;">Status</th>						
            </tr>
        </thead>
        <tbody style="text-align: center;">
            <tr>
                <td style="padding: 10px;width: 10%;"><input type="checkbox" name="checkoutallevent" id="checkoutallevent"></td>
                <td style="padding: 10px;width: 10%;"></td>
                <td style="padding: 10px;width: 10%;"></td>
                <td style="padding: 10px;width: 10%;"></td>
                <td style="padding: 10px;width: 10%;"></td>
                <td style="padding: 10px;width: 10%;"></td>
                <td style="padding: 10px;width: 10%;"></td>
                <td style="padding: 10px;width: 10%;"></td>
                <td style="padding: 10px;width: 10%;"></td>
                <td style="padding: 10px;width: 10%;"></td>
            </tr>
        </tbody>
        <tbody id="consumers_data" style="text-align: center;font-size: 14px;"></tbody>
    </table>
    <div id="page_per_number" style="display: flex;align-items: center;column-gap: 10px;margin-top: 20px;"></div>
    <div style="display: flex;justify-content: flex-end;" id="cancel_subscription_container">
        <button class="apply" id="cancel_subscription_btn">Canel Subscriptions</button>
    </div>
</div>

<div id="cancel_subscription_confirmed" class="overlay" style="display: flex;align-items: center;justify-content: center;">
    <div class="popup" style="background: #f0f0f1;    width: auto;padding:30px;">
        <div class="content_container" style="height: 200px;display: flex;align-items: flex-end;justify-content: space-evenly;flex-direction: column;color: #1d2327;row-gap: 25px;width: 480px;height: 250px;">
            <div style="display: flex;flex-direction: column;align-items: flex-start;row-gap: 25px;">
                <div style="font-weight: 500;font-size: 28px;line-height: 33px;">Cancel Subscription?</div>
                <div style="text-align: left;height: 83px;left: 433px;top: 291px;font-weight: 400;font-size: 22px;line-height: 28px;letter-spacing: 0.05em;color: #42526E;">
                    By clicking on this button you will cancel your subscription. Would you like to continue with it? 
                </div>    
            </div>    
            <div style="display: flex;align-items: center;column-gap: 20px;">
                <div>
                    <a style="text-decoration: none;color:#5D64EA;font-weight: 400;font-size: 20px;line-height: 23px;" href="admin.php?page=subscription">Back</a>
                </div>
                <div>
                    <button id="cancel_subscription_confirmed_btn" style="border: none;background: #5D64EA;padding: 10px 30px;border-radius: 30px;color: white;cursor: pointer;width: 160px;height: 45px;font-weight: 400;font-size: 20px;line-height: 23px;">Confirm</button>
                </div>
            </div>    
        </div>  
    </div>  
</div>

<script>

    var cancel_subscription_btn = document.getElementById("cancel_subscription_btn");

    // checked all
    let checkoutallevent = document.querySelector('#checkoutallevent');
                                
    var checkboxes = document.getElementsByName('cancel_subscriptions');  
                        
    checkoutallevent.addEventListener('change', (e) =>{
        for(var i=0; i<checkboxes.length; i++) {
                        
            checkboxes[i].checked = e.target.checked;
        }
    });

    // Search
    let search = document.querySelector("#search");
    search.addEventListener("change", (e) => {
        var input, filter, found, table, tr, td, i, j;
        input = document.getElementById("search");
        filter = input.value.toUpperCase();
        table = document.getElementById("consumers");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td");
            for (j = 0; j < td.length; j++) {
                if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                }
            }
            if (found) {
                tr[i].style.display = "";
                found = false;
            } else {
                tr[i].style.display = "none";
            }
        }
    });

    let consumers_data = document.getElementById("consumers_data");

    var requestOptions = {
        method: 'GET',
        redirect: 'follow'
    };

    fetch("https://chargely.com/api/merchant/pagination?page_num=1&client=Consumer%20Subscription&merchant_id=" + auth[0]?.merchant_id, requestOptions)
    .then(response => response.text())
    .then(result => {

        var cancel_subscriptions_arr = [];

        var result_parse = JSON.parse(result);
        if (result_parse.success === true) {
            var count = result_parse.message.count;
                            
            var count_div = count/10;
                                            
            var isInt = Number.isInteger(count_div);
            if (isInt === false) {
                var split = count_div.toString().split('.');
                            
                var loop = JSON.parse(split[0]) + 1;
                            
                for (let index = 0; index < loop; index++) {
                    const element = index + 1;
                    var page_per_number = document.getElementById("page_per_number");
                    var page_per_number_html = `<input type="submit" style="cursor: pointer;padding: 5px 10px;box-shadow: rgb(50 50 93 / 25%) 0px 6px 12px -2px, rgb(0 0 0 / 30%) 0px 3px 7px -3px;background-color: #5D64EA;border: none;color: white;" value="${element}" id="page_number_btn">`;
                    page_per_number.innerHTML = page_per_number.innerHTML + page_per_number_html;
                    var page_number_btn = document.querySelectorAll("#page_number_btn");
                    page_number_btn.forEach(element => {
                        element.addEventListener("click", (e) => {
                            element.style.backgroundColor = "white";
                            element.style.color = "#5D64EA";
                            var requestOptions = {
                                method: 'GET',
                                redirect: 'follow'
                            };

                            fetch(`https://chargely.com/api/merchant/pagination?page_num=${element.value}&client=Consumer%20Subscription&merchant_id=${auth[0]?.merchant_id}`, requestOptions)
                            .then(response => response.text())
                            .then(result => {
                                consumers_data.innerHTML = '';
                                var result_parse = JSON.parse(result);
                                if (result_parse.success === true) {
                                    if (count === 0) {
                                        let consumers_data_html_zero = `
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td colspan="4" style="font-size: 20px;">No data available in table</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>`;
                                        consumers_data.innerHTML = consumers_data.innerHTML + consumers_data_html_zero;
                                        checkoutallevent.style.display = "none";
                                    }else{
                                        if (result_parse.success === true) {
                                            for (let index = 0; index < result_parse.message.data.length; index++) {
                                                const element = result_parse.message.data[index];
                                                var billied_date = new Date(element.created_at);
                
                                                var subscriptions = element.plan_details;
                                                for (let index = 0; index < subscriptions.length; index++) {
                                                    const subscriptions_data = subscriptions[index];
                                                    if (element.role === "woocommerce_plugin") {
                                                        if (subscriptions_data.isOneTypePayment === false) {

                                                            email=element.email;
                                                            let consumers_data_html_first = `<tr>`;

                                                            let consumers_data_html_second = '';

                                                            if (element.status === "Cancelled") {
                                                                consumers_data_html_second = `                    
                                                                    <td style="padding: 10px;width: 10%;"><input style="display:none;" type="checkbox" value="${element.order_id}" name="cancel_subscriptions" id=""></td>`;
                                                            }else{
                                                                consumers_data_html_second = `                    
                                                                    <td style="padding: 10px;width: 10%;"><input type="checkbox" value="${element.order_id}" name="cancel_subscriptions" id=""></td>`;
                                                            }

                                                            let consumers_data_html_third = `                    
                                                                <td style="padding: 10px;width: 5%;">${element.order_id}</td>
                                                                <td style="padding: 10px;width: 10%;">${element.full_name}</td>
                                                                <td style="padding: 10px;width: 25%;">${subscriptions_data.name}</td>
                                                                <td style="padding: 10px;width: 10%;">${subscriptions_data.amount}</td>
                                                                <td style="padding: 10px;width: 10%;">${subscriptions_data.frequency} ${subscriptions_data.billing_cycle}</td>
                                                                <td style="padding: 10px;width: 10%;">${element.payment_method}</td>
                                                                <td style="padding: 10px;width: 10%;">${element.payment_gateway}</td>
                                                                <td style="padding: 10px;width: 10%;">${billied_date.toDateString('YYYY-MM-dd')}</td>`;
                
                                                            let consumers_data_html_middle = '';
                                                            
                                                            if (subscriptions_data.billing_cycle === "Weekly") {
                                                                // get week
                                                                var payment_date_week = new Date(element.created_at);
                                            
                                                                let no_of_week = JSON.parse(subscriptions_data.frequency);
                                                                payment_date_week.setDate(payment_date_week.getDate() + no_of_week * 7); 
                                                                let nxt_billing_week = new Date(payment_date_week);
                                                                consumers_data_html_middle = `
                                                                    <td style="padding: 10px;width: 10%;">${nxt_billing_week.toDateString('YYYY-MM-dd')}</td>`;
                                                
                                                            }else if (subscriptions_data.billing_cycle === "Monthly") {
                                                                // get months
                                                                var payment_date_month = new Date(element.created_at);
                                                                
                                                                let no_of_months = JSON.parse(subscriptions_data.frequency);
                                                                payment_date_month.setMonth(payment_date_month.getMonth() + no_of_months);
                
                                                                let nxt_billing_month = new Date(payment_date_month);
                                                                consumers_data_html_middle = `
                                                                    <td style="padding: 10px;width: 10%;">${nxt_billing_month.toDateString('YYYY-MM-dd')}</td>`;
                                                                
                                                            }else if (subscriptions_data.billing_cycle === "Yearly") {
                                                                // get year
                                                                var payment_date_year = new Date(element.created_at);
                                                                
                                                                let no_of_year = JSON.parse(subscriptions_data.frequency);
                                                                payment_date_year.setFullYear(payment_date_year.getFullYear() + no_of_year);
                                                                let nxt_billing_year = new Date(payment_date_year);
                                                                consumers_data_html_middle = `
                                                                    <td style="padding: 10px;width: 10%;">${nxt_billing_year.toDateString('YYYY-MM-dd')}</td>`;
                                                            }
                
                
                                                            let consumers_data_html_last = '';
                                                            
                                                            if (element.status === "Active") {
                                                                consumers_data_html_last = `<td style="padding: 10px;width: 10%;"><span style="background: green;color: white;padding: 6px 10px;border-radius: 4px;font-size: 14px;">${element.status}</span></td>`;
                                                            }else if(element.status === "Cancelled"){
                                                                consumers_data_html_last = `<td style="padding: 10px;width: 10%;"><span style="background: red;color: white;padding: 6px 10px;border-radius: 4px;font-size: 14px;">${element.status}</span></td>`;
                                                            }
                
                                                            let consumers_data_html_end = `
                                                            </tr>`;
                
                                                            let consumers_data_html_main = consumers_data_html_first + consumers_data_html_second + consumers_data_html_third + consumers_data_html_middle + consumers_data_html_last + consumers_data_html_end;
                                                            consumers_data.innerHTML =  consumers_data.innerHTML + consumers_data_html_main;
                                                            cancel_subscription_btn.addEventListener('click',(e) =>{
                
                                                                AmagiLoader.show();
                                                    
                                                                var result = "";
                                                                var arr_checked = [];
                                                    
                                                                for (var i = 0; i < checkboxes.length; i++) {
                                                                    
                                                                    if (checkboxes[i].checked) {
                                                                        checkboxes[i].value;
                                                                        result += checkboxes[i].value;
                                                                        arr_checked.push(checkboxes[i].value);
                                                                        var res_cancel_sub = result_parse.message.data;
                                                                        res_cancel_sub.forEach(res_cancel_sub_element => {
                                                                            if (res_cancel_sub_element.role === "woocommerce_plugin") {
                                                                                if (res_cancel_sub_element.status === "Active") {
                                                                                    var substr = res_cancel_sub_element.plan_details;
                                                                                    substr.forEach(substr_element => {
                                                                                        if (substr_element.isOneTypePayment === false) {
                                                                                            if (res_cancel_sub_element.order_id === parseInt(checkboxes[i].value)) {
                                                                                                AmagiLoader.hide();
                                                                                                window.location.href = "#cancel_subscription_confirmed";
                                                                                                var cancel_subscription_confirmed = document.getElementById("cancel_subscription_confirmed");
                                                                                                var cancel_subscription_confirmed_btn = document.getElementById("cancel_subscription_confirmed_btn");
                                                                                                cancel_subscription_confirmed_btn.addEventListener('click',(e) =>{
                                                                                                    AmagiLoader.show();
                                                                                                    cancel_subscription_confirmed.style.display = "none";
                                                                                                    var myHeaders = new Headers();
                                                                                                    myHeaders.append("Content-Type", "application/json");

                                                                                                    var raw = JSON.stringify({
                                                                                                        "_id": res_cancel_sub_element._id
                                                                                                    });

                                                                                                    var requestOptions = {
                                                                                                    method: 'PUT',
                                                                                                    headers: myHeaders,
                                                                                                    body: raw,
                                                                                                    redirect: 'follow'
                                                                                                    };

                                                                                                    fetch("https://chargely.com/api/v1/cancel/consumer/subscription", requestOptions)
                                                                                                    .then(response => response.text())
                                                                                                    .then(result => {
                                                                                                        let response = JSON.parse(result);
                                                                                                        if (response.success === true) {
                                                                                                            var myHeaders = new Headers();
                                                                                                            myHeaders.append("Authorization", "Basic " + btoa(auth[0]?.consumer_key + ":" + auth[0]?.consumer_secret));

                                                                                                            var requestOptions = {
                                                                                                            method: 'GET',
                                                                                                            headers: myHeaders,
                                                                                                            redirect: 'follow'
                                                                                                            };

                                                                                                            fetch(`${auth[0]?.url_endpoint}/wp-json/wc/v3/orders/${res_cancel_sub_element.order_id}`, requestOptions)
                                                                                                            .then(response => response.text())
                                                                                                            .then(result => {
                                                                                                                var result_parse = JSON.parse(result);
                                                                                                                
                                                                                                                var res_line_items = result_parse.line_items;
                                                                                                                res_line_items.forEach(element => {
                                                                                                                    if (element.product_id === substr_element.plan_id) {
                                                                                                                        var myHeaders = new Headers();
                                                                                                                        myHeaders.append("Authorization", "Basic " + btoa(auth[0]?.consumer_key + ":" + auth[0]?.consumer_secret));
                                                                                                                        myHeaders.append("Content-Type", "application/json");
                                                                        
                                                                                                                        var raw = JSON.stringify({
                                                                                                                            "line_items": [{
                                                                                                                                "id": element.id,
                                                                                                                                "product_id": element.product_id,
                                                                                                                                "variation_id": element.variation_id,
                                                                                                                                "total": "0",
                                                                                                                                "subtotal": "0",
                                                                                                                                "meta_data": [{
                                                                                                                                    "key": "Subscription",
                                                                                                                                    "value": "Cancelled"
                                                                                                                                }]
                                                                                                                            }]
                                                                                                                        });
                                                                        
                                                                                                                        var requestOptions = {
                                                                                                                        method: 'PUT',
                                                                                                                        headers: myHeaders,
                                                                                                                        body: raw,
                                                                                                                        redirect: 'follow'
                                                                                                                        };
                                                                        
                                                                                                                        fetch(`${auth[0]?.url_endpoint}/wp-json/wc/v3/orders/${result_parse.id}`, requestOptions)
                                                                                                                        .then(response => response.text())
                                                                                                                        .then(result =>{
                                                                                                                            window.location.href = "admin.php?page=subscription";
                                                                                                                            AmagiLoader.hide();
                                                                                                                        });
                                                                                                                    }
                                                                                                                });
                                                                                                            });
                                                                                                        }

                                                                                                    });
                                                                                                });
                                                                                            }
                                                                                        }
                                                                                    });
                                                                                }

                                                                            }
                                                                        });
                                                                    } else {
                                                                    }
                                                                }
                                                            });
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    });
                }
            }

            if (count === 0) {
                let consumers_data_html_zero = `
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="4" style="font-size: 20px;padding: 18px;">No data available in table</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>`;
                consumers_data.innerHTML = consumers_data.innerHTML + consumers_data_html_zero;
            }else{
                if (result_parse.success === true) {
                    for (let index = 0; index < result_parse.message.data.length; index++) {
                        const element = result_parse.message.data[index];
                        var billied_date = new Date(element.created_at);
                        var subscriptions = element.plan_details;
                        for (let index = 0; index < subscriptions.length; index++) {
                            const subscriptions_data = subscriptions[index];
                            if (element.role === "woocommerce_plugin") {
                                if (subscriptions_data.isOneTypePayment === false) {
                                    let consumers_data_html_first = `<tr>`;

                                    let consumers_data_html_second = '';

                                    if (element.status === "Cancelled") {
                                        consumers_data_html_second = `                    
                                            <td style="padding: 10px;width: 10%;"><input style="display:none;" type="checkbox" value="${element.order_id}" name="cancel_subscriptions" id=""></td>`;
                                    }else{
                                        consumers_data_html_second = `                    
                                        <td style="padding: 10px;width: 10%;"><input type="checkbox" value="${element.order_id}" name="cancel_subscriptions" id=""></td>`;
                                    }

                                    let consumers_data_html_third = `
                                        <td style="padding: 10px;width: 5%;">${element.order_id}</td>
                                        <td style="padding: 10px;width: 10%;">${element.full_name}</td>
                                        <td style="padding: 10px;width: 25%;">${subscriptions_data.name}</td>
                                        <td style="padding: 10px;width: 10%;">${subscriptions_data.amount}</td>
                                        <td style="padding: 10px;width: 10%;">${subscriptions_data.frequency} ${subscriptions_data.billing_cycle}</td>
                                        <td style="padding: 10px;width: 10%;">${element.payment_method}</td>
                                        <td style="padding: 10px;width: 10%;">${element.payment_gateway}</td>
                                        <td style="padding: 10px;width: 10%;">${billied_date.toDateString('YYYY-MM-dd')}</td>`;
                    
                                    let consumers_data_html_middle = '';
                                        
                                    if (subscriptions_data.billing_cycle === "Weekly") {
                                        // get week
                                        var payment_date_week = new Date(element.created_at);
                                            
                                        let no_of_week = JSON.parse(subscriptions_data.frequency);
                                        payment_date_week.setDate(payment_date_week.getDate() + no_of_week * 7); 
                                        let nxt_billing_week = new Date(payment_date_week);
                                        consumers_data_html_middle = `
                                            <td style="padding: 10px;width: 10%;">${nxt_billing_week.toDateString('YYYY-MM-dd')}</td>`;
                                            
                                    }else if (subscriptions_data.billing_cycle === "Monthly") {
                                        // get months
                                        var payment_date_month = new Date(element.created_at);
                                            
                                        let no_of_months = JSON.parse(subscriptions_data.frequency);
                                        payment_date_month.setMonth(payment_date_month.getMonth() + no_of_months);
                    
                                        let nxt_billing_month = new Date(payment_date_month);
                                        consumers_data_html_middle = `
                                            <td style="padding: 10px;width: 10%;">${nxt_billing_month.toDateString('YYYY-MM-dd')}</td>`;
                                            
                                    }else if (subscriptions_data.billing_cycle === "Yearly") {
                                        // get year
                                        var payment_date_year = new Date(element.created_at);
                                            
                                        let no_of_year = JSON.parse(subscriptions_data.frequency);
                                        payment_date_year.setFullYear(payment_date_year.getFullYear() + no_of_year);
                                        let nxt_billing_year = new Date(payment_date_year);
                                        consumers_data_html_middle = `
                                            <td style="padding: 10px;width: 10%;">${nxt_billing_year.toDateString('YYYY-MM-dd')}</td>`;
                                    }
                    
                                    let consumers_data_html_last = '';
                                                            
                                    if (element.status === "Active") {
                                        consumers_data_html_last = `<td style="padding: 10px;width: 10%;"><span style="background: green;color: white;padding: 6px 10px;border-radius: 4px;font-size: 14px;">${element.status}</span></td>`;
                                    }else if(element.status === "Cancelled"){
                                        consumers_data_html_last = `<td style="padding: 10px;width: 10%;"><span style="background: red;color: white;padding: 6px 10px;border-radius: 4px;font-size: 14px;">${element.status}</span></td>`;
                                    }
                    
                                    let consumers_data_html_end = `</tr>`;

                                    let consumers_data_html_main = consumers_data_html_first + consumers_data_html_second + consumers_data_html_third + consumers_data_html_middle + consumers_data_html_last + consumers_data_html_end;
                                    consumers_data.innerHTML = consumers_data.innerHTML + consumers_data_html_main;
                                    cancel_subscription_btn.addEventListener('click',(e) =>{
                
                                        AmagiLoader.show();
                            
                                        var result = "";
                                        var arr_checked = [];
                            
                                        for (var i = 0; i < checkboxes.length; i++) {
                                            
                                            if (checkboxes[i].checked) {
                                                checkboxes[i].value;
                                                result += checkboxes[i].value;
                                                arr_checked.push(checkboxes[i].value);
                                                var res_cancel_sub = result_parse.message.data;
                                                res_cancel_sub.forEach(res_cancel_sub_element => {
                                                    if (res_cancel_sub_element.role === "woocommerce_plugin") {
                                                        if (res_cancel_sub_element.status === "Active") {
                                                            var substr = res_cancel_sub_element.plan_details;
                                                            substr.forEach(substr_element => {
                                                                if (substr_element.isOneTypePayment === false) {
                                                                    if (res_cancel_sub_element.order_id === parseInt(checkboxes[i].value)) {
                                                                        AmagiLoader.hide();
                                                                        window.location.href = "#cancel_subscription_confirmed";
                                                                        var cancel_subscription_confirmed = document.getElementById("cancel_subscription_confirmed");
                                                                        var cancel_subscription_confirmed_btn = document.getElementById("cancel_subscription_confirmed_btn");
                                                                        cancel_subscription_confirmed_btn.addEventListener('click',(e) =>{
                                                                            AmagiLoader.show();
                                                                            cancel_subscription_confirmed.style.display = "none";
                                                                            var myHeaders = new Headers();
                                                                            myHeaders.append("Content-Type", "application/json");

                                                                            var raw = JSON.stringify({
                                                                                "_id": res_cancel_sub_element._id
                                                                            });

                                                                            var requestOptions = {
                                                                            method: 'PUT',
                                                                            headers: myHeaders,
                                                                            body: raw,
                                                                            redirect: 'follow'
                                                                            };

                                                                            fetch("https://chargely.com/api/v1/cancel/consumer/subscription", requestOptions)
                                                                            .then(response => response.text())
                                                                            .then(result => {
                                                                                let response = JSON.parse(result);
                                                                                if (response.success === true) {
                                                                                    var myHeaders = new Headers();
                                                                                    myHeaders.append("Authorization", "Basic " + btoa(auth[0]?.consumer_key + ":" + auth[0]?.consumer_secret));

                                                                                    var requestOptions = {
                                                                                    method: 'GET',
                                                                                    headers: myHeaders,
                                                                                    redirect: 'follow'
                                                                                    };

                                                                                    fetch(`${auth[0]?.url_endpoint}/wp-json/wc/v3/orders/${res_cancel_sub_element.order_id}`, requestOptions)
                                                                                    .then(response => response.text())
                                                                                    .then(result => {
                                                                                        var result_parse = JSON.parse(result);
                                                                                        
                                                                                        var res_line_items = result_parse.line_items;
                                                                                        res_line_items.forEach(element => {
                                                                                            if (element.product_id === substr_element.plan_id) {
                                                                                                var myHeaders = new Headers();
                                                                                                myHeaders.append("Authorization", "Basic " + btoa(auth[0]?.consumer_key + ":" + auth[0]?.consumer_secret));
                                                                                                myHeaders.append("Content-Type", "application/json");
                                                
                                                                                                var raw = JSON.stringify({
                                                                                                    "line_items": [{
                                                                                                        "id": element.id,
                                                                                                        "product_id": element.product_id,
                                                                                                        "variation_id": element.variation_id,
                                                                                                        "total": "0",
                                                                                                        "subtotal": "0",
                                                                                                        "meta_data": [{
                                                                                                            "key": "Subscription",
                                                                                                            "value": "Cancelled"
                                                                                                        }]
                                                                                                    }]
                                                                                                });
                                                
                                                                                                var requestOptions = {
                                                                                                method: 'PUT',
                                                                                                headers: myHeaders,
                                                                                                body: raw,
                                                                                                redirect: 'follow'
                                                                                                };
                                                
                                                                                                fetch(`${auth[0]?.url_endpoint}/wp-json/wc/v3/orders/${result_parse.id}`, requestOptions)
                                                                                                .then(response => response.text())
                                                                                                .then(result =>{
                                                                                                    window.location.href = "admin.php?page=subscription";
                                                                                                    AmagiLoader.hide();
                                                                                                });
                                                                                            }
                                                                                        });
                                                                                    });
                                                                                }

                                                                            });
                                                                        });
                                                                    }
                                                                }
                                                            });
                                                        }

                                                    }
                                                });
                                            } else {
                                            }
                                        }
                                    });
                                }
                            }
                        }
                    }
                }
            }

        }
    });

</script>

<div id="error_popup_login" class="overlay">
    <div class="popup">
        <div class="content_container">Need To Login</div>  
        <div><a class="close" href="admin.php?page=login">×</a></div>
    </div>  
</div>
<div id="error_popup_dashboard" class="overlay">
    <div class="popup">
        <div class="content_container">Need To Connect Woocommerce</div>  
        <div><a class="close" href="admin.php?page=dashboard">×</a></div>
    </div>  
</div>
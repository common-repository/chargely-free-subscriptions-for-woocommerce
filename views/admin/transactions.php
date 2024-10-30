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
</style>
</head>

<div class="body" id="body">
    <div class="head">
        <div class="title"><h1>Transactions</h1></div>
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
                <th style="padding:10px 0px 10px 10px;">Order ID</th>
                <th>Customer Name</th>
                <th>Product Name</th>
                <th>Amount</th>						
                <th>Payment Method</th>
                <th>Payment Gateway</th>
                <th>Billed Date</th>						
                <th style="padding-right:10px;">Product Type</th>
            </tr>
        </thead>
        <tbody id="consumers_data" style="text-align: center;font-size: 14px;"></tbody>
    </table>
    <div id="page_per_number" style="display: flex;align-items: center;column-gap: 10px;margin-top: 20px;"></div>
</div>

<script>

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
                    var page_per_number_html = `<input type="submit" style="cursor: pointer;padding: 5px 10px;box-shadow: rgb(50 50 93 / 25%) 0px 6px 12px -2px, rgb(0 0 0 / 30%) 0px 3px 7px -3px;background-color: #5D64EA;color: white;border: none;" value="${element}" id="page_number_btn">`;
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
                                            <td colspan="2" style="font-size: 20px;padding: 18px;">No data available in table</td>
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
                                                        let consumers_data_html_first = `                    
                                                        <tr>
                                                            <td style="padding: 14px 5px 0px 5px;width: 5%;">${element.order_id}</td>
                                                            <td style="padding: 14px 5px 0px 5px;width: 10%;">${element.full_name}</td>
                                                            <td style="padding: 14px 5px 0px 5px;width: 25%;">${subscriptions_data.name}</td>
                                                            <td style="padding: 14px 5px 0px 5px;width: 10%;">${subscriptions_data.amount}</td>
                                                            <td style="padding: 14px 5px 0px 5px;width: 10%;">${element.payment_method}</td>
                                                            <td style="padding: 14px 5px 0px 5px;width: 10%;">${element.payment_gateway}</td>
                                                            <td style="padding: 14px 5px 0px 5px;width: 10%;">${billied_date.toDateString('YYYY-MM-dd')}</td>`;
                                                            
                                                        let consumers_data_html_middle = '';
                                                                
                                                        if (subscriptions_data.isOneTypePayment === true) {
                                                            consumers_data_html_middle = `<td style="padding: 14px 5px 0px 5px;width: 5%;"><div style="background: orange;margin: 0 24px;color: white;padding: 6px 10px;border-radius: 4px;font-size: 14px;">One Time Purchase</div></td>`;
                                                        }else{
                                                            consumers_data_html_middle = `<td style="padding: 14px 5px 0px 5px;width: 5%;"><div style="background: forestgreen;margin: 0 24px;color: white;padding: 6px 10px;border-radius: 4px;font-size: 14px;">Subscriptions</div></td>`;
                                                        }

                                                        let consumers_data_html_end = `</tr>`;

                                                        let consumers_data_html_main = consumers_data_html_first + consumers_data_html_middle + consumers_data_html_end;

                                                        consumers_data.innerHTML = consumers_data.innerHTML + consumers_data_html_main;
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
                    <td colspan="2" style="font-size: 20px;padding: 18px;">No data available in table</td>
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
                                let consumers_data_html_first = `                    
                                <tr>
                                    <td style="padding: 14px 5px 0px 5px;width: 5%;">${element.order_id}</td>
                                    <td style="padding: 14px 5px 0px 5px;width: 10%;">${element.full_name}</td>
                                    <td style="padding: 14px 5px 0px 5px;width: 25%;">${subscriptions_data.name}</td>
                                    <td style="padding: 14px 5px 0px 5px;width: 10%;">${subscriptions_data.amount}</td>
                                    <td style="padding: 14px 5px 0px 5px;width: 10%;">${element.payment_method}</td>
                                    <td style="padding: 14px 5px 0px 5px;width: 10%;">${element.payment_gateway}</td>
                                    <td style="padding: 14px 5px 0px 5px;width: 10%;">${billied_date.toDateString('YYYY-MM-dd')}</td>`;
                                    
                                let consumers_data_html_middle = '';
                                        
                                if (subscriptions_data.isOneTypePayment === true) {
                                    consumers_data_html_middle = `<td style="padding: 14px 5px 0px 5px;width: 5%;"><div style="background: orange;color: white;margin: 0 24px;padding: 6px 10px;border-radius: 4px;font-size: 14px;">One Time Purchase</div></td>`;
                                }else{
                                    consumers_data_html_middle = `<td style="padding: 14px 5px 0px 5px;width: 5%;"><div style="background: forestgreen;color: white;margin: 0 24px;padding: 6px 10px;border-radius: 4px;font-size: 14px;">Subscriptions</div></td>`;
                                }

                                let consumers_data_html_end = `</tr>`;

                                let consumers_data_html_main = consumers_data_html_first + consumers_data_html_middle + consumers_data_html_end;

                                consumers_data.innerHTML = consumers_data.innerHTML + consumers_data_html_main;
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
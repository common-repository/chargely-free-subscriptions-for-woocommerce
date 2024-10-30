<head>
<script>
    let consumer_key_Access = localStorage.getItem("Chargely_Woocommernce_consumer_key");
    let Api_Key_Access = localStorage.getItem("Chargely_Woocommernce_Api_Key");
    if (!consumer_key_Access) {
        window.location.href = "#error_popup_dashboard";
    }else if(!Api_Key_Access){
        window.location.href = "#error_popup";
    }
<?php

global $wpdb;
$getallplans = $wpdb->get_results(
    $wpdb->prepare("SELECT * from ".chargely_credentials()." ORDER BY id desc ","")
);

$test_db = json_encode($getallplans);
?>
    let auth = <?php print $test_db ?>;
    if (auth.length == 0) {
        window.location.href = "#error_popup";
    }
    else if(auth.length>0){
        localStorage.setItem("Chargely_Woocommernce_consumer_key", auth[0]?.consumer_key);
    }
    
</script> 
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
    .container {
        margin: 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background-color: white;
        padding: 50px;
        border-radius: 4px;
        box-shadow: rgb(50 50 93 / 25%) 0px 6px 12px -2px, rgb(0 0 0 / 30%) 0px 3px 7px -3px;
    }

    .input-container {
        display: flex;
        align-items: center;
        column-gap: 5px;
        font-size: 20px;
    }

    .form {
        display: flex;
        flex-direction: column;
        row-gap: 18px;
        padding-right: 50%;
    }

    .submit input {
        height: 38px;
        width: 112px;
        background-color: #5D64EA;
        border: none;
        color: #ffffff;
        font-size: 16px;
        font-weight: 500;
        border-radius: 4px;
        cursor: pointer;
    }

    .submit input:hover {
        background-color: #4045A0 ;
    }

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        border-radius: 4px;
    }

    td,
    th {
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: white;
    }

    .header {
        background-color: #5D64EA;
        color: white;
    }

    .nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 22px;
    }

    .disconnect {
        cursor: pointer;
        width: 150px;
        height: 50px;
        border: none;
        background-color: #5D64EA;
        color: #ffffff;
        font-size: 18px;
        font-weight: 500;
        padding: 10px;
        border-radius: 4px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
    }

    .disconnect:hover {
        background-color: #4045A0 ;
    }

    input[type=number]:focus {
        border-color: #5D64EA;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
    }

    input[type=text]:focus {
        border-color: #5D64EA;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
    }

    select[id=product_id]:focus {
        border-color: #5D64EA;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
    }

    select[id=billing_period_html]:focus {
        border-color: #5D64EA;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
    }

    select[id=billing_period_type_html]:focus {
        border-color: #5D64EA;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
    }

    .input-container-uniqid {
        display: none;
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
        z-index: 3;
    }

    .overlay:target {
        visibility: visible;
        opacity: 1;
    }

    .popup {
        margin: 70px auto;
        padding: 20px;
        background: #fff;
        border-radius: 5px;
        width: 30%;
        position: relative;
        transition: all 5s ease-in-out;
    }

    .popup h2 {
        margin-top: 0;
        color: #333;
        font-family: Tahoma, Arial, sans-serif;
    }

    .popup .close {
        position: absolute;
        top: 20px;
        right: 30px;
        transition: all 200ms;
        font-size: 30px;
        font-weight: bold;
        text-decoration: none;
        color: #333;
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

    .addbtn {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #5D64EA;
        color: white;
        padding: 10px;
        width: 30%;
        border-radius: 4px;
        cursor: pointer;
    }

    .wp-core-ui select:hover {
        color: #5D64EA;
    }

    #frmAddProduct label.error {
        color: red;
    }

    input[type=search]:focus {
        border-color: #5D64EA;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
    }

    select[name=tblSample_length]:focus {
        border-color: #5D64EA;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
    }

    input[type=checkbox]:focus {
        border-color: #5D64EA;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
    }

    .tabContainer .tabPanel {
        display: none;
    }

    .dataTables_wrapper .dataTables_length select:focus {
        border-color: #5D64EA;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
    }

    .tabContainer {
        padding: 0;
        list-style: none;
        text-align: center;
    }

    .tabContainer .buttonContainer {
        position: relative;
        padding-bottom: 22px;
        display: flex;
        align-items: center;
        column-gap: 20px;
        font-size: 20px;
        font-weight: bold;
    }

    .tabContainer .buttonContainer button {
        color: #111;
        text-decoration: none;
        letter-spacing: 1px;
        display: inline-block;
        position: relative;
        border: none;
        background-color: white;
        padding: 0;
        cursor: pointer;
        font-weight: 400;
    }

    .tabContainer .buttonContainer button:after {
        bottom: -6px;
        content: "";
        display: block;
        height: 3px;
        left: 50%;
        position: absolute;
        background: #5D64EA;
        transition: width 0.3s ease 0s, left 0.3s ease 0s;
        width: 0;
        border-radius: 50px;
    }

    .tabContainer .buttonContainer button:hover:after {
        width: 100%;
        left: 0;
    }

    .tabContainer .buttonContainer button:focus:after {
        width: 100%;
        left: 0;
    }

    @media screen and (max-height: 300px) {
        .tabContainer {
            margin-top: 40px;
        }
    }

    .apply {
        float: right;
        padding: 10px;
        margin-top: 30px;
        width: 112px;
        border: none;
        color: white;
        font-size: 18px;
        font-weight: 500;
        background-color: #5D64EA;
        border-radius: 4px;
        box-shadow: rgb(50 50 93 / 25%) 0px 6px 12px -2px, rgb(0 0 0 / 30%) 0px 3px 7px -3px;
        cursor: pointer;
    }

    .apply:hover {
        background-color: #4045A0 ;
    }

    .hr {
        margin-top: -18px;
        height: 1px;
        width: 100%;
        background-color: lightgrey;
        margin-bottom: 30px;
    }

    select[id=billing_period_option_html]:focus {
        border-color: #5D64EA;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
    }

    #selected_product_list .dataTables_empty {
        display: none;
    }

    .err_overlay {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        transition: opacity 500ms;
        visibility: hidden;
        opacity: 0;
        z-index: 3;
    }

    .err_overlay:target {
        visibility: visible;
        opacity: 1;
    }

    .err_popup {
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

    .err_popup .err_content_container {
        font-size: 18px;
        color: white;
    }

    .err_popup .err_close {
        transition: all 200ms;
        font-size: 30px;
        font-weight: bold;
        text-decoration: none;
        color: white;
        cursor: pointer;
    }
    select[id=page_per]:focus {
        border-color: #5D64EA;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
    }
</style>
</head>

<div id="api_error_popup_invalid" class="overlay">
    <div class="err_popup">
        <div class="err_content_container">Invalid Credentials</div>  
        <div><a class="err_close btnplandelete" href="javascript:void(0)">×</a></div>
    </div>  
</div>

<script>
    var u = new URLSearchParams(window.location.search);
    if (u?.get('success') == 1) {
        AmagiLoader.show();
        let Merchant_Email = localStorage.getItem("Chargely_Woocommernce_Merchant_email");
        let Merchant_ID = localStorage.getItem("Chargely_Woocommernce_Merchant_id");
        let Api_Key = localStorage.getItem("Chargely_Woocommernce_Api_Key");
        const cookieValue = document.cookie
            .split('; ')
            .find((row) => row.startsWith('Chargely_Woocommernce_Url_Endpoint='))
            ?.split('=')[1];
        var postdata = `action=myplanlibrary&param=updated_plugin&id=1&merchant_id=${Merchant_ID}&api_key=${Api_Key}&url_endpoint=${cookieValue}&consumer_key=${auth[0]?.consumer_key}&consumer_secret=${auth[0]?.consumer_secret}&cancel_subscription=false`;
        jQuery.post(myplanajaxurl, postdata, function(resp) {
            var data = jQuery.parseJSON(resp);
            if (data.status == 1) {
                    jQuery.notifyBar({
                    cssClass: "success",
                    html: data.message
                });
                setTimeout(function() {
                    location.reload();
                    AmagiLoader.hide();
                    location.replace("admin.php?page=setting");
                    localStorage.removeItem("Chargely_Woocommernce_Merchant_id");
                    localStorage.removeItem("Chargely_Woocommernce_Merchant_email");
                }, 1300)
            } else {

            }
        });
    }
</script>

<?php

if(count($getallplans)>0){
    foreach($getallplans as $key=>$value){


function join_params( $params ) {
    $query_params = array();

    foreach ( $params as $param_key => $param_value ) {
        $string = $param_key . '=' . $param_value;
        $query_params[] = str_replace( array( '+', '%7E' ), array( ' ', '~' ), rawurlencode( $string ) );
    }
    
    return implode( '%26', $query_params );
}

$consumer_key = $value->consumer_key;
$consumer_secret = $value->consumer_secret;
$requestTokenUrl = $value->url_endpoint."/wp-json/wc/v3/products"; 

    }
}

$getallproduct = $wpdb->get_results(
    $wpdb->prepare("SELECT * from " . chargely_product_table_name() . " ORDER BY product_id desc", ""), ARRAY_A
);

$test_product_status = json_encode($getallproduct);

?>

    <body>
        <div class="container">
            <div class="nav" style="">
            </div>

            <div class="tabContainer">
                <div class="buttonContainer">
                    <button onclick="showPanel(0)">List All</button>
                    <button onclick="showPanel(1)">Subscribed</button>
                    <button onclick="showPanel(2)">Cancelled</button>
                </div>
                <div class="hr"></div>
                <div class="tabPanel">
                    <div style="display: flex;align-items: center;justify-content: space-between;margin-bottom: 20px;">
                        <div style="display: flex;align-items: center;column-gap: 4px;">
                            <div><input id="remember" name="remember" type="checkbox" onclick="validate()" /></div>
                            <div>Allow consumer to cancel there subscriptions from there account</div>
                        </div>
                        <div style="display: flex;align-items: center;column-gap: 4px;">
                            <div>Search:</div>
                            <div><input type="search" name="" id="myInput" style="padding: 5px;" ></div>
                        </div>
                    </div>
                    <table id="tblListallProduct">
                        <thead style="background-color: #5D64EA;color: white;">
                            <tr>
                                <th>Action</th>
                                <th>Product Id</th>
                                <th>Product Name</th>
                                <th>Product Price</th>
                                <th>Status</th>
                                <th>Stock Status</th>
                            </tr>
                        </thead>
                        <tbody id="">
                            <tr>
                                <td><input type= "checkbox" id="checkoutallevent"/></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tbody id="woocom_product" style="text-transform: capitalize;"></tbody>
                    </table>
                    <div id="page_per_number" style="display: flex;align-items: center;column-gap: 10px;margin-top: 20px;"></div>
                    <button class="apply" onclick="getValue()">Apply</button>
                </div>
                <div class="tabPanel">
                    <table id="tblSubcribeProduct">
                        <thead style="background-color: #5D64EA;color: white;">
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>One-time Price</th>
                                <th>Percentage</th>
                                <th>Subscribe Price</th>
                                <th>Billing Cycle</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="status_active"></tbody>
                    </table>
                </div>
                <div class="tabPanel">
                    <table id="tblCancelledProduct">
                        <thead style="background-color: #5D64EA;color: white;">
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>One-time Price</th>
                                <th>Percentage</th>
                                <th>Subscribe Price</th>
                                <th>Billing Cycle</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="status_deactive"></tbody>
                    </table>
                </div>
            </div>
        </div>
                          
        <div id="popup1" class="overlay">
            <div class="popup" style="width:60%">
                <a class="close" href="#" id ="close">×</a><br><br>
                <script>
                    var close = document.getElementById("close");
                    close.addEventListener("click", (e) => {
                        e.preventDefault()
                        window.location.href = "admin.php?page=setting";
                    });
                </script>
                <div class="content-containe">
                    <div class="steps-container">
                        <div style="padding: 10px;display: block;max-height: 450px;overflow-y: scroll;">
                            <div style="display: flex;align-items: center;justify-content: space-between;margin-bottom: 20px;">
                                <div style="display: flex;align-items: center;column-gap: 4px;">
                                    <h1>Selected Product List</h1>
                                </div>
                                <div style="display: flex;align-items: center;column-gap: 4px;">
                                    <div>Search:</div>
                                    <div><input type="search" name="" id="myInputSelected" style="padding: 5px;" ></div>
                                </div>
                            </div>
                            <table id="selected_product_list_table">
                                <thead style="background-color: #5D64EA;color: white;">
                                    <tr>
                                        <th>Product Id</th>
                                        <th>Product Name</th>
                                        <th>Product Price</th>
                                        <th>State</th>
                                        <th>Country</th>
                                    </tr>
                                </thead>
                                <tbody id="selected_product_list" style="text-transform: capitalize;"></tbody>
                            </table>
                            <script>
                                let myInputSelected = document.querySelector("#myInputSelected");
                                myInputSelected.addEventListener("change", (e) => {
                                    var input, filter, found, table, tr, td, i, j;
                                    input = document.getElementById("myInput");
                                    filter = input.value.toUpperCase();
                                    table = document.getElementById("selected_product_list_table");
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
                            </script>
                            <form action="javascript:void(0)" id="frmAddProduct" style="margin-top: 30px;">
                                <div class="form">
                                    <div class="input-container" style="display: flex;align-items: center;justify-content: space-between;">
                                        <div>Percentage</div>
                                        <div><input type="number" min="1" class="form-control" name="percentage" id="percentage" placeholder="Enter the Percentage" style="width:300px;" required></div>
                                    </div>
                                    <div class="input-container" style="display: flex;align-items: center;justify-content: space-between;">
                                        <div>Billing Cycle</div>
                                        <div style="display: flex;width: 300px;column-gap: 5px;">
                                            <select type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required style="width: 30%;">
                                                <option value="1" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>1</option>
                                                <option value="2" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>2</option>
                                                <option value="3" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>3</option>
                                                <option value="4" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>4</option>
                                                <option value="5" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>5</option>
                                                <option value="6" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>6</option>
                                                <option value="7" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>7</option>
                                                <option value="8" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>8</option>
                                                <option value="9" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>9</option>
                                                <option value="10" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>10</option>
                                                <option value="11" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>11</option>
                                                <option value="12" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>12</option>
                                                <option value="13" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>13</option>
                                                <option value="14" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>14</option>
                                                <option value="15" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>15</option>
                                                <option value="16" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>16</option>
                                                <option value="17" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>17</option>
                                                <option value="18" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>18</option>
                                                <option value="19" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>19</option>
                                                <option value="20" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>20</option>
                                                <option value="21" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>21</option>
                                                <option value="22" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>22</option>
                                                <option value="23" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>23</option>
                                                <option value="24" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>24</option>
                                                <option value="225" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>25</option>
                                                <option value="26" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>26</option>
                                                <option value="27" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>27</option>
                                                <option value="28" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>28</option>
                                                <option value="29" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>29</option>
                                                <option value="30" type="billing_period_html" class="form-control" id="billing_period_html" name="billing_period" required>30</option>
                                            </select>
                                            <select type="billing_period_type_html" class="form-control" id="billing_period_type_html" name="billing_period_type" required style="width: 40%;">
                                                <option value="Weekly" type="billing_period_type_html" class="form-control" id="billing_period_type_html" name="billing_period_type" style="width: 10%;cursor: pointer;" required>Weekly</option>
                                                <option value="Monthly" type="billing_period_type_html" class="form-control" id="billing_period_type_html" name="billing_period_type" required>Monthly</option>
                                                <option value="Yearly" type="billing_period_type_html" class="form-control" id="billing_period_type_html" name="billing_period_type" required>Yearly</option>
                                            </select>
                                            <div id="add_btn" class="addbtn">Add</div>
                                        </div>
                                    </div>
                                    <div class="test" id="billing_cycle_display"></div>

                                    <div class="submit" style="padding: 0;margin: 0;">
                                        <input type="submit" value="Submit" id="submit_btn">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<script>

    if (auth[0]?.cancel_subscription === "true") {
        document.getElementById('remember').checked = true;
    }

    function validate() {
        AmagiLoader.show();
        if (document.getElementById('remember').checked) {
            var postdata = `action=myplanlibrary&param=updated_plugin&id=1&merchant_id=${auth[0]?.merchant_id}&api_key=${auth[0]?.api_key}&url_endpoint=${auth[0]?.url_endpoint}&consumer_key=${auth[0]?.consumer_key}&consumer_secret=${auth[0]?.consumer_secret}&cancel_subscription=true`;
            jQuery.post(myplanajaxurl, postdata, function(resp) {
                var data = jQuery.parseJSON(resp);
                if (data.status == 1) {
                        jQuery.notifyBar({
                        cssClass: "success",
                        html: data.message
                    });
                    setTimeout(function() {
                        location.reload();
                        AmagiLoader.hide();
                        location.replace("admin.php?page=setting");
                    }, 1300)
                } else {

                }
            });
        } else if(document.getElementById('remember').checked === false){
            var postdata = `action=myplanlibrary&param=updated_plugin&id=1&merchant_id=${auth[0]?.merchant_id}&api_key=${auth[0]?.api_key}&url_endpoint=${auth[0]?.url_endpoint}&consumer_key=${auth[0]?.consumer_key}&consumer_secret=${auth[0]?.consumer_secret}&cancel_subscription=false`;
            jQuery.post(myplanajaxurl, postdata, function(resp) {
                var data = jQuery.parseJSON(resp);
                if (data.status == 1) {
                        jQuery.notifyBar({
                        cssClass: "success",
                        html: data.message
                    });
                    setTimeout(function() {
                        location.reload();
                        AmagiLoader.hide();
                        location.replace("admin.php?page=setting");
                    }, 1300)
                } else {

                }
            });
        }
    }

    let billing_period_arr = [];
    let billing_period_type_arr = [];
    let status_active = document.getElementById("status_active");
    let status_deactive = document.getElementById("status_deactive");
    let  test_product_status = <?php print $test_product_status ?>;
    for (let index = 0; index < test_product_status.length; index++) {
        const product_status = test_product_status[index];
        
        let check_period_arr = [];
        let check_type_arr = [];

        const billing_period_array = product_status.billing_period;
        const billing_period_split =  billing_period_array.split(",");

        const billing_period_type_array = product_status.billing_period_type;
        const billing_period_type_split =  billing_period_type_array.split(",");
            
            if (product_status.status === "Active") {
                    let first_status_active_tr = `
                    <tr style="text-align: center;">
                    <td >${product_status.product_id}</td>
                    <td >${product_status.product_name}</td>
                    <td >${product_status.price}</td>
                    <td >${product_status.percentage}</td>
                    <td >${product_status.updated_price}</td>
                    <td ><select id="billing_period_option_html">`

                    
                    let middle_status_active_tr = ''
            
                    billing_period_type_split.forEach((element,i) => {
                        middle_status_active_tr = middle_status_active_tr + `
                        <option value="${billing_period_split[i]} ${element}">${billing_period_split[i]} ${element}</option>`
                    });

                    let last_status_active_tr =`
                    </select></td>
                    <td ><span style="background-color: green;color: white;padding: 5px;border-radius: 4px;">${product_status.status}</span></td>
                    <td ><a style="color:#5D64EA;" class="btnplanedit" href="admin.php?page=test&edit=${product_status.product_id}"><img style="width: 20px;height: 20px;color: red;" src="<?php print plugins_url('images/edit_pen.png' , __FILE__) ?>"></a></td>
                    </tr>`

                    let main_active_html = first_status_active_tr + middle_status_active_tr + last_status_active_tr;

                    status_active.innerHTML = status_active.innerHTML + main_active_html;

                }else if(product_status.status === "Deactive"){
                    let first_status_deactive_tr = `
                    <tr style="text-align: center;">
                    <td >${product_status.product_id}</td>
                    <td >${product_status.product_name}</td>
                    <td >${product_status.price}</td>
                    <td >${product_status.percentage}</td>
                    <td >${product_status.updated_price}</td>
                    <td><select id="billing_period_option_html">`

                    let middle_status_deactive_tr = ''

                    billing_period_type_split.forEach((element,i) => {
                        middle_status_deactive_tr = middle_status_deactive_tr + `
                        <option value="${billing_period_split[i]} ${element}">${billing_period_split[i]} ${element}</option>`
                    });

                    let last_status_deactive_tr =`
                    </select></td>
                    <td ><span style="background-color: red;color: white;padding: 5px;border-radius: 4px;">${product_status.status}</span></td>
                    <td ><a style="color:#5D64EA;" class="btnplanedit" href="admin.php?page=test&edit=${product_status.product_id}"><img style="width: 20px;height: 20px;color: red;" src="<?php print plugins_url('images/edit_pen.png' , __FILE__) ?>"></a></td>
                    </tr>`

                    let main_deactive_html = first_status_deactive_tr + middle_status_deactive_tr + last_status_deactive_tr;

                    status_deactive.innerHTML = status_deactive.innerHTML + main_deactive_html;
                }
            }
            

        let res_arr;
        let product_id = document.getElementById("product_id");
        let product_name = document.getElementById("product_name");
        let price = document.getElementById("price");
        let woocom_product = document.getElementById("woocom_product");
        let add_btn = document.getElementById("add_btn");
        let billing_cycle_display = document.getElementById("billing_cycle_display");
        const percentage_input = document.getElementById("percentage");
        const updated_price_input = document.getElementById("updated_price");
        const billing_period = document.getElementById("billing_period_html");
        const billing_period_type = document.getElementById("billing_period_type_html");
        const product_id_uniqid = document.getElementById("product_id_uniqid");

        add_btn.addEventListener("click", (e) => {
            let test_display = `
            <div style="display: flex;align-items: center;column-gap: 10px;" id="cycle_container">
                <div style="display: flex;align-items: center;">
                    <input value="${billing_period.value}" type="billing_period" style="border: none;width: 50px;padding: 6px;text-align: center;" class="form-control" id="billing_period" name="billing_period" required readonly>
                    <input value="${billing_period_type.value}" type="billing_period_type" style="border: none;padding: 6px;text-align: center;width: 106px;" class="form-control" id="billing_period_type" name="billing_period_type" required readonly>
                </div>
                <div>`;
                
            billing_cycle_display.innerHTML = billing_cycle_display.innerHTML + test_display;
            
            billing_period_arr.push(billing_period.value);
            
            billing_period_type_arr.push(billing_period_type.value);
            
        })

        // pagnation 

        var api_url = '<?php print $requestTokenUrl ?>';
        var consumer_key = '<?php print $consumer_key ?>';
        var consumer_secret = '<?php print $consumer_secret ?>';

        <?php
            $products = wc_get_products( array( 'status' => 'publish', 'limit' => -1 ) );
            $productsencode = count($products);
        ?>
                        
        var count = <?php print $productsencode ?>;
                        
        var count_div = count/10;
                        
        var isInt = Number.isInteger(count_div);
        
        // start

        const request = new XMLHttpRequest();
        request.withCredentials = true;
        request.addEventListener("readystatechange", function() {
            if (this.readyState == 4 && this.status == 200) {
                var res  = request.response;
                var res_encode = JSON.parse(request.responseText);
                res_arr = res_encode;
                woocom_product.innerHTML = woocom_product.innerHTML + `
                            `;
                res_encode.forEach(woocom_product_data => {

                    let frist_woocom_product_tr = `
                    <tr>
                    <td >`

                    let middle_woocom_product_tr = '';

                    let selected_product = document.getElementById('selected_product');

                    middle_woocom_product_tr = middle_woocom_product_tr + `<input type="checkbox" name="selected_product" id="selected_product" value="${woocom_product_data.id}">`
                    let last_woocom_product_tr =`</td>
                    <td >${woocom_product_data.id}</td>
                    <td >${woocom_product_data.name}</td>
                    <td >${woocom_product_data.price}</td>
                    <td >${woocom_product_data.status}</td>
                    <td >${woocom_product_data.stock_status}</td>
                    </tr>`

                    let main_html = frist_woocom_product_tr + middle_woocom_product_tr + last_woocom_product_tr;

                    woocom_product.innerHTML = woocom_product.innerHTML + main_html;
                });
                let checkoutallevent = document.querySelector('#checkoutallevent');

                checkoutallevent.addEventListener('change', (e) =>{

                    var ele = document.getElementsByName('selected_product');  

                    for(var i=0; i<ele.length; i++) {

                        ele[i].checked = e.target.checked;
                    }
                });

                let searchEvent = document.querySelector("#myInput");
                searchEvent.addEventListener("change", (e) => {
                    var input, filter, found, table, tr, td, i, j;
                    input = document.getElementById("myInput");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("tblListallProduct");
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
            } 
        });
        request.open("GET", `${api_url}?per_page=10&page=1`, true);
        request.setRequestHeader("Authorization", "Basic " + btoa(consumer_key + ":" + consumer_secret));
        request.send();

        // end
        
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
                        var xhr = new XMLHttpRequest();
                        xhr.withCredentials = true;
                            
                        xhr.addEventListener("readystatechange", function() {
                            if (this.readyState == 4 && this.status == 200) {
                                var res  = xhr.response;
                                var res_encode = JSON.parse(xhr.responseText);
                                res_arr = res_encode;
                                woocom_product.innerHTML = '';                    
                                res_encode.forEach(woocom_product_data => {
                            
                                    let frist_woocom_product_tr = `
                                    <tr>
                                    <td >`
                            
                                    let middle_woocom_product_tr = '';
                            
                                    let selected_product = document.getElementById('selected_product');
                            
                                    middle_woocom_product_tr = middle_woocom_product_tr + `<input type="checkbox" name="selected_product" id="selected_product" value="${woocom_product_data.id}">`
                                    let last_woocom_product_tr =`</td>
                                    <td >${woocom_product_data.id}</td>
                                    <td >${woocom_product_data.name}</td>
                                    <td >${woocom_product_data.price}</td>
                                    <td >${woocom_product_data.status}</td>
                                    <td >${woocom_product_data.stock_status}</td>
                                    </tr>`
                            
                                    let main_html = frist_woocom_product_tr + middle_woocom_product_tr + last_woocom_product_tr;
                                    woocom_product.innerHTML = woocom_product.innerHTML  + main_html;
                                });
                            }
                        });
                        xhr.open("GET", `${api_url}?per_page=10&page=${element.value}`);
                        xhr.setRequestHeader("Authorization", "Basic " + btoa(consumer_key + ":" + consumer_secret)); 
                        xhr.send();
                    });
                });
            }
        }


        let selected_product_list = document.getElementById("selected_product_list");

        function getValue() {
            var checkboxes = document.getElementsByName('selected_product');
  
            var result = "";
            var arr_checked = [];
  
            for (var i = 0; i < checkboxes.length; i++) {
                
                if (checkboxes[i].checked) {
                    checkboxes[i].value;
                    result += checkboxes[i].value;
                    arr_checked.push(checkboxes[i].value);
                    res_arr.forEach(element => {
                        if (element.id === parseInt(checkboxes[i].value)) {
                        let uniqid_ts = "id" + Math.random().toString(16).slice(2);
                            window.location.href = "#popup1";
                            let selected_product_list_html = `<tr style="text-align: center;"> 
                            <td >${element.id}</td>
                            <td >${element.name}</td>
                            <td >${element.price}</td>
                            <td >${element.status}</td>
                            <td >${element.stock_status}</td>
                            </tr>`;
                            selected_product_list.innerHTML = selected_product_list.innerHTML + selected_product_list_html;
                        }
                    });
                } else {
                }
            }
            localStorage.setItem("array_of_checked", JSON.stringify(arr_checked));
        }

        jQuery(document).ready(function() {
            jQuery("#tblSubcribeProduct").DataTable();
            jQuery("#tblCancelledProduct").DataTable();
        jQuery("#frmAddProduct").validate({
            submitHandler: function() {
                let arr_check = JSON.parse(localStorage.getItem("array_of_checked"));
                res_arr.forEach((element,i) => {
                    arr_check.forEach(ele => {
                        if (element.id == ele) {
                            let uniqid = "id" + Math.random().toString(16).slice(2);
                                let calculate_updated_price = ((parseInt(element.price) * parseInt(percentage_input.value))/100);
                                let updated_price = ((parseInt(element.price)-calculate_updated_price)).toString();
                                var data_send = `action=myproductlibrary&param=save_product&product_id=${element.id}&product_id_uniqid=${uniqid}&product_name_create=${element.name}&price_create=${element.price}&percentage_create=${percentage_input.value}&updated_price_create=${updated_price}&billing_period_create=${billing_period_arr}&billing_period_type_create=${billing_period_type_arr}`;
                                jQuery.post(myplanajaxurl, data_send, function(resp) {
                                    var data = jQuery.parseJSON(resp);
                                    if (data.status == 1) {
                                        jQuery.notifyBar({
                                            cssClass: "success",
                                            html: data.message
                                        });
                                        setTimeout(function() {
                                        window.location.href = "admin.php?page=setting";
                                        localStorage.removeItem("array_of_checked");
                                        }, 1300)
                                    } else {
                                    }
                                });
                        }
                    });

                });
            }
        });

        jQuery("#frmEditProduct").validate({
        submitHandler: function() {
            var postdata = "action=myproductlibrary&param=edit_plan&" + jQuery("#frmEditProduct").serialize();
            jQuery.post(myplanajaxurl, postdata, function(resp) {
                var data = jQuery.parseJSON(resp);
                if (data.status == 1) {
                    jQuery.notifyBar({
                        cssClass: "success",
                        html: data.message
                    });
                    setTimeout(function() {
                        location.reload();
                        location.replace("admin.php?page=setting");
                    }, 1300)
                } else {

                }
            });
        }
        });

        jQuery(document).on("click", ".btnplandelete", function() {
            var postdata = "action=myplanlibrary&param=delete_plan&id=1";
            jQuery.post(myplanajaxurl, postdata, function(response) {
                var data = jQuery.parseJSON(response);
                if (data.status == 1) {
                    window.location.href = "admin.php?page=dashboard";
                    localStorage.removeItem('Chargely_Woocommernce_consumer_key');
                    setTimeout(function() {
                        location.reload();
                    }, 1300)
                } else {

                }
            });
        // }
        });

        })
        </script>
    </body>
<div id="error_popup" class="err_overlay">
    <div class="err_popup">
        <div class="err_content_container">Need To Login</div>  
        <div id="err_close" class="err_close">×</div>
    </div>  
</div>

<div id="error_popup_dashboard" class="overlay">
    <div class="err_popup">
        <div class="err_content_container">Need To Connect Woocommerce</div>  
        <div><a class="err_close" href="admin.php?page=dashboard">×</a></div>
    </div>  
</div>

<div id="error_popup_invalid" class="overlay">
    <div class="err_popup">
        <div class="err_content_container">Invalid Credentials</div>  
        <div><a class="err_close" href="admin.php?page=login">×</a></div>
    </div>  
</div>

<div id="select_one" class="overlay">
    <div class="err_popup">
        <div class="err_content_container">Select Any One Product</div>  
        <div><a class="err_close" href="admin.php?page=setting">×</a></div>
    </div>  
</div>

<script>
    let err_close = document.getElementById("err_close");

    err_close.addEventListener("click", (e) => {
        e.preventDefault()
        localStorage.clear();
        window.location.href = "admin.php?page=login";
    });

        var tabButtons = document.querySelectorAll(".tabContainer .buttonContainer button");
    var tabPanels = document.querySelectorAll(".tabContainer .tabPanel");

    function showPanel(panelIndex, colorCode) {
        tabButtons.forEach(function(node) {
            node.style.backgroundColor="";
            node.style.color="";
        });

        tabButtons[panelIndex].style.backgroundColor = "#5D64EA";
        tabButtons[panelIndex].style.color = "white";
        tabButtons[panelIndex].style.padding = "2px 12px 2px 12px";
        tabButtons[panelIndex].style.borderRadius = "5px";

        tabPanels.forEach(function(node) {
            node.style.display = "none";
        });
        tabPanels[panelIndex].style.display = "block";
        tabPanels[panelIndex].style.backgroundColor = colorCode;
    }
    showPanel(0);

</script>

<div class="loader" id="loader"></div>
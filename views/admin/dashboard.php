<head>
    <script>
        let Chargely_Woocommernce_Merchant_email = localStorage.getItem("Chargely_Woocommernce_Merchant_email");
        let Api_Key_Access = localStorage.getItem("Chargely_Woocommernce_Api_Key");
        let consumer_key = localStorage.getItem("Chargely_Woocommernce_consumer_key");
        if (consumer_key) {
            window.location.href = "admin.php?page=setting";
        }else if(!Api_Key_Access ){
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
        }else if(auth.length>0){
            if (consumer_key === auth[0]?.consumer_key) {
                window.location.href = "admin.php?page=setting";
            }
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
}

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
    border-radius: 4px;
    box-shadow: rgb(50 50 93 / 25%) 0px 6px 12px -2px, rgb(0 0 0 / 30%) 0px 3px 7px -3px;
}

td,
th {
    padding: 8px;
}

.container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 50px;
}

.sbtn {
    cursor: pointer;
    width: 150px;
    height: 50px;
    border: none;
    border-radius: 4px;
    background-color: #5D64EA;
    color: #ffffff;
    font-size: 18px;
    font-weight: 500;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
}

.sbtn:hover {
    background-color: #4045A0 ;
}

.box {
    display: flex;
    align-items: center;
    flex-direction: column;
}

.connect-box {
    box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
    border-radius: 4px;
    background-color: #ffffff;
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

.connect-box-container {
    display: flex;
    align-items: center;
    justify-content: center;
}

.connect-boxs {
    width: 250px;
    height: 100px;
    padding: 20px;
}

.connect-boxs img {
    width: 100%;
    height: 100%;
}

.connect-link {
    width: 50px;
    height: 50px;
}

.connect-link img {
    width: 100%;
    height: 100%;
}

.connect-btn button {
    cursor: pointer;
    width: 200px;
    height: 50px;
    border: none;
    border-radius: 4px;
    background-color: #5D64EA;
    color: #ffffff;
    font-size: 18px;
    font-weight: 500;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
}

.connect-btn button:hover {
    background-color: #4045A0 ;
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
}

.left{
    width: 650px;
    height: 450px;
}

.left img{
    width: 100%;
    height: 100%;
}

.overlay:target {
    visibility: visible;
    opacity: 1;
}

.popup {
    margin: 70px auto;
    padding: 20px;
    background: #F2F2F2;
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
    overflow: hidden;
    text-align: center;
}

.continue-btn {
    border: none;
    width: 150px;
    height: 40px;
    border-radius: 4px;
    background-color: #5D64EA;
    font-weight: 500;
    font-size: 16px;
    cursor: pointer;
}

.continue-btn {
    text-decoration: none;
    color: #ffffff;
}

#popup1 button:hover {
    background-color: #4045A0 ;
}

.content-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    row-gap: 10px;
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
}

form .input {
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    row-gap: 16px;
    background-color: white;
    padding: 0 30px 30px 30px;
    align-items: center;
    justify-content: center;
}

form .input input {
    width: 350px;
    height: 55px;
    font-size: 16px;
    padding: 10px;
}

.right {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

@media screen and (max-width: 700px) {
    .box {
        width: 70%;
    }
    .popup {
        width: 70%;
    }
}

.steps-container {
    display: flex;
    flex-direction: column;
    row-gap: 22px;
}

input[type=password]:focus {
    border-color: #5D64EA;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
}

.hide-loader {
    display: none;
}

.steps {
    display: flex;
    align-items: center;
    column-gap: 10px;
}

input[type=url]:focus {
    border-color: #5D64EA;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
}

.popupp {
    margin: 70px auto;
    padding: 20px;
    background: #F2F2F2;
    border-radius: 5px;
    width: 30%;
    position: relative;
    transition: all 5s ease-in-out;
}
    </style>
</head>

<?php
if(count($getallplans)>0){
    foreach($getallplans as $key=>$value){

    }
}
?>
        <div class="container">
        </div>

        <div id="woocom_credentials" class="box"></div>

        <div class="box" id="woocom_connect">
            <div class="connect-box">
                <div style="font-weight: 600;font-size: 37px;line-height: 47px;color: #5D64EA;padding-bottom: 50px;">Connect your store</div>
                <div class="connect-box-container" style="column-gap: 50px;padding-bottom: 50px;">

                <div class="left">
                <img src="<?php print plugins_url('images/dashboard_connect_left.png', __FILE__) ?>" alt="" srcset="">
                </div>
                <div class="right" style="box-shadow: rgb(50 50 93 / 10%) 0px 6px 12px -2px, rgb(0 0 0 / 10%) 0px 3px 7px -3px;border: 1px solid rgba(74, 18, 69, 0.25);padding: 20px 50px;border-radius: 4px;">

                    <div>
                        <img style="width: 250px;height: 100%;" src="<?php print plugins_url('images/woocommerce-logo-transparent.png',__FILE__) ?>" alt="">
                    </div>
                    <div class="content" style="font-weight: 400;font-size: 16px;line-height: 26px;text-align: center;">
                        Chargely is requesting permission to access your <br> Woocommerce Store live Products
                    </div>

                    <form action="javascript:void(0)">
                        <div class="input">
                            <div style="text-align: center;font-size: 24px;padding: 0;margin: 0;">Enter Your Store URL</div>
                            <input type="url" class="form-control" name="url_endpoint" id="url_endpoint" placeholder="https://example.com">
                            <span id="url_endpoint_err"  style="color: red;margin: 0;padding: 0 2px;text-align: left;"></span>
                            <button type="submit" class="continue-btn" onclick="myFunction()">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="active_payment" class="overlay">
            <div class="popup" style="width: 50%;">
            <div class="content-containe" style="display: flex;align-items: center;column-gap: 20px;text-align: center;">    
                    <div style="font-size: 20px;font-weight: 500;line-height: 2rem;">
                        Payment Gateways Not Available Please Active Your Payment Gatways in <a href="https://chargely.com/merchant/dashboard/payment/settings" style="color: #5D64EA;">Chargely</a>
                    </div>                    
                    <div>
                        <a class="close" href="admin.php?page=dashboard">×</a>
                    </div>                    
                </div>
            </div>
        </div>
        
        <script>

            let Chargely_Woocommernce_consumer_key = document.getElementById("consumer_key");
            let url_endpoint = document.getElementById("url_endpoint");
            let url_endpoint_err = document.getElementById("url_endpoint_err");

            var u = new URLSearchParams(window.location.search);
            if (u?.get('merchant_id') && u?.get('api_key')) {
                localStorage.setItem("Chargely_Woocommernce_Merchant_id", u.get('merchant_id'));
                localStorage.setItem("Chargely_Woocommernce_Api_Key", u.get('api_key'));
                document.cookie="Chargely_Woocommernce_Merchant_id=" + u.get('merchant_id');
                document.cookie="Chargely_Woocommernce_Api_Key=" + u.get('api_key');
                window.location.href = "#active_payment";
            }

            function myFunction() {
                var currentUrl = url_endpoint.value;

                var merchantUrlValue = url_endpoint.value.trim();

                if (merchantUrlValue == "") {
                    setErrorr(url_endpoint, "Store URL is required*");
                    url_endpoint.style.border = "1px solid red";
                    return false;
                }else{
                    url_endpoint.style.border = "1px solid green";
                    url_endpoint_err.innerText = '';
                }

                if(currentUrl.substr(-1) == '/') {
                    currentUrl = currentUrl.substr(0, currentUrl.length - 1);
                    setErrorr(url_endpoint, "Store URL Should Not End With /");
                    url_endpoint.style.border = "1px solid red";
                    return false;
                }

                function setErrorr(u, msg) {
                    var parentBox = u.parentElement;
                    parentBox.className = "input";
                    var p = parentBox.querySelector("span");
                    p.innerText = msg;
                }

                if (url_endpoint.value) {
                    const store_url = url_endpoint.value;
                    const endpoint = '/wc-auth/v1/authorize';
                    const params = {
                        app_name: 'Chargely',
                        scope: 'read_write',
                        user_id: 123,
                        return_url: url_endpoint.value + '/wp-admin/admin.php?page=setting',
                        callback_url: url_endpoint.value + '/wp-json/chargely/v1/receive-callback'
                    };
                    const objString = store_url + endpoint + '?' + new URLSearchParams(params).toString();
                    document.cookie="Chargely_Woocommernce_Url_Endpoint=" + url_endpoint.value;
                    localStorage.setItem("Chargely_Woocommernce_consumer_key" , 'test');
                    window.location.href = objString;
                    return true;
                }

            }

        </script>

<div id="error_popup" class="overlay">
    <div class="err_popup">
        <div class="err_content_container">Need To Login</div>  
        <div><a class="err_close" href="admin.php?page=login">×</a></div>
    </div>  
</div>
<div id="error_popup_invalid" class="overlay">
    <div class="err_popup">
        <div class="err_content_container">Invalid Credentials</div>  
        <div><a class="err_close" href="admin.php?page=login">×</a></div>
    </div>  
</div>
<div id="error_popup_slash" class="overlay">
    <div class="err_popup">
        <div class="err_content_container">Store URL Should Not End With "/"</div>  
        <div><a class="err_close" href="admin.php?page=dashboard">×</a></div>
    </div>  
</div>

<div class="loader" id="loader"></div>
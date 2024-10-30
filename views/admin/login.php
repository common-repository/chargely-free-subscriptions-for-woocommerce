<head>
    <script>
        let Consumer_Key_Access = localStorage.getItem("Chargely_Woocommernce_consumer_key");
        if (Consumer_Key_Access) {
            window.location.href = "admin.php?page=setting";
        }
        <?php
            global $wpdb;
            $getallplans = $wpdb->get_results(
                $wpdb->prepare("SELECT * from ".chargely_credentials()." ORDER BY id desc ","")
            );

            $test_db = json_encode($getallplans);
        ?>
        let auth = <?php print $test_db ?>;
        if (auth>0) {
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
        cursor: pointer;
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

    .box {
        height: 100%;
        background: #ffffff;
        display: flex;
        justify-content: space-evenly;
        background-color: white;
        margin: 50px;
        flex-direction: column;
    }

    .first_box {
        height: 100%;
        background: #ffffff;
        display: flex;
        justify-content: space-evenly;
        background-color: white;
        align-items: center;
        margin-bottom: 60px;
        column-gap: 50px;
    }

    a {
        color: #5D64EA;
        font-size: 16px;
        font-weight: 500;
        text-decoration: none;
    }

    a:hover {
        color: #4045A0 ;
    }

    a:focus {
        outline: none;
        box-shadow: none;
        color: white;
    }

    .sbtn {
        cursor: pointer;
        height: 50px;
        border-radius: 50px;
        background-color: #5D64EA;
        margin: 20px 0;
        border: none;
        font-size: 18px;
        font-weight: 500;
        color: #ffffff;
        width: 500px;
    }

    .input-field input:focus {
        border-color: #5D64EA;
    }

    .sbtn:hover {
        background-color: #4045A0 ;
    }

    .sbtns {
        margin: 20px 0;
        height: 50px;
        border-radius: 50px;
        background-color: #ffffff;
        border: 2px solid #5D64EA;
        font-size: 18px;
        font-weight: 500;
        cursor: pointer;
        width: 500px;
    }

    .sbtns:hover {
        background-color: #4045A0 ;
        color: #ffffff;
    }

    ::placeholder {
        color: lightgrey;
        opacity: 1;
    }

    input[type=password]:focus {
        border-color: #5D64EA;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
    }

    .about_btn:hover {
        background-color: #4045A0 ;
        color: #ffffff;
    }

    .hide-loader {
        display: none;
    }

    input[type=email]:focus {
        border-color: #5D64EA;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
    }

    input[type=text]:focus {
        border-color: #5D64EA;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
    }

    .overlayy {
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
        display: flex;
        justify-content: center;
    }

    .overlayy:target {
        visibility: visible;
        opacity: 1;
    }

    .about_popup {
        padding: 30px;
        background: white;
        border-radius: 10px;
        position: relative;
        transition: all 5s ease-in-out;
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: space-between;
        max-height: 600px;
        overflow-y: scroll;
        width: 556px;
        margin-top: 50px;
    }

    .about_logo {
        width: 132px;
        height: 39px;
    }

    .about_popup .about_content_container {
        font-size: 18px;
        line-height: 3.7rem;
        color: white;
        padding: 20px 20px 0 20px;
    }

    .about_popup .about_close {
        transition: all 200ms;
        font-size: 30px;
        font-weight: bold;
        text-decoration: none;
        color: black;
        cursor: pointer;
    }

    .about_popup .about_head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .about_btn {
        padding: 12px;
        background-color: #5D64EA;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        width: 110px;
        border-radius: 4px;
        color: white;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        margin: 0;
        box-shadow: 0px 4px 4px rgb(0 0 0 / 25%);
    }

    .login_popup {
        padding: 30px;
        background: white;
        border-radius: 5px;
        position: relative;
        transition: all 5s ease-in-out;
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: space-between;
        min-height: 100px;
        max-width: 480px;
        min-width: 380px;
        width: 100%;
    }

    .login_popup .login_close {
        position: absolute;
        top: 10px;
        right: 10px;
        transition: all 200ms;
        font-size: 30px;
        font-weight: bold;
        text-decoration: none;
        color: black;
        float: right;
        cursor: pointer;
    }

    .login_popup .login_head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .login_popup .login_content_container {
        font-size: 18px;
        line-height: 3.7rem;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        width: 100%;
        min-height: 100px;
        max-width: 480px;
        min-width: 380px;
    }

    .login_popup .login_content_container input {
        width: 100%;
        display: block;
        width: 100%;
        height: 41.98px;
        padding: 0.375rem 2.25rem 0.375rem 0.75rem;
        -moz-padding-start: calc(.75rem - 3px);
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #000;
        background-color: #fff;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        -webkit-appearance: none;
        appearance: none;
        text-align: left;
    }

    .login_popup .login_content_container button {
        height: 41.98px;
        cursor: pointer;
        border: 1px solid transparent;
        outline: none;
        font-size: 1rem;
        font-weight: 400;
        padding: 0.625em 1.25em;
        border-radius: 4px;
        background-color: #5D64EA;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: -1em;
    }

    .login_popup .login_content_container button:hover {
        background-color: #4045A0 ;
        color: #ffffff;
    }

    .input-login {
        margin-bottom: 10px;
        display: flex;
        flex-direction: column;
    }

    .input-icons {
        margin-bottom: 10px;
        display: flex;
        flex-direction: column;
    }

    .input-login i {
        position: absolute;
    }

    form a:focus {
        color: #4045A0 ;
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

    .about_signup_button {
        width: 232px;
        height: 45px;
        background: #5D64EA;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.25);
        border-radius: 10px;
        border: none;
        font-weight: 600;
        font-size: 18px;
        line-height: 156.2%;
        color: #FFFFFF;
        cursor: pointer;
    }

    .about_signup_button:hover {
        background: #4045A0 ;
        color: white;
    }

    .input-icons img {
        position: absolute;
    }

    .icon {
        padding: 10px;
        color: #5D64EA;
        min-width: 40px;
        text-align: center;
        font-size: 20px;
    }

    .input-field {
        padding: 10px;
        text-align: center;
        height: 64px;
        width: 100%;
    }
</style>
</head>

    <body>
        <div class="box">
            <div style="display: flex;align-items: center;justify-content: space-between;margin-bottom: 30px;">
                <div style="margin: 30px;width:150px;"><img src="<?php print plugins_url('images/chargerly_logo.png', __FILE__) ?>" alt="" style="width: 100%;"></div>
                <div style="display: flex;align-items: center;column-gap: 40px;margin: 30px;">
                    <a href="#about"><button class="about_btn">About</button></a>
                </div>
            </div>

            <!-- About -->
            <div id="about" class="overlayy">
                <div class="about_popup">
                    <div class="about_head">
                        <div class="about_logo"><img src="<?php print plugins_url('images/chargerly_logo.png', __FILE__) ?>" alt="" style="width: 100%;height:100%"></div>  
                        <div id="err_close" class="about_close"><img src="<?php print plugins_url('images/close.png', __FILE__) ?>" alt="" srcset=""></div>
                    </div>
                    <div class="about_content_container">
                        <div style="color: #5D64EA;font-size: 17px;font-weight: 600;margin-bottom: 14px;"><span style="color: black;">Chargely - </span>Free Subscription Payments Plugin for Woocommerce</span></div>
                        <div style="display: flex;row-gap: 24px;justify-content: center;flex-direction: column;">
                            <div style="display: flex;column-gap: 12px;">
                                <div style="color: black;font-weight: 400;font-size: 18px;line-height: 2rem;">
                                    Chargely is a Advanced Subscription/Recurring Payments Plugin developed by Payment experts 
                                    previously worked with PayPal and Braintree.
                                </div>
                            </div>
                            <div style="display: flex;column-gap: 12px;">
                                <div style="color: black;font-weight: 400;font-size: 18px;line-height: 156.2%;">
                                    You don't need to be PCI certified as chargely provides a PCi certified payment page for card processing
                                </div>
                            </div>
                            <div style="display: flex;column-gap: 12px;">
                                <div style="color: black;font-weight: 400;font-size: 18px;line-height: 156.2%;">
                                    Your customer data is stored in a secured and certified environment
                                </div>
                            </div>
                        </div>
                        <div style="display: flex;align-items: center;justify-content: space-between;">
                            <div>
                                <button id="about_signup_button" class="about_signup_button">Start Free Trial</button>
                            </div>
                            <div style="width: 250px;height: auto;">
                                <img style="width: 100%;height: 100%;" src="<?php print plugins_url('images/about.jpg' , __FILE__) ?>" alt="" srcset="">
                            </div>
                        </div>
                    </div>
                </div>  
            </div>

            <div  class="first_box" style="column-gap: 50px;padding-right: 50px;">
                <div style="width: 50%;height: 500px;padding-left: 80px;margin-bottom: 50px;">
                    <img class="laptop" src="<?php print plugins_url('video/ts.gif' , __FILE__) ?>" alt="" style="width: 100%;height: 100%;border: 8px solid;border-radius: 22px;box-shadow: rgb(0 0 0 / 15%) 0px 2px 8px;">
                    <img class="phone" src="<?php print plugins_url('images/phone.png' , __FILE__) ?>" alt="" style="width: 200px;position: absolute;top: 25%;left: 100px;">
                </div>
                <div class="container" style="display: flex;width: 50%;flex-direction: column;align-items: center;">

                    <div style="text-align: center;">
                        <div style="display: flex;align-items: center;">
                            <div style="height: 40px;width: 50px;">
                                <img src="<?php print plugins_url('images/icon.png' , __FILE__) ?>" alt="" style="width: 100%;height: 100%;">
                            </div>
                        <div style="width: 500px;"><div style="font-size: 20px;font-weight: 700;">Enable Subscriptions on Your Woocommernce Store</div ></div>
                    </div>
                        <p>Get the Merchant ID & API Key from the account settings page in <br/>
                        <a target="_blank" style="text-decoration:underline;" href="https://chargely.com/merchant/dashboard/account/settings/profile">chargely.com</a></p>
                    </div>
                    <div>
                        <div id="merchant_err_msg" class="merchant_err_msg" style="margin-bottom: 20px;color: white;background-color: #f33;border-radius: 4px;padding: 0 10px;font-size: 16px;height: 41px;display: none ;align-items: center;"></div>
                        <form action="javascript:void(0)" style="display: flex;flex-direction: column;row-gap: 10px;">
                            <div class="input-icons">
                                <img src="<?php print plugins_url('images/login_account.png' , __FILE__) ?>" alt="" style="width: 18px;height: 18px;margin: 14px 0 0 14px;">
                                <input class="input-field" type="password" name="mercant_id" id="merchant_ID" placeholder="Enter Your Merchant ID" maxlength="8" style="width: 500px;height: 50px;">
                                <p id="merchant_id_err"  style="color: red;margin: 0;padding: 0 2px;text-align: left;"></p>
                            </div>
                            <div class="input-icons">
                                <img src="<?php print plugins_url('images/login_key.png' , __FILE__) ?>" alt="" style="width: 18px;height: 18px;margin: 14px 0 0 14px;">
                                <input class="input-field" type="password" name="api_key" id="APIKEY" placeholder="Enter Your Api Key" maxlength="37" style="width: 500px;height: 50px;">
                                <p id="api_key_err"  style="color: red;margin: 0;padding: 0 2px;text-align: left;"></p>
                            </div>
                            <button id="login_btn" class="sbtn" type="submit">Log In</button>
                        </form>
                    </div>
                    <div style="display: flex;align-items: center;column-gap: 10px;margin: 10px 0;">
                        <div style="height: 1px;background-color: grey;width: 200px;"></div>
                        <div>Or</div>
                        <div style="height: 1px;background-color: grey;width: 200px;"></div>
                    </div>
                    <button class="sbtns" id="signup_btn">Start Free Trial</button>
                </div>
            </div>
            <div><div style="display: flex;justify-content: center;column-gap: 50px;font-size: 18px; padding: 0 50px;">
				<div style="display: flex;align-items: center;justify-content: center;">
					<div style="width: 50px;display: flex;align-items: center;justify-content: center;">
						<img style="width: 100%; height:100%;" src="<?php print plugins_url('images/pci_compliance_logo.png' , __FILE__) ?>" alt="img">
					</div>
					Certified Payment Page
				</div>
				<div style="display: flex;align-items: center;justify-content: center;column-gap: 5px;">
					<div style="width: 50px;display: flex;align-items: center;justify-content: center;">
						<img style="width: 100%; height:100%;" src="<?php print plugins_url('images/secure.png' , __FILE__) ?>" alt="img">
					</div>
					Secure Data Storage
				</div>
				<div style="display: flex;align-items: center;justify-content: center;column-gap: 5px;">
					<div style="width: 50px;display: flex;align-items: center;justify-content: center;">
						<img style="width: 100%; height:100%;" src="<?php print plugins_url('images/payment_gateway.png' , __FILE__) ?>" alt="img">
					</div>
					Popular Gateways
				</div>
				<div style="display: flex;align-items: center;justify-content: center;">
					<div style="width: 50px;display: flex;align-items: center;justify-content: center;">
						<img style="width: 100%; height:100%;" src="<?php print plugins_url('images/currency-card-color-icon.jpg' , __FILE__) ?>" alt="img">
					</div>
					Multiple Currency Support
				</div>
			</div>
			<div>	
				<p style="font-size: 34px;font-weight: 500;padding: 20px;text-align: center;">Payment Gateway Support</p>
				<div style="display: flex;align-items: center;justify-content: center;padding-bottom: 100px;column-gap: 70px;">
				<div style="width: 150px;padding: 25px;height: 30px;border-radius: 5px;display: flex;align-items: center;justify-content: center;box-shadow: rgba(0, 0, 0, 0.15) 0px 2px 8px; background-color: #ffffff;">
					<img style="width: 100%; height:auto;" src="<?php print plugins_url('images/Stripe_Logo.png' , __FILE__) ?>" alt="img">
				</div>	
				<div style="width: 150px;padding: 25px;height: 30px;border-radius: 5px;display: flex;align-items: center;justify-content: center;box-shadow: rgba(0, 0, 0, 0.15) 0px 2px 8px; background-color: #ffffff;">
					<img style="width: 100%; height:auto;" src="<?php print plugins_url('images/PayPal.png' , __FILE__) ?>" alt="img">
				</div>
				<div style="width: 150px;padding: 25px;height: 30px;border-radius: 5px;display: flex;align-items: center;justify-content: center;box-shadow: rgba(0, 0, 0, 0.15) 0px 2px 8px; background-color: #ffffff;">
					<img style="width: 100%; height:auto;" src="<?php print plugins_url('images/Braintree_logo.png' , __FILE__) ?>" alt="img">					
				</div>
                <div style="width: 150px;padding: 25px;height: 30px;border-radius: 5px;display: flex;align-items: center;justify-content: center;box-shadow: rgba(0, 0, 0, 0.15) 0px 2px 8px; background-color: #ffffff;">
					<img style="width: 100%; height:auto;" src="<?php print plugins_url('images/adyen.svg' , __FILE__) ?>" alt="img">					
				</div>
            </div>
        </div>
        
        <div id="reg_api_error_popup_invalid" class="overlay">
            <div class="err_popup">
                <div class="err_content_container" id="reg_api_err_msg"></div>  
                <div><a class="err_close" href="#register">×</a></div>
            </div>  
        </div>

        <div id="log_api_error_popup_invalid" class="overlay">
            <div class="err_popup">
                <div class="err_content_container" id="log_api_err_msg"></div>  
                <div><a class="err_close" href="#login">×</a></div>
            </div>  
        </div>

        <div id="das_api_error_popup_invalid" class="overlay">
            <div class="err_popup">
                <div class="err_content_container" id="das_api_err_msg"></div>  
                <div><a class="err_close" href="admin.php?page=login">×</a></div>
            </div>  
        </div>

        <script>
        
            const loaderContainer = document.querySelector('.loader');
            const login_btn = document.getElementById("login_btn");
            const merchant_id = document.getElementById("merchant_ID");
            const api_key = document.getElementById("APIKEY");
            const merchant_id_err = document.getElementById("merchant_id_err");
            const api_key_err = document.getElementById("api_key_err");
            const merchant_err_msg = document.getElementById("merchant_err_msg");
            let das_api_err_msg = document.getElementById("das_api_err_msg");

            const about_signup_button = document.getElementById("about_signup_button");
            about_signup_button.addEventListener("click", (e) => {
                e.preventDefault()
                let origin = window.location.origin;
                let pathname = window.location.pathname;
                let about_signup_url = "https://chargely.com/oauth/merchant?redirect_uri=" + origin + pathname + "&page=dashboard&utm_source=woocommerceplugin&utm_medium=banner&utm_campaign=woocommerce";
                window.location.href = about_signup_url;
            });

            const signup_btn = document.getElementById("signup_btn");
            signup_btn.addEventListener("click", (e) => {
                e.preventDefault()
                let origin = window.location.origin;
                let pathname = window.location.pathname;
                let signup_url = "https://chargely.com/oauth/merchant?redirect_uri=" + origin + pathname + "&page=dashboard&utm_source=woocommerceplugin&utm_medium=banner&utm_campaign=woocommerce";
                window.location.href = signup_url;
            });

            login_btn.addEventListener("click", (e) => {

                var merchantEmailValue = merchant_id.value.trim();
                var merchantPasswordValue = api_key.value.trim();

                if (merchantEmailValue == "") {
                    setErrorr(merchant_id, "Merchant Id is required*");
                    merchant_id.style.border = "1px solid red";
                    return false;
                }else if(merchantEmailValue.length<8){
                    setErrorr(merchant_id, "The Merchant Id field must have 8 characters");
                    merchant_id.style.border = "1px solid red";
                    return false;
                }else{
                    merchant_id.style.border = "1px solid green";
                    merchant_id_err.innerText = '';
                }

                if (merchantPasswordValue == "") {
                    setErrorr(api_key, "Api Key is required*");
                    api_key.style.border = "1px solid red";
                    return false;
                }else if(merchantPasswordValue.length<37){
                    setErrorr(api_key, "The Api Key field must have 37 characters");
                    api_key.style.border = "1px solid red";
                    return false;
                }else {
                    api_key.style.border = "1px solid green";
                    api_key_err.innerText = '';
                }

                function setErrorr(u, msg) {
                    var parentBox = u.parentElement;
                    parentBox.className = "input-icons";
                    var p = parentBox.querySelector("p");
                    p.innerText = msg;
                }

                AmagiLoader.show();

                if (merchant_id.value && api_key.value) {
                    AmagiLoader.show();
                    e.preventDefault()
                    const request = new XMLHttpRequest();
                    request.open("GET", "https://chargely.com/api/get/merchant/by/" + merchant_id.value);
                    request.onload = () => {
                        let response_api_key = JSON.parse(request.response).message.api_key;
                        let response_merchant_id = JSON.parse(request.response).message.merchant_id;
                        if (response_api_key === api_key.value) {	
                            AmagiLoader.hide();
                            localStorage.setItem("Chargely_Woocommernce_Merchant_id", response_merchant_id);
                            localStorage.setItem("Chargely_Woocommernce_Api_Key", response_api_key);
                            document.cookie="Chargely_Woocommernce_Merchant_id=" + response_merchant_id;
                            document.cookie="Chargely_Woocommernce_Api_Key=" + response_api_key;
                            window.location.href = "admin.php?page=dashboard";
                        } else {
                            AmagiLoader.hide();
                            window.location.href = "#error_popup_invalid";
                        }
                    }
                    request.setRequestHeader("Authorization", "Basic " + btoa(merchant_id.value + ":" + api_key.value)); 
                    request.send();
                }else{

                }

                return true;

            });
        
            <?php
            if(count($getallplans)>0){
                foreach($getallplans as $key=>$value){

                $consumer_key = $value->consumer_key;
                $consumer_key_encode = json_encode($consumer_key);
            ?>
            const consumer_key = <?php print $consumer_key_encode ?>;
            localStorage.setItem("Chargely_Woocommernce_consumer_key", consumer_key);
            <?php
                }
            }
            ?>

        </script>
        <div id="error_popup_invalid" class="overlay">
            <div class="err_popup">
                <div class="err_content_container">Invalid Credentials</div>  
                <div><a class="err_close" href="admin.php?page=login">×</a></div>
            </div>  
        </div>

        <script>
            let err_close = document.getElementById("err_close");

            err_close.addEventListener("click", (e) => {
                e.preventDefault()
                localStorage.clear();
                window.location.href = "admin.php?page=login";
            });
        </script>

        <div class="loader" id="loader"></div>
    </body>

<script async src="https://www.googletagmanager.com/gtag/js?id=G-SG0BWN3MYP"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-SG0BWN3MYP');
</script>
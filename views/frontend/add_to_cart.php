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
    input[type=number]{
        min-height: 0;
        padding: 0;
        margin-bottom: 0;
    }
    .label{
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 10%;
    }
    @media screen and (max-width: 700px){
        .popup{
            width: 70%;
        }
    }
    .fields{
      display: flex;
      text-align: left;
      justify-content: space-between;
      column-gap: 20px;
    }
    .field{
      display: flex;
      flex-direction: column;
      text-align: left;
    }
    .box{
        border: 1px solid;
        padding: 12px;
        margin-top: 12px;
    }
    input[type=number]:focus{
        outline: 0;
    }
    select[type=product_id]:focus{
        outline: 0;
    }
    select[id=billing_period_type]:focus{
        outline: 0;
    }
    .woocommerce .price ins, .woocommerce bdi {
        display: none;
    }
    .woocommerce div.product .quantity+.single_add_to_cart_button {
        display: none;
    }
    .woocommerce div.product .quantity .qty {
        display: none;
    }
    .billing_cycle{
        border: 1px solid #c4c4c4;
        font-size: 10px;
        font-weight: bold;
        margin: 10px 0;
    }
    .custom_quantity{
        border: 1px solid;
        font-size: 10px;
        font-weight: bold;
        padding: 0px 12px;
    }
    .cart{
        display: none;
    }
    .price{
        display: none;
    }
    .quantity{
        display: none;
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
<?php
    global $product;
    $price = $product->get_price();
    $id = $product->get_id();
    $product_name = $product->get_title();
    $sku = $product->get_sku();
    $add_to_cart_url = $product->add_to_cart_url();
    $type = $product->get_type();
    $checkout_url = WC()->cart->get_checkout_url();
    $currency_code = get_woocommerce_currency();
    $currency_symbol = get_woocommerce_currency_symbol();
    $regular_price = get_post_meta( get_the_ID(), '_regular_price', true);
    $sale_price = get_post_meta( get_the_ID(), '_sale_price', true);

    $currency_code_encode = json_encode($currency_code);
    $product_name_encode = json_encode($product_name);


    global $wpdb;
    $getallproductfrontend = $wpdb->get_results(
    $wpdb->prepare("SELECT * from ".chargely_product_table_name()." ORDER BY product_id desc ","")
    );

    $test_db = json_encode($getallproductfrontend);

    if( $product){
    echo '
    <form id="mainForm" name="mainForm" action="" method="post" style="display:none">
    </form>

    <form id="mainForm" name="mainForm" action="" method="post">
        <div class="label">
            <div>SELECT FREQUENCY</div>
            <div class="learn_more">Learn more</div>
        </div>
        <div class="box">
            <div style="display: flex;justify-content: space-between;align-items: center;">
                <div style="display: flex;align-items: center;column-gap: 2px;"><input type="radio" name="rads" id="one_time_btn_localstorage" style="cursor: pointer;" value="'.$price.'" checked/>One-Time Purchase</div>
                <div>'.$currency_symbol.' <span>'.number_format($price, 2).'</span></div>
            </div>
        </div>
        <div id="subscribe"></div>
        <div style="display: flex;align-items: center;justify-content: space-between;">
            <div style="width: 20%;margin-top: 10px;">
                <fieldset class="custom_quantity">
                    <legend>QUANTITY</legend>
                    <input type="number" name="custom_quantity" id="custom_quantity" min="1" placeholder="0" style="width: 100%;border:none;height: 30px;"> 
                </fieldset>
            </div>

            <div style="width: 70%;margin-top: 10px;" id="cus_addtocart_btn">
                <a class="button alt wp-element-button" id="test" style="text-transform: uppercase;display: flex;align-items: center;justify-content: center;border: none;column-gap: 22px;">
                    <div id="text">Add to cart</div>
                    <div>'.$currency_symbol.'<span id="result">'.number_format($price, 2).'</span></div>
                </a>
            </div>
        </div>
    </form>'; 
?>

<script>
    let local_storage_arr = [];
    let currency_code = <?php print $currency_code_encode ?>;

    let product_name = <?php print $product_name_encode ?>;

    let currency_symbol = '<?php print $currency_symbol ?>';
    let billing_cycle_frequency;
    let billing_cycle;
    
    const subscribe_price = document.getElementById("subscribe");
    const ress = <?php print $test_db?>;

    const product_id_db = <?php print $id?>;

    const wc_price = <?php print $price?>;

    ress.forEach(element => {
        if (parseInt(element.product_id) === product_id_db && element.status === "Active") {
            let cal_update_price = ((parseInt(wc_price) * parseInt(element.percentage))/100);
            let display_update_price = ((parseInt(wc_price)-cal_update_price));
            
            let top_header = `
            <div class="box">
                <div style="display: flex;justify-content: space-between;align-items: center;">
                    <div style="display: flex;align-items: center;column-gap: 2px;"><input type="radio" id="subscribe_btn_localstorage" name="rads" style="cursor: pointer;" value="${(display_update_price).toFixed(2)}" >Subscribe &amp; Save ${element.percentage}%</div>
                    <div><span style="text-decoration: line-through;">${currency_symbol}${(wc_price).toFixed(2)}</span> ${currency_symbol}${(display_update_price).toFixed(2)}</div>
                </div>
                <fieldset class="billing_cycle">
                <legend>DELIVER EVERY</legend>
                <select name="" style="width: 100%;border:none;cursor: pointer;" type="product_id" id="billing_cyclee">`;


            let select_option = '';
            const billing_period_array = element.billing_period;
            const billing_period_split =  billing_period_array.split(",");
            const billing_period_type_array = element.billing_period_type;
            const billing_period_type_split =  billing_period_type_array.split(",");
                
            billing_period_type_split.forEach((element,i) => {
                select_option =  select_option + `<option type="product_id" class="form-control" id="product_id" name="product_id" value='${billing_period_split[i]}${element}' required>${billing_period_split[i]} ${element}</option>`
            });
                    
            let footer = `</select>
                </fieldset>
            </div>`;

            let main_html = top_header + select_option + footer;

            subscribe_price.innerHTML = subscribe_price.innerHTML + main_html;

            const billing_cyclee = document.getElementById("billing_cyclee");

            billing_cyclee.addEventListener('click', (e)=>{
                let billing_cycle_selected = e.target.value;
                let billing_cycle_split = billing_cycle_selected.split(/(\d+)/);
                billing_cycle_frequency = billing_cycle_split[1];
                billing_cycle = billing_cycle_split[2];
            });
        }
    });
    
    const one_time_btn_localstorage = document.getElementById("one_time_btn_localstorage");
    const subscribe_btn_localstorage = document.getElementById("subscribe_btn_localstorage");
    const cus_qty = document.getElementById("custom_quantity");
    const cus_addtocart_btn = document.getElementById("cus_addtocart_btn");

    var addcart_text = "ADD TO CART";
    var subscribe_text = "SUBSCRIBE";

    document.mainForm.onclick = function(){
        
        var radVal = document.mainForm.rads.value;
        var t = ((radVal)*(cus_qty.value)).toFixed(2);
        result.innerHTML = t;    
        cus_addtocart_btn.addEventListener("click", (e) => {
            AmagiLoader.show();
            e.preventDefault()
            document.cookie = `cookie1=0; path=/`;

            if (one_time_btn_localstorage.checked===true) {
                var endpoint = window.location.href;
                let ONE_URL = `${endpoint}?add-to-cart=${product_id_db}&quantity=${cus_qty.value}&price=${radVal}&product_name=${product_name}&currency=${currency_code}&billing_cycle=null&frequency=null&isOneTypePayment=true&product_type=One-time`;
                var ONE_URL_request = new XMLHttpRequest();
                ONE_URL_request.open("PUT", ONE_URL , true);
                ONE_URL_request.setRequestHeader('Content-Type', 'application/json');
                ONE_URL_request.onreadystatechange=()=>{
                    AmagiLoader.hide();
                }

                ONE_URL_request.send();

            }else if(subscribe_btn_localstorage.checked===true){
                if (billing_cycle != undefined){
                    var endpoint = window.location.href;
                    let SUB_URL = `${endpoint}?add-to-cart=${product_id_db}&quantity=${cus_qty.value}&price=${radVal}&product_name=${product_name}&currency=${currency_code}&billing_cycle=${billing_cycle}&frequency=${billing_cycle_frequency}&isOneTypePayment=false&product_type=Subscription`;
                    var SUB_URL_request = new XMLHttpRequest();
                    SUB_URL_request.withCredentials = true;
                    SUB_URL_request.addEventListener("readystatechange", function() {
                        if(this.readyState === 4) {
                            AmagiLoader.hide();
                        }
                    });
                    SUB_URL_request.open("POST", SUB_URL);
                    SUB_URL_request.send();
                }else if (billing_cycle == undefined){
                    AmagiLoader.hide();
                    window.location.href = "#error_popup";
                }
            }
        });
    }

</script>
<?php
}
?>
<div class="loader" id="loader"></div>

<div id="error_popup" class="error_overlay">
    <div class="error_popup">
        <div class="error_left_line"></div>
        <div class="error_content-container">
            <div class="error_content" id="err_msg">Billing Cycle Requried</div>
            <div  id="err_close">
                <a href="#" class="error_close" onclick="history.go(-1)">x</a>
            </div>
        </div>
    </div>
</div>
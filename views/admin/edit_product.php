<head>


<?php
$plan_id = isset($_GET['edit']) ? intval($_GET['edit']) : 0;
global $wpdb;
$plan_detail = $wpdb->get_row(
  $wpdb->prepare(
    "SELECT * from ".chargely_product_table_name()." WHERE product_id = %d ",$plan_id
  ),ARRAY_A
);
?>

<style>
  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
    border-radius: 4px;
    box-shadow: rgb(50 50 93 / 25%) 0px 6px 12px -2px, rgb(0 0 0 / 30%) 0px 3px 7px -3px;
    margin-bottom: 20px;
  }

  td,
  th {
      text-align: center;
      padding: 8px;
  }

  .header {
      background-color: #5D64EA;
      color: white;
  }

  td input {
      border: none;
      font-size: 18px;
      text-align: center;
  }

  .form-group {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 50% 10px 0;
      font-size: 18px;
      text-transform: unset;
      font-weight: 500;
  }

  .form-group input {
      width: 60%;
      height: 30px;
      padding: 10px;
      border: 1px solid darkgrey;
      border-radius: 4px;
  }

  input[class=form-control]:focus {
      border-color: #5D64EA;
      outline: 0;
      box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
  }

  select[class=form-control]:focus {
      border-color: #5D64EA;
      outline: 0;
      box-shadow: 0 0 0 0.25rem rgb(98 31 105 / 20%);
  }

  .go_back {
      background-color: #5D64EA;
      padding: 10px;
      width: 100px;
      color: white;
      font-size: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      border-radius: 6px;
      box-shadow: rgb(50 50 93 / 25%) 0px 6px 12px -2px, rgb(0 0 0 / 30%) 0px 3px 7px -3px;
      cursor: pointer;
  }

  .go_back:hover {
      background-color: #4045A0 ;
      color: white;
      text-decoration: none;
  }

  .update_btn {
      background-color: #5D64EA;
      padding: 10px;
      width: 120px;
      color: white;
      font-size: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      border-radius: 6px;
      box-shadow: rgb(50 50 93 / 25%) 0px 6px 12px -2px, rgb(0 0 0 / 30%) 0px 3px 7px -3px;
      cursor: pointer;
      border: none;
  }

  .update_btn:hover {
      background-color: #4045A0 ;
      color: white;
      text-decoration: none;
  }

  .add_btn {
      margin-left: 12px;
      padding: 6px 12px;
      background: wheat;
      background-color: #5D64EA;
      width: 50px;
      color: white;
      font-size: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      border-radius: 6px;
      box-shadow: rgb(50 50 93 / 25%) 0px 6px 12px -2px, rgb(0 0 0 / 30%) 0px 3px 7px -3px;
      cursor: pointer;
      border: none;
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
</style>
</head>

<div class="wrap">
	<div style="display: flex;align-items: center;column-gap: 7px;font-size: 22px;font-weight: 700;color: #5D64EA;">

		<?php settings_errors(); ?>
	</div>

<div class="container" style="width:100%; margin-top: 10px;">
<div class="row">
    <div class="panel">
    <div class="panel-body" style="display: flex; justify-content: center;">
    <form action="javascript:void(0)" id="frmEditProduct" style="width: 70%; background-color: #f6f7f7; padding: 50px;">
    <input type="hidden" name="plan_id" value="<?php print isset($_GET['edit']) ? intval($_GET['edit']) : 0; ?>"/>
    
    <div style="display: flex;align-items: center;justify-content: space-between;margin-bottom: 20px;">
      <h1>Edit Product</h1>
      <a href="javascript:history.go(-1)" class="go_back" title="Return to the previous page">« Go back</a>
    </div>
      <table id="tblCancelledProduct">
        <thead style="background-color: #5D64EA;color: white;">
          <tr>
            <th>Product Id</th>
            <th>Product Name</th>
            <th>Product Price</th>
          </tr>
        </thead>
        <tbody id="status_deactive">
          <tr style="background-color: white;">
            <td><input style="background-color: white;" type="product_id" value="<?php print $plan_detail['product_id']; ?>" class="form-control" id="product_id" name="product_id" required readonly></td>
            <td><input style="background-color: white;" type="product_name" value="<?php print $plan_detail['product_name']; ?>" class="form-control" id="product_name" name="product_name" required readonly></td>
            <td><input style="background-color: white;" type="price" value="<?php print $plan_detail['price']; ?>" class="form-control" id="price" name="price" required readonly></td>
          </tr>
        </tbody>
      </table>
  <div class="form-group">
    <label for="percentage">Percentage</label><br>
    <input type="number" min="1" value="<?php print $plan_detail['percentage']; ?>" class="form-control" id="percentage" name="percentage" min="0" required>
  </div>

  <div class="form-group" style="display:none">
    <label for="updated_price">Updated Price</label><br>
    <input type="updated_price" value="<?php print $plan_detail['updated_price']; ?>" class="form-control" id="updated_price" name="updated_price" required readonly>
  </div>

  <div class="form-group" style="flex-direction: column;align-items: flex-start;">
    <div for="billing_cycle">Billing Cycle</div><br>
    <div style="display: flex;align-items: center;margin-bottom: 10px;">
      <div>
        <select type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>
          <option value="1" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>1</option>
          <option value="2" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>2</option>
          <option value="3" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>3</option>
          <option value="4" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>4</option>
          <option value="5" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>5</option>
          <option value="6" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>6</option>
          <option value="7" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>7</option>
          <option value="8" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>8</option>
          <option value="9" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>9</option>
          <option value="10" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>10</option>
          <option value="11" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>11</option>
          <option value="12" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>12</option>
          <option value="13" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>13</option>
          <option value="14" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>14</option>
          <option value="15" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>15</option>
          <option value="16" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>16</option>
          <option value="17" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>17</option>
          <option value="18" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>18</option>
          <option value="19" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>19</option>
          <option value="20" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>20</option>
          <option value="21" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>21</option>
          <option value="22" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>22</option>
          <option value="23" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>23</option>
          <option value="24" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>24</option>
          <option value="225" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>25</option>
          <option value="26" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>26</option>
          <option value="27" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>27</option>
          <option value="28" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>28</option>
          <option value="29" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>29</option>
          <option value="30" type="billing_period_add_id" class="form-control" id="billing_period_add_id" name="billing_period_add_id" required>30</option>        
        </select>
      </div>
      <div>
        <select type="billing_period_type_add_id" class="form-control" id="billing_period_type_add_id" name="billing_period_type_add_id" required>
          <option value="Weekly" type="billing_period_type_add_id" class="form-control" id="billing_period_type_add_id" name="billing_period_type_add_id" required>Weekly</option>
          <option value="Monthly" type="billing_period_type_add_id" class="form-control" id="billing_period_type_add_id" name="billing_period_type_add_id" required>Monthly</option>
          <option value="Yearly" type="billing_period_type_add_id" class="form-control"  id="billing_period_type_add_id" name="billing_period_type_add_id" required>Yearly</option>        
        </select>
      </div>
      <div><div class="add_btn" id="add_billing_cycle_btn">Add</div></div>
    </div>
    <div style="display: flex;align-items: center;">
      <div id="billig_period_innerHTML_id" style="display: flex;flex-direction: column;row-gap: 10px;"></div>
      <div id="billig_period_type_innerHTML_id" style="display: flex;flex-direction: column;row-gap: 10px;"></div>
    </div>
    <div>
      <?php 
        $billing_period_db = $plan_detail['billing_period']; 
        $billing_period_db_encode = json_encode($billing_period_db);
      ?>
    </div>
    <div>
      <?php 
        $billing_period_type_db = $plan_detail['billing_period_type']; 
        $billing_period_type_db_encode = json_encode($billing_period_type_db);
        ?>
    </div>
  </div>

  <div class="form-group">
    <label for="status">Status</label><br>
    <select type="status" class="form-control" id="status" name="status" style="width: 60%;" required>
        <option value="<?php print $plan_detail['status']; ?>" type="status" class="form-control" id="status" name="status" required><?php print $plan_detail['status']; ?></option>
    </select>
  </div>
  
  <button class="update_btn" type="submit" class="btn btn-default">Update</button>
</form>
    </div>
</div>
</div>
</div>

<script>
    let consumer_key_Access = localStorage.getItem("Chargely_Woocommernce_consumer_key");
    let Api_Key_Access = localStorage.getItem("Chargely_Woocommernce_Api_Key");
    if (!consumer_key_Access) {
        window.location.href = "#error_popup_dashboard";
        frmEditProduct.style.display = "none";
    }else if(!Api_Key_Access){
        window.location.href = "#error_popup_login";
        frmEditProduct.style.display = "none";
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
    
    var u = new URLSearchParams(window.location.search);
    if (u?.get('edit') === null) {
      frmEditProduct.style.display = "none";
      window.location.href = "#chosse_product";
    }

</script> 


<script>
var billing_period_arr = [];
var billing_period_type_arr = [];
var options;
const product_id = document.getElementById("product_id");
const product_name = document.getElementById("product_name");
const price_input = document.getElementById("price");
const percentage_input = document.getElementById("percentage");
const status = document.getElementById("status");
const updated_price_input = document.getElementById("updated_price");
percentage_input.addEventListener('change', ()=>{
    calculate_updated_price_input = ((parseInt(price_input.value) * parseInt(percentage_input.value))/100);
    let updated_price_inputvalue = ((parseInt(price_input.value)-calculate_updated_price_input)).toString();
});

if (status.value === "Active") {
  options = `<option value="Deactive" type="status" class="form-control" id="status" name="status" required>Deactive</option>`;
  status.innerHTML = status.innerHTML + options;
}else{
  options = `<option value="Active" type="status" class="form-control" id="status" name="status" required>Active</option>`;
  status.innerHTML = status.innerHTML + options;
}


    var billig_period_innerHTML_id = document.getElementById("billig_period_innerHTML_id");
    var billing_period_add_id = document.getElementById("billing_period_add_id");
    var add_billing_cycle_btn = document.getElementById("add_billing_cycle_btn");
    var billing_period_add_id = document.getElementById("billing_period_add_id");
    let billig_period_innerHTML = '';
    var billing_period_array = <?php print $billing_period_db_encode ?>;
    var billing_period_array_split = billing_period_array?.split(',');
    billing_period_array_split?.forEach(billing_period_element => {
      billig_period_innerHTML =`
        <select type="billing_period" class="form-control" id="billing_period" name="billing_period" required>
        <option value="${billing_period_element}" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>${billing_period_element}</option>
          <option value="1" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>1</option>
          <option value="2" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>2</option>
          <option value="3" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>3</option>
          <option value="4" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>4</option>
          <option value="5" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>5</option>
          <option value="6" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>6</option>
          <option value="7" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>7</option>
          <option value="8" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>8</option>
          <option value="9" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>9</option>
          <option value="10" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>10</option>
          <option value="11" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>11</option>
          <option value="12" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>12</option>
          <option value="13" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>13</option>
          <option value="14" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>14</option>
          <option value="15" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>15</option>
          <option value="16" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>16</option>
          <option value="17" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>17</option>
          <option value="18" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>18</option>
          <option value="19" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>19</option>
          <option value="20" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>20</option>
          <option value="21" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>21</option>
          <option value="22" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>22</option>
          <option value="23" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>23</option>
          <option value="24" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>24</option>
          <option value="225" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>25</option>
          <option value="26" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>26</option>
          <option value="27" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>27</option>
          <option value="28" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>28</option>
          <option value="29" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>29</option>
          <option value="30" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>30</option>
          </select>`;
          billig_period_innerHTML_id.innerHTML = billig_period_innerHTML_id.innerHTML + billig_period_innerHTML;
          billing_period_arr.push(billing_period_element);
    });

    var billing_period_type_add_id = document.getElementById("billing_period_type_add_id");
    var billig_period_type_innerHTML_id = document.getElementById("billig_period_type_innerHTML_id");
    let billig_period_type_innerHTML = '';
    var billing_period_type_array = <?php print $billing_period_type_db_encode ?>;
    var billing_period_type_array_split = billing_period_type_array?.split(',');
    billing_period_type_array_split?.forEach(billing_period_type_element => {
      billig_period_type_innerHTML = `
      <select type="billing_period_type" class="form-control" id="billing_period_type" name="billing_period_type" required>
        <option value="${billing_period_type_element}" type="billing_period_type" class="form-control" id="billing_period_type" name="billing_period_type" required>${billing_period_type_element}</option>
        <option value="Weekly" type="billing_period_type" class="form-control" id="billing_period_type" name="billing_period_type" required>Weekly</option>
        <option value="Monthly" type="billing_period_type" class="form-control" id="billing_period_type" name="billing_period_type" required>Monthly</option>
        <option value="Yearly" type="billing_period_type" class="form-control"  id="billing_period_type" name="billing_period_type" required>Yearly</option>
      </select>`;
        billig_period_type_innerHTML_id.innerHTML = billig_period_type_innerHTML_id.innerHTML + billig_period_type_innerHTML;
        billing_period_type_arr.push(billing_period_type_element);
      });

    add_billing_cycle_btn.addEventListener("click" , (e) => {
      billig_period_innerHTML =`
        <select type="billing_period" class="form-control" id="billing_period" name="billing_period" required>
          <option value="${billing_period_add_id.value}" type="billing_period" class="form-control" id="billing_period" name="billing_period" required>${billing_period_add_id.value}</option>
        </select>`;
      billig_period_innerHTML_id.innerHTML = billig_period_innerHTML_id.innerHTML + billig_period_innerHTML;
      billing_period_arr.push(billing_period_add_id.value);
      billig_period_type_innerHTML = `
      <select type="billing_period_type" class="form-control" id="billing_period_type" name="billing_period_type" required>
        <option value="${billing_period_type_add_id.value}" type="billing_period_type" class="form-control" id="billing_period_type" name="billing_period_type" required>${billing_period_type_add_id.value}</option>
      </select>`;
      billig_period_type_innerHTML_id.innerHTML = billig_period_type_innerHTML_id.innerHTML + billig_period_type_innerHTML;
      billing_period_type_arr.push(billing_period_type_add_id.value);
    })

    jQuery(document).ready(function() {

    jQuery("#frmEditProduct").validate({
    submitHandler: function() {

      let calculate_updated_price_input = ((parseInt(price_input.value) * parseInt(percentage_input.value))/100);
      let updated_price_input = ((parseInt(price_input.value)-calculate_updated_price_input)).toString();

      var postdata = `action=myproductlibrary&param=edit_plan&product_id=${product_id.value}&product_name_edit=${product_name.value}&price_edit=${price_input.value}&percentage_edit=${percentage_input.value}&updated_price_edit=${updated_price_input}&billing_period_edit=${billing_period_arr}&billing_period_type_edit=${billing_period_type_arr}&status=${status.value}`;
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
    })

    </script>

<div id="error_popup" class="err_overlay">
<div class="err_popup">
        <div class="err_content_container">Need To Login</div>  
        <div><a class="err_close" href="admin.php?page=login">×</a></div>
    </div>   
</div>


<div id="chosse_product" class="err_overlay">
    <div class="err_popup">
        <div class="err_content_container">Choose Atleast One To Edit</div>  
        <div><a class="err_close" href="admin.php?page=setting">×</a></div>
    </div>  
</div>

<div id="error_popup_dashboard" class="err_overlay">
    <div class="err_popup">
        <div class="err_content_container">Need To Connect Woocommerce</div>  
        <div><a class="err_close" href="admin.php?page=dashboard">×</a></div>
    </div>  
</div>
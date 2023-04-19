<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:user_login.php');
};

if (isset($_POST['order'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. ' . $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if ($check_cart->rowCount() > 0) {

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'order placed successfully!';
   } else {
      $message[] = 'your cart is empty';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="checkout-orders">

      <form action="" method="POST">

         <h3>your orders</h3>

         <div class="display-orders">
            <?php
            $grand_total = 0;
            $cart_items[] = '';
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if ($select_cart->rowCount() > 0) {
               while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                  $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
                  $total_products = implode($cart_items);
                  $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
            ?>
                  <p> <?= $fetch_cart['name']; ?> <span>(<?= 'NRS. ' . $fetch_cart['price'] . '/- x ' . $fetch_cart['quantity']; ?>)</span> </p>
            <?php
               }
            } else {
               echo '<p class="empty">your cart is empty!</p>';
            }
            ?>
            <input type="hidden" name="total_products" value="<?= $total_products; ?>">
            <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
            <div class="grand-total">grand total : <span>NRs.<?= $grand_total; ?>/-</span></div>
         </div>

         <h3>place your orders</h3>

         <div class="flex">
            <div class="inputBox">
               <span>your name :</span>
               <input type="text" name="name" placeholder="Enter your name" class="box" maxlength="20" required>
            </div>
            <div class="inputBox">
               <span>your number :</span>
               <input type="number" name="number" placeholder="Enter your number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
            </div>
            <div class="inputBox">
               <span>your email :</span>
               <input type="email" name="email" placeholder="Enter your email" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>payment method :</span>
               <select name="method" class="box" required>
                  <option value="cash on delivery">Khalti</option>
                  <!--<option value="credit card">credit card</option>
                  <option value="paytm">paytm</option>
                  <option value="paypal">paypal</option> -->
               </select>
            </div>
            <div class="inputBox">
               <span>address line 01 :</span>
               <input type="text" name="flat" placeholder="e.g. flat number" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>address line 02 :</span>
               <input type="text" name="street" placeholder="e.g. street name" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>city :</span>
               <input type="text" name="city" placeholder="e.g. Chitwan, Parsa" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>state :</span>
               <input type="text" name="state" placeholder="e.g. Bagmati" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>country :</span>
               <input type="text" name="country" placeholder="e.g. Nepal" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>pin code :</span>
               <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
            </div>
         </div>

         <input type="submit" id="payment-button" name="order" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" value="Buy">

      </form>

   </section>







   <!-- <?php
         // $args = http_build_query(array(
         //    'token' => $request->token,
         //    'amount'  => 1000
         // ));

         // $url = "https://khalti.com/api/v2/payment/verify/";

         // # Make the call using API.
         // $ch = curl_init();
         // curl_setopt($ch, CURLOPT_URL, $url);
         // curl_setopt($ch, CURLOPT_POST, 1);
         // curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
         // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

         // $headers = ['Authorization: Key test_secret_key_75e2a1f970ba44ed933a5383475eef0b'];
         // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

         // // Response
         // $response = curl_exec($ch);
         // $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
         // curl_close($ch);

         // if ($status_code == 200) {
         //    return response()->json([
         //       'success' => 1,
         //       'redirectto' => '/successpage',
         //    ]);
         // } else {
         //    return response()->json([
         //       'message' => 'Something Went Wrong',
         //    ]);
         // }
         ?> -->




   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>

   <script>
      var config = {
         // replace the publicKey with yours
         // "publicKey": "test_public_key_dc74e0fd57cb46cd93832aee0a390234",
         "publicKey": "test_public_key_99697f8fd7fc41e8b922cb5f84cf4e82",
         "productIdentity": "1234567890",
         "productName": "Dragon",
         "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
         "paymentPreference": [
            "KHALTI",
            "EBANKING",
            "MOBILE_BANKING",
            "CONNECT_IPS",
            "SCT",
         ],
         "eventHandler": {
            onSuccess(payload) {
               // hit merchant api for initiating verfication
               console.log(payload);
               if (payload.idx) {
                  $.ajaxSetup({
                     headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                     }
                  });


                  $.ajax({
                     method: 'POST',
                     url: "{{route('khalti.verify')}}",
                     data: payload,
                     success: function(response) {
                        console.log('successfully paid');
                        // window.location = response.redirectto; 
                     },
                     error: function(data) {
                        console.log(data.message);
                     }
                  });
               }


            },
            onError(error) {
               console.log(error);
            },
            onClose() {
               console.log('widget is closing');
            }
         }
      };

      var checkout = new KhaltiCheckout(config);
      var btn = document.getElementById("payment-button");
      btn.onclick = function() {
         // minimum transaction amount must be 10, i.e 1000 in paisa.
         checkout.show({
            amount: 1000
         });
      }
   </script>

</body>

</html>
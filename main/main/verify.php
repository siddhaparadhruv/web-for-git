<?php

    session_start();
    require('inc/razorpay-php/Razorpay.php');
    include('inc/razorpay-php/config.php');
    require('./admin/inc/config.php');
    require('./admin/inc/essentials.php');

    use Razorpay\Api\Api;
    use Razorpay\Api\Errors\SignatureVerificationError;

    $user_res = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1",[$_SESSION['uId']],'i');
	    $user_data = mysqli_fetch_assoc($user_res);

    $success = true;

    $error = "Payment Failed";

    if (empty($_POST['razorpay_payment_id']) === false)
    {
        $api = new Api($keyId, $keySecret);

        try
        {
            // Please note that the razorpay order ID must
            // come from a trusted source (session here, but
            // could be database or something else)
            $attributes = array(
                'razorpay_order_id' => $_SESSION['razorpay_order_id'],
                'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                'razorpay_signature' => $_POST['razorpay_signature']
            );

            $api->utility->verifyPaymentSignature($attributes);
        }
        catch(SignatureVerificationError $e)
        {
            $success = false;
            $error = 'Razorpay Error : ' . $e->getMessage();
        }
    }

    if ($success === true)
    {

        $cust_id = $user_data['id'];
        $name = $user_data['name'];
        $email = $user_data['email'];
        $phonenum = $user_data['phonenum'];
        $address = $user_data['address'];

        $posted_hash = $_SESSION['razorpay_order_id'];

        if(isset($_POST['razorpay_order_id'])){
            $tenid=$_POST['razorpay_order_id'];
            $status = 'success';
            $eid = $_POST['shopping_order_id'];
            $amount = $_POST['amount'] / 100;
            $subject = 'Your payment was successful';
            $currency = 'INR';
            $check_in =$_POST['cin'];
            $check_out =$_POST['cout'];
            $order_id =random_int(1,1000);

            $frm_data = filteration($_POST);

            $query = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`,`order_id`) VALUES (?,?,?,?,?)";

            insert($query,[$cust_id,$_SESSION['room']['id'],$check_in,$check_out,$order_id],'issss');

            $booking_id = mysqli_insert_id($con);

            $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `phonenum`, `address`) VALUES (?,?,?,?,?,?,?)";

            insert($query2,[$booking_id,$_SESSION['room']['name'],$_SESSION['room']['price'],$amount,$name,$phonenum,$address],'issssss');
        }
    }
    else
    {
        $status = "<p>Your payment failed</p>
                <p>{$error}</p>";
    }

    $slct_query = "SELECT `booking_id`,`user_id` FROM `booking_order` WHERE `order_id`='$order_id'";

    $slct_res = mysqli_query($con,$slct_query);

    $slct_fetch = mysqli_fetch_assoc($slct_res);

    if($status == 'success'){
        $update = "UPDATE `booking_order` SET `booking_status`='booked',`trans_id`='$tenid',`trans_amt`='$amount',`trans_status`='TXN_SUCCESS',`trans_resp_msg`='Your payment has been successful' WHERE `booking_id`=$slct_fetch[booking_id]";

        mysqli_query($con,$update);
    }
    else{
        $update2 = "UPDATE `booking_order` SET `booking_status`='payment failed',`trans_id`='$tenid',`trans_amt`='$amount',`trans_status`='TXN_SUCCESS',`trans_resp_msg`='Your payment has been fail' WHERE `booking_id`=$slct_fetch[booking_id]";

        mysqli_query($con,$update2);
    }
    redirect('pay_status.php?order='.$order_id);
    
?>
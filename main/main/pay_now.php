<?php
    require('inc/razorpay-php/Razorpay.php');
    require('./admin/inc/config.php');
    require('./admin/inc/essentials.php');

    session_start();

    if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
		redirect('rooms.php');
	}

    $user_res = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1",[$_SESSION['uId']],'i');
	$user_data = mysqli_fetch_assoc($user_res);

    $frm_data = filteration($_POST);
    $cin = $frm_data['checkin'];
    $cout = $frm_data['checkout'];

?>

<?php
    include('inc/razorpay-php/config.php');
    use Razorpay\Api\Api;
    $api = new Api($keyId, $keySecret);

    $orderData = [
        'receipt'         => $user_data['id'],
        'amount'          => $_SESSION['room']['payment'] * 100, // 2000 rupees in paise
        'currency'        => 'INR',
        'payment_capture' => 1 // auto capture
    ];

    $razorpayOrder = $api->order->create($orderData);

    $razorpayOrderId = $razorpayOrder['id'];

    $_SESSION['razorpay_order_id'] = $razorpayOrderId;

    $displayAmount = $amount = $orderData['amount'];

    if ($displayCurrency !== 'INR')
    {
        $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
        $exchange = json_decode(file_get_contents($url), true);

        $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
    }

    $data = [
        "key"               => $keyId,
        "amount"            => $amount,
        "name"              => "HOTEL HOLIDAYS",
        "description"       => "ROOM BOOKING",
        "image"             => "https://s29.postimg.org/r6dj1g85z/daft_punk.jpg",
        "prefill"           => [
        "name"              => $user_data['name'],
        "email"             => $user_data['email'],
        "contact"           => $user_data['phonenum'],
        ],
        "notes"             => [
        "address"           => $user_data['address'],
        "merchant_order_id" => "12312321",
        ],
        "theme"             => [
        "color"             => "#F37254"
        ],
        "order_id"          => $razorpayOrderId,
    ];
    
    if ($displayCurrency !== 'INR')
    {
        $data['display_currency']  = $displayCurrency;
        $data['display_amount']    = $displayAmount;
    }

    $json = json_encode($data);
?>

<form action="verify.php" method="POST">
  <script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="<?php echo $data['key']?>"
    data-amount="<?php echo $data['amount']?>"
    data-currency="INR"
    data-name="<?php echo $data['name']?>"
    data-image="<?php echo $data['image']?>"
    data-description="<?php echo $data['description']?>"
    data-prefill.name="<?php echo $data['prefill']['name']?>"
    data-prefill.email="<?php echo $data['prefill']['email']?>"
    data-prefill.contact="<?php echo $data['prefill']['contact']?>"
    data-notes.shopping_order_id="<?php $user_data['id'] ?>"
    data-order_id="<?php echo $data['order_id']?>"
    <?php if ($displayCurrency !== 'INR') { ?> data-display_amount="<?php echo $data['display_amount']?>" <?php } ?>
    <?php if ($displayCurrency !== 'INR') { ?> data-display_currency="<?php echo $data['display_currency']?>" <?php } ?>
  >
  </script>
  <!-- Any extra fields to be submitted with the form but not sent to Razorpay -->
  <input type="hidden" name="shopping_order_id" value="<?php $user_data['id'] ?>">
  <input type="hidden" name="amount" value="<?php echo $data['amount']?>">
  <input type="hidden" name="cin" value="<?php echo $cin ?>">
  <input type="hidden" name="cout" value="<?php echo $cout ?>">
</form>
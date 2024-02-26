<?php 
    require('inc/config.php'); 
    require('inc/essentials.php'); 

    session_start();
        if((isset($_SESSION['admin_login']) && $_SESSION['admin_login'])){
            redirect('dashboard.php');
        }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Panel</title>
    <?php require('inc/links.php'); ?>

    <style>
        div.login-form{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            width: 400px;
        }
    </style>
</head>

<body class="bg-light">

    <div class="login-form text-center rounded bg-white shadow overflow-hidden">
        <form method="POST" autocomplete="off">
            <h4 class="bg-dark text-white py-3">ADMIN LOGIN PANEL</h4>
            <div class="p-4">
                <div class="mb-3">
                    <input name="admin_name" type="text" require class="form-control shadow-none text-center" placeholder="Admin Name">
                </div>
                <div class="mb-4">
                    <input name="admin_pass" type="Password" require class="form-control shadow-none text-center" placeholder="Password">
                </div>
                <button name="login" type="submit" class="btn text-white custom-bg shadow-none">LOGIN</button>
            </div>
        </form>
    </div>

    <?php 
        if(isset($_POST['login'])){
            $frm_data = filteration($_POST);

            $query = "SELECT * FROM admin_login WHERE admin_name =? AND admin_pass =?";

            $values = [$frm_data['admin_name'],$frm_data['admin_pass']];

            $result = select($query,$values,"ss");
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_assoc($result);

                $_SESSION['admin_login'] = true;
                $_SESSION['admin_id'] = $row['sr_no'];
                redirect('dashboard.php');
            }else{
                alert('error','UserName And Password Wrong');
            }
        }
    ?>
    <?php require('inc/script.php') ?>
</body>

</html>
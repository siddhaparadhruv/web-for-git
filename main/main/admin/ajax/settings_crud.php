<?php
    require('../inc/config.php');
    require('../inc/essentials.php');
    adminLogin();

    if(isset($_POST['get_general'])){
        $select = "SELECT * FROM `settings` WHERE `sr_no`=?";
        $values = [1];
        $result = select($select,$values,"i");
        $data = mysqli_fetch_assoc($result);
        $json_data = json_encode($data);
        echo $json_data;
    }

    if(isset($_POST['upd_general'])){
        $frm_data = filteration($_POST);

        $update = "UPDATE `settings` SET `site_title`=?,`site_about`=? WHERE `sr_no`=?";
        $values = [$frm_data['site_title'],$frm_data['site_about'],1];
        $result = update($update,$values,'ssi');
        echo $result;
    }

    if(isset($_POST['upd_shutdown'])){
        $frm_data = ($_POST['upd_shutdown']==0) ? 1 : 0;

        $update = "UPDATE `settings` SET `shutdown`=? WHERE `sr_no`=?";
        $values = [$frm_data,1];
        $result = update($update,$values,'ii');
        echo $result;
    }

    if(isset($_POST['get_contacts'])){
        $select = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
        $values = [1];
        $result = select($select,$values,"i");
        $data = mysqli_fetch_assoc($result);
        $json_data = json_encode($data);
        echo $json_data;
    }

    if(isset($_POST['upd_contacts'])){
        $frm_data = filteration($_POST);

        $update = "UPDATE `contact_details` SET `address`=?,`gmap`=?,`pn1`=?,`pn2`=?,`email`=?,`fb`=?,`insta`=?,`tw`=?,`iframe`=? WHERE `sr_no`=?";
        $values = [$frm_data['address'],$frm_data['gmap'],$frm_data['pn1'],$frm_data['pn2'],$frm_data['email'],$frm_data['fb'],$frm_data['insta'],$frm_data['tw'],$frm_data['iframe'],1];
        $result = update($update,$values,'sssssssssi');
        echo $result;
    }

    if(isset($_POST['add_member'])){
        $frm_data = filteration($_POST);

        $img_r = uploadImage($_FILES['picture'],ABOUT_FOLDER);

        if($img_r == 'inv_img'){
            echo $img_r;
        }elseif($img_r == 'inv_size'){
            echo $img_r;
        }elseif($img_r == 'inv_failed'){
            echo $img_r;
        }else{
            $insert = "INSERT INTO `team_details`(`name`, `picture`) VALUES (?,?)";
            $values = [$frm_data['name'],$img_r];
            $result = insert($insert,$values,'ss');
            echo $result;
        }
    }

    if(isset($_POST['get_members'])){
        $result = selectAll('team_details');

        while($row = mysqli_fetch_assoc($result)){
            $path = ABOUT_IMG_PATH;
            echo "
            <div class='col-md-2 mb-3'>
            <div class='card bg-dark text-white'>
                <img src='$path$row[picture]' class='card-img'>
                <div class='card-img-overlay text-end'>
                    <button class='btn btn-danger btn-sm shadow-none' onclick='rem_member($row[sr_no])'><i class='bi bi-trash'></i>Delete</button>
                </div>
                <p class='card-text text-center px-3 py-2'>$row[name]</p>
            </div>
        </div>
            ";
        }
    }

    if(isset($_POST['rem_member'])){
        $frm_data = filteration($_POST);
        $values = [$frm_data['rem_member']];

        $select = "SELECT * FROM `team_details` WHERE `sr_no`=?";
        $result = select($select,$values,'i');
        $img = mysqli_fetch_assoc($result);

        if(deleteImage($img['picture'],ABOUT_FOLDER)){
            $delete = "DELETE FROM `team_details` WHERE `sr_no`=?";
            $result = delete($delete,$values,'i');
            echo $result;
        }else{
            echo 0;
        }
    }
?>
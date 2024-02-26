<?php
    require('../inc/config.php');
    require('../inc/essentials.php');
    adminLogin();

    if(isset($_POST['add_image'])){

        $img_r = uploadImage($_FILES['picture'],CAROUSEL_FOLDER);

        if($img_r == 'inv_img'){
            echo $img_r;
        }elseif($img_r == 'inv_size'){
            echo $img_r;
        }elseif($img_r == 'inv_failed'){
            echo $img_r;
        }else{
            $insert = "INSERT INTO `carousel`(`image`) VALUES (?)";
            $values = [$img_r];
            $result = insert($insert,$values,'s');
            echo $result;
        }
    }

    if(isset($_POST['get_carousel'])){
        $result = selectAll('carousel');

        while($row = mysqli_fetch_assoc($result)){
            $path = CAROUSEL_IMG_PATH;
            echo "
            <div class='col-md-4 mb-3'>
            <div class='card bg-dark text-white'>
                <img src='$path$row[image]' class='card-img'>
                <div class='card-img-overlay text-end'>
                    <button class='btn btn-danger btn-sm shadow-none' onclick='rem_image($row[sr_no])'><i class='bi bi-trash'></i>Delete</button>
                </div>
            </div>
        </div>
            ";
        }
    }

    if(isset($_POST['rem_image'])){
        $frm_data = filteration($_POST);
        $values = [$frm_data['rem_image']];

        $select = "SELECT * FROM `carousel` WHERE `sr_no`=?";
        $result = select($select,$values,'i');
        $img = mysqli_fetch_assoc($result);

        if(deleteImage($img['image'],CAROUSEL_FOLDER)){
            $delete = "DELETE FROM `carousel` WHERE `sr_no`=?";
            $result = delete($delete,$values,'i');
            echo $result;
        }else{
            echo 0;
        }
    }
?>
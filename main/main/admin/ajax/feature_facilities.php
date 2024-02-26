<?php
require('../inc/config.php');
require('../inc/essentials.php');
adminLogin();

if (isset($_POST['add_feature'])) {
    $frm_data = filteration($_POST);

    $insert = "INSERT INTO `features`(`name`) VALUES (?)";
    $values = [$frm_data['name']];
    $result = insert($insert, $values, 's');
    echo $result;
}

if (isset($_POST['get_features'])) {
    $result = selectAll('features');
    $i = 1;

    while ($row = mysqli_fetch_assoc($result)) {
        echo "

            <tr>
                <td>$i</td>
                <td>$row[name]</td>
                <td>
                <button class='btn btn-danger btn-sm shadow-none' onclick='rem_features($row[id])'><i class='bi bi-trash'></i>Delete</button>
                </td>
            </tr>
            ";
        $i++;
    }
}

if (isset($_POST['rem_features'])) {
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_features']];

    $check_q = select('SELECT * FROM `room_features` WHERE `features_id`=?',[$frm_data['rem_features']],'i');

    if(mysqli_num_rows($check_q)==0){
        $delete = "DELETE FROM `features` WHERE `id`=?";
        $result = delete($delete, $values, 'i');
        echo $result;
    }else{
        echo 'room_added';
    }

}

if (isset($_POST['add_facility'])) {
    $frm_data = filteration($_POST);

    $img_r = uploadSVGImage($_FILES['icon'], FACILITIES_FOLDER);

    if ($img_r == 'inv_img') {
        echo $img_r;
    } elseif ($img_r == 'inv_size') {
        echo $img_r;
    } elseif ($img_r == 'inv_failed') {
        echo $img_r;
    } else {
        $insert = "INSERT INTO `facilities`(`icon`,`name`, `description`) VALUES (?,?,?)";
        $values = [$img_r, $frm_data['name'], $frm_data['desc']];
        $result = insert($insert, $values, 'sss');
        echo $result;
    }
}

if (isset($_POST['get_facilities'])) {
    $result = selectAll('facilities');
    $i = 1;
    $path = FACILITIES_IMG_PATH;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "

            <tr class='align-middle'>
                <td>$i</td>
                <td><img src='$path$row[icon]' width='100px'></td>
                <td>$row[name]</td>
                <td>$row[description]</td>
                <td>
                <button class='btn btn-danger btn-sm shadow-none' onclick='rem_facility($row[id])'><i class='bi bi-trash'></i>Delete</button>
                </td>
            </tr>
            ";
        $i++;
    }
}

if (isset($_POST['rem_facility'])) {
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_facility']];

    $check_q = select('SELECT * FROM `room_facilities` WHERE `facilities_id`=?',[$frm_data['rem_facility']],'i');

    if(mysqli_num_rows($check_q)==0){
        $select = "SELECT * FROM `facilities` WHERE `id`=?";
        $result = select($select, $values, 'i');
        $img = mysqli_fetch_assoc($result);
    
        if (deleteImage($img['icon'], FACILITIES_FOLDER)) {
            $delete = "DELETE FROM `facilities` WHERE `id`=?";
            $result = delete($delete, $values, 'i');
            echo $result;
        } else {
            echo 0;
        }
    }else{
        echo 'room_added';
    }

}

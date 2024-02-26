<?php
require('../inc/config.php');
require('../inc/essentials.php');
adminLogin();

if (isset($_POST['add_room'])) {

    $features = filteration(json_decode($_POST['features']));
    $facilities = filteration(json_decode($_POST['facilities']));

    $frm_data = filteration($_POST);
    $flag = 0;

    $insert = "INSERT INTO `rooms`(`name`, `area`, `price`, `quantity`, `adult`, `children`, `description`) VALUES (?,?,?,?,?,?,?)";
    $values = [$frm_data['name'], $frm_data['area'], $frm_data['price'], $frm_data['quantity'], $frm_data['adult'], $frm_data['children'], $frm_data['desc']];

    if (insert($insert, $values, 'siiiiis')) {
        $flag = 1;
    }

    $room_id = mysqli_insert_id($con);

    $insert2 = "INSERT INTO `room_facilities`(`room_id`, `facilities_id`) VALUES (?,?)";

    if ($stmt = mysqli_prepare($con, $insert2)) {

        foreach ($facilities as $f) {
            mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {

        $flag = 0;
        die('query cannot be prepared - insert');
    }

    $insert3 = "INSERT INTO `room_features`(`room_id`, `features_id`) VALUES (?,?)";

    if ($stmt = mysqli_prepare($con, $insert3)) {

        foreach ($features as $f) {
            mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {

        $flag = 0;
        die('query cannot be prepared - insert');
    }

    if ($flag) {
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['get_all_rooms'])) {

    $result = select("SELECT * FROM `rooms` WHERE `removed`=?",[0],'i');
    $i = 1;

    $data = "";

    while ($row = mysqli_fetch_assoc($result)) {

        if ($row['status'] == 1) {
            $status = "<button onclick='toggle_status($row[id],0)' class='btn btn-dark btn-sm shadow-none'>active</button>";
        } else {
            $status = "<button onclick='toggle_status($row[id],1)' class='btn btn-warning btn-sm shadow-none'>inactive</button>";
        }

        $data .= "
            <tr class='align-middle'>
                <td>$i</td>
                <td>$row[name]</td>
                <td>$row[area] sq. ft.</td>
                <td>
                    <span class='badge rounded-pill bg-light text-dark'>
                        Adult: $row[adult]
                    </span><br>
                    <span class='badge rounded-pill bg-light text-dark'>
                        Children: $row[children]
                    </span>
                </td>
                <td>₹$row[price]</td>
                <td>$row[quantity]</td>
                <td>$status</td>
                <td>
                <button type='button' onclick='edit_details($row[id])' class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#edit-room'>
                <i class='bi bi-pencil-square'></i>
            </button>
                <button type='button' onclick=\"room_images($row[id],'$row[name]')\" class='btn btn-info shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#room-images'>
                <i class='bi bi-images'></i>
            </button>
            <button type='button' onclick='remove_room($row[id])' class='btn btn-danger shadow-none btn-sm'>
                <i class='bi bi-trash'></i>
            </button>
                </td>
            </tr>
        ";
        $i++;
    }
    echo $data;
}

if (isset($_POST['get_room'])) {

    $frm_data = filteration($_POST);

    $result1 = select("SELECT * FROM `rooms` WHERE `id`=?", [$frm_data['get_room']], 'i');
    $result2 = select("SELECT * FROM `room_features` WHERE `room_id`=?", [$frm_data['get_room']], 'i');
    $result3 = select("SELECT * FROM `room_facilities` WHERE `room_id`=?", [$frm_data['get_room']], 'i');

    $roomdata = mysqli_fetch_assoc($result1);
    $features = [];
    $facilities = [];

    if (mysqli_num_rows($result2) > 0) {
        while ($row = mysqli_fetch_assoc($result2)) {
            array_push($features, $row['features_id']);
        }
    }

    if (mysqli_num_rows($result3) > 0) {
        while ($row = mysqli_fetch_assoc($result3)) {
            array_push($facilities, $row['facilities_id']);
        }
    }

    $data = ["roomdata" => $roomdata, "features" => $features, "facilities" => $facilities];

    $data = json_encode($data);

    echo $data;
}
if (isset($_POST['edit_room'])) {

    $features = filteration(json_decode($_POST['features']));
    $facilities = filteration(json_decode($_POST['facilities']));

    $frm_data = filteration($_POST);
    $flag = 0;

    $update1 = "UPDATE `rooms` SET `name`=?,`area`=?,`price`=?,`quantity`=?,`adult`=?,`children`=?,`description`=? WHERE `id`=?";
    $values = [$frm_data['name'], $frm_data['area'], $frm_data['price'], $frm_data['quantity'], $frm_data['adult'], $frm_data['children'], $frm_data['desc'], $frm_data['room_id']];

    if (update($update1, $values, 'siiiiisi')) {
        $flag = 1;
    }

    $del_features = delete("DELETE FROM `room_features` WHERE `room_id`=?", [$frm_data['room_id']], 'i');
    $del_facilities = delete("DELETE FROM `room_facilities` WHERE `room_id`=?", [$frm_data['room_id']], 'i');

    if (!($del_facilities && $del_features)) {
        $flag = 0;
    }

    $insert2 = "INSERT INTO `room_facilities`(`room_id`, `facilities_id`) VALUES (?,?)";

    if ($stmt = mysqli_prepare($con, $insert2)) {

        foreach ($facilities as $f) {
            mysqli_stmt_bind_param($stmt, 'ii', $frm_data['room_id'], $f);
            mysqli_stmt_execute($stmt);
        }
        $flag = 1;
        mysqli_stmt_close($stmt);
    } else {

        $flag = 0;
        die('query cannot be prepared - insert');
    }

    $insert3 = "INSERT INTO `room_features`(`room_id`, `features_id`) VALUES (?,?)";

    if ($stmt = mysqli_prepare($con, $insert3)) {

        foreach ($features as $f) {
            mysqli_stmt_bind_param($stmt, 'ii', $frm_data['room_id'], $f);
            mysqli_stmt_execute($stmt);
        }
        $flag = 1;
        mysqli_stmt_close($stmt);
    } else {

        $flag = 0;
        die('query cannot be prepared - insert');
    }

    if ($flag) {
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['toggle_status'])) {

    $frm_data = filteration($_POST);

    $update = "UPDATE `rooms` SET `status`=? WHERE `id`=?";
    $values = [$frm_data['val'], $frm_data['toggle_status']];

    if (update($update, $values, 'ii')) {
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['add_image'])) {
    $frm_data = filteration($_POST);

    $img_r = uploadImage($_FILES['image'], ROOMS_FOLDER);

    if ($img_r == 'inv_img') {
        echo $img_r;
    } elseif ($img_r == 'inv_size') {
        echo $img_r;
    } elseif ($img_r == 'inv_failed') {
        echo $img_r;
    } else {
        $insert = "INSERT INTO `room_images`(`room_id`, `image`) VALUES (?,?)";
        $values = [$frm_data['room_id'], $img_r];
        $result = insert($insert, $values, 'is');
        echo $result;
    }
}

if (isset($_POST['get_room_images'])) {

    $frm_data = filteration($_POST);
    $result = select("SELECT * FROM `room_images` WHERE `room_id`=?",[$frm_data['get_room_images']],'i');

    $path = ROOMS_IMG_PATH;

    while($row = mysqli_fetch_assoc($result)){

        if($row['thumb']==1){
            $thumb_btn = "<i class='bi bi-check-lg text-light bg-success px-2 py-1 rounded fs-5'></i>";
        }else{
            $thumb_btn = "<button onclick='thumb_image($row[sr_no],$row[room_id])' class='btn btn-secondary shadow-none'><i class='bi bi-check-lg'></i></button>";
        }

        echo "
            <tr class='align-middle'>
                <td><img src='$path$row[image]' class='img-fluid'></td>
                <td>$thumb_btn</td>
                <td>
                    <button onclick='rem_image($row[sr_no],$row[room_id])' class='btn btn-danger shadow-none'><i class='bi bi-trash'></i></button>
                </td>
            </tr>
        ";
    }
}

if(isset($_POST['rem_image'])){
    $frm_data = filteration($_POST);
    $values = [$frm_data['image_id'],$frm_data['room_id']];

    $select = "SELECT * FROM `room_images` WHERE `sr_no`=? AND `room_id`=?";
    $result = select($select,$values,'ii');
    $img = mysqli_fetch_assoc($result);

    if(deleteImage($img['image'],ROOMS_FOLDER)){
        $delete = "DELETE FROM `room_images` WHERE `sr_no`=? AND `room_id`=?";
        $result = delete($delete,$values,'ii');
        echo $result;
    }else{
        echo 0;
    }
}

if(isset($_POST['thumb_image'])){
    $frm_data = filteration($_POST);
    
    $update = "UPDATE `room_images` SET `thumb`=? WHERE `room_id`=?";
    $value = [0,$frm_data['room_id']];
    $result = update($update,$value,'ii');

    $update2 = "UPDATE `room_images` SET `thumb`=? WHERE `sr_no`=? AND `room_id`=?";
    $value2 = [1,$frm_data['image_id'],$frm_data['room_id']];
    $result2 = update($update2,$value2,'iii');

    echo $result2;
}

if(isset($_POST['remove_room'])){

    $frm_data = filteration($_POST);

    $result = select("SELECT * FROM `room_images` WHERE `room_id`=?",[$frm_data['room_id']],'i');

    while($row = mysqli_fetch_assoc($result)){
        deleteImage($row['image'],ROOMS_FOLDER);
    }

    $result2 = delete("DELETE FROM `room_images` WHERE `room_id`=?",[$frm_data['room_id']],'i');

    $result3 = delete("DELETE FROM `room_features` WHERE `room_id`=?",[$frm_data['room_id']],'i');

    $result4 = delete("DELETE FROM `room_facilities` WHERE `room_id`=?",[$frm_data['room_id']],'i');

    $result5 = update("UPDATE `rooms` SET `removed`=? WHERE `id`=?",[1,$frm_data['room_id']],'ii');

    if($result2 || $result3 || $result4 || $result5){
        echo 1;
    }else{
        echo 0;
    }
}
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/includes/include.php';
define('MB', 1048576);
$errors = [];
$data = [
    "success" => false,
    "errors" => false
];

$age = new DateTime($_POST['date']);
$today = new DateTime();
$diff = $age->diff($today);
if ($diff->y < 18) {
    $errors['date'] = "Возраст должен больше 18 лет";
}
if (empty($_POST['email'])) {
    $errors["email"] = "Email не указан.";
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors["email"] = "Недействительный адрес электронной почты. Пожалуйста, попробуйте еще раз";
}
if (empty($_POST['name'])) {
    $errors["name"] = "Название не указано.";
}
if (empty($_POST['phone'])) {
    $errors["phone"] = "Номер телефона не указан.";
}
if (empty($_FILES['image'])) {
    $errors['image'] = "Картинка не выбрано";
}
if (empty($_POST['date'])) {
    $errors['date'] = "Дата рождения не указана";
}

if (empty($errors)) {
    $db = DB::getConnection();
    $name = $db->real_escape_string($_POST['name']);
    $email = $db->real_escape_string($_POST['email']);
    $phone = $db->real_escape_string($_POST['phone']);
    $birthday = $db->real_escape_string($_POST['date']);
    $sql = "INSERT INTO `albums` (name, email, phone, birthday) 
        VALUES ('$name', '$email', '$phone', '$birthday')";
    $result = $db->query($sql);

    $id = $db->insert_id;
    if ($id > 0) {
        for($i=0; $i<count($_FILES['image']['name']); $i++){
            if ($_FILES['image']['size'][$i] > MB) {
                $errors['image'] = "Максимальный размер файла должен не более 1 МБ";
            } else {
                $ext = explode('.', basename( $_FILES['image']['name'][$i]));
                $file_name = md5(uniqid()) . "." . $ext[count($ext)-1];
                $document_path = $_SERVER['DOCUMENT_ROOT']. "/uploads/". $file_name;
                $target_path = 'uploads/' . $file_name;

                if(move_uploaded_file($_FILES['image']['tmp_name'][$i], $document_path)) {
                    $sql2 = "INSERT INTO `images` (image, size, albums_id) 
                    VALUES ('$target_path', '{$_FILES['image']['size'][$i]}', '$id')";
                    $res = $db->query($sql2);
                    if ($res == false) {
                        echo '<pre>'; print_r($db->error); echo '</pre>';
                    }
                } else{
                    $errors['image'] = "При загрузке файла произошла ошибка, попробуйте еще раз! ";
                }
            }

        }
        $data = [
            "success" => true,
            "errors" => false
        ];
    }

} else {
    $data = [
        "success" => false,
        "errors" => $errors
    ];
}

header("Content-type: application/json; charset=utf-8");
die(json_encode($data));
<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/includes/include.php';
$data = [
    "success" => false,
    "errors" => false
];
if (!empty($_POST["id"])) {
    $db = DB::getConnection();

    $arResult = [];
    $lastKey = null;

    // Подсчитать все записи, кроме уже отображаемых
    $query = $db->query("SELECT COUNT(*) as num_rows FROM albums WHERE id > " . $_POST['id'] . " ORDER BY id ASC");
    $resAll = $query->fetch_assoc();
    $totalRowCount = $resAll['num_rows'];
    $showLimit = 1;
    // Получение записи из базы данных
    $query = $db->query("SELECT * FROM albums WHERE id > " . $_POST['id'] . " ORDER BY id ASC LIMIT $showLimit");

    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            $images = $db->query("SELECT * FROM images WHERE albums_id = " . intval($row['id']));
            while ($arImage = $images->fetch_assoc()) {
                $row['images'][] = $arImage;
            }
            $arResult[] = $row;
            $lastKey = $row['id'];
        }
    }

    $data = [
        "success" => true,
        "data" =>
            [
                "items" => $arResult,
                "showPager" => boolval($totalRowCount > $showLimit),
                "lastKey" => $lastKey
            ],
        "errors" => false
    ];
} else {
    $data = [
        "success" => false,
        "errors" => "Не передан ид альбома"
    ];
}

header("Content-type: application/json; charset=utf-8");
die(json_encode($data));
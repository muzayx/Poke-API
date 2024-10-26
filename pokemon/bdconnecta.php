<?php
    header('Content-Type: application/json; charset=utf-8');
    $conn = mysqli_connect("localhost", "root", "", "22092");   
    if (!$conn) {
        $json = json_encode(['status' => 'error', 'message' => 'Falha na conexão com o banco de dados'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo $json;
    }
    else {
        $json = json_encode(['status' => 'sucess', 'message' => 'Conexão bem sucedida'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo $json;
    }
    date_default_timezone_set('Brazil/East');
    mysqli_query($conn, "SET NAMES 'utf8'");
?>


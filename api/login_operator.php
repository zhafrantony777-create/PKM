<?php
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$conn = new mysqli("localhost", "root", "", "perpustakaan_simpel");
if ($conn->connect_error) {
    echo json_encode(["status"=>"error", "message"=>"DB error"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$username = $data["username"] ?? "";
$password = $data["password"] ?? "";

// Ambil data operator (id 1)
$res = $conn->query("SELECT * FROM operator WHERE id = 1 LIMIT 1");
if ($res->num_rows == 0) {
    echo json_encode(["status"=>"error", "message"=>"Operator tidak ditemukan"]);
    exit;
}

$op = $res->fetch_assoc();

if ($username !== $op["username"]) {
    echo json_encode(["status"=>"error", "message"=>"Username salah"]);
    exit;
}

if (!password_verify($password, $op["password"])) {
    echo json_encode(["status"=>"error", "message"=>"Password salah"]);
    exit;
}

echo json_encode(["status"=>"success", "message"=>"Login berhasil"]);
?>

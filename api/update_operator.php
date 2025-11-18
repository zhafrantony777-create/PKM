<?php
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Koneksi ke database perpustakaan_simpel
// $conn = new mysqli("http://202.10.40.254", "root", "", "perpustakaan_simpel");
include 'conn.php';
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Gagal koneksi database"]);
    exit;
}

// Ambil input JSON dari frontend
$data = json_decode(file_get_contents("php://input"), true);

$oldPass = $data["oldPass"] ?? "";
$newPass = $data["newPass"] ?? "";
$usernameBaru = $data["usernameBaru"] ?? "";

// Validasi dasar
if (empty($oldPass) || empty($newPass)) {
    echo json_encode(["status" => "error", "message" => "Password lama dan baru wajib diisi"]);
    exit;
}

// Ambil data operator (diasumsikan id = 1)
$res = $conn->query("SELECT * FROM operator WHERE id = 1 LIMIT 1");
if ($res->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Data operator tidak ditemukan"]);
    exit;
}

$op = $res->fetch_assoc();

// Verifikasi password lama
if (!password_verify($oldPass, $op["password"])) {
    echo json_encode(["status" => "error", "message" => "Password lama salah"]);
    exit;
}

// Hash password baru
$newPassHash = password_hash($newPass, PASSWORD_DEFAULT);

// Jika username kosong → pakai username lama
if (empty($usernameBaru)) {
    $usernameBaru = $op["username"];
}

// Update username & password
$stmt = $conn->prepare("UPDATE operator SET username = ?, password = ? WHERE id = 1");
$stmt->bind_param("ss", $usernameBaru, $newPassHash);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Akun operator berhasil diperbarui"]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal menyimpan pengaturan"]);
}

$conn->close();
?>

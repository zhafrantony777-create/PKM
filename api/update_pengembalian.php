<?php
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// GANTI DATABASE KE perpustakaan_simpel
$conn = new mysqli("http://202.10.40.254", "root", "", "perpustakaan_simpel");
if ($conn->connect_error) {
  echo json_encode(["status" => "error", "message" => "Koneksi gagal: " . $conn->connect_error]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$id = intval($data["id"]);

// Menggunakan prepared statement
$sql = "UPDATE peminjaman SET dikembalikan = 'ya' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
  echo json_encode(["status" => "success", "message" => "Buku telah dikembalikan."]);
} else {
  echo json_encode(["status" => "error", "message" => "Gagal memperbarui status: " . $conn->error]);
}

$stmt->close();
$conn->close();
?>
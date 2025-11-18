<?php

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// koneksi ke database: KRITIS DIGANTI KE perpustakaan_simpel
$conn = new mysqli("localhost", "root", "", "perpustakaan_simpel");
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Koneksi gagal: " . $conn->connect_error]);
    exit;
}

// ambil data JSON dari fetch
$data = json_decode(file_get_contents("php://input"), true);

$judul = $conn->real_escape_string($data["judul"]);
$pengarang = $conn->real_escape_string($data["pengarang"]);
// $tahun Dihapus
$rak = $conn->real_escape_string($data["rak"]);
$stok = intval($data["stok"]);

// Query diubah, kolom tahun dihapus
$sql = "INSERT INTO buku (judul, pengarang, rak, stok)
        VALUES ('$judul', '$pengarang', '$rak', $stok)";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$conn->close();
?>
<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// GANTI DATABASE KE perpustakaan_simpel
$conn = new mysqli("localhost", "root", "", "perpustakaan_simpel"); 
if ($conn->connect_error) {
  echo json_encode(["status" => "error", "message" => "Koneksi gagal: " . $conn->connect_error]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);

// NIS sekarang bisa kosong (diisi dari body: JSON.stringify({ nis: "" }))
// Menggunakan real_escape_string dan operator null-coalescing untuk keamanan
$nis     = $conn->real_escape_string($data["nis"] ?? ""); 
$nama    = $conn->real_escape_string($data["nama"]);
$kelas   = $conn->real_escape_string($data["kelas"]);
$id_buku = $conn->real_escape_string($data["id_buku"]);
$judul   = $conn->real_escape_string($data["judul"]);
$rak     = $conn->real_escape_string($data["rak"]);
$tenggat = $conn->real_escape_string($data["tenggat"]);

// Menggunakan prepared statement
$sql = "INSERT INTO peminjaman (nis, nama, kelas, id_buku, judul, rak, tenggat, dikembalikan)
        VALUES (?, ?, ?, ?, ?, ?, ?, 'tidak')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssisss", $nis, $nama, $kelas, $id_buku, $judul, $rak, $tenggat);

if ($stmt->execute()) {
  echo json_encode(["status" => "success", "message" => "Peminjaman berhasil dicatat."]);
} else {
  echo json_encode(["status" => "error", "message" => $conn->error]);
}

$stmt->close();
$conn->close();
?>
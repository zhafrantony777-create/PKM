<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// KRITIS: KONEKSI KE perpustakaan_simpel
$conn = new mysqli("localhost", "root", "", "perpustakaan_simpel"); 
if ($conn->connect_error) {
  // Jika koneksi DB gagal, kirim status 500
  http_response_code(500); 
  echo json_encode(["status" => "error", "message" => "Koneksi database gagal: " . $conn->connect_error]);
  exit;
}

// Ambil semua data buku
$sql = "SELECT * FROM buku ORDER BY judul ASC";

$result = $conn->query($sql);
$data = [];

if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
}

echo json_encode($data);
$conn->close();
?>
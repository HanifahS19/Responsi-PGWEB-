<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "penyakit";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
   
    $kecamatan = $_POST['kecamatan'];
   
    $tahun = $_POST['tahun'];
    $jumlah= $_POST['jumlah'];
   

    $sql = "UPDATE prevalensi_penyakit SET ID = ?, kecamatan = ?, tahun = ?, ljumlah = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdiidi", $ID, $kecamatan, $penyakit, $tahun, $jumlah, $id);

    if ($stmt->execute()) {
        echo "Data berhasil diperbarui.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    header("Location: index.php"); // Redirect kembali ke halaman utama
    exit;
}

$conn->close();
?>

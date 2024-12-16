<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Penyakit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            overflow-y: auto;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 400px;
            margin-top: 20px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 15px;
            text-align: left;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        p {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Data Penyakit</h2>

        <!-- PHP code untuk proses update dan form -->
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "penyakit";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Koneksi gagal: " . htmlspecialchars($conn->connect_error));
        }

        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $conn->prepare("SELECT * FROM prevalensi_penyakit WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } else {
                echo "<p>Data tidak ditemukan.</p>";
                exit;
            }
            $stmt->close();
        } else {
            echo "<p>ID tidak valid.</p>";
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = intval($_POST['id']);
            $kecamatan = htmlspecialchars(trim($_POST['kecamatan']));
            $tahun = intval($_POST['tahun']);
            $tb_paru = intval($_POST['tb_paru']);
            $pneumonia_balita = intval($_POST['pneumonia_balita']);
            $dbd = intval($_POST['dbd']);
            $jumlah = intval($_POST['jumlah']);
            $luas = floatval($_POST['luas']);
            $jumlah_pddk = floatval($_POST['jumlah_pddk']);
            $longitude = floatval($_POST['longitude']);
            $latitude = floatval($_POST['latitude']);

            $update_sql = $conn->prepare("UPDATE prevalensi_penyakit SET kecamatan = ?, tahun = ?, tb_paru = ?, pneumonia_balita = ?, dbd = ?, jumlah = ?, luas = ?, jumlah_pddk = ?, longitude = ?, latitude = ? WHERE id = ?");
            $update_sql->bind_param("siiiiiidddi", $kecamatan, $tahun, $tb_paru, $pneumonia_balita, $dbd, $jumlah, $luas, $jumlah_pddk, $longitude, $latitude, $id);
            if ($update_sql->execute()) {
                echo "<p>Data berhasil diperbarui. <a href='index.php'>Kembali ke halaman utama</a>.</p>";
            } else {
                echo "<p>Error memperbarui data: " . htmlspecialchars($conn->error) . "</p>";
            }
            $update_sql->close();
        }
        ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
            <label for="kecamatan">Kecamatan:</label>
            <input type="text" id="kecamatan" name="kecamatan" value="<?php echo htmlspecialchars($row['kecamatan']); ?>" placeholder="Nama Kecamatan" required>
            
            <label for="tahun">Tahun:</label>
            <input type="number" id="tahun" name="tahun" value="<?php echo htmlspecialchars($row['tahun']); ?>" min="1900" placeholder="Tahun" required>

            <label for="tb_paru">TB Paru:</label>
            <input type="number" id="tb_paru" name="tb_paru" value="<?php echo htmlspecialchars($row['tb_paru']); ?>" min="0" required>

            <label for="pneumonia_balita">Pneumonia Balita:</label>
            <input type="number" id="pneumonia_balita" name="pneumonia_balita" value="<?php echo htmlspecialchars($row['pneumonia_balita']); ?>" min="0" required>

            <label for="dbd">DBD:</label>
            <input type="number" id="dbd" name="dbd" value="<?php echo htmlspecialchars($row['dbd']); ?>" min="0" required>

            <label for="jumlah">Jumlah:</label>
            <input type="number" id="jumlah" name="jumlah" value="<?php echo htmlspecialchars($row['jumlah']); ?>" min="0" required>

            <label for="luas">Luas (km²):</label>
            <input type="number" id="luas" name="luas" step="any" value="<?php echo htmlspecialchars($row['luas']); ?>" min="0" required>

            <label for="jumlah_pddk">Jumlah Penduduk:</label>
            <input type="number" id="jumlah_pddk" name="jumlah_pddk" step="any" value="<?php echo htmlspecialchars($row['jumlah_pddk']); ?>" min="0" required>

            <label for="longitude">Longitude:</label>
            <input type="number" id="longitude" name="longitude" step="any" value="<?php echo htmlspecialchars($row['longitude']); ?>" required>

            <label for="latitude">Latitude:</label>
            <input type="number" id="latitude" name="latitude" step="any" value="<?php echo htmlspecialchars($row['latitude']); ?>" required>

            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>

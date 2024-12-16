<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Prevalensi Penyakit</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .table-container {
            width: 90%;
            margin: 20px;
        }

        .table-title {
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
            color: #333333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        th {
            background-color: #007bff;
            color: #ffffff;
            padding: 15px;
        }

        td {
            padding: 15px;
            text-align: left;
            border: 1px solid #dddddd;
        }

        .button {
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            cursor: pointer;
            text-decoration: none;
        }

        .button-hapus {
            background-color: #e57373;
        }

        .button-hapus:hover {
            background-color: #ef5350;
        }

        .button-edit {
            background-color: #4CAF50;
            margin-left: 5px;
        }

        .button-edit:hover {
            background-color: #388E3C;
        }

        .button-input {
            background-color: #007bff;
            margin-top: 10px;
            display: inline-block;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
        }

        .button-input:hover {
            background-color: #0056b3;
        }

        .message {
            margin: 10px auto;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            width: 80%;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "penyakit";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    if (isset($_POST['delete_id']) && is_numeric($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        $delete_sql = "DELETE FROM prevalensi_penyakit WHERE id = $id";

        if ($conn->query($delete_sql) === TRUE) {
            echo "<div class='message success'>Data berhasil dihapus.</div>";
        } else {
            echo "<div class='message error'>Error menghapus data: " . $conn->error . "</div>";
        }
    }

    $sql = "SELECT * FROM prevalensi_penyakit";
    $result = $conn->query($sql);
    ?>

    <!-- Grafik Penyakit Berdasarkan Kecamatan -->
    <h1 style="text-align: center;">Grafik Penyakit Berdasarkan Kecamatan</h1>
    <div style="width: 80%; margin: auto;">
        <canvas id="myChart"></canvas>
    </div>

    <script>
        // Ambil data dari data.php
        fetch('data.php')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.kecamatan); // Nama kecamatan
                const values = data.map(item => item.jumlah);   // Nilai jumlah

                // Buat grafik
                const ctx = document.getElementById('myChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar', // Jenis grafik
                    data: {
                        labels: labels, // Label untuk sumbu x
                        datasets: [{
                            label: 'Jumlah Penyakit per Kecamatan',
                            data: values, // Data untuk sumbu y
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error:', error));
    </script>

    <!-- Tabel Data Penyakit -->
    <div class="table-container">
        <div class="table-title" style="text-align: center;">Data Penyakit</div>
        <a href="inputdata.html" class="button-input">Input Data Baru</a>
        <?php
        if ($result->num_rows > 0) {
            echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Kecamatan</th>
                    <th>Tahun</th>
                    <th>TB Paru</th>
                    <th>Pneumonia Balita</th>
                    <th>DBD</th>
                    <th>Jumlah</th>
                    <th>Luas</th>
                    <th>Jumlah_pddk</th>
                    <th>Longitude</th>
                    <th>Latitude</th>
                    
                    <th>Aksi</th>
                </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($row["id"]) . "</td>
                    <td>" . htmlspecialchars($row["kecamatan"]) . "</td>
                    <td>" . htmlspecialchars($row["tahun"]) . "</td>
                    <td>" . htmlspecialchars($row["tb_paru"]) . "</td>
                    <td>" . htmlspecialchars($row["pneumonia_balita"]) . "</td>
                    <td>" . htmlspecialchars($row["dbd"]) . "</td>
                    <td>" . htmlspecialchars($row["jumlah"]) . "</td>
                    <td>" . htmlspecialchars($row["luas"]) . "</td>
                    <td>" . htmlspecialchars($row["jumlah_pddk"]) . "</td>
                    <td>" . htmlspecialchars($row["longitude"]) . "</td>
                    <td>" . htmlspecialchars($row["latitude"]) . "</td>
                    
                    <td>
                        <form method='post' style='display:inline;' onsubmit='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");'>
                            <input type='hidden' name='delete_id' value='" . htmlspecialchars($row["id"]) . "'>
                            <button type='submit' class='button button-hapus'>Hapus</button>
                        </form>
                        <form method='get' action='edit.php' style='display:inline;'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "'>
                            <button type='submit' class='button button-edit'>Edit</button>
                        </form>
                    </td>
                </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Tidak ada data.</p>";
        }

        $conn->close();
        ?>
    </div>

</body>

</html>

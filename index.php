<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>CRUD System</title>
    <style>
        /* Pengaturan tampilan global */
        body {
            font-family: 'arial', sans-serif;
            background-color: #e3f2fd;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Container utama */
        .container {
            width: 100%;
            max-width: 1000px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }

        /* Judul halaman */
        h2 {
            font: "Abril fatface", sans-serif;
            color: #000;
            text-align: center;
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 30px;
        }

        /* Container header untuk tombol dan pencarian */
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        /* Tombol */
        .btn, .search-btn {
            padding: 10px 20px;
            background-color: #1a4b8e;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn:hover, .search-btn:hover {
            background-color: #4187d6;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        /* Form pencarian */
        .search-container form {
            display: flex;
            align-items: center;
        }

        .search-container input {
            padding: 10px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            margin-right: 10px;
        }

        /* Container tabel */
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead tr {
            background-color: #1e88e5;
            color: white;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e9e9e9;
        }

        table tbody tr:hover {
            background-color: #f0f8ff;
        }

        /* Tombol aksi di tabel */
        .btn-edit, .btn-delete {
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-edit {
            color: #fff;
            background-color: #175f21;
        }

        .btn-edit:hover {
            background-color: #2daf3e;
        }

        .btn-delete {
            color: #fff;
            background-color: #7e1717;
        }

        .btn-delete:hover {
            background-color: #b64d4d;
        }

        /* Responsif untuk layar kecil */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                align-items: stretch;
            }

            .search-container input {
                width: 100%;
                margin-bottom: 10px;
            }

            .btn, .search-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Pengguna</h2>

        <!-- Container untuk Tombol Tambah Pengguna dan Form Pencarian -->
        <div class="header-container">
            <a href="create.php" class="btn">+ Tambah Pengguna</a>

            <!-- Form Pencarian -->
            <div class="search-container">
                <form method="GET" action="">
                    <input type="text" name="search" placeholder="Cari nama atau email...">
                    <button type="submit" class="search-btn">Cari</button>
                </form>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Koneksi ke database
                    $conn = new mysqli("localhost", "root", "", "crud_db");
                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }

                    // Mendapatkan kata kunci pencarian
                    $search = isset($_GET['search']) ? $_GET['search'] : '';

                    // Query untuk menampilkan data sesuai pencarian
                    $sql = "SELECT * FROM pendaftar WHERE name LIKE '%$search%' OR email LIKE '%$search%'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row["id"] . "</td>
                                <td>" . $row["name"] . "</td>
                                <td>" . $row["email"] . "</td>
                                <td>" . $row["phone"] . "</td>
                                <td>
                                    <a href='update.php?id=" . $row["id"] . "' class='btn-edit'>Edit</a>
                                    <a href='delete.php?id=" . $row["id"] . "' class='btn-delete'>Hapus</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

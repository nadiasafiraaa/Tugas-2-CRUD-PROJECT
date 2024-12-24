<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "crud_db");

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengecek apakah parameter ID diterima
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mengambil data pengguna berdasarkan ID
    $sql = "SELECT * FROM user WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $phone = $row['phone'];
    } else {
        echo "Data tidak ditemukan!";
        exit();
    }
}

// Mengecek apakah tombol delete diklik
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Query untuk menghapus data pengguna
    $sql = "DELETE FROM pendaftar WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Pengguna</title>
    <style>
        .container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .delete-message {
            font-size: 18px;
            margin-bottom: 20px;
            color: #444;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .delete-btn {
            padding: 10px 20px;
            background-color: #7e1717;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .delete-btn:hover {
            background-color: #b64d4d;
        }

        .cancel-btn {
            padding: 10px 20px;
            background-color: #695151;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .cancel-btn:hover {
            background-color: #a59898;
        }
    </style>
</head>
<body>

<div class="container">
    <p class="delete-message">Apakah Anda yakin ingin menghapus data pengguna berikut?</p>
    <p><strong>Nama:</strong> <?php echo $name; ?></p>
    <p><strong>Email:</strong> <?php echo $email; ?></p>
    <p><strong>Telepon:</strong> <?php echo $phone; ?></p>

    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="button-group">
            <button type="submit" name="delete" class="delete-btn" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
            <a href="index.php" class="cancel-btn">Batal</a>
        </div>
    </form>
</div>

</body>
</html>

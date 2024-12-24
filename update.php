<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "crud_db");

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Variabel untuk menyimpan nilai awal
$id = $name = $email = $phone = "";

// Mengecek apakah parameter ID diterima untuk edit data
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mengambil data pengguna berdasarkan ID
    $sql = "SELECT * FROM pendaftar WHERE id=$id";
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

// Mengecek apakah form telah disubmit dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Jika ada ID, maka update data, jika tidak, tambah data baru
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "UPDATE pendaftar SET name='$name', email='$email', phone='$phone' WHERE id=$id";
    } else {
        $sql = "INSERT INTO pendaftar (name, email, phone) VALUES ('$name', '$email', '$phone')";
    }

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
    <title><?php echo isset($_GET['id']) ? 'Edit' : 'Tambah'; ?> Pengguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            width: 320px;
            text-align: center;
        }

        .form-container h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="email"] {
            width: 95%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus {
            border-color: #6c63ff;
            outline: none;
            box-shadow: 0 0 5px rgba(108, 99, 255, 0.5);
        }

        .submit-btn {
            background-color: #1a4b8e;
            color: #ffffff;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s, box-shadow 0.3s;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: #4187d6;
            box-shadow: 0 5px 10px rgba(65, 135, 214, 0.4);
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2><?php echo isset($_GET['id']) ? 'Edit' : 'Tambah'; ?> Pengguna</h2>
    <form method="POST" action="">
        <!-- Hidden input untuk ID -->
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Telepon</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
        </div>
        
        <button type="submit" class="submit-btn"><?php echo isset($_GET['id']) ? 'Update' : 'Tambah'; ?></button>
    </form>
</div>

</body>
</html>

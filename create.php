<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($_GET['id']) ? 'Edit' : 'Tambah'; ?> Pengguna</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f8;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            width: 320px;
            text-align: center;
        }

        .form-container h2 {
            color: #333;
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="email"] {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus {
            border-color: #6c63ff;
            outline: none;
            box-shadow: 0 0 8px rgba(108, 99, 255, 0.3);
        }

        .submit-btn {
            background-color: #1a4b8e;
            color: #ffffff;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s, box-shadow 0.3s, transform 0.2s;
        }

        .submit-btn:hover {
            background-color: #5551c8;
            box-shadow: 0 6px 10px rgba(85, 81, 200, 0.3);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <tbody><?php
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
?></tbody>

<div class="form-container">
    <h2><?php echo isset($_GET['id']) ? 'Edit' : 'Tambah'; ?> Pengguna</h2>
    <form method="POST" action="">
        <!-- Hidden input untuk ID -->
        <input type="hidden" name="id" value="">
        
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" value="" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Telepon</label>
            <input type="text" id="phone" name="phone" value="" required>
        </div>
        
        <button type="submit" class="submit-btn"><?php echo isset($_GET['id']) ? 'Update' : 'Tambah'; ?></button>
    </form>
</div>

</body>
</html>

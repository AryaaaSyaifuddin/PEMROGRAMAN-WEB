<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

include("connection.php");

if (isset($_GET["nim"])) {
    $nim = $_GET["nim"];

    // Retrieve student data based on NIM
    $query = "SELECT * FROM student WHERE nim='$nim'";
    $result = mysqli_query($connection, $query);
    $data = mysqli_fetch_assoc($result);

    // Check if data exists
    if (!$data) {
        die("Data mahasiswa tidak ditemukan.");
    }

    // Assign data to variables
    $name = $data["name"];
} else {
    die("NIM tidak ditemukan.");
}

if (isset($_POST["confirm"])) {
    // Delete data from the database
    $query = "DELETE FROM student WHERE nim='$nim'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $message = "Data mahasiswa \"$name\" berhasil dihapus.";
        $message = urlencode($message);
        header("Location: student_view.php?message={$message}");
    } else {
        die("Query gagal dijalankan: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hapus Data Mahasiswa</title>
    <link href="assets/style.css" rel="stylesheet">

    <style>
        *{
      padding: 0;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      box-sizing: border-box;
      background-color: #4566a1;
    }

    h1{
      font-size: -webkit-xxx-large;
      display: inline-flex;
      justify-content: center;
      width: 100%;
      color: aliceblue;
      padding: 10px;
    }

    h2{
        color: aliceblue;
        margin-bottom: 4px;
        
    }

    form input{
        background-color: aliceblue;
        padding: 10px;
    }
    
    form a{
        color: aliceblue;
        padding: 10px;  
        text-decoration: none;
    }

    .container .hapusdata{
        padding: 30px
    }
    </style>

</head>

<body>
    <div class="container">
        <div id="header">
            <h1 id="logo">Hapus Data Mahasiswa</h1>
        </div>
        <hr>
        <nav>
            <ul>
                <li><a href="student_view.php" style="color: aliceblue; justify-content: center; display: flex; margin-top: 30px">Back</a></li>
                <li><a href="logout.php" style="color: aliceblue; justify-content: center; display: flex; margin-bottom: 30px">Logout</a>
            </ul>
        </nav>;
        <div class="hapusdata">
            <h2>Konfirmasi Hapus Data Mahasiswa</h2>
            <p style="color: aliceblue; font-size: 15px; font-style: italic; margin-bottom: 10px;">Anda yakin ingin menghapus data mahasiswa <strong><?php echo $name; ?></strong>?</p>
            <form action="student_delete.php?nim=<?php echo $nim; ?>" method="post">
                <input type="submit" name="confirm" value="Ya, Hapus Data">
                <a href="student_view.php">Batal</a>
            </form>
        </div>
    </div>
</body>

</html>
<?php
mysqli_close($connection);
?>

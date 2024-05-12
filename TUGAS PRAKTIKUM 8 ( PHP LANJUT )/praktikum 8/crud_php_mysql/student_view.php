<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

include("connection.php");

if (isset($_GET["message"])) {
    $message = $_GET["message"];
}

$query = "SELECT * FROM student ORDER BY nim ASC";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa</title>
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
    }

    table{
        display: flex;
        justify-content: center;
    }

    table tr th{
        padding: 10px 20px;
        color: black;
    }

    th, td {
        text-align: center;
        padding: 8px;
        border: 1px solid #ddd;
    }
    
    th, td a{
        color: aliceblue
    }

    div .pesan{
        margin-bottom: 20px;
        text-align: center;
        color: aliceblue;
        font-style: italic;
        font-weight: 270;
    }
    </style>

</head>
<body>
<div class="container">
    <div id="header">
        <h1 id="logo">Data Mahasiswa</h1>
    </div>
    <hr>
    <nav>
        <ul>
            <li><a href="student_view.php" style="color: aliceblue; justify-content: center; display: flex; margin-top: 30px">Refresh</a></li>
            <li><a href="student_add.php" style="color: aliceblue; justify-content: center; display: flex;">Tambah</a>
            <li><a href="logout.php" style="color: aliceblue; justify-content: center; display: flex; margin-bottom: 30px">Logout</a>
        </ul>
    </nav>
    <?php
    if (isset($message)) {
        echo "<div class='pesan'>$message</div>";
    }
    ?>
    <table border="1">
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Fakultas</th>
            <th>Jurusan</th>
            <th>IPK</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>

        <?php
        $result = mysqli_query($connection, $query);
        if (!$result) {
            die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
        }

        while ($data = mysqli_fetch_assoc($result)) {
            $birth_date = strtotime($data["birth_date"]);
            $formatted_date = date("d-m-Y", $birth_date);

            echo "<tr>";
            echo "<td>{$data['nim']}</td>";
            echo "<td>{$data['name']}</td>";
            echo "<td>{$data['birth_city']}</td>";
            echo "<td>$formatted_date</td>";
            echo "<td>{$data['faculty']}</td>";
            echo "<td>{$data['department']}</td>";
            echo "<td>{$data['gpa']}</td>";
            echo "<td><a href='student_edit.php?nim={$data['nim']}'>Edit</a></td>";
            echo "<td><a href='student_delete.php?nim={$data['nim']}' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a></td>";
            echo "</tr>";
        }

        mysqli_free_result($result);
        mysqli_close($connection);
        ?>
    </table>
</div>
</body>
</html>

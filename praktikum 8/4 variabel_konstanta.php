<?php
    // Menampilkan Variabel dan Konstanta
    $nama = "Arya";
    define("GAJI", 500000000);
    echo $nama;
    echo "<br>";
    echo GAJI;

    // Memanggil variabel dalam string
    $nama = "Arya";
    echo "<p>Selamat pagi $nama</p>";

    // Menghapus Variabel
    $nama = "Arya";
    echo $nama;
    unset($nama);
?>
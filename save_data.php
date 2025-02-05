<?php

$servername = "MalioApar.vercel.app"; // Ganti dengan server Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "apar"; // Ganti dengan nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari form
$inspector = $_POST['inspector'];
$locationType = $_POST['locationType'];
$area = $_POST['area'];
$floor = $_POST['floor'];
$tube = $_POST['tube'];
$hoseCondition = $_POST['hoseCondition'];
$handleCondition = $_POST['handleCondition'];
$safetyPinCondition = $_POST['safetyPinCondition'];
$bodyCondition = $_POST['bodyCondition'];
$pressure = $_POST['pressure'];
$remarks = $_POST['remarks'];
$checkDate = $_POST['checkDate'];

// SQL untuk menyimpan data
$sql = "INSERT INTO checklist (inspector, locationType, area, floor, tube, hoseCondition, handleCondition, safetyPinCondition, bodyCondition, pressure, remarks, checkDate) 
VALUES ('$inspector', '$locationType', '$area', $floor, '$tube', '$hoseCondition', '$handleCondition', '$safetyPinCondition', '$bodyCondition', '$pressure', '$remarks', '$checkDate')";

if ($conn->query($sql) === TRUE) {
    // Redirect ke halaman untuk menampilkan data
    header('Location: display_data.php'); // Ganti dengan nama file untuk menampilkan data
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
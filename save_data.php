<?php
$servername = "MalioApar.vercel.app"; // Ganti dengan server Anda jika tidak lokal
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "apar"; // Ganti dengan nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek apakah form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    // Untuk foto
    if (isset($_FILES['photoUpload'])) {
        $uploadedFiles = [];
        foreach ($_FILES['photoUpload']['tmp_name'] as $index => $tmpName) {
            $fileName = $_FILES['photoUpload']['name'][$index];
            $fileTmp = $_FILES['photoUpload']['tmp_name'][$index];
            $fileDestination = 'uploads/' . $fileName;

            if (move_uploaded_file($fileTmp, $fileDestination)) {
                $uploadedFiles[] = $fileDestination; // Simpan path file yang berhasil di-upload
            }
        }
    }

    // SQL untuk menyimpan data dengan prepared statement
    $stmt = $conn->prepare("INSERT INTO checklist (inspector, locationType, area, floor, tube, hoseCondition, handleCondition, safetyPinCondition, bodyCondition, pressure, remarks, checkDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $inspector, $locationType, $area, $floor, $tube, $hoseCondition, $handleCondition, $safetyPinCondition, $bodyCondition, $pressure, $remarks, $checkDate);

    if ($stmt->execute()) {
        // Jika foto berhasil diupload, kita simpan path foto
        if (!empty($uploadedFiles)) {
            $lastId = $stmt->insert_id; // Dapatkan ID terakhir yang disisipkan
            foreach ($uploadedFiles as $file) {
                $photoStmt = $conn->prepare("INSERT INTO photos (checklist_id, file_path) VALUES (?, ?)");
                $photoStmt->bind_param("is", $lastId, $file);
                $photoStmt->execute();
            }
        }

        // Redirect ke halaman yang sama atau halaman lain setelah berhasil
        header('Location: save_data.php'); // Ganti dengan nama file yang sesuai
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

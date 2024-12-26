<?php
if (isset($_POST['upload'])) {
    // Kiểm tra thư mục upload
    $uploadDir = "uploaded_files/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Xử lý file tải lên
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileError = $_FILES['file']['error'];

    if ($fileError === UPLOAD_ERR_OK) {
        $destination = $uploadDir . basename($fileName);
        if (move_uploaded_file($fileTmpName, $destination)) {
            // Lưu vào cơ sở dữ liệu
            $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg_file) VALUES ('$fileName', '$destination')";
            echo "File uploaded successfully! <a href='test.php'>Go back</a>";
        } else {
            echo "Failed to upload file. <a href='test.php'>Try again</a>";
        }
    } else {
        echo "Error uploading file. Error code: $fileError. <a href='test.php'>Try again</a>";
    }
}
?>


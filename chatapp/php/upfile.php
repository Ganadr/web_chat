

<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        include "config.php";

        $outgoing_id = $_SESSION['user_id'];
        $incoming_id = $_POST['incoming_id'];
        

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
                    $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, msg_file) VALUES ($incoming_id, $outgoing_id,'Gửi file thành công', '$fileName')";

                    mysqli_query($conn,$sql);
                    echo "File uploaded successfully! <a href='../chat.php?user_id=$incoming_id'>Go back</a>";
                    header('location: ../chat.php?user_id='.$incoming_id);
                } else {
                    echo "Failed to upload file. <a href='../chat.php?user_id=$incoming_id'>Try again</a>";
                }
            } else {
                echo "Error uploading file. Error code: $fileError. <a href='../chat.php?user_id=$incoming_id'>Try again</a>";
            }
        }


        






    }else{
        header('location: login.php');
    }
?>


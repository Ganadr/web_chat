<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Download Files</title>
</head>
<body>
    <h2>Upload File</h2>
    <form action="up.php" method="post" enctype="multipart/form-data">
        <label for="file">Choose file:</label>
        <input type="file" name="file" id="file" required>
        <button type="submit" name="upload">Upload</button>
    </form>

    <h2>Available Files</h2>
    <ul>
        <?php
        include "../php/config.php"; // Kết nối cơ sở dữ liệu

        $sql = "SELECT * FROM messages";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                
                $filePath = $row['msg_file'];
                echo "<li><a href='./uploaded_files/$filePath' download>Download</a></li>";
            }
        } else {
            echo "<li>No files available</li>";
        }
        ?>

    </ul>
</body>
</html>








































<div class="chat-layout" style="display: flex; gap: 2rem; padding: 1.5rem; background-color: #f8f9fa; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin: 1rem auto; width: 100%; max-width: 1200px;">
    <!-- Sidebar for files -->
    <div class="file-sidebar" style="flex: 0 0 300px; background: white; padding: 1.5rem; border-radius: 6px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
        <h3 style="color: #2c3e50; font-size: 1.25rem; margin: 0 0 1rem 0; padding-bottom: 0.75rem; border-bottom: 2px solid #e9ecef;">Files</h3>
        <ul style="list-style: none; padding: 0; margin: 0;">
            <?php
            $sqll = "SELECT * FROM messages WHERE (outgoing_msg_id = {$user_id} AND incoming_msg_id = {$get_user_id})
            OR (outgoing_msg_id = {$get_user_id} AND incoming_msg_id = {$user_id}) ORDER BY msg_id";
            $resultt = mysqli_query($conn, $sqll);
            if (mysqli_num_rows($resultt) > 0) {
                while ($row = mysqli_fetch_assoc($resultt)) {
                    $filePath = $row['msg_file'];
                    echo "<li style='margin: 0.5rem 0;'><a href='./uploaded_files/uploaded_files/$filePath' download style='display: block; padding: 0.75rem 1rem; color: #495057; text-decoration: none; background: #f8f9fa; border-radius: 4px; transition: all 0.2s ease; word-break: break-all; hover: {background: #e9ecef; color: #228be6; transform: translateX(4px);}'>{$filePath}</a></li>";
                }
            } else {
                echo "<li style='margin: 0.5rem 0;'>No files available</li>";
            }
            ?>
        </ul>
    </div>
    <div style="flex: 1; background: white; padding: 1.5rem; border-radius: 6px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
        <h2 style="color: #2c3e50; font-size: 1.5rem; margin: 0 0 1.5rem 0;">Upload File</h2>
        <form action="./php/upfile.php" method="post" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1rem;">
            <label for="file" style="color: #495057; font-weight: 500;">Choose file:</label>
            <input type="file" name="file" id="file" required style="padding: 0.5rem; border: 2px dashed #dee2e6; border-radius: 4px; background: #f8f9fa; cursor: pointer;">
            <input type="text" name="incoming_id" value="<?php echo $get_user_id ?>" class="incoming_id" hidden>
            <button type="submit" name="upload" style="padding: 0.75rem 1.5rem; background: #228be6; color: white; border: none; border-radius: 4px; font-weight: 500; cursor: pointer; transition: background 0.2s ease; align-self: flex-start; hover: {background: #1c7ed6;}">Upload</button>
        </form>
    </div>
</div>

<script>
// Add hover effects since they can't be added directly in inline styles
document.querySelectorAll('.file-sidebar a').forEach(link => {
    link.addEventListener('mouseover', function() {
        this.style.background = '#e9ecef';
        this.style.color = '#228be6';
        this.style.transform = 'translateX(4px)';
    });
    link.addEventListener('mouseout', function() {
        this.style.background = '#f8f9fa';
        this.style.color = '#495057';
        this.style.transform = 'translateX(0)';
    });
});

document.querySelector('button[name="upload"]').addEventListener('mouseover', function() {
    this.style.background = '#1c7ed6';
});
document.querySelector('button[name="upload"]').addEventListener('mouseout', function() {
    this.style.background = '#228be6';
});
</script>

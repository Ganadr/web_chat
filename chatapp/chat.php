<?php 
    include 'php/config.php';// including the database connection
    session_start();
    $user_id = $_SESSION['user_id'];

    $get_user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
    if(!isset($user_id)){
        header('location: login.php');
    }

    $select = mysqli_query($conn, "SELECT * FROM user_form WHERE user_id = '$get_user_id' ");
    $s = mysqli_query($conn, "SELECT * FROM user_form WHERE user_id = '$user_id'");
    if(mysqli_num_rows($select) > 0){
        $row = mysqli_fetch_assoc($select);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/chat-layout.css">
    <title>chat area</title>

    <style>
        /* Dark mode styles */
        [data-theme="dark"] {
            --bg-color: #1a1a1a;
            --text-color: #ffffff;
            --border-color: #404040;
            --section-bg: #2d2d2d;
        }

        [data-theme="light"] {
            --bg-color: #ffffff;
            --text-color: #333333;
            --border-color: #e6e6e6;
            --section-bg: #f8f8f8;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
        }

        .container section {
            background-color: var(--section-bg);
            border-color: var(--border-color);
        }

        .theme-toggle {
            position: absolute;
            right: 80px;
            top: 20px;
            padding: 8px 12px;
            border-radius: 5px;
            border: 1px solid var(--border-color);
            background: transparent;
            color: var(--text-color);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <section class="chat-area">
            <button class="theme-toggle">🌓</button>
            <header>
                <a href="home.php" class="back-icon"><img src="images/arrow.svg" alt=""></a>
                <img src="uploaded_img/<?php echo $row['img'] ?>" alt="">
                <div class="details">
                    <span><?php echo $row['name'] ?></span>
                    <p><?php echo $row['status'] ?></p>
                </div>
            </header>

            <div class="chat-box">
                <!-- <div class="text">
                    <img src="uploaded_img/default-avatar.png" alt="">
                    <span>no message are available. once you send message will appear here.</span>
                </div> -->

                <!-- <div class="chat outgoing">
                    <div class="details">
                        <p>hi</p>
                    </div>
                </div>
                <div class="chat incoming">
                    <img src="uploaded_img/default-avatar.png" alt="">
                    <div class="details">
                        <p>hi</p>
                    </div>
                </div>
                <div class="chat incoming">
                    <img src="uploaded_img/default-avatar.png" alt="">
                    <div class="details">
                        <p><img src="uploaded_img/default-avatar.png" alt=""></p>
                    </div>
                </div>
                <div class="chat outgoing">
                    <div class="details">
                        <p><img src="uploaded_img/default-avatar.png" alt=""></p>
                    </div>
                </div> -->
                
            </div>

            <form action="" class="typing-area" method="POST">
                <input type="text" name="incoming_id" value="<?php echo $get_user_id ?>" class="incoming_id" hidden>
                <input type="text" name="message" class="input-field" placeholder="type a message here....">
                <button class="image"><img src="images/camera.svg" alt=""></button>
                <input type="file" name="send_image" accept="image/*" class="upload_img" hidden>
                <button class="send_btn" name="send_btn"><img src="images/send.svg" alt=""></button>
            </form>
            
        </section>

        <div class="chat-layout" >
                <!-- Sidebar for files -->
                <div class="file-sidebar">
                    <h3>Files</h3>
                    <ul>
                        <?php

                        $sqll = "SELECT * FROM messages WHERE (outgoing_msg_id = {$user_id} AND incoming_msg_id = {$get_user_id})
                    OR (outgoing_msg_id = {$get_user_id} AND incoming_msg_id = {$user_id}) ORDER BY msg_id";
                        $resultt = mysqli_query($conn, $sqll);

                        if (mysqli_num_rows($resultt) > 0) {
                            while ($row = mysqli_fetch_assoc($resultt)) {
                                
                                $filePath = $row['msg_file'];
                                echo "<li><a href='./uploaded_files/uploaded_files/$filePath' download>$filePath</a></li>";
                            }
                        } else {
                            echo "<li>No files available</li>";
                        }
                        ?>
                    </ul>
                </div>
                <div>
                    <h2>Upload File</h2>
                    <form action="./php/upfile.php" method="post" enctype="multipart/form-data">
                        <label for="file">Choose file:</label>
                        <input type="file" name="file" id="file" required>
                        <input type="text" name="incoming_id" value="<?php echo $get_user_id ?>" class="incoming_id" hidden>

                        <button type="submit" name="upload">Upload</button>
                    </form>
                </div>
                <div class="info">
                 
                <?php if(mysqli_num_rows($s) > 0){
                    $row = mysqli_fetch_assoc($s);
                } ?>
                <img src="uploaded_img/<?php echo $row['img'] ?>" alt="">
                <div class="details">
                    <span> <?php echo $row['name'] ?></span>
                    <p><?php echo $row['status'] ?></p>
                </div>
                 
                </div>
                
        </div>


    </div>

    <script src="js/chat.js"></script>
    <script>
        const themeToggle = document.querySelector('.theme-toggle');
        
        // Check for saved theme preference
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    </script>
</body>
</html>
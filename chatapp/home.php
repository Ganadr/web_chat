<?php 
    include 'php/config.php';// including the database connection
    session_start();
    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location: login.php');
    }

    $select = mysqli_query($conn, "SELECT * FROM user_form WHERE user_id = '$user_id' ");
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
    <title>Home page</title>

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
        <section class="users">
            <header class="profile">
                <div class="content">
                    <a href="update_profile.php"><img src="uploaded_img/<?php echo $row['img'] ?>" alt=""></a>
                    <div class="details">
                        <span><?php echo $row['name'] ?></span>
                        <p><?php echo $row['status'] ?></p>
                    </div>
                </div>
                <button class="theme-toggle">🌓</button>
                <a href="php/logout.php?logout_id=<?php echo $user_id ?>" class="logout">Logout</a>
                
            </header>
            <form action="" method="post" class="search">
                <input type="text" name="search_box" placeholder="enter name or email to search">
                <button name="search_user"><img src="images/search.svg" alt=""></button>
            </form>
            <div class="all_users">
                <!-- <a href="chat.php">
                    <div class="content">
                        <img src="uploaded_img/default-avatar.png" alt="">
                        <div class="details">
                            <span>Alfred Marshall</span>
                            <p>hello bro</p>
                        </div>
                    </div>
                    <div class="status-dot"></div>
                </a> -->
            </div>


            <!-- giải trí -->
            <div style="font-family: 'Arial', sans-serif; background-color: #f4f4f9; display: flex; justify-content: center; align-items: center; height: 10vh; padding-top: 10px;">
                    <a href="caro.php" style="text-decoration: none; padding: 20px 30px; background-color: #87CEEB; color: white; font-size: 20px; font-weight: bold; border-radius: 50px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;">
                        Mệt mỏi quá ư, hãy giải trí nào
                    </a>
                </div>
                <script>
                    // JavaScript for hover effect
                    const link = document.querySelector('a');
                    link.addEventListener('mouseenter', () => {
                        link.style.backgroundColor = '#00BFFF'; // Light sky blue
                        link.style.transform = 'translateY(-3px)';
                        link.style.boxShadow = '0 6px 15px rgba(0, 0, 0, 0.2)';
                    });
                    link.addEventListener('mouseleave', () => {
                        link.style.backgroundColor = '#87CEEB'; // Sky blue
                        link.style.transform = 'translateY(0)';
                        link.style.boxShadow = '0 4px 10px rgba(0, 0, 0, 0.1)';
                    });
                    link.addEventListener('mousedown', () => {
                        link.style.transform = 'translateY(1px)';
                        link.style.boxShadow = '0 3px 7px rgba(0, 0, 0, 0.15)';
                    });
                    link.addEventListener('mouseup', () => {
                        link.style.transform = 'translateY(0)';
                        link.style.boxShadow = '0 4px 10px rgba(0, 0, 0, 0.1)';
                    });
                </script>

                
        </section>



    </div>
    <script src="js/home.js"></script>
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
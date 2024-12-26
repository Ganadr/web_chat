<?php 
include 'php/config.php';// including the database connection
    session_start(); 

    ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị viên</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-50">
    <div class="p-6 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold"><a href="login.php">Admin--->Login</a></h1>
            <div class="text-sm text-gray-500">27/12/2024</div>
        </div>

        <!-- Thẻ thống kê -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <!-- Thống kê người dùng -->
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Tổng người dùng</p>
                        <p class="text-2xl font-bold text-blue-600"><?php 
                        $tong_user="SELECT COUNT(*) AS total_rows
                        FROM user_form ;" ;
                        $r = mysqli_query($conn, $tong_user);
                        if ($r) {
                            // Lấy dữ liệu từ kết quả
                            $row = mysqli_fetch_assoc($r);
                            echo $row['total_rows'];
                        } else {
                            echo "Không có dữ liệu.";
                        }?>
                            
                        </p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Thống kê tin nhắn -->
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Tổng tin nhắn</p>
                        <p class="text-2xl font-bold text-green-600"><?php 
                            $t_m="SELECT COUNT(msg) AS total_not_null
                            FROM messages
                            WHERE msg IS NOT NULL;";
                            $r = mysqli_query($conn, $t_m);
                            if ($r) {
                                // Lấy dữ liệu từ kết quả
                                $row = mysqli_fetch_assoc($r);
                                echo $row['total_not_null'];
                            } else {
                                echo "Không có dữ liệu.";}
                         ?></p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Thống kê ảnh -->
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Tổng ảnh gửi</p>
                        <p class="text-2xl font-bold text-purple-600"><?php 
                            $t_i="SELECT COUNT(msg_img) AS total_not_null
                            FROM messages
                            WHERE msg_img IS NOT NULL;";
                            $r = mysqli_query($conn, $t_i);
                            if ($r) {
                                // Lấy dữ liệu từ kết quả
                                $row = mysqli_fetch_assoc($r);
                                echo $row['total_not_null'];
                            } else {
                                echo "Không có dữ liệu.";}
                         ?></p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Thống kê file -->
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Tổng file gửi</p>
                        <p class="text-2xl font-bold text-orange-600"><?php 
                            $t_f="SELECT COUNT(msg_file) AS total_not_null
                            FROM messages
                            WHERE msg_file IS NOT NULL;";
                            $r = mysqli_query($conn, $t_f);
                            if ($r) {
                                // Lấy dữ liệu từ kết quả
                                $row = mysqli_fetch_assoc($r);
                                echo $row['total_not_null'];
                            } else {
                                echo "Không có dữ liệu.";}
                         ?></p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-full">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nội dung chính -->
        <div class="bg-white rounded-lg shadow p-6">
            <!-- Thanh tìm kiếm -->
            <!-- <div class="mb-4">
                <div class="flex gap-4">
                    <input type="text" placeholder="Tìm kiếm theo tên hoặc email..." 
                           class="flex-1 p-2 border rounded focus:ring-2 focus:ring-blue-500">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                        Tìm kiếm
                    </button>
                </div>
            </div> -->

            <!-- Bảng cuộn -->
            <div class="overflow-x-auto">
                <div class="max-h-[600px] overflow-y-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="p-4 text-left bg-gray-50">Người dùng</th>
                                <th class="p-4 text-left bg-gray-50">Email</th>
                                <th class="p-4 text-left bg-gray-50">Trạng thái</th>
                                
                            </tr>
                        </thead>
                        <?php 
                        $sql="SELECT * FROM user_form;";
                        $r = mysqli_query($conn, $sql);
                            
                         
                         ?>
                        <tbody class="divide-y">
                            
                            <!-- 2 mẫu dòng dữ liệu thực tế -->
                            


                                <?php 
                                if ($r) {
                                    // Kiểm tra xem có kết quả không
                                    if (mysqli_num_rows($r) > 0) {
                                        // Lặp qua từng dòng kết quả
                                        while ($row = mysqli_fetch_assoc($r)) {
                                            $n = $row['name']; // Lấy tên từ kết quả
                                            $e = $row['email'];
                                            $a = $row['status'];
                                            $i = $row['img'];
                                            echo '<tr class="hover:bg-gray-50">
                                <td class="p-4 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-600 font-medium"><img src="./uploaded_img/'.$i.'"></span>
                                    </div>'.$n.'</td>
                                <td class="p-4">'.$e.'<td class="p-4">
                                    <span class="px-2 py-1 rounded-full text-sm bg-green-100 text-green-800">'.$a.'</span>
                                </td>';
                                        }
                                    } else {
                                        echo "<li>No available</li>"; // Nếu không có dữ liệu
                                    }
                                }

                                 ?>


                                 

                                
                                
                                
                            
                        </tbody>


                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
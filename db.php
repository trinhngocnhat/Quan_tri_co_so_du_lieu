<?php
// Cấu hình kết nối
$serverName = "localhost"; // Tên máy chủ hoặc địa chỉ IP của SQL Server
$connectionOptions = array(
    "Database" => "hienmau", // Tên cơ sở dữ liệu của bạn
    "Uid" => "TRINHNGOCNHAT",           // Tên người dùng SQL Server
    "PWD" => ""            // Mật khẩu người dùng SQL Server
);

// Kết nối đến SQL Server
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Kiểm tra kết nối
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true)); // In lỗi nếu kết nối thất bại
} else {
    echo "Kết nối thành công!";
}

// Đóng kết nối
sqlsrv_close($conn);
?>

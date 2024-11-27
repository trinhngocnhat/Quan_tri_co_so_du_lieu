<?php
$serverName = "TRINHNGOCNHAT"; // Hoặc "." nếu bạn sử dụng SQL Server Express
$database = "hienmau"; // Tên cơ sở dữ liệu bạn muốn kết nối đến

try {
    // Tạo chuỗi DSN cho SQL Server với xác thực Windows
    $dsn = "sqlsrv:Server=$serverName;Database=$database";

    // Kết nối tới SQL Server với PDO sử dụng xác thực Windows
    $conn = new PDO($dsn);

    // Thiết lập chế độ lỗi PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Kết nối thành công!";
} catch (PDOException $e) {
    echo "Lỗi kết nối: " . $e->getMessage();
}
?>
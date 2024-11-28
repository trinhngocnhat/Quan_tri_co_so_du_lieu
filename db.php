<?php
$serverName = "TRINHNGOCNHAT";
$database = "hienmau";

try {
    $dsn = "sqlsrv:Server=$serverName;Database=$database";
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Thêm Session
    if (isset($_POST['add_session'])) {
        $donation_date = $_POST['donation_date'];
        $max_slot = $_POST['max_slot'];
        $available_slots = $_POST['available_slots'];

        $stmt = $conn->prepare("INSERT INTO Blood_donation_sessions (donation_date, max_slot, available_slots) VALUES (?, ?, ?)");
        $stmt->execute([$donation_date, $max_slot, $available_slots]);
        header("Location: admin.php");
    }

    // Cập nhật Session
    if (isset($_POST['update_session'])) {
        $id = $_POST['id_session'];
        $donation_date = $_POST['donation_date'];
        $max_slot = $_POST['max_slot'];
        $available_slots = $_POST['available_slots'];

        $stmt = $conn->prepare("UPDATE Blood_donation_sessions SET donation_date = ?, max_slot = ?, available_slots = ? WHERE id_session = ?");
        $stmt->execute([$donation_date, $max_slot, $available_slots, $id]);
        header("Location: admin.php");
    }

    // Xóa Session
    if (isset($_POST['delete_session_id'])) {
        $id = $_POST['delete_session_id'];

        $stmt = $conn->prepare("DELETE FROM Blood_donation_sessions WHERE id_session = ?");
        $stmt->execute([$id]);
        header("Location: admin.php");
    }

    // Thêm Donor
    if (isset($_POST['add_donor'])) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $blood_type = $_POST['blood_type'];
        $height = $_POST['height'];
        $weight = $_POST['weight'];
        $day_of_birth = $_POST['day_of_birth'];
        $last_donation = $_POST['last_donation'];

        $stmt = $conn->prepare("INSERT INTO Donor (name, phone, blood_type, height, weight, day_of_birth, last_donation) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $phone, $blood_type, $height, $weight, $day_of_birth, $last_donation]);
        header("Location: admin.php");
    }

    // Cập nhật Donor
    if (isset($_POST['update_donor'])) {
        $id = $_POST['id_donor'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $blood_type = $_POST['blood_type'];
        $height = $_POST['height'];
        $weight = $_POST['weight'];
        $day_of_birth = $_POST['day_of_birth'];
        $last_donation = $_POST['last_donation'];

        $stmt = $conn->prepare("UPDATE Donor SET name = ?, phone = ?, blood_type = ?, height = ?, weight = ?, day_of_birth = ?, last_donation = ? WHERE id_donor = ?");
        $stmt->execute([$name, $phone, $blood_type, $height, $weight, $day_of_birth, $last_donation, $id]);
        header("Location: admin.php");
    }

    // Xóa Donor
    if (isset($_POST['delete_donor_id'])) {
        $id = $_POST['delete_donor_id'];

        $stmt = $conn->prepare("DELETE FROM Donor WHERE id_donor = ?");
        $stmt->execute([$id]);
        header("Location: admin.php");
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #444;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 60px;
            overflow-y: auto;
        }
        .sidebar a {
            display: block;
            padding: 10px;
            color: #fff;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #555;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        .table-container {
            margin-bottom: 40px;
        }
        form {
            margin-top: 20px;
        }
        form input, form button {
            padding: 8px;
            margin-right: 10px;
            margin-bottom: 10px;
        }
        form button {
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Admin Dashboard</h1>
    </div>

    <div class="sidebar">
        <a href="#sessions">Blood Donation Sessions</a>
        <a href="#donors">Donors</a>
    </div>

    <div class="main-content">
        <h2>Welcome, Admin</h2>
        <p>Manage blood donation sessions and donors.</p>

        <!-- Bảng phiên hiến máu -->
        <div id="sessions" class="table-container">
            <h3>Blood Donation Sessions</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Donation Date</th>
                        <th>Max Slots</th>
                        <th>Available Slots</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db.php';

                    // Lấy dữ liệu phiên hiến máu
                    try {
                        $stmt = $conn->query("SELECT * FROM Blood_donation_sessions");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>{$row['id_session']}</td>";
                            echo "<td>{$row['donation_date']}</td>";
                            echo "<td>{$row['max_slot']}</td>";
                            echo "<td>{$row['available_slots']}</td>";
                            echo "<td>
                                    <form method='post' style='display:inline;'>
                                        <input type='hidden' name='edit_session_id' value='{$row['id_session']}'>
                                        <input type='hidden' name='donation_date' value='{$row['donation_date']}'>
                                        <input type='hidden' name='max_slot' value='{$row['max_slot']}'>
                                        <input type='hidden' name='available_slots' value='{$row['available_slots']}'>
                                        <button type='submit' name='edit_session'>Edit</button>
                                    </form>
                                    <form method='post' style='display:inline;'>
                                        <input type='hidden' name='delete_session_id' value='{$row['id_session']}'>
                                        <button type='submit'>Delete</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='5'>Error: " . $e->getMessage() . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Thêm phiên hiến máu mới -->
            <form method="post">
                <h4>Add New Session</h4>
                <input type="date" name="donation_date" required>
                <input type="number" name="max_slot" placeholder="Max Slots" required>
                <input type="number" name="available_slots" placeholder="Available Slots" required>
                <button type="submit" name="add_session">Add Session</button>
            </form>

            <!-- Sửa phiên hiến máu -->
            <?php if (isset($_POST['edit_session'])): ?>
            <form method="post">
                <h4>Edit Session</h4>
                <input type="hidden" name="id_session" value="<?php echo $_POST['edit_session_id']; ?>">
                <input type="date" name="donation_date" value="<?php echo $_POST['donation_date']; ?>" required>
                <input type="number" name="max_slot" value="<?php echo $_POST['max_slot']; ?>" required>
                <input type="number" name="available_slots" value="<?php echo $_POST['available_slots']; ?>" required>
                <button type="submit" name="update_session">Save Changes</button>
            </form>
            <?php endif; ?>
        </div>

        <!-- Bảng thông tin người hiến máu -->
        <div id="donors" class="table-container">
            <h3>Donors</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Blood Type</th>
                        <th>Height</th>
                        <th>Weight</th>
                        <th>Date of Birth</th>
                        <th>Last Donation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Lấy dữ liệu người hiến máu
                    try {
                        $stmt = $conn->query("SELECT * FROM Donor");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>{$row['id_donor']}</td>";
                            echo "<td>{$row['name']}</td>";
                            echo "<td>{$row['phone']}</td>";
                            echo "<td>{$row['blood_type']}</td>";
                            echo "<td>{$row['height']}</td>";
                            echo "<td>{$row['weight']}</td>";
                            echo "<td>{$row['day_of_birth']}</td>";
                            echo "<td>{$row['last_donation']}</td>";
                            echo "<td>
                                    <form method='post' style='display:inline;'>
                                        <input type='hidden' name='edit_donor_id' value='{$row['id_donor']}'>
                                        <input type='hidden' name='name' value='{$row['name']}'>
                                        <input type='hidden' name='phone' value='{$row['phone']}'>
                                        <input type='hidden' name='blood_type' value='{$row['blood_type']}'>
                                        <input type='hidden' name='height' value='{$row['height']}'>
                                        <input type='hidden' name='weight' value='{$row['weight']}'>
                                        <input type='hidden' name='day_of_birth' value='{$row['day_of_birth']}'>
                                        <input type='hidden' name='last_donation' value='{$row['last_donation']}'>
                                        <button type='submit' name='edit_donor'>Edit</button>
                                    </form>
                                    <form method='post' style='display:inline;'>
                                        <input type='hidden' name='delete_donor_id' value='{$row['id_donor']}'>
                                        <button type='submit'>Delete</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='9'>Error: " . $e->getMessage() . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Thêm người hiến máu mới -->
            <form method="post">
                <h4>Add New Donor</h4>
                <input type="text" name="name" placeholder="Name" required>
                <input type="text" name="phone" placeholder="Phone" required>
                <input type="text" name="blood_type" placeholder="Blood Type" required>
                <input type="number" name="height" placeholder="Height" required>
                <input type="number" name="weight" placeholder="Weight" required>
                <input type="date" name="day_of_birth" required>
                <input type="date" name="last_donation">
                <button type="submit" name="add_donor">Add Donor</button>
            </form>

            <!-- Sửa thông tin người hiến máu -->
            <?php if (isset($_POST['edit_donor'])): ?>
            <form method="post">
                <h4>Edit Donor</h4>
                <input type="hidden" name="id_donor" value="<?php echo $_POST['edit_donor_id']; ?>">
                <input type="text" name="name" value="<?php echo $_POST['name']; ?>" required>
                <input type="text" name="phone" value="<?php echo $_POST['phone']; ?>" required>
                <input type="text" name="blood_type" value="<?php echo $_POST['blood_type']; ?>" required>
                <input type="number" name="height" value="<?php echo $_POST['height']; ?>" required>
                <input type="number" name="weight" value="<?php echo $_POST['weight']; ?>" required>
                <input type="date" name="day_of_birth" value="<?php echo $_POST['day_of_birth']; ?>" required>
                <input type="date" name="last_donation" value="<?php echo $_POST['last_donation']; ?>">
                <button type="submit" name="update_donor">Save Changes</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

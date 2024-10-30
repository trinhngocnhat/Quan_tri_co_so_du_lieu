CREATE TABLE Donor (
    id_donor CHAR(12) PRIMARY KEY,         -- Mã định danh duy nhất cho mỗi người hiến máu
    name VARCHAR(50) NOT NULL,             -- Tên người hiến máu
    phone VARCHAR(15),                     -- Số điện thoại, cho phép chứa mã vùng
    blood_type ENUM('O', 'A', 'B', 'AB') NOT NULL,  -- Nhóm máu
    height INT,                            -- Chiều cao (cm)
    weight INT,                            -- Cân nặng (kg)
    day_of_birth DATE NOT NULL,            -- Ngày sinh, để tính tuổi người hiến máu
    last_donation DATE,                    -- Ngày hiến máu lần cuối
    create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Ngày giờ tạo bản ghi
);


CREATE TABLE Blood_donation_sessions (
    id_session CHAR(10) PRIMARY KEY,           -- Mã định danh duy nhất cho mỗi phiên hiến máu
    donation_date DATE NOT NULL,               -- Ngày tổ chức phiên hiến máu
    max_slot INT CHECK (max_slot <= 10),       -- Số lượng tối đa người có thể hiến trong phiên
    available



**Giải thích**:
- **`max_slot`** có ràng buộc để giới hạn số lượng người tham gia mỗi phiên không vượt quá 10.
- **`available_slots`** lưu trữ số chỗ còn trống trong phiên hiến máu, và có ràng buộc kiểm tra để đảm bảo nó không vượt quá `max_slot`.

### 3. **Bảng Donation_requests** (Thông tin đăng ký hiến máu)

Bảng này lưu trữ thông tin đăng ký hiến máu cho mỗi phiên, liên kết với người hiến máu và phiên hiến máu cụ thể.

```sql
CREATE TABLE Donation_requests (
    id_request CHAR(15) PRIMARY KEY,                  -- Mã định danh duy nhất cho mỗi yêu cầu
    id_donor CHAR(12),                                -- Tham chiếu đến người hiến máu (khóa ngoại từ bảng Donor)
    id_session CHAR(10),                              -- Tham chiếu đến phiên hiến máu (khóa ngoại từ bảng Blood_donation_sessions)
    request_date DATE DEFAULT CURRENT_DATE,           -- Ngày đăng ký hiến máu
    FOREIGN KEY (id_donor) REFERENCES Donor(id_donor),
    FOREIGN KEY (id_session) REFERENCES Blood_donation_sessions(id_session)
);

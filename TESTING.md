# SmartCafe Lab01 — Bộ test thủ công

Bộ test này dùng để bạn tự chạy từng tình huống trên cả bản `basic.php` và bản refactor. Không cần cài test framework.

## Chạy một test

1. Mở `basic.php` và `data/cafe-data.php` trong VS Code.
2. Thay các giá trị sample bằng input của một hàng trong bảng bên dưới. Hai file có các biến tương ứng: `$unitPrice`, `$rawQuantity`, `$customerStatus`, `$productAvailable`.
3. Chạy bản Basic trong Terminal:

   ```powershell
   cd C:\xampp\htdocs\smartcafe-lab01
   C:\xampp\php\php.exe basic.php
   ```

4. Chạy lại cùng input trên bản refactor:

   ```powershell
   C:\xampp\php\php.exe index.php
   ```

   Output của `index.php` là HTML; tìm tổng tiền và trạng thái trong output. Hoặc để xem giao diện, bật Apache trong XAMPP rồi tải lại `http://localhost/smartcafe-lab01/`.

5. So sánh Actual với Expected. Sau mỗi test, chuyển sang input của hàng kế tiếp. Cuối cùng khôi phục sample mặc định: `45.000`, `" 3 "`, `MEMBER`, `true`.

## Test Data Matrix

Quy tắc dùng trong các phép tính: giảm giá thành viên 5% nếu `customerStatus === "MEMBER"` và subtotal `>= 120.000`; phí bao bì 2.000/ly; phí dịch vụ 4% trên subtotal sau giảm giá. Tổng = subtotal − discount + packaging + service fee.

| Case | `$unitPrice` | `$rawQuantity` | `$customerStatus` | `$productAvailable` | Expected | Trường hợp cần kiểm tra |
|---|---:|---|---|---|---|---|
| T1 Happy path | `45000` | `" 3 "` | `"MEMBER"` | `true` | Subtotal 135.000; giảm 6.750; bao bì 6.000; dịch vụ 5.130; tổng **139.380 VND**; `READY TO ORDER` | Trim/cast, giảm giá, phí và gate hợp lệ |
| T2 No benefit | `45000` | `"2"` | `"GUEST"` | `true` | Subtotal 90.000; giảm 0; bao bì 4.000; dịch vụ 3.600; tổng **97.600 VND**; `READY TO ORDER` | Không phải member nên không giảm |
| T3 Boundary | `40000` | `"3"` | `"MEMBER"` | `true` | Subtotal 120.000; giảm 6.000; bao bì 6.000; dịch vụ 4.560; tổng **124.560 VND**; `READY TO ORDER` | Đúng ngưỡng `>= MEMBER_MIN` vẫn được giảm |
| T4 Invalid quantity | `45000` | `"0"` | `"MEMBER"` | `true` | Subtotal 0; giảm 0; bao bì 0; dịch vụ 0; tổng **0 VND**; `BLOCKED` | `$hasValidQuantity` là false |
| T5 Product unavailable | `45000` | `"1"` | `"GUEST"` | `false` | Subtotal 45.000; giảm 0; bao bì 2.000; dịch vụ 1.800; tổng **48.800 VND**; `BLOCKED` | Sản phẩm không còn; gate là false |

## Phiếu ghi kết quả

Điền sau khi tự chạy từng case. Hai bản cần cho ra cùng kết quả với cùng input.

| Case | Basic Actual | Refactor Actual | Pass/Fail | Ghi chú |
|---|---|---|---|---|
| T1 |  |  |  |  |
| T2 |  |  |  |  |
| T3 |  |  |  |  |
| T4 |  |  |  |  |
| T5 |  |  |  |  |

## File được chia theo trách nhiệm

- `basic.php`: bản một file để quan sát input, kiểu dữ liệu, công thức và receipt.
- `config/constants.php`: các business constants.
- `data/cafe-data.php`: sample input; giữ raw quantity ở dạng string.
- `src/cafe.php`: chuẩn hóa, tính toán và xác định trạng thái.
- `views/receipt.php`: hiển thị kết quả HTML.
- `index.php`: nạp constants → data → logic → view theo thứ tự.


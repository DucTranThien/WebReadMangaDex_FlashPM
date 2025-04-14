📖 MangaFlashPM

MangaFlashPM là nền tảng đọc truyện tranh trực tuyến được xây dựng bằng PHP thuần, kết nối trực tiếp với MangaDex API để fetch dữ liệu truyện. Dự án hướng đến trải nghiệm người dùng hiện đại, tốc độ nhanh, nền tối đẹp mắt, và tích hợp hệ thống xác thực người dùng bằng JWT chuyên nghiệp.

🚀 Tính Năng Chính

✅ Tìm kiếm nâng cao theo tên, thể loại, tình trạng truyện

✅ Hiển thị chi tiết truyện: ảnh bìa, mô tả, chapter, rating, like, follow

✅ Đọc truyện theo chương, hiển thị hình ảnh chất lượng cao từ MangaDex CDN

✅ Tự động lưu lịch sử đọc truyện của người dùng

✅ Hệ thống đăng nhập/đăng ký hỗ trợ:

🔐 Form thường (username/password)

🔐 Google Login

🔐 Facebook Login

✅ Sử dụng JWT để xác thực, đồng bộ avatar và thông tin người dùng

✅ Giao diện nền tối, responsive, chia component rõ ràng (header, footer, dashboard, ...)

✅ Tối ưu tốc độ với hệ thống cache JSON từ API

🛠️ Công Nghệ Sử Dụng

Thành phần

Công nghệ

Backend

PHP thuần

Frontend

HTML, CSS, JavaScript

Database

MySQL (phpMyAdmin quản lý)

API

MangaDex REST API

Xác thực

JSON Web Token (JWT) với firebase/php-jwt

OAuth

Google API, Facebook SDK

Công cụ hỗ trợ

Composer, cURL, XAMPP

📦 Cấu Trúc Thư Mục Dự Án

Comic/
├── api/                # Gọi API MangaDex, cache truyện
├── includes/           # Cấu hình DB, xử lý JWT, header/footer
├── pages/              # Giao diện chính: index, manga_detail, readingpage, search
├── users/              # Xử lý auth: login, register, dashboard, update_avatar/profile
├── uploads/            # Lưu avatar người dùng (nếu upload)
├── assets/             # CSS, hình ảnh mặc định
├── vendor/             # Thư viện JWT (sinh ra bởi composer)
└── .env (tuỳ chọn)     # Lưu khóa bí mật Google/Facebook

⚙️ Hướng Dẫn Cài Đặt

1️⃣ Clone Dự Án

git clone https://github.com/your-username/MangaFlashPM.git
cd MangaFlashPM

2️⃣ Cài Đặt Thư Viện JWT

composer install

Sử dụng composer require firebase/php-jwt nếu chưa có file composer.json

3️⃣ Cấu Hình CSDL

Tạo CSDL tên comic trên phpMyAdmin

Import file comic.sql có sẵn trong dự án

4️⃣ Cấu Hình OAuth (nếu dùng)

Đăng ký Google Client ID / Facebook App ID

Điền thông tin vào file .env hoặc chỉnh trực tiếp trong google-callback.php, facebook-callback.php

5️⃣ Chạy Localhost

Mở http://localhost/Comic/index.php

Đăng ký tài khoản và bắt đầu đọc truyện

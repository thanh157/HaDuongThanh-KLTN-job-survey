
function validatePassword() {
    const email = document.querySelector('input[name="email"]').value;
    const password = document.querySelector('input[name="password"]').value;
    const confirmPassword = document.querySelector('input[name="password_confirmation"]').value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Regex kiểm tra email

    // Kiểm tra email hợp lệ
    if (!emailRegex.test(email)) {
        alert("Vui lòng nhập email hợp lệ.");
        return false;
    }

    // Kiểm tra mật khẩu nhập lại
    if (password !== confirmPassword) {
        document.getElementById("passwordError").style.display = "block";
        return false;
    } else {
        document.getElementById("passwordError").style.display = "none";
    }

    // Hiển thị thông báo thành công và chuyển sang form chỉnh sửa
    // showSuccessMessage(event);
    return false; // Ngăn gửi form đi
}

function showSuccessMessage(event) {
    event.preventDefault();

    // Ẩn form đăng ký và hiển thị thông báo thành công
    document.querySelector(".login-form").style.display = "none";
    document.getElementById("successMessage").style.display = "block";
    // document.getElementById("profileEditForm").style.display = "block";
}

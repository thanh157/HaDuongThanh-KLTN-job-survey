// Kiểm tra mật khẩu và hiển thị thông báo lỗi nếu không khớp
function validatePassword() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;

    if (password !== confirmPassword) {
        document.getElementById("passwordError").style.display = "block"; // Hiển thị thông báo lỗi
        return false; // Ngừng form submit
    } else {
        document.getElementById("passwordError").style.display = "none"; // Ẩn thông báo lỗi
        showSuccessMessage(); // Hiển thị thông báo thành công
        return false; // Ngừng submit để không reload trang
    }
}

// Hiển thị thông báo thành công và ẩn form
function showSuccessMessage() {
    document.getElementById("registrationForm").style.display = "none";
    document.getElementById("successMessage").style.display = "block";
}

// Chuyển hướng đến trang chỉnh sửa hồ sơ
function goToProfile() {
    window.location.href = "profile-edit.html"; // Đổi thành URL trang chỉnh sửa hồ sơ của bạn
}

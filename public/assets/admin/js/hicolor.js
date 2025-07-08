document.addEventListener("DOMContentLoaded", function () {
    const hour = new Date().getHours();
    const greetingBox = document.querySelector(".custom-greeting");

    // Gán nội dung chào dựa theo giờ
    const greetingText = document.getElementById("greeting");
    if (hour >= 5 && hour < 12) {
        greetingText.innerText = "Chào buổi sáng!";
    } else if (hour >= 12 && hour < 18) {
        greetingText.innerText = "Chào buổi chiều!";
    } else {
        greetingText.innerText = "Chào buổi tối!";
    }

    // Gán class thời tiết hiệu ứng
    if (hour >= 18 || hour < 6) {
        greetingBox.classList.add("weather-effect"); // hiệu ứng sao/tuyết
    }
});


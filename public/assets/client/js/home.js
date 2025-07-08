document.addEventListener('DOMContentLoaded', function () {
    // document.querySelectorAll('.like-icon').forEach(likeElement => {
    //     likeElement.addEventListener('click', function (event) {
    //         event.preventDefault();

    //         const heartIcon = this.querySelector('i');
    //         const likeCountElement = this.querySelector('span');
    //         const heartContainer = this.closest('.card-footer').querySelector('.heart-container');
    //         let likeCount = parseInt(likeCountElement.textContent.trim());

    //         if (heartIcon.classList.contains('fa-solid')) { // Nếu là trái tim đậm
    //             heartIcon.classList.remove('fa-solid'); // Loại bỏ trạng thái đậm
    //             heartIcon.classList.add('fa-regular'); // Trái tim không đậm
    //             // likeCount -= 1;
    //         } else {
    //             heartIcon.classList.remove('fa-regular'); // Loại bỏ trái tim không đậm
    //             heartIcon.classList.add('fa-solid'); // Trái tim đậm (đỏ)
    //             // likeCount += 1;

    //             // Tạo nhiều trái tim bay lên
    //             for (let i = 0; i < 8; i++) { // Tạo 8 trái tim bay lên
    //                 createFlyingHeart(heartContainer);
    //             }
    //         }

    //         // Cập nhật số lượng tim
    //         // likeCountElement.textContent = likeCount;
    //     });
    // });

    // Hàm tạo trái tim bay
    function createFlyingHeart(container) {
        const heart = document.createElement('i');
        heart.className = 'fa-solid fa-heart heart'; // Biểu tượng trái tim từ Font Awesome

        // Vị trí ngẫu nhiên cho mỗi trái tim
        const randomX = Math.random() * 60 - 30;  // Vị trí ngang ngẫu nhiên
        const randomY = Math.random() * 50 - 30;  // Vị trí dọc ngẫu nhiên
        const randomRotation = Math.random() * 60 - 30;  // Góc quay ngẫu nhiên
        const randomScale = Math.random() * 0.5 + 1;  // Kích thước ngẫu nhiên

        heart.style.left = `${randomX}%`;
        heart.style.top = `100%`;  // Bắt đầu từ dưới
        heart.style.transform = `rotate(${randomRotation}deg) scale(${randomScale})`;  // Thêm góc quay và thay đổi kích thước
        heart.style.animationDelay = `${Math.random() * 0.5}s`; // Thời gian bay ngẫu nhiên
        container.appendChild(heart);

        // Xóa trái tim khi hoàn thành animation
        heart.addEventListener('animationend', () => {
            heart.remove();
        });
    }
});

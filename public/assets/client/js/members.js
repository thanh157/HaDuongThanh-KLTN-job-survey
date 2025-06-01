
// Đường dẫn đến avatar (server xử lý đúng trong file Blade)
const avatarPath = "{{asset('assets/client/images/logo-vnua.jpg')}}";

// Dữ liệu thành viên
const members = [
    { name: "Nguyễn Văn An", role: "Tổ trưởng nhóm nghiên cứu", avatar: avatarPath },
    { name: "Trần Thị Bích", role: "Cộng tác viên", avatar: avatarPath },
    { name: "Lê Văn Cường", role: "Thành viên", avatar: avatarPath },
    { name: "Hoàng Thị Duyên", role: "Thành viên", avatar: avatarPath },
    { name: "Phạm Minh Đức", role: "Thành viên", avatar: avatarPath },
    { name: "Nguyễn Thị Hoa", role: "Cộng tác viên", avatar: avatarPath },
    { name: "Trần Văn Hải", role: "Thành viên", avatar: avatarPath },
    { name: "Lê Thị Khánh", role: "Thành viên", avatar: avatarPath },
    { name: "Hoàng Văn Nam", role: "Tổ trưởng nhóm sự kiện", avatar: avatarPath },
    { name: "Phạm Thị Oanh", role: "Cộng tác viên", avatar: avatarPath }
];

  
  let currentPage = 1;
  const membersPerPage = 6;
  
  // Hàm hiển thị các thành viên trên mỗi trang
  function displayMembers() {
    const start = (currentPage - 1) * membersPerPage;
    const end = currentPage * membersPerPage;
    const membersToDisplay = members.slice(start, end);
    
    const memberList = document.getElementById('member-list');
    memberList.innerHTML = ''; // Xóa danh sách cũ
  
    membersToDisplay.forEach(member => {
      const li = document.createElement('li');
      li.innerHTML = `
        <div class="avatar-container">
          <img src="${member.avatar}" alt="Avatar">
          <div class="member-info">
            <p>${member.name}</p>
            <p>${member.role}</p>
          </div>
        </div>
      `;
      memberList.appendChild(li);
    });
  
    // Cập nhật thông tin trang hiện tại
    document.getElementById('current-page').textContent = `Trang ${currentPage}`;
  
    // Cập nhật trạng thái của nút phân trang
    document.getElementById('prev-page').disabled = currentPage === 1;
    document.getElementById('next-page').disabled = currentPage * membersPerPage >= members.length;
  }
  
  // Hàm xử lý việc chuyển trang
  function changePage(direction) {
    if (direction === 'next') {
      currentPage++;
    } else if (direction === 'prev') {
      currentPage--;
    }
    displayMembers(); // Cập nhật danh sách khi thay đổi trang
  }
  
  // Gọi hàm displayMembers khi trang được tải
  document.addEventListener('DOMContentLoaded', displayMembers);
  
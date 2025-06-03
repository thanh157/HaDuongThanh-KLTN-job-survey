  function toggleFilter(id) {
    // Ẩn popup khác
    document.querySelectorAll('.filter-popup').forEach(popup => {
      if (popup.id !== id) popup.style.display = 'none';
    });

    // Toggle popup hiện tại
    const el = document.getElementById(id);
    el.style.display = (el.style.display === 'block') ? 'none' : 'block';
  }

  // Ẩn khi click ra ngoài
  window.addEventListener('click', function (e) {
    document.querySelectorAll('.filter-popup').forEach(popup => {
      if (!popup.contains(e.target) && !popup.previousElementSibling.contains(e.target)) {
        popup.style.display = 'none';
      }
    });
  });
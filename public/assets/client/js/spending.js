let totalExpense = 0;
    const expenses = [
      { date: '2024-12-15', description: 'Sự kiện 1 - Mua vật liệu', amount: 200000 },
      { date: '2024-12-18', description: 'Sự kiện 2 - Thuê địa điểm', amount: 1000000 },
      { date: '2024-12-22', description: 'Sự kiện 3 - Đồ ăn uống', amount: 500000 }
    ];

    const expenseList = document.getElementById('expenseList');
    const totalExpenseElement = document.querySelector('.total-expense p');

    expenses.forEach(expense => {
      totalExpense += expense.amount;
    });

    totalExpenseElement.textContent = `Tổng chi tiêu: ${totalExpense.toLocaleString()} VND`;

    // Tìm kiếm chi tiêu
    document.getElementById('searchInput').addEventListener('input', function () {
      const searchTerm = this.value.toLowerCase();
      const filteredExpenses = expenses.filter(expense => 
        expense.description.toLowerCase().includes(searchTerm) || expense.date.includes(searchTerm)
      );
      renderExpenses(filteredExpenses);
    });

    document.getElementById('filterSelect').addEventListener('change', function () {
      const selectedEvent = this.value;
      const filteredExpenses = selectedEvent ? expenses.filter(expense => expense.description.includes(selectedEvent)) : expenses;
      renderExpenses(filteredExpenses);
    });

    function renderExpenses(expenses) {
      expenseList.innerHTML = '';
      expenses.forEach(expense => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${expense.date}</td>
          <td>${expense.description}</td>
          <td>${expense.amount.toLocaleString()} VND</td>
        `;
        expenseList.appendChild(row);
      });
    }
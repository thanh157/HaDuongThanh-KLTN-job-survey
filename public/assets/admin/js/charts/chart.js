document.addEventListener('DOMContentLoaded', function () {
const pieCtx = document.getElementById('pieChart').getContext('2d');

const barCtx = document.getElementById('barChart').getContext('2d');
const batches = ['Đợt 1', 'Đợt 2', 'Đợt 3'];

const chartData = {
  employed: {
    pieLabels: ['Có việc làm', 'Chưa có việc làm'],
    pieData: [500, 120],
    pieColors: ['#4caf50', '#ff7043'],

    lineLabels: batches,
    employedCount: [120, 180, 200],
    totalGraduates: [150, 220, 250]
  },
  location: {
    pieLabels: ['Trong nước', 'Nước ngoài'],
    pieData: [420, 80],
    pieColors: ['#2196f3', '#ffc107'],

    lineLabels: batches,
    inCountry: [100, 150, 170],
    outCountry: [20, 30, 30]
  },
  field: {
    pieLabels: ['Đúng ngành', 'Trái ngành'],
    pieData: [390, 120],
    pieColors: ['#9c27b0', '#f44336'],

    lineLabels: batches,
    correctField: [90, 140, 160],
    wrongField: [30, 40, 50]
  }
};

// Khởi tạo biểu đồ Pie
const pieChart = new Chart(pieCtx, {
  type: 'pie',
  data: {
    labels: chartData.employed.pieLabels,
    datasets: [{
      data: chartData.employed.pieData,
      backgroundColor: chartData.employed.pieColors,
      hoverOffset: 25,
    }]
  },
  options: {
    responsive: false,
    maintainAspectRatio: false,
    plugins: {
      legend: { position: 'bottom', labels: { padding: 14, font: { size: 14, weight: '600' } } }
    }
  }
});

// Khởi tạo biểu đồ Bar nhóm
let barChart = new Chart(barCtx, {
  type: 'bar',
  data: {
    labels: chartData.employed.lineLabels,
    datasets: [
      {
        label: 'Có việc làm',
        data: chartData.employed.employedCount,
        backgroundColor: '#4caf50',
      },
      {
        label: 'Tổng số SV tốt nghiệp',
        data: chartData.employed.totalGraduates,
        backgroundColor: '#1976d2',
      }
    ]
  },
  options: {
    responsive: false,
    maintainAspectRatio: false,
    scales: {
      y: { beginAtZero: true, grid: { color: '#eee' } },
      x: { grid: { color: '#eee' } }
    },
    plugins: {
      legend: { position: 'top', labels: { font: { size: 14, weight: '600' } } }
    }
  }
});

// Cập nhật biểu đồ theo lựa chọn
document.getElementById('chartType').addEventListener('change', function () {
  const val = this.value;

  if (val === 'employed') {
    pieChart.data.labels = chartData.employed.pieLabels;
    pieChart.data.datasets[0].data = chartData.employed.pieData;
    pieChart.data.datasets[0].backgroundColor = chartData.employed.pieColors;

    barChart.data.labels = chartData.employed.lineLabels;
    barChart.data.datasets = [
      {
        label: 'Có việc làm',
        data: chartData.employed.employedCount,
        backgroundColor: '#4caf50',
      },
      {
        label: 'Tổng số SV tốt nghiệp',
        data: chartData.employed.totalGraduates,
        backgroundColor: '#1976d2',
      }
    ];
  } 
  else if (val === 'location') {
    pieChart.data.labels = chartData.location.pieLabels;
    pieChart.data.datasets[0].data = chartData.location.pieData;
    pieChart.data.datasets[0].backgroundColor = chartData.location.pieColors;

    barChart.data.labels = chartData.location.lineLabels;
    barChart.data.datasets = [
      {
        label: 'Làm trong nước',
        data: chartData.location.inCountry,
        backgroundColor: '#2196f3',
      },
      {
        label: 'Làm ngoài nước',
        data: chartData.location.outCountry,
        backgroundColor: '#ffc107',
      }
    ];
  } 
  else if (val === 'field') {
    pieChart.data.labels = chartData.field.pieLabels;
    pieChart.data.datasets[0].data = chartData.field.pieData;
    pieChart.data.datasets[0].backgroundColor = chartData.field.pieColors;

    barChart.data.labels = chartData.field.lineLabels;
    barChart.data.datasets = [
      {
        label: 'Đúng ngành',
        data: chartData.field.correctField,
        backgroundColor: '#9c27b0',
      },
      {
        label: 'Trái ngành',
        data: chartData.field.wrongField,
        backgroundColor: '#f44336',
      }
    ];
  }

  pieChart.update();
  barChart.update();
});
});
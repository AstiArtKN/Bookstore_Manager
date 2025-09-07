const ctx = document.getElementById("myChart");

new Chart(ctx, {
  type: "bar",
  data: {
    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
    datasets: [
      {
        label: "# of Votes",
        data: [12, 19, 3, 5, 2, 3],
        backgroundColor: "white",
        borderRadius: 5, // bo góc
        barThickness: 9,
      },
    ],
  },
  options: {
    scales: {
      y: {
        beginAtZero: true,
      },
    },
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
  },
});

const canvas2 = document.getElementById("myChart-right");
const ctx2 = canvas2.getContext("2d"); // lấy context 2D

// Tạo gradient màu
const gradient1 = ctx2.createLinearGradient(0, 0, 0, 400);
gradient1.addColorStop(0, "rgba(236, 72, 153, 0.2)"); // hồng nhạt
gradient1.addColorStop(1, "rgba(236, 72, 153, 0)"); // trong suốt

const gradient2 = ctx2.createLinearGradient(0, 0, 0, 400);
gradient2.addColorStop(0, "rgba(59, 130, 246, 0.2)"); // xanh nhạt
gradient2.addColorStop(1, "rgba(59, 130, 246, 0)"); // trong suốt

new Chart(ctx2, {
  type: "line",
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
    datasets: [
      {
        label: "Sales 2024",
        data: [10, 20, 15, 25, 30, 45],
        borderColor: "#ec4899",
        backgroundColor: gradient1,
        fill: true,
        tension: 0.4, // bo tròn line
        pointRadius: 2, // chấm tròn
        pointBackgroundColor: "#ec4899",
      },
      {
        label: "Sales 2025",
        data: [5, 15, 10, 30, 25, 40],
        borderColor: "#1e3a8a",
        backgroundColor: gradient2,
        fill: true,
        tension: 0.4,
        pointRadius: 2,
        pointBackgroundColor: "#1e3a8a",
      },
    ],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
  },
});

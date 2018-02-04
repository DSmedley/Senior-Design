function chart(n1, n2, n3) {
    var ctx = document.getElementById("myChart").getContext("2d");
    var myChart = new Chart(ctx, {
      type: "doughnut",
      data: {
        labels: ["Positive", "Neutral", "Negative"],
        datasets: [{
          backgroundColor: [
            "#2ecc71",
            "#95a5a6",
            "#e74c3c"
          ],
          data: [n1, n2, n3]
        }]
      },
      options: {
          title: {
            display: true,
            text: 'Users overall positivity index'
          },
          responsive: true,
          maintainAspectRatio: false,
        }
    });
    return myChart;
}

new Chart(document.getElementById("pie-chart"), {
    type: 'doughnut',
    data: {
        labels: ["Neutral", "Positive", "Negative"],
        display: false,
        datasets: [{
            label: "Positivity Index",
            backgroundColor: ["#95a5a6","#2ecc71","#c45850"],
            data: [33,33,34]
        }]
    },
    options: {
        title: {
            display: false,
            text: 'Twitter Users Overall Positivity Index'
        },
        legend: {
            display: false
        }
    }
});

chart(pos, neu, neg);

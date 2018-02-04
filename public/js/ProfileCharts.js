function chart(name, data) {            
        var myChart = new Chart(document.getElementById(name), {
        type: 'doughnut',
        data: {
            labels: ["Neutral", "Positive", "Negative"],
            display: false,
            datasets: [{
                label: "Positivity Index",
                backgroundColor: ["#95a5a6","#2ecc71","#e74c3c"],
                data: data
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

    return myChart;
}



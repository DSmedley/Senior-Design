function preview(name, data) {            
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

function chart(name, data) {            
        var myChart = new Chart(document.getElementById(name), {
        type: 'doughnut',
        data: {
            labels: ["Neutral", "Positive", "Negative"],
            display: true,
            datasets: [{
                label: "Positivity Index",
                backgroundColor: ["#95a5a6","#2ecc71","#e74c3c"],
                data: data
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Overall Positivity Index'
            },
            legend: {
                display: true
            }
        }
    });

    return myChart;
}

function bar(name, data) {            
        var myChart = new Chart(document.getElementById(name), {
        type: 'bar',
        data: {
            labels: ["Anger", "Anticipation", "Disgust", "Fear", "Joy", "Sadness", "Surprise", "Trust"],
            display: true,
            datasets: [{
                backgroundColor: [
                    'rgba(0, 99, 132, 0.6)',
                    'rgba(30, 99, 132, 0.6)',
                    'rgba(60, 99, 132, 0.6)',
                    'rgba(90, 99, 132, 0.6)',
                    'rgba(120, 99, 132, 0.6)',
                    'rgba(150, 99, 132, 0.6)',
                    'rgba(180, 99, 132, 0.6)',
                    'rgba(210, 99, 132, 0.6)',
                    'rgba(240, 99, 132, 0.6)'
                ],
                borderColor: [
                    'rgba(0, 99, 132, 1)',
                    'rgba(30, 99, 132, 1)',
                    'rgba(60, 99, 132, 1)',
                    'rgba(90, 99, 132, 1)',
                    'rgba(120, 99, 132, 1)',
                    'rgba(150, 99, 132, 1)',
                    'rgba(180, 99, 132, 1)',
                    'rgba(210, 99, 132, 1)',
                    'rgba(240, 99, 132, 1)'
                ],
                data: data
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Twitter Users Emotions'
            },
            legend: {
                display: false
            }
        }
    });

    return myChart;
}


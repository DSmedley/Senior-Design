function positive(name, names, data) { 
    var dataset = [];
    var colors = ['rgba(0, 99, 132, 0.6)', 'rgba(60, 99, 132, 0.6)', 'rgba(120, 99, 132, 0.6)', 'rgba(180, 99, 132, 0.6)'];
    var borders = ['rgba(0, 99, 132, 1)', 'rgba(60, 99, 132, 1)', 'rgba(120, 99, 132, 1)', 'rgba(180, 99, 132, 1)'];
    for (i = 0, j = 0; i < data.length; i+=3, j++) { 
        dataset.push({
            label: names[j],
            backgroundColor: colors[j],
            borderColor: borders[j],
            data: [data[i], data[i+1], data[i+2]]
        });
    }
    var myChart = new Chart(document.getElementById(name), {
        type: 'bar',
        data: {
            labels: ["Neutral", "Positive", "Negative"],
            display: false,
            datasets: dataset
        },
        options: {
            title: {
                display: true,
                text: 'Overall Positivity Index Comparison'
            }
        }
    });

    return myChart;
}

function compare(name, names, labels, data) {       
    var dataset = [];
    var colors = ['rgba(0, 99, 132, 0.6)', 'rgba(60, 99, 132, 0.6)', 'rgba(120, 99, 132, 0.6)', 'rgba(180, 99, 132, 0.6)'];
    var borders = ['rgba(0, 99, 132, 1)', 'rgba(60, 99, 132, 1)', 'rgba(120, 99, 132, 1)', 'rgba(180, 99, 132, 1)'];
    for (i = 0, j = 0; i < data.length; i+=2, j++) { 
        dataset.push({
            label: names[j],
            backgroundColor: colors[j],
            borderColor: borders[j],
            data: [data[i], data[i+1]]
        });
    }
    var myChart = new Chart(document.getElementById(name), {
        type: 'bar',
        data: {
            labels: labels,
            display: true,
            datasets: dataset
        },
        options: {
            title: {
                display: true,
                text: 'Emotion Comparison'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
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


var colors = ['rgba(4, 40, 239, 0.6)', 'rgba(33, 224, 52, 0.6)', 'rgba(204, 0, 0, 0.6)', 'rgba(163, 0, 204, 0.6)'];
var borders = ['rgba(4, 40, 239, 1)', 'rgba(33, 224, 52, 1)', 'rgba(204, 0, 0, 1)', 'rgba(163, 0, 204, 1)'];

function positive(name, names, data) { 
    var dataset = [];
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

function percentage(name, names, text, percent, sign) { 
    var chart = document.getElementById(name);
    var dataset = [];
    for (k = 0; k < names.length; k++) {
        dataset.push({
            'percent': percent[k], 
            'color': colors[k], 
            'title': names[k] 
        });
    }

	$(chart).circliful({
        animationStep: 15,
        foregroundBorderWidth: 7,
        backgroundBorderWidth: 7,
        text: text,
        multiPercentage: 1,
        percentages: dataset,
        multiPercentageLegend: 1,
        noPercentageSign: sign
    });
}

function activeHours(name, names, times, occurs) {
    var data = new Array();
    var dataset = [];

    for (k = 0; k < times.length; k++) {
        data[k] = new Array();
        for (i = 0, j = 0; i < times[k].length; i++, j++) { 
            if(times[k][i] == j){
                data[k].push(occurs[k][i]);
            }else{
                data[k].push(0);
                i--;
            }
        }
        dataset.push({
            type: 'bar',
            label: names[k],
            backgroundColor: colors[k],
            borderColor: borders[k],
            data: data[k]
        });
    }
    var myChart = new Chart(document.getElementById(name), {
        type: 'bar',
        data: {
            labels: ["12am", "1am", "2am", "3am", "4am", "5am", "6am", "7am", "8am", "9am", "10am", "11am", "12pm", "1pm", "2pm", "3pm", "4pm", "5pm", "6pm", "7pm", "8pm", "9pm", "10pm", "11pm"],
            display: true,
            datasets: dataset
        },
        options: {
            scales: {
              xAxes: [{
                  stacked: true
              }],
              yAxes: [{
                  stacked: true,
                  ticks: {
                        beginAtZero: true
                    }
              }]
            },
            maintainAspectRatio: false,
            title: {
                display: true,
                text: 'Tweets Per Hour (UTC Military Time)'
            },
            legend: {
                display: true
            },
            tooltips: {
                mode: 'index'
            }
        }
    });

    return myChart;
}
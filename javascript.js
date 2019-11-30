$(".navbarImage").on('click', function() {

    window.location.reload(true);

});





var table = document.getElementById("mainTable2");

var totalFat = 0;
var totalCarbs = 0;
var totalProtein = 0;
var totalCosts = 0;
var totalKcals = 0;


for (var i = 0; i < table.rows.length; i++) {
    totalFat = totalFat + Number(table.rows[i].cells[1].innerHTML);
    totalCarbs = totalCarbs + Number(table.rows[i].cells[2].innerHTML);
    totalProtein = totalProtein + Number(table.rows[i].cells[3].innerHTML);
    totalCosts = totalCosts + Number(table.rows[i].cells[4].innerHTML);
    totalKcals = totalKcals + Number(table.rows[i].cells[5].innerHTML);
}


document.getElementById("totalKcals").innerHTML = 'Kcals:&emsp;' + totalKcals;
document.getElementById("totalCosts").innerHTML = 'Costs:&emsp; € ' + totalCosts.toFixed(2);

// Create food items

function createFoodItem() {

    document.getElementById("modalOne").classList.remove('hidden');
}



function cancel() {
    document.getElementById('foodForm').reset();
    document.getElementById("modalOne").classList.add('hidden');
}

function cancel2() {
    document.getElementById("modalTwo").classList.add('hidden');
}

function cancel3() {
    document.getElementById("modalThree").classList.add('hidden');
}

// Chart one

let chart = document.getElementById('chart').getContext('2d');

var ctx = $('#chart')[0];

ctx.height = 165;


let barChart = new Chart(chart, {
    type: 'bar',
    data: {
        labels: ['Fat', 'Carbs', 'Protein'],
        datasets: [{
            label: 'Grams',
            data: [
                totalFat,
                totalCarbs,
                totalProtein,
            ],
            backgroundColor: ['rgba(250, 147, 28, 0.8)', 'rgba(236, 59, 66, 0.8)', 'rgba(161, 223, 245, 0.8)']
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        title: {
            display: false,
            text: 'Macros',
            fontSize: 15,
        },
        legend: {
            display: false
        },
        scales: {
            yAxes: [{
                display: true,
                ticks: {
                    beginAtZero: true,
                    display: true,
                    steps: 6,
                    max: 250
                },
                gridLines: {
                    display: false
                }
            }],
            xAxes: [{
                gridLines: {
                    display: false
                }
            }]
        }
    }
});

function updateChart() {

    var table = document.getElementById("mainTable2");

    var totalFat = 0;
    var totalCarbs = 0;
    var totalProtein = 0;
    var totalCosts = 0;
    var totalKcals = 0;

    for (var i = 0; i < table.rows.length; i++) {
        totalFat = totalFat + Number(table.rows[i].cells[1].innerHTML);
        totalCarbs = totalCarbs + Number(table.rows[i].cells[2].innerHTML);
        totalProtein = totalProtein + Number(table.rows[i].cells[3].innerHTML);
        totalCosts = totalCosts + Number(table.rows[i].cells[4].innerHTML);
        totalKcals = totalKcals + Number(table.rows[i].cells[5].innerHTML);
    }



    barChart.data.datasets[0].data = [totalFat, totalCarbs, totalProtein];
    barChart.update();

    document.getElementById("totalKcals").innerHTML = 'Kcals:&emsp;' + totalKcals;
    document.getElementById("totalCosts").innerHTML = 'Costs:&emsp; € ' + totalCosts.toFixed(2);

};


var today = moment().format("DD/MM");
var todayMinusOne = moment().subtract(1, 'days').format("DD/MM");
var todayMinusTwo = moment().subtract(2, 'days').format("DD/MM");
var todayMinusThree = moment().subtract(3, 'days').format("DD/MM");
var todayMinusFour = moment().subtract(4, 'days').format("DD/MM");
var todayMinusFive = moment().subtract(5, 'days').format("DD/MM");
var todayMinusSix = moment().subtract(6, 'days').format("DD/MM");

// Load Graph data from database

var graphthis = 'graph';

$(document).ready(function() {

    var totalPriceToday = 'test';

    console.log('ready');
    $.post("loadgraphs.php", { graphthis: graphthis }, function(data) {

        var returnData = JSON.parse(data);
        console.log(returnData);

        totalPriceToday = returnData[0][1];
        totalPriceMinusOne = returnData[1][1];
        totalPriceMinusTwo = returnData[2][1];
        totalPriceMinusThree = returnData[3][1];
        totalPriceMinusFour = returnData[4][1];
        totalPriceMinusFive = returnData[5][1];
        totalPriceMinusSix = returnData[6][1];



        // Chart two

        let chartTwo = document.getElementById('chartTwo').getContext('2d');

        let lineChart = new Chart(chartTwo, {
            type: 'line',
            data: {
                labels: [todayMinusSix,
                    todayMinusFive,
                    todayMinusFour,
                    todayMinusThree,
                    todayMinusTwo,
                    todayMinusOne,
                    today,
                ],
                datasets: [{
                    label: ['Kg'],
                    data: [
                        63.7,
                        63.3,
                        63.1,
                        63.5,
                        63.2,
                        62.9,
                        63.2,
                    ],
                    backgroundColor: ['rgba(161, 223, 245, 0.3)'],
                    borderColor: ['rgba(92, 97, 101, 0.3)'],
                    pointBorderColor: 'rgba(92, 97, 101, 0.7)',
                    pointBackgroundColor: 'rgba(92, 97, 101, 0.7)',

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: false,
                    text: 'Weight',
                    fontSize: 15,
                },
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        display: false,
                        ticks: {
                            beginAtZero: false,
                            display: false,
                        },
                        gridLines: {
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                }
            }
        });

        // Chart Three




        let chartThree = document.getElementById('chartThree').getContext('2d');

        let barChartTwo = new Chart(chartThree, {
            type: 'bar',
            data: {
                labels: [todayMinusSix,
                    todayMinusFive,
                    todayMinusFour,
                    todayMinusThree,
                    todayMinusTwo,
                    todayMinusOne,
                    today
                ],
                datasets: [{
                    label: ['€'],
                    data: [
                        totalPriceMinusSix,
                        totalPriceMinusFive,
                        totalPriceMinusFour,
                        totalPriceMinusThree,
                        totalPriceMinusTwo,
                        totalPriceMinusOne,
                        totalPriceToday
                    ],
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: false,
                    text: 'Costs',
                    fontSize: 15,
                },
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true,
                            display: true,
                            steps: 1,
                            max: 14
                        },
                        gridLines: {
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                }
            }
        });


        // Chart Four

        let chartFour = document.getElementById('chartFour').getContext('2d');

        let barChartFour = new Chart(chartFour, {
            type: 'bar',
            data: {
                labels: [todayMinusSix,
                    todayMinusFive,
                    todayMinusFour,
                    todayMinusThree,
                    todayMinusTwo,
                    todayMinusOne,
                    today,
                ],
                datasets: [{
                        label: ['Fat'],
                        data: [
                            totalPriceMinusSix,
                            totalPriceMinusFive,
                            totalPriceMinusFour,
                            totalPriceMinusThree,
                            totalPriceMinusTwo,
                            totalPriceMinusOne,
                            totalPriceToday
                        ],
                        backgroundColor: '#EBCCD1'
                    },
                    {
                        label: ['Carbs'],
                        data: [
                            2,
                            2,
                            2,
                            2,
                            2,
                            2,
                            2
                        ],
                        backgroundColor: '#FAEBCC'
                    },
                    {
                        label: ['Protein'],
                        data: [
                            1,
                            1,
                            1,
                            1,
                            1,
                            1,
                            1
                        ],
                        backgroundColor: '#D6E9C6'
                    }
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: false,
                    text: 'Costs',
                    fontSize: 15,
                },
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        display: true,
                        stacked: true,
                        ticks: {
                            beginAtZero: true,
                            display: true,
                            steps: 1,
                            max: 14
                        },
                        gridLines: {
                            display: false
                        }
                    }],
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            display: false
                        }
                    }]
                }
            }
        });









    });
});

// Chart header functions


$('#tableKcalsGraph').click(function() {
    $('#tableKcalsGraph').css({
        'border-bottom': '4px solid lightgrey',
    });

    $('#tableWeightGraph').css({
        'border-bottom': '0px',
    });

    $('#tableCostsGraph').css({
        'border-bottom': '0px',
    });

    $('#chartTwo').addClass("hidden");
    $('#chartThree').addClass("hidden");
    $('#chartFour').removeClass("hidden");

});

$('#tableWeightGraph').click(function() {
    $('#tableKcalsGraph').css({
        'border-bottom': '0px',
    });

    $('#tableWeightGraph').css({
        'border-bottom': '4px solid lightgrey',
    });

    $('#tableCostsGraph').css({
        'border-bottom': '0px',
    });

    $('#chartFour').addClass("hidden");
    $('#chartTwo').removeClass("hidden");
    $('#chartThree').addClass("hidden");

});


$('#tableCostsGraph').click(function() {
    $('#tableKcalsGraph').css({
        'border-bottom': '0px',
    });

    $('#tableWeightGraph').css({
        'border-bottom': '0px',
    });

    $('#tableCostsGraph').css({
        'border-bottom': '4px solid lightgrey',
    });

    $('#chartFour').addClass("hidden");
    $('#chartTwo').addClass("hidden");
    $('#chartThree').removeClass("hidden");

});

//
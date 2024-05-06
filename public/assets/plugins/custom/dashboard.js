$('.overview-year').on('change', function () {
    let year = $(this).val();
    updateUserOverviewChart(year)
})

$(document).ready(function() {
    getYearlyStatistics();
    updateUserOverviewChart();
})

let userOverView = false;

// Function to update the User Overview chart
function updateUserOverviewChart(year = new Date().getFullYear()) {
    if (userOverView) {
        userOverView.destroy();
    }
    Chart.defaults.elements.arc.roundedCornersFor = {
        "start": 0,
        "end": 0
    };
    Chart.defaults.datasets.doughnut.cutout = '65%';
    let url = $('#get-user-overview').val();
    $.ajax({
        url: url += '?year=' + year,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            let totalFreeUsers = data.free_user;
            let totalSubscription = data.subscription;
            let inMonths = $("#ShareProfit");
            userOverView = new Chart(inMonths, {
                type: 'doughnut',
                data: {
                    labels: ["Free Users: " + totalFreeUsers, "Subscribed Users: " + totalSubscription],
                    datasets: [{
                        label: "Total Users",
                        borderWidth: 0,
                        data: [totalFreeUsers, totalSubscription],
                        backgroundColor: [
                            "#2CE78D",
                            "#9039FF",
                        ],
                        borderColor: [
                            "#2CE78D",
                            "#2CE78D",
                        ],
                    }]
                },
                plugins: [{
                    afterUpdate: function (chart) {
                        if (chart.options.elements.arc.roundedCornersFor !== undefined) {
                            var arcValues = Object.values(chart.options.elements.arc.roundedCornersFor);

                            arcValues.forEach(function (arcs) {
                                arcs = Array.isArray(arcs) ? arcs : [arcs];
                                arcs.forEach(function (i) {
                                    var arc = chart.getDatasetMeta(0).data[i];
                                    arc.round = {
                                        x: (chart.chartArea.left + chart.chartArea
                                            .right) / 2,
                                        y: (chart.chartArea.top + chart.chartArea
                                            .bottom) / 2,
                                        radius: (arc.outerRadius + arc
                                            .innerRadius) / 2,
                                        thickness: (arc.outerRadius - arc
                                            .innerRadius) / 2,
                                        backgroundColor: arc.options.backgroundColor
                                    }
                                });
                            });
                        }
                    },
                    afterDraw: (chart) => {

                        if (chart.options.elements.arc.roundedCornersFor !== undefined) {
                            var {
                                ctx,
                                canvas
                            } = chart;
                            var arc,
                                roundedCornersFor = chart.options.elements.arc.roundedCornersFor;
                            for (var position in roundedCornersFor) {
                                var values = Array.isArray(roundedCornersFor[position]) ?
                                    roundedCornersFor[position] : [roundedCornersFor[position]];
                                values.forEach(p => {
                                    arc = chart.getDatasetMeta(0).data[p];
                                    var startAngle = Math.PI / 2 - arc.startAngle;
                                    var endAngle = Math.PI / 2 - arc.endAngle;
                                    ctx.save();
                                    ctx.translate(arc.round.x, arc.round.y);
                                    ctx.fillStyle = arc.options.backgroundColor;
                                    ctx.beginPath();
                                    if (position == "start") {
                                        ctx.arc(arc.round.radius * Math.sin(startAngle), arc
                                            .round.radius * Math.cos(startAngle), arc.round
                                            .thickness, 0, 2 * Math.PI);
                                    } else {
                                        ctx.arc(arc.round.radius * Math.sin(endAngle), arc.round
                                            .radius * Math.cos(endAngle), arc.round
                                            .thickness, 0, 2 * Math.PI);
                                    }
                                    ctx.closePath();
                                    ctx.fill();
                                    ctx.restore();
                                });

                            }
                            ;
                        }
                    }
                }],
                options: {
                    responsive: true,
                    tooltips: {
                        displayColors: true,
                        zIndex: 999999,
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 10
                            }
                        },
                        title: {
                            // display: true,
                        }
                    },
                    scales: {
                        x: {
                            display: false,
                            stacked: true,
                        },
                        y: {
                            display: false,
                            stacked: true,
                        }
                    },
                }
            });
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log('Error fetching user overview data: ' + textStatus);
        }
    });
}

// PRINT TOP DATA
getDashboardData();
function getDashboardData() {
    var url = $('#get-dashboard').val();
    $.ajax({
        type: "GET",
        url: url,
        dataType: "json",
        success: function (res) {
            $('#dashboard_app_user').text(res.app_user);
            $('#dashboard_subscription').text(res.subscription);
            $('#dashboard_free_user').text(res.free_subscribers);
            $('#dashboard_subscribers').text(res.subscribers);
            $('#dashboard_banner').text(res.banner);
            $('#dashboard_fags').text(res.faqs);
            $('#dashboard_suggestions').text(res.suggestions);
            $('#dashboard_credit').text(res.credit);
            $('#cost_credits').text(res.cost_credits);
            $('#dashboard_category').text(res.category);
        }
    });
}

// Function to convert month index to month name
function getMonthNameFromIndex(index) {
    var months = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];
    return months[index - 1];
}

$('.generates-statistics').on('change', function () {
    let year = $(this).val();
    getYearlyStatistics(year)
})

function getYearlyStatistics(year = new Date().getFullYear()) {
    var url = $('#yearly-generates-url').val();
    $.ajax({
        type: "GET",
        url: url += '?year=' + year,
        dataType: "json",
        success: function (res) {
            var texts = res.texts;
            var images = res.images;
            var total_texts = [];
            var total_images = [];

            for (var i = 0; i <= 11; i++) {
                var monthName = getMonthNameFromIndex(i); // Implement this function to get month name
                
                var textsData = texts.find(item => item.month === monthName);
                total_texts[i] = textsData ? textsData.total_items : 0;

                var imagesData = images.find(item => item.month === monthName);
                total_images[i] = imagesData ? imagesData.total_items : 0;
            }
            totalGeneratesChart(total_texts, total_images)
        },
    });
}

let statiSticsValu = false;

function totalGeneratesChart(total_texts, total_images) {
    if (statiSticsValu) {
        statiSticsValu.destroy();
    }

    var ctx = document.getElementById('monthly-statistics').getContext('2d');
    var gradient = ctx.createLinearGradient(0, 100, 10, 280);
    gradient.addColorStop(0, '#9039FF');
    gradient.addColorStop(1, 'rgba(50, 130, 241, 0)');

    var gradient2 = ctx.createLinearGradient(0, 0, 0, 290);
    gradient2.addColorStop(0, 'rgba(255, 68, 5, 1)');
    gradient2.addColorStop(1, 'rgba(255, 68, 5, 0)');


    statiSticsValu = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                    backgroundColor: gradient,
                    label: "Total Generated Texts: " + total_texts.reduce((prevVal, currentVal) => prevVal + currentVal, 0),
                    fill: true,
                    borderWidth: 1,
                    borderColor: "#9039FF",
                    data: total_texts,
                },
                {
                    backgroundColor: gradient2,
                    label: "Total Generated Images: " + total_images.reduce((prevVal, currentVal) => prevVal + currentVal, 0),
                    fill: true,
                    borderWidth: 1,
                    borderColor: "rgba(255, 68, 5, 1)",
                    data: total_images,
                }
            ]
        },

        options: {
            responsive: true,
            tension: 0.3,
            tooltips: {
                displayColors: true,
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 30
                    }
                },
                title: {
                    // display: true,
                }
            },
            scales: {
                x: {
                    display: true,
                },
                y: {
                    display: true,
                    beginAtZero: true
                }
            },
        },
    });
};

(function($) {
    "use strict";
    var ctx = document.getElementById('depositChart').getContext("2d")
    var depositChart = new Chart(ctx, {
        type: 'line',
        yaxisname: "Monthly Deposit",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Monthly Deposit",
                borderColor: "#17a2b8",
                pointBorderColor: "#17a2b8",
                pointBackgroundColor: "#17a2b8",
                pointHoverBackgroundColor: "#17a2b8",
                pointHoverBorderColor: "#D1D1D1",
                pointBorderWidth: 4,
                pointHoverRadius: 2,
                pointHoverBorderWidth: 1,
                pointRadius: 3,
                fill: false,
                borderWidth: 3,
                data: $('#monthly_deposit').data("dt")
            }]
        },
        options: {
            legend: {
                position: "bottom",
                display: true,
                labels: {
                    fontColor: '#928F8F'
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        fontColor: "#928F8F",
                        fontStyle: "bold",
                        beginAtZero: true,
                        padding: 20
                    },
                    gridLines: {
                        drawTicks: false,
                        display: false
                    }
                }],
                xAxes: [{
                    gridLines: {
                        zeroLineColor: "transparent",
                        drawTicks: false,
                        display: false
                    },
                    ticks: {
                        padding: 20,
                        fontColor: "#928F8F",
                        fontStyle: "bold"
                    }
                }]
            }
        }
    });
    var ctx = document.getElementById('withdrawalChart').getContext("2d");
    var withdrawalChart = new Chart(ctx, {
        type: 'line',
        yaxisname: "Monthly Withdrawal",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Monthly Withdrawal",
                borderColor: "#f691be",
                pointBorderColor: "#f691be",
                pointBackgroundColor: "#f691be",
                pointHoverBackgroundColor: "#f691be",
                pointHoverBorderColor: "#D1D1D1",
                pointBorderWidth: 4,
                pointHoverRadius: 2,
                pointHoverBorderWidth: 1,
                pointRadius: 3,
                fill: false,
                borderWidth: 3,
                data: $('#monthly_withdrawal').data("dt")
            }]
        },
        options: {
            legend: {
                position: "bottom",
                display: true,
                labels: {
                    fontColor: '#928F8F'
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        fontColor: "#928F8F",
                        fontStyle: "bold",
                        beginAtZero: false,
                    },
                    gridLines: {
                        drawTicks: false,
                        display: false
                    }
                }],
                xAxes: [{
                    gridLines: {
                        zeroLineColor: "transparent",
                        drawTicks: true,
                        display: false
                    },
                    ticks: {
                        fontColor: "#928F8F",
                        fontStyle: "bold",
                        autoSkip: false
                    }
                }]
            }
        }
    });
    $('#pending_withdrwall').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        responsive: false,
        ajax: $('#admin_pending_withdrawal').data("dt"),
        order: [7, 'desc'],
        autoWidth: false,
        language: {
            paginate: {
                next: 'Next &#8250;',
                previous: '&#8249; Previous'
            }
        },
        columns: [
            {"data": "address_type"},
            {"data": "sender"},
            {"data": "address"},
            {"data": "receiver"},
            {"data": "amount"},
            {"data": "fees"},
            {"data": "transaction_hash"},
            {"data": "updated_at"},
            {"data": "actions"}
        ]
    });
})(jQuery)

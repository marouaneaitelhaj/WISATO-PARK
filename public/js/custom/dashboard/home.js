(function ($) {
    "use strict";
    var parkingDatatableEl = null;

    $(document).ready(function () {
        $("#barcode").focus();
        Home.LoadParkingDatatable();
    });

    var Home = {
        LoadParkingDatatable: function () {
            parkingDatatableEl = $("#parkingDatatable").DataTable({
                dom: '<"row"<"col-12 col-sm-6"l><"col-12 col-sm-6"f>><"row"<"col-12 col-sm-12"t><"col-12 col-sm-6"i><"col-12 col-sm-6"p>>',
                lengthMenu: [
                    [5, 50, 100, 200, -1],
                    [5, 50, 100, 200, "All"],
                ],
                buttons: [],
                columns: [
                    {
                        title: "#SL",
                        data: "id",
                        class: "no-sort",
                        width: "50px",
                        render: function (data, row, type, col) {
                            var pageInfo = parkingDatatableEl.page.info();
                            return col.row + 1 + pageInfo.start;
                        },
                    },
                    {
                        title: "Barcode",
                        name: "barcode",
                        data: "barcode",
                        render: function (data, type, row) {
                            if (row.out_time == null) {
                                var barcodeURL = route("parking.barcode", {
                                    parking: row.id,
                                });
                                return (
                                    '<a href="' +
                                    barcodeURL +
                                    '" class="font-weight-bold text-info">' +
                                    data +
                                    "</a>"
                                );
                            } else {
                                return "<span>" + data + "</span>";
                            }
                        },
                    },
                    {
                        title: "Vehicle No",
                        name: "vehicle_no",
                        data: "vehicle_no",
                    },
                    {
                        title: "Slot",
                        class: "no-sort",
                        name: "slot.name",
                        data: "slot.name",
                        render: function (data, type, row) {
                            return typeof data != "undefined" ? data : "";
                        },
                    },
                    {
                        title: "Type",
                        name: "category",
                        data: "category",
                        render: function (data, type, row) {
                            return data.type;
                        },
                    },
                    { title: "In Time", name: "in_time", data: "in_time" },
                    { title: "Out Time", name: "out_time", data: "out_time" },
                    { title: "Amount", name: "amount", data: "amount" },
                ],

                ajax: {
                    url: route("parking.index"),
                    dataSrc: "data",
                },

                language: {
                    paginate: {
                        next: "&#8594;", // or '→'
                        previous: "&#8592;", // or '←'
                    },
                },
                columnDefs: [
                    {
                        searchable: false,
                        orderable: false,
                        targets: [0, 3, 4],
                    },
                ],
                responsive: true,
                autoWidth: false,
                serverSide: true,
                processing: true,
            });
        },
    };

    const stackedData = {
        labels: barChartLabel,
        datasets: [
            {
                barThickness: 32,
                label: "Available",
                backgroundColor: "#76e7bd",
                data: lineChartAvailableData,
            },
            {
                barThickness: 32,
                label: "Booked",
                backgroundColor: "#220fa6",
                data: lineChartBookedData,
            },
        ],
    };

    if ($("#barchart").length) {
        var barChartCanvas = $("#barchart").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var barChart = new Chart(barChartCanvas, {
            type: "bar",
            data: stackedData,
            options: {
                responsive: true,
                maintainAspectRatio: true,
                animation: {
                    easing: "easeInOutQuad",
                    duration: 520,
                },
                legend: false,
                scales: {
                    yAxes: [{ stacked: true }],
                    xAxes: [
                        {
                            stacked: true,
                            ticks: { maxRotation: 90, minRotation: 90 },
                        },
                    ],
                },
            },
        });
    }

    // gradient line chart
    if ($("#linechart").length) {
        var chart = document.getElementById("linechart").getContext("2d"),
            gradient = chart.createLinearGradient(0, 0, 0, 150);

        gradient.addColorStop(0, "rgba(0, 210, 132, 0.78)");
        gradient.addColorStop(0.5, "rgba(255, 255, 255, 0.2)");
        gradient.addColorStop(1, "rgba(255, 255, 255, 0.1)");

        var data = {
            labels: lineChartLabel,
            datasets: [
                {
                    backgroundColor: gradient,
                    pointBackgroundColor: "white",
                    borderWidth: 1,
                    borderColor: "#00d284",
                    data: lineChartData,
                },
            ],
        };

        var options = {
            responsive: true,
            maintainAspectRatio: true,
            animation: {
                easing: "easeInOutQuad",
                duration: 520,
            },
            scales: {
                xAxes: [
                    {
                        gridLines: {
                            color: "rgba(0, 210, 132, 0.41)",
                            lineWidth: 1,
                            drawBorder: false,
                        },
                    },
                ],
                yAxes: [
                    {
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            display: false,
                            beginAtZero: true,
                        },
                    },
                ],
            },
            elements: {
                line: {
                    tension: 0.4,
                },
            },
            legend: {
                display: false,
            },
            point: {
                backgroundColor: "white",
            },
        };

        var chartInstance = new Chart(chart, {
            type: "line",
            data: data,
            options: options,
        });
    }
})(jQuery);

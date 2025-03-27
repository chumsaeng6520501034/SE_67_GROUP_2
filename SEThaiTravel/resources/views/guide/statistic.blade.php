<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs"></script>
    <script src="https://cdn.tailwindcss.com"></script> 
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap">
    <title>Statistic</title>
    <style>
        body {
            background-image: url('https://codyduncan.com/blogimages/2012/12/cody-duncan-landscape-2012-01.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Sarabun', sans-serif;
        }
    
        html {
            height: 100%;
        }

        /* Make the main content area take full width and height */
        #mainContent {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        /* Sidebar and Toggle behavior */
        #sidebar,
        #mainContent {
            transition: all 0.3s ease-in-out;
        }

        #sidebar {
            z-index: 50;
        }

        #toggleSidebar {
            position: fixed;
            z-index: 100;
        }

        #sidebar {
            transform: translateX(-100%);
        }

        .sidebar-open #sidebar {
            transform: translateX(0);
        }

        .sidebar-open #mainContent {
            margin-left: 16rem;
            width: 80%;
        }

        .sidebar-open #chart {
            height: 80vh;
            /* Adjust height as needed */
        }
    </style>
</head>

<body>
    @include('components.sidebarGuide')
    <div class="flex h-screen">
        <main class="p-6" id="mainContent">
            <!-- Row for graphs -->
            <div class="flex justify-between space-x-2 w-full mt-12 text-white" id="chart ">
                <!-- Tourist per Month Graph -->
                <div class="bg-white/10 backdrop-blur-2xl p-6 rounded-lg shadow-lg w-full sm:w-6/12 lg:w-6/12 xl:w-6/12">
                    <div class="text-xl font-semibold text-center mb-4 ">Tourists / month</div>
                    <canvas id="touristPerMonthChart"></canvas>
                </div>

                <!-- Revenue per Month Graph -->
                <div class="bg-white/10 backdrop-blur-2xl p-6 rounded-lg shadow-lg w-full  sm:w-6/12 lg:w-6/12 xl:w-6/12">
                    <div class="text-xl font-semibold text-center mb-4">Revenue / month</div>
                    <canvas id="revenuePerMonthChart"></canvas>
                </div>
            </div>



            <!-- Data Display Boxes -->
            <div class="flex justify-between space-x-6 mt-auto mb-2 text-white">
                <div class="bg-white/10 backdrop-blur-2xl p-6 rounded-lg shadow-md w-[300px] text-center flex  flex-col justify-center item-center">
                    <div class="font-bold text-xl ">Tourists / month</div>
                    <div class="mt-4 text-lg">{{ $avgTourist[0]->avgTourist }}</div>
                </div>
                <div class="bg-white/10 backdrop-blur-2xl p-6 rounded-lg shadow-md w-[300px] text-center flex  flex-col justify-center item-center">
                    <div class="font-bold text-xl">Revenue / month</div>
                    <div class="mt-4">
                        @if (is_null($avgRevenue[0]->avgRevenue))
                            0
                        @else
                            {{ $avgRevenue[0]->avgRevenue }}
                        @endif

                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur-2xl p-6 rounded-lg shadow-md w-[300px] text-center flex  flex-col justify-center item-center">
                    <div class="font-bold text-xl">Tourists / year</div>
                    <div class="mt-4 text-lg">{{ $touristPerYear[0]->tourListPerYear }}</div>
                </div>
                <div class="bg-white/10 backdrop-blur-2xl p-6 rounded-lg shadow-md w-[300px] text-center flex flex-col justify-center item-center">
                    <div class="font-bold text-xl">Revenue / year</div>
                    <div class="mt-4 text-lg">
                        @if (is_null($revenuePerYear[0]->revenuePerYear))
                            0
                        @else
                            {{ $revenuePerYear[0]->revenuePerYear }}
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        var ctxTouristPerMonth = document.getElementById('touristPerMonthChart').getContext('2d');
        var ctxRevenuePerMonth = document.getElementById('revenuePerMonthChart').getContext('2d');

        var touristPerMonth = @json($touristPerMonth); // Replace with actual data
        var revenuePerMonth = @json($revenuePerMonth); // Replace with actual data
        if (touristPerMonth === null || touristPerMonth.length === 0) {
            touristPerMonth = [{
                YM: 'No Data',
                tourListPerMonth: 0
            }];
        }
        const chartData = touristPerMonth.map(item => ({
            x: item.YM,
            y: item.tourListPerMonth
        }));
        if (revenuePerMonth === null || revenuePerMonth.length === 0) {
            revenuePerMonth = [{
                YM: 'No Data',
                revenuePerMonth: 0
            }];
        }
        const chartRevenueData = revenuePerMonth.map(item => ({
            x: item.YM,
            y: item.revenuePerMonth
        }));
        var touristPerMonthChart = new Chart(ctxTouristPerMonth, {
            type: 'bar',
            data: {
                datasets: [{
                    label: 'Tourists per month',
                    data: chartData,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgb(138, 197, 236)',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                aspectRatio: 1.7,
                scales: {
                    x: {
                        ticks: {
                            color: '#ffffff' // เปลี่ยนสีข้อความแกน X เป็นสีขาว
                        }
                    },
                    y: {
                        ticks: {
                            color: '#ffffff' // เปลี่ยนสีข้อความแกน Y เป็นสีขาว
                        }
                    }
                }
            }
        });

        var revenuePerMonthChart = new Chart(ctxRevenuePerMonth, {
            type: 'bar',
            data: {
                datasets: [{
                    label: 'Revenue per month',
                    data: chartRevenueData,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgb(238, 156, 173)',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                aspectRatio: 1.7,
                scales: {
                    x: {
                        ticks: {
                            color: '#ffffff' // เปลี่ยนสีข้อความแกน X เป็นสีขาว
                        }
                    },
                    y: {
                        ticks: {
                            color: '#ffffff' // เปลี่ยนสีข้อความแกน Y เป็นสีขาว
                        }
                    }
                }
            }
        });

        // var revenuePerMonthChart = new Chart(ctxRevenuePerMonth, {
        //     type: 'bar',
        //     data: {
        //         datasets: [{
        //             label: 'Revenue per month',
        //             data: revenuePerMonthData.map(item => item.revenuePerMonth),
        //             borderColor: 'rgba(75, 192, 192, 1)',
        //             borderWidth: 1,
        //         }]
        //     },
        // });
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.body.classList.toggle('sidebar-open');

            // Force the chart to resize after the sidebar is toggled
            touristPerMonthChart.resize();
            revenuePerMonthChart.resize();
            // Update the chart to adjust for container size
            touristPerMonthChart.update();
            revenuePerMonthChart.update();
        });
    </script>
</body>

</html>

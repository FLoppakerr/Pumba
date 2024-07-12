let myChart;

        function updateChart() {
            const limit = document.getElementById('provinceCount').value;
            fetch(`fetch_data.php?limit=${limit}`)
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.province);
                    const counts = data.map(item => item.count);

                    if (myChart) {
                        myChart.destroy();
                    }

                    const ctx = document.getElementById('myChart').getContext('2d');
                    myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'จำนวนลูกค้า',
                                data: counts,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                                fill: false
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateChart();
        });
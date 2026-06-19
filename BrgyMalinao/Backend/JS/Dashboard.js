document.addEventListener('DOMContentLoaded', () => {
    // Function to render line chart
    function renderLineChart() {
        const ctx = document.getElementById('ageRangeChart').getContext('2d');

        // Data for the line chart
        const lineChartData = {
            labels: ['0-17', '18-29', '30-49', '50+'],
            datasets: [{
                label: 'Age Range Distribution',
                data: [
                    age_0_17,
                    age_18_29,
                    age_30_49,
                    age_50_plus
                ],
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        };

        // Options for the line chart
        const lineChartOptions = {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        // Render the line chart
        const lineChart = new Chart(ctx, {
            type: 'line',
            data: lineChartData,
            options: lineChartOptions
        });
    }

    // Call the renderLineChart function
    renderLineChart();
});

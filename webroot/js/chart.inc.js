console.log("chart");


window.onload = function(){
    
        /**
         * Proportion de femmes et d’hommes au total 
         * @type Chart (chart.js)
         * @param {integer} nbWomen -> Le nombre de femmes totale parmis les employés
         * @param {integer} nbMen  -> Le nombre d'homme total parmis les employés
         */
        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Femmes', 'Hommes'],
                datasets: [{
                    label: 'Proportion femmes/hommes',
                    data: [nbWomen, nbMen],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    
        /**
         * Courbe annuelle du nombre de femmes au total
         * @type Chart (chart.js)
         * @param {array} yearWomen -> Les années durant lesquelles des femmes ont été employées
         * @param {array} nbHireWomen -> Les nombres de femmes employées par année
         */
        new Chart(document.getElementById("myLineChart"),
        {"type":"line","data":{"labels":yearWomen,
                "datasets":[{"label":"Courbe annuelle du nombre de femmes au total",
                "data":nbHireWomen,
                "fill":false,
                "borderColor":"rgb(255, 99, 132, 0.9)",
                "lineTension":0.1}]},"options":{}});

        /**
         * Les 3 départements présentant le plus de femmes
         * @type Chart (chart.js)
         * 
         */
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });

        /**
         * Les 3 départements présentant le moins de femmes
         * @type Chart (chart.js)
         * 
         */
        var myBarChart2 = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
        });
        
        /**
         * Proportion de femmes et d’hommes manager
         * @type Chart (chart.js)
         * 
         */
        var myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: options
        });
};

    
    







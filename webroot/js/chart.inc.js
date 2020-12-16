/**
 * @class Graphiques de la page "Women at work" du projet "Employees" réalisé dans le cadre du cours de Framework à l'EPFC
 * @author Grégory Van Ossel, Myriam Kadi, Simon Oldenhove
 * @version 1.0
 * 
 */

window.onload = function(){
    
    /**
     * Proportion de femmes et d’hommes au total 
     * @type Chart (chart.js)
     * @param {integer} nbWomen -> Le nombre de femmes totale parmis les employés
     * @param {integer} nbMen  -> Le nombre d'homme total parmis les employés
     */
    let ctx = document.getElementById('myChart');
    let myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Femmes employées', 'Hommes employés'],
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
            "lineTension":0.1}]},"options":{legend:{display: false}}});

    /**
     * Proportion de femmes et d’hommes manager
     * @type Chart (chart.js)
     * @param {integer} nbWomenManager -> Le nombre de femmes manager
     * @param {integer} nbMenManager  -> Le nombre d'hommes manager
     */
    let ctx2 = document.getElementById('myDoughnutChart');
    let myDoughnutChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Femmes manager', 'Hommes manager'],
            datasets: [{
                label: 'Proportion femmes/hommes manager',
                data: [nbWomenManager, nbMenManager],
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
     * Les 3 départements présentant le plus de femmes
     * @type Chart (chart.js)
     * @param {array} depNameMoreWomen -> Tableau des 3 noms des départements contenant le plus de femmes
     * @param {array} nbDepMoreWomen  -> Tableau des nombres des 3 départements contenant le plus de femmes
     */
    new Chart(document.getElementById("myBarChart"),
    {"type":"bar","data":{"labels":depNameMoreWomen,
            "datasets":[{"label":false,
                    "data":nbDepMoreWomen,"fill":false,
                    "backgroundColor":["rgba(255, 99, 132, 0.4)","rgba(255, 99, 132, 0.3)","rgba(255, 99, 132, 0.2)"],
                    "borderColor":["rgb(255, 99, 132)","rgb(255, 99, 132)","rgb(255, 99, 132)"],
                    "borderWidth":1}]},"options":{"scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]},legend:{display: false}}});

    /**
     * Les 3 départements présentant le moins de femmes
     * @type Chart (chart.js)
     * @param {integer} depNameLessWomen -> Tableau des 3 noms des départements contenant le moins de femmes
     * @param {integer} nbDepLessWomen  -> Tableau des nombres des 3 départements contenant le moins de femmes
     */
    new Chart(document.getElementById("myBarChart2"),
    {"type":"bar","data":{"labels":depNameLessWomen,
            "datasets":[{
                    "data":nbDepLessWomen,"fill":false,
                    "backgroundColor":["rgba(255, 99, 132, 0.2)","rgba(255, 99, 132, 0.3)","rgba(255, 99, 132, 0.4)"],
                    "borderColor":["rgb(255, 99, 132)","rgb(255, 99, 132)","rgb(255, 99, 132)"],
                    "borderWidth":1}]},"options":{"scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]},legend:{display: false}}});
};
<template>
    <div>
        <h3>Number of items learned this month</h3>
        <div>
            <canvas id="chart" width="400" height="300"></canvas>
        </div>

    </div>
</template>

<script>
    export default {
        name: "VocabSizePerDayGraph",
        props: {
            dataEndpoint: {
                type: String,
                required: true
            }
        },
        data: function(){
            return {
                graphData: {}
            }
        },
        methods: {
            fetchData: function(){
                let self = this;
                axios.get(this.dataEndpoint)
                    .then(function(response){
                        self.graphData = response.data;
                        self.buildGraph()
                    })
                    .catch(function (error) {
                        toastr.error('Error while retrieving vocab size data for graph.');
                    })
            },
            buildGraph(){
                let canvasCtx = document.getElementById('chart').getContext('2d');

                let chart = new Chart(canvasCtx, {
                    type: 'line',
                    data: {
                        labels: Object.keys(this.graphData),
                        datasets: [{
                            label: "Items learned",
                            data: Object.values(this.graphData),
                            borderColor: 'rgba(50, 82, 89, 1)',
                            backgroundColor: 'rgba(153,208,242,0.27)',
                            hoverBackgroundColor: 'rgba(153,208,242,0.40)',
                            borderWidth: 3,
                            pointBorderWidth: 4,
                            pointHoverBorderWidth: 10,
                            borderJoinStyle: 'round',
                            lineTension: 0.1,
                            yAxisID: 'y-axis'
                        }],
                    },
                    options: {
                        legend: {
                            display: false
                        },
                        scales: {
                            yAxes: [
                                {
                                    id: 'y-axis',
                                    type: 'linear',
                                    ticks: {
                                        min: 0,
                                        stepSize: 2
                                    }
                                }
                            ]
                        }
                    }
                })
            }
        },
        mounted() {
            this.fetchData()
        }
    }
</script>

<style scoped>

</style>

<template>
    <div>
        <h3>Number of level up per day this month</h3>
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
                            label: "asdf",
                            data: Object.values(this.graphData),
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }],

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

<script>
import { Line, mixins } from 'vue-chartjs'
const { reactiveProp } = mixins

export default {
    extends: Line,
    mixins: [reactiveProp],
    props: ['options'],
    mounted () {
        if(this.chartData == undefined) {
            this.renderChart({
                labels: ["4 days ago", "3 days ago",  "2 days ago",  "1 days ago", "4 hours ago", "2 hours ago", "1 hour ago"],
                datasets: [
                    {
                        label: 'Humidity',
                        backgroundColor: 'RGB(255, 255, 255, 255)',
                        borderColor: 'RGBA(32, 156, 238, .6)',
                        data: [100, 98, 96, 45, 23, 12, 3, 0]
                    }
                ]
            }, {
                legend: {
                    display: false
                },
                elements: {
                    point: {
                        radius: 0
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display:false
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display:false
                        }
                    }]
                }
            })
        } else {
            this.renderChart(this.chartData, this.options)
        }
    }
}
</script>

<style>
</style>

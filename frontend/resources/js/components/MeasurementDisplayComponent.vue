<template>
    <div class="column is-one-third">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    {{sensor.name + " "}}
                    <span :class="isBelowAlarmThreshold ? 'tag is-danger' : 'tag'">{{ isBelowAlarmThreshold ? 'low moisture!' : 'everything is ok' }}</span>
                </p>
            </header>

            <div class="card-content">
                <div class="content">
                    <p class="subtitle is-4">{{lastMeasurement}}</p>

                    <humidity-line-chart :chartData="chartdata" :options="options"></humidity-line-chart>
                    <br>
                    Last update: {{lastUpdate}}
                    <br>
                </div>
            </div>

            <footer class="card-footer">
                <a class="card-footer-item" href="#">Settings</a>
                <a class="card-footer-item" href="#">Details</a>
                <a class="card-footer-item" href="#">Measure Now</a>
            </footer>

        </div>
    </div>
</template>

<script>
    function generateTimeAgoString(pastDate) {
        function calculateHoursAgo(pastDate) {
            let millisecondsPerHour = 1000 * 60 * 60;
            let millisecondsAgo = new Date() - new Date(pastDate);
            let hoursAgo = millisecondsAgo / millisecondsPerHour;
            return hoursAgo;
        }

        let hours = calculateHoursAgo(pastDate);
        let days = hours / 24;

        if (days > 4) {
            return Math.round(days) + " days ago";
        }
        return Math.round(hours) + " hours ago";
    }

    function lastMeasurement(measurements) {
        return measurements.slice(-1)[0];
    }

    function generateLastUpdateString(measurements) {
        let last = lastMeasurement(measurements);
        return (last === undefined) ? "never" : generateTimeAgoString(last.created_at)
    }

    export default {
        props: ['sensor'],
        data() {
            return {
                chartdata: {
                    labels: undefined, //replaced when mounted() ist called
                    datasets: undefined
                },
                options: {
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
                                display: false
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                display: false
                            }
                        }]
                    }
                },
                data: true
            };
        },
        computed: {
            lastUpdate: function () {
                return generateLastUpdateString(this.sensor.measurements);
            },
            isBelowAlarmThreshold: function () {
                let last = lastMeasurement(this.sensor.measurements);
                if (last === undefined) {
                    return false;
                }
                return this.sensor.alarm_threshold > last.value;
            },
            lastMeasurement: function () {
                let last = lastMeasurement(this.sensor.measurements);
                return "Moisture: " + ((last === undefined) ? "?" : last.value);
            },

            chartData: function() {
                return this.chartdata.datasets.data = this.sensor.measurements.map(m => m.value);
            }
        }, mounted() {
            this.chartdata = {
                labels: this.sensor.measurements.map(m => generateTimeAgoString(m.created_at)),
                datasets: [
                    {
                        label: 'Moisture',
                        backgroundColor: 'RGB(255, 255, 255, 255)',
                        borderColor: 'RGBA(32, 156, 238, .6)',
                        data: this.sensor.measurements.map(m => m.value)
                    }
                ]
            }
        }
    }
</script>

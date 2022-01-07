@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div style="margin: 1rem 2rem;">
                    <h2>โควิด - 19 <h5 id="date"></h5>
                        <h5 id="dateUpdate"></h5>
                    </h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col p-2 ">
                            <div class="card newcase bg-danger p-3 text-white">
                                <div class="card-body text-center">
                                    <span id="newcase"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col p-2">
                            <div class="card total_case bg-danger p-3 text-white">
                                <div class="card-body text-center">
                                    <span id="total_case"></span>
                                </div>
                            </div>
                        </div>
                        <div style="margin-bottom: 3rem;">
                            <canvas id="newCaseChart" style="max-width: 850px;padding:1rem;"></canvas>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col p-2">
                            <div class="card recover bg-success p-3 text-white">
                                <div class="card-body text-center">
                                    <span id="recover"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col p-2">
                            <div class="card total_recover bg-success p-3 text-white">
                                <div class="card-body text-center">
                                    <span id="total_recover"></span>
                                </div>
                            </div>
                        </div>
                        <div style="margin-bottom: 3rem;">
                            <canvas id="recoverChart" style="max-width: 850px;padding:1rem;"></canvas>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col p-2">
                            <div class="card death bg-dark p-3 text-white">
                                <div class="card-body text-center">
                                    <span id="death"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col p-2">
                            <div class="card total_death bg-dark p-3 text-white">
                                <div class="card-body text-center">
                                    <span id="total_death"></span>
                                </div>
                            </div>
                        </div>
                        <div style="margin-bottom: 3rem;">
                            <canvas id="deathChart" style="max-width: 850px;padding:1rem;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('localScript')
<script type="text/javascript" src="{{ asset('js/chartjs/chart.js') }}"></script>
<script type="text/javascript">
    var arrayDate = []
    var arrayAmount = []
    var arrayAllAmount = []
    var arrayRecover = []
    var arrayAllRecover = []
    var arrayDeath = []
    var arrayAllDeath = []
    newcaseChart()
    async function newcaseChart() {
        try {
            var res = await fetch('https://covid19.ddc.moph.go.th/api/Cases/timeline-cases-all')
            var data = await res.json()

            for (var i = 0; i < data.length; i++) {
                arrayDate.push(data[i].txn_date)
                arrayAmount.push(data[i].new_case)
            }

            var ctx = document.getElementById("newCaseChart").getContext("2d");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: arrayDate.slice(-31),
                    datasets: [{
                        label: 'จำนวนวันนี้ ',
                        data: arrayAmount.slice(-31),
                        backgroundColor: [
                            'rgb(255, 47, 61)',
                        ],
                        borderColor: [
                            'rgb(255, 47, 61)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    elements: {
                        center: {
                            text: 'test'
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: 'rgb(255, 99, 132)',
                                font: {
                                    family: "'Noto Sans Thai', sans-serif"
                                }
                            },
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        },


                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        } catch (error) {
            console.log(error);
        }
    }
    totalnewcaseChart()
    async function totalnewcaseChart() {
        try {
            var res = await fetch('https://covid19.ddc.moph.go.th/api/Cases/timeline-cases-all')
            var data = await res.json()

            for (var i = 0; i < data.length; i++) {
                arrayDate.push(data[i].txn_date)
                arrayAllAmount.push(data[i].total_case)
            }

            var ctx = document.getElementById("newCaseChartTotal").getContext("2d");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: arrayDate.slice(-31),
                    datasets: [{
                        label: 'จำนวนสะสม ',
                        data: arrayAllAmount.slice(-31),
                        backgroundColor: [
                            'rgb(153, 0, 0)',
                        ],
                        borderColor: [
                            'rgb(153, 0, 0)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    elements: {
                        center: {
                            text: 'test'
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: 'rgb(255, 99, 132)',
                                font: {
                                    family: "'Noto Sans Thai', sans-serif"
                                }
                            },
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        },


                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        } catch (error) {
            console.log(error);
        }
    }
    recoveredChart()
    async function recoveredChart() {
        try {
            var res = await fetch('https://covid19.ddc.moph.go.th/api/Cases/timeline-cases-all')
            var data = await res.json()

            for (var i = 0; i < data.length; i++) {
                arrayDate.push(data[i].txn_date)
                arrayRecover.push(data[i].new_recovered)
            }

            var ctx = document.getElementById("recoverChart").getContext("2d");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: arrayDate.slice(-31),
                    datasets: [{
                        label: 'จำนวนวันนี้ ',
                        data: arrayRecover.slice(-31),
                        backgroundColor: [
                            'rgb(0, 255, 111)'
                        ],
                        borderColor: [
                            'rgb(0, 255, 111)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    elements: {
                        center: {
                            text: 'test'
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: 'rgb(0, 255, 111)',
                                font: {
                                    family: "'Noto Sans Thai', sans-serif"
                                }
                            },
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        },


                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        } catch (error) {
            console.log(error);
        }
    }
    totalrecoveredChart()
    async function totalrecoveredChart() {
        try {
            var res = await fetch('https://covid19.ddc.moph.go.th/api/Cases/timeline-cases-all')
            var data = await res.json()

            for (var i = 0; i < data.length; i++) {
                arrayDate.push(data[i].txn_date)
                arrayAllRecover.push(data[i].total_recovered)
            }

            var ctx = document.getElementById("recoverChartTotal").getContext("2d");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: arrayDate.slice(-31),
                    datasets: [{
                        label: 'จำนวนสะสม ',
                        data: arrayAllRecover.slice(-31),
                        backgroundColor: [
                            'rgb(0, 204, 102)'
                        ],
                        borderColor: [
                            'rgb(0, 204, 102)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    elements: {
                        center: {
                            text: 'test'
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: 'rgb(0, 255, 111)',
                                font: {
                                    family: "'Noto Sans Thai', sans-serif"
                                }
                            },
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        },


                    }
                },
                responsive: true,
                maintainAspectRatio: false
            });
        } catch (error) {
            console.log(error);
        }
    }
    deathChart()
    async function deathChart() {
        try {
            var res = await fetch('https://covid19.ddc.moph.go.th/api/Cases/timeline-cases-all')
            var data = await res.json()

            for (var i = 0; i < data.length; i++) {
                arrayDate.push(data[i].txn_date)
                arrayDeath.push(data[i].new_death)
            }

            var ctx = document.getElementById("deathChart").getContext("2d");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: arrayDate.slice(-31),
                    datasets: [{
                        label: 'จำนวนวันนี้ ',
                        data: arrayDeath.slice(-31),
                        backgroundColor: [
                            'rgb(128, 128, 128)'
                        ],
                        borderColor: [
                            'rgb(128, 128, 128)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    elements: {
                        center: {
                            text: 'test'
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: 'rgb(128, 128, 128)',
                                font: {
                                    family: "'Noto Sans Thai', sans-serif"
                                }
                            },
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        },


                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        } catch (error) {
            console.log(error);
        }
    }
    totaldeathChart()
    async function totaldeathChart() {
        try {
            var res = await fetch('https://covid19.ddc.moph.go.th/api/Cases/timeline-cases-all')
            var data = await res.json()

            for (var i = 0; i < data.length; i++) {
                arrayDate.push(data[i].txn_date)
                arrayAllDeath.push(data[i].total_death)
            }

            var ctx = document.getElementById("deathChartTotal").getContext("2d");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: arrayDate.slice(-31),
                    datasets: [{
                        label: 'จำนวนสะสม ',
                        data: arrayAllDeath.slice(-31),
                        backgroundColor: [
                            'rgb(64, 64, 64)'
                        ],
                        borderColor: [
                            'rgb(64, 64, 64)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    elements: {
                        center: {
                            text: 'test'
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: 'rgb(128, 128, 128)',
                                font: {
                                    family: "'Noto Sans Thai', sans-serif"
                                }
                            },
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        },


                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        } catch (error) {
            console.log(error);
        }
    }
    getData()
    async function getData() {
        try {
            // var res = await fetch('https://covid19.ddc.moph.go.th/api/Cases/timeline-cases-by-provinces')
            var res = await fetch('https://covid19.ddc.moph.go.th/api/Cases/timeline-cases-all')
            var data = await res.json()
            document.getElementById('newcase').innerHTML = 'ผู้ป่วยรายใหม่ : ' + data.at(-1).new_case
            document.getElementById('total_case').innerHTML = 'ผู้ป่วยทั้งหมด : ' + data.at(-1).total_case
            document.getElementById('recover').innerHTML = 'หายกลับบ้าน : ' + data.at(-1).new_recovered
            document.getElementById('total_recover').innerHTML = 'หายกลับบ้านทั้งหมด : ' + data.at(-1).total_recovered
            document.getElementById('death').innerHTML = 'เสียชีวิต : ' + data.at(-1).new_death
            document.getElementById('total_death').innerHTML = 'เสียชีวิตทั้งหมด : ' + data.at(-1).total_death
            document.getElementById('dateUpdate').innerHTML = ' ข้อมูลล่าสุดวันที่ :  ' + data.at(-1).txn_date
            document.getElementById('date').innerHTML = 'ข้อมูลตั้งแต่วันที่ : ' + data.at(0).txn_date + ' - ' + data.at(-1).txn_date
        } catch (error) {
            console.log(error);
        }
    }
</script>

@endsection
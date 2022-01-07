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
    getData()
    async function getData() {
        var arrayDate = []
        var arrayAmount = []
        var arrayAllAmount = []
        var arrayRecover = []
        var arrayAllRecover = []
        var arrayDeath = []
        var arrayAllDeath = []
        try {
            // var res = await fetch('https://covid19.ddc.moph.go.th/api/Cases/timeline-cases-by-provinces')
            var res = await fetch('https://covid19.ddc.moph.go.th/api/Cases/timeline-cases-all')
            var data = await res.json()
            // console.log(data);

            // console.log(data.at(-1));
            if (data.length != 0) {
                document.getElementById('newcase').innerHTML = 'ผู้ป่วยรายใหม่ : ' + data.at(-1).new_case
                document.getElementById('total_case').innerHTML = 'ผู้ป่วยทั้งหมด : ' + data.at(-1).total_case
                document.getElementById('recover').innerHTML = 'หายกลับบ้าน : ' + data.at(-1).new_recovered
                document.getElementById('total_recover').innerHTML = 'หายกลับบ้านทั้งหมด : ' + data.at(-1).total_recovered
                document.getElementById('death').innerHTML = 'เสียชีวิต : ' + data.at(-1).new_death
                document.getElementById('total_death').innerHTML = 'เสียชีวิตทั้งหมด : ' + data.at(-1).total_death
                document.getElementById('dateUpdate').innerHTML = ' ข้อมูลล่าสุดวันที่ :  ' + data.at(-1).txn_date
                document.getElementById('date').innerHTML = 'ข้อมูลตั้งแต่วันที่ : ' + data.at(0).txn_date + ' - ' + data.at(-1).txn_date
            } else {
                console.log(data.at(-1));
                document.getElementById('newcase').innerHTML = 'ไม่สามารถแสดงข้อมูลได้ กรุณา Refresh '
                document.getElementById('total_case').innerHTML = 'ไม่สามารถแสดงข้อมูลได้ กรุณา Refresh '
                document.getElementById('recover').innerHTML = 'ไม่สามารถแสดงข้อมูลได้ กรุณา Refresh '
                document.getElementById('total_recover').innerHTML = 'ไม่สามารถแสดงข้อมูลได้ กรุณา Refresh '
                document.getElementById('death').innerHTML = 'ไม่สามารถแสดงข้อมูลได้ กรุณา Refresh '
                document.getElementById('total_death').innerHTML = 'ไม่สามารถแสดงข้อมูลได้ กรุณา Refresh '
                document.getElementById('dateUpdate').innerHTML = 'ไม่สามารถแสดงข้อมูลได้ กรุณา Refresh '
            }
            //chart
            for (var i = 0; i < data.length; i++) {
                arrayDate.push(data[i].txn_date)
                arrayAmount.push(data[i].new_case)
                arrayAllAmount.push(data[i].total_case)
                arrayRecover.push(data[i].new_recovered)
                arrayAllRecover.push(data[i].total_recovered)
                arrayDeath.push(data[i].new_death)
                arrayAllDeath.push(data[i].total_death)
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
                        },
                        {
                            label: 'จำนวนสะสม ',
                            data: arrayAllAmount.slice(-31),
                            backgroundColor: [
                                'rgb(153, 0, 0)',
                            ],
                            borderColor: [
                                'rgb(153, 0, 0)',
                            ],
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    elements: {
                        center: {
                            text: 'test',
                            // color: '#FF6384', // Default is #000000
                            // fontStyle: 'Arial', // Default is Arial
                            // sidePadding: 20, // Default is 20 (as a percentage)
                            // minFontSize: 20, // Default is 20 (in px), set to false and text will not wrap.
                            // lineHeight: 25 // Default is 25 (in px), used for when text wraps
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
                            position: 'right'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true
                            }
                        },
                        x: {
                            grid: {
                                display: true
                            }
                        },


                    }
                }
            });
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
                        },
                        {
                            label: 'จำนวนสะสม ',
                            data: arrayAllRecover.slice(-31),
                            backgroundColor: [
                                'rgb(0, 204, 102)'
                            ],
                            borderColor: [
                                'rgb(0, 204, 102)'
                            ],
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    elements: {
                        center: {
                            text: 'test',
                            // color: '#FF6384', // Default is #000000
                            // fontStyle: 'Arial', // Default is Arial
                            // sidePadding: 20, // Default is 20 (as a percentage)
                            // minFontSize: 20, // Default is 20 (in px), set to false and text will not wrap.
                            // lineHeight: 25 // Default is 25 (in px), used for when text wraps
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
                            position: 'right'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true
                            }
                        },
                        x: {
                            grid: {
                                display: true
                            }
                        },


                    }
                }
            });
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
                        },
                        {
                            label: 'จำนวนสะสม ',
                            data: arrayAllDeath.slice(-31),
                            backgroundColor: [
                                'rgb(64, 64, 64)'
                            ],
                            borderColor: [
                                'rgb(64, 64, 64)'
                            ],
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    elements: {
                        center: {
                            text: 'test',
                            // color: '#FF6384', // Default is #000000
                            // fontStyle: 'Arial', // Default is Arial
                            // sidePadding: 20, // Default is 20 (as a percentage)
                            // minFontSize: 20, // Default is 20 (in px), set to false and text will not wrap.
                            // lineHeight: 25 // Default is 25 (in px), used for when text wraps
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
                            position: 'right'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true
                            }
                        },
                        x: {
                            grid: {
                                display: true
                            }
                        },


                    }
                }
            });
        } catch (error) {
            console.log(error);
        }
    }
</script>

@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div style="border-bottom: 1px solid gray;">
        <h3>
            ภาพรวมทั้งหมด
        </h3>
        <br>
        <canvas id="AllChart" style="margin: 1rem auto;position: relative;height:20vh;width:40vw;"></canvas>
    </div>

    <h4 class="p-3">ข้อมูลย้อนหลัง 30 วัน</h4>
    <div class="row">
        <div class="col">
            <h5 class="p-3">ผู้ป่วยรายใหม่</h5>
        </div>
        <div class="col">
            <h5 class="p-3">หายกลับบ้าน</h5>
        </div>
        <div class="col">
            <h5 class="p-3">เสียชีวิต</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <canvas id="newCaseChart" style="max-width: auto;position:relative;"></canvas>
        </div>
        <div class="col-4">

            <canvas id="recoverChart" style="max-width: auto;position:relative;"></canvas>
        </div>
        <div class="col-4">

            <canvas id="deathChart" style="max-width: auto;position:relative;"></canvas>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <canvas id="newCaseChartTotal" style="max-width: auto;position:relative;"></canvas>
        </div>
        <div class="col-4">
            <canvas id="recoverChartTotal" style="max-width: auto;position:relative;"></canvas>
        </div>
        <div class="col-4">
            <canvas id="deathChartTotal" style="max-width: auto;position:relative;"></canvas>
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
    // getData()
    totalChart()
    async function totalChart() {
        try {
            var res = await fetch('https://covid19.ddc.moph.go.th/api/Cases/timeline-cases-all')
            var data = await res.json()

            var ctx = document.getElementById("AllChart").getContext("2d");
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['ผู้ป่วยรายใหม่', 'หายกลับบ้าน', 'เสียชีวิต'],
                    datasets: [{
                        label: 'ภาพรวม ',
                        data: [data.at(-1).total_case, data.at(-1).total_recovered, data.at(-1).total_death],
                        backgroundColor: [
                            'rgb(255, 47, 61)',
                            'rgb(0, 255, 111)',
                            'rgb(128, 128, 128)'
                        ],
                        borderColor: [
                            'rgb(255, 47, 61)',
                            'rgb(0, 255, 111)',
                            'rgb(128, 128, 128)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    elements: {
                        center: {
                            text: 'test',
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: [
                                    'rgb(255, 99, 132)',
                                    'rgb(0, 255, 111)',
                                    'rgb(128, 128, 128)'
                                ],
                                font: {
                                    family: "'Noto Sans Thai', sans-serif"
                                }
                            },
                            position: 'right'
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: true
                }
            });
        } catch (error) {
            console.log(error);
        }
    }
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
    // async function getData() {

    //     try {
    //         // var res = await fetch('https://covid19.ddc.moph.go.th/api/Cases/timeline-cases-by-provinces')
    //         var res = await fetch('https://covid19.ddc.moph.go.th/api/Cases/timeline-cases-all')
    //         var data = await res.json()
    //         //chart
    //         for (var i = 0; i < data.length; i++) {
    //             arrayDate.push(data[i].txn_date)
    //             arrayAmount.push(data[i].new_case)
    //             arrayAllAmount.push(data[i].total_case)
    //             arrayRecover.push(data[i].new_recovered)
    //             arrayAllRecover.push(data[i].total_recovered)
    //             arrayDeath.push(data[i].new_death)
    //             arrayAllDeath.push(data[i].total_death)
    //         }
    //         var ctx = document.getElementById("AllChart").getContext("2d");
    //         var myChart = new Chart(ctx, {
    //             type: 'doughnut',
    //             data: {
    //                 labels: ['ผู้ป่วยรายใหม่', 'หายกลับบ้าน', 'เสียชีวิต'],
    //                 datasets: [{
    //                     label: 'ภาพรวม ',
    //                     data: [data.at(-1).total_case, data.at(-1).total_recovered, data.at(-1).total_death],
    //                     backgroundColor: [
    //                         'rgb(255, 47, 61)',
    //                         'rgb(0, 255, 111)',
    //                         'rgb(128, 128, 128)'
    //                     ],
    //                     borderColor: [
    //                         'rgb(255, 47, 61)',
    //                         'rgb(0, 255, 111)',
    //                         'rgb(128, 128, 128)'
    //                     ],
    //                     borderWidth: 1
    //                 }]
    //             },
    //             options: {
    //                 elements: {
    //                     center: {
    //                         text: 'test',
    //                         // color: '#FF6384', // Default is #000000
    //                         // fontStyle: 'Arial', // Default is Arial
    //                         // sidePadding: 20, // Default is 20 (as a percentage)
    //                         // minFontSize: 20, // Default is 20 (in px), set to false and text will not wrap.
    //                         // lineHeight: 25 // Default is 25 (in px), used for when text wraps
    //                     }
    //                 },
    //                 plugins: {
    //                     legend: {
    //                         display: true,
    //                         labels: {
    //                             color: [
    //                                 'rgb(255, 99, 132)',
    //                                 'rgb(0, 255, 111)',
    //                                 'rgb(128, 128, 128)'
    //                             ],
    //                             font: {
    //                                 family: "'Noto Sans Thai', sans-serif"
    //                             }
    //                         },
    //                         position: 'right'
    //                     }
    //                 },
    //                 responsive: true,
    //                 maintainAspectRatio: true
    //             }
    //         });
    //         var ctx = document.getElementById("newCaseChart").getContext("2d");
    //         var myChart = new Chart(ctx, {
    //             type: 'line',
    //             data: {
    //                 labels: arrayDate.slice(-31),
    //                 datasets: [{
    //                     label: 'จำนวนวันนี้ ',
    //                     data: arrayAmount.slice(-31),
    //                     backgroundColor: [
    //                         'rgb(255, 47, 61)',
    //                     ],
    //                     borderColor: [
    //                         'rgb(255, 47, 61)',
    //                     ],
    //                     borderWidth: 1
    //                 }]
    //             },
    //             options: {
    //                 elements: {
    //                     center: {
    //                         text: 'test',
    //                         // color: '#FF6384', // Default is #000000
    //                         // fontStyle: 'Arial', // Default is Arial
    //                         // sidePadding: 20, // Default is 20 (as a percentage)
    //                         // minFontSize: 20, // Default is 20 (in px), set to false and text will not wrap.
    //                         // lineHeight: 25 // Default is 25 (in px), used for when text wraps
    //                     }
    //                 },
    //                 plugins: {
    //                     legend: {
    //                         display: true,
    //                         labels: {
    //                             color: 'rgb(255, 99, 132)',
    //                             font: {
    //                                 family: "'Noto Sans Thai', sans-serif"
    //                             }
    //                         },
    //                         position: 'top'
    //                     }
    //                 },
    //                 scales: {
    //                     y: {
    //                         beginAtZero: true,
    //                         grid: {
    //                             display: false
    //                         }
    //                     },
    //                     x: {
    //                         grid: {
    //                             display: false
    //                         }
    //                     },


    //                 },
    //                 responsive: true,
    //                 maintainAspectRatio: false
    //             }
    //         });
    //         var ctx = document.getElementById("recoverChart").getContext("2d");
    //         var myChart = new Chart(ctx, {
    //             type: 'line',
    //             data: {
    //                 labels: arrayDate.slice(-31),
    //                 datasets: [{
    //                     label: 'จำนวนวันนี้ ',
    //                     data: arrayRecover.slice(-31),
    //                     backgroundColor: [
    //                         'rgb(0, 255, 111)'
    //                     ],
    //                     borderColor: [
    //                         'rgb(0, 255, 111)'
    //                     ],
    //                     borderWidth: 1
    //                 }]
    //             },
    //             options: {
    //                 elements: {
    //                     center: {
    //                         text: 'test',
    //                         // color: '#FF6384', // Default is #000000
    //                         // fontStyle: 'Arial', // Default is Arial
    //                         // sidePadding: 20, // Default is 20 (as a percentage)
    //                         // minFontSize: 20, // Default is 20 (in px), set to false and text will not wrap.
    //                         // lineHeight: 25 // Default is 25 (in px), used for when text wraps
    //                     }
    //                 },
    //                 plugins: {
    //                     legend: {
    //                         display: true,
    //                         labels: {
    //                             color: 'rgb(0, 255, 111)',
    //                             font: {
    //                                 family: "'Noto Sans Thai', sans-serif"
    //                             }
    //                         },
    //                         position: 'top'
    //                     }
    //                 },
    //                 scales: {
    //                     y: {
    //                         beginAtZero: true,
    //                         grid: {
    //                             display: false
    //                         }
    //                     },
    //                     x: {
    //                         grid: {
    //                             display: false
    //                         }
    //                     },


    //                 },
    //                 responsive: true,
    //                 maintainAspectRatio: false
    //             }
    //         });
    //         var ctx = document.getElementById("deathChart").getContext("2d");
    //         var myChart = new Chart(ctx, {
    //             type: 'line',
    //             data: {
    //                 labels: arrayDate.slice(-31),
    //                 datasets: [{
    //                     label: 'จำนวนวันนี้ ',
    //                     data: arrayDeath.slice(-31),
    //                     backgroundColor: [
    //                         'rgb(128, 128, 128)'
    //                     ],
    //                     borderColor: [
    //                         'rgb(128, 128, 128)'
    //                     ],
    //                     borderWidth: 1
    //                 }]
    //             },
    //             options: {
    //                 elements: {
    //                     center: {
    //                         text: 'test',
    //                         // color: '#FF6384', // Default is #000000
    //                         // fontStyle: 'Arial', // Default is Arial
    //                         // sidePadding: 20, // Default is 20 (as a percentage)
    //                         // minFontSize: 20, // Default is 20 (in px), set to false and text will not wrap.
    //                         // lineHeight: 25 // Default is 25 (in px), used for when text wraps
    //                     }
    //                 },
    //                 plugins: {
    //                     legend: {
    //                         display: true,
    //                         labels: {
    //                             color: 'rgb(128, 128, 128)',
    //                             font: {
    //                                 family: "'Noto Sans Thai', sans-serif"
    //                             }
    //                         },
    //                         position: 'top'
    //                     }
    //                 },
    //                 scales: {
    //                     y: {
    //                         beginAtZero: true,
    //                         grid: {
    //                             display: false
    //                         }
    //                     },
    //                     x: {
    //                         grid: {
    //                             display: false
    //                         }
    //                     },


    //                 },
    //                 responsive: true,
    //                 maintainAspectRatio: false
    //             }
    //         });
    //         var ctx = document.getElementById("newCaseChartTotal").getContext("2d");
    //         var myChart = new Chart(ctx, {
    //             type: 'line',
    //             data: {
    //                 labels: arrayDate.slice(-31),
    //                 datasets: [{
    //                     label: 'จำนวนสะสม ',
    //                     data: arrayAllAmount.slice(-31),
    //                     backgroundColor: [
    //                         'rgb(153, 0, 0)',
    //                     ],
    //                     borderColor: [
    //                         'rgb(153, 0, 0)',
    //                     ],
    //                     borderWidth: 1
    //                 }]
    //             },
    //             options: {
    //                 elements: {
    //                     center: {
    //                         text: 'test',
    //                         // color: '#FF6384', // Default is #000000
    //                         // fontStyle: 'Arial', // Default is Arial
    //                         // sidePadding: 20, // Default is 20 (as a percentage)
    //                         // minFontSize: 20, // Default is 20 (in px), set to false and text will not wrap.
    //                         // lineHeight: 25 // Default is 25 (in px), used for when text wraps
    //                     }
    //                 },
    //                 plugins: {
    //                     legend: {
    //                         display: true,
    //                         labels: {
    //                             color: 'rgb(255, 99, 132)',
    //                             font: {
    //                                 family: "'Noto Sans Thai', sans-serif"
    //                             }
    //                         },
    //                         position: 'top'
    //                     }
    //                 },
    //                 scales: {
    //                     y: {
    //                         beginAtZero: true,
    //                         grid: {
    //                             display: false
    //                         }
    //                     },
    //                     x: {
    //                         grid: {
    //                             display: false
    //                         }
    //                     },


    //                 },
    //                 responsive: true,
    //                 maintainAspectRatio: false
    //             }
    //         });
    //         var ctx = document.getElementById("recoverChartTotal").getContext("2d");
    //         var myChart = new Chart(ctx, {
    //             type: 'line',
    //             data: {
    //                 labels: arrayDate.slice(-31),
    //                 datasets: [{
    //                     label: 'จำนวนสะสม ',
    //                     data: arrayAllRecover.slice(-31),
    //                     backgroundColor: [
    //                         'rgb(0, 204, 102)'
    //                     ],
    //                     borderColor: [
    //                         'rgb(0, 204, 102)'
    //                     ],
    //                     borderWidth: 1
    //                 }]
    //             },
    //             options: {
    //                 elements: {
    //                     center: {
    //                         text: 'test',
    //                         // color: '#FF6384', // Default is #000000
    //                         // fontStyle: 'Arial', // Default is Arial
    //                         // sidePadding: 20, // Default is 20 (as a percentage)
    //                         // minFontSize: 20, // Default is 20 (in px), set to false and text will not wrap.
    //                         // lineHeight: 25 // Default is 25 (in px), used for when text wraps
    //                     }
    //                 },
    //                 plugins: {
    //                     legend: {
    //                         display: true,
    //                         labels: {
    //                             color: 'rgb(0, 255, 111)',
    //                             font: {
    //                                 family: "'Noto Sans Thai', sans-serif"
    //                             }
    //                         },
    //                         position: 'top'
    //                     }
    //                 },
    //                 scales: {
    //                     y: {
    //                         beginAtZero: true,
    //                         grid: {
    //                             display: false
    //                         }
    //                     },
    //                     x: {
    //                         grid: {
    //                             display: false
    //                         }
    //                     },


    //                 }
    //             },
    //             responsive: true,
    //             maintainAspectRatio: false
    //         });
    //         var ctx = document.getElementById("deathChartTotal").getContext("2d");
    //         var myChart = new Chart(ctx, {
    //             type: 'line',
    //             data: {
    //                 labels: arrayDate.slice(-31),
    //                 datasets: [{
    //                     label: 'จำนวนสะสม ',
    //                     data: arrayAllDeath.slice(-31),
    //                     backgroundColor: [
    //                         'rgb(64, 64, 64)'
    //                     ],
    //                     borderColor: [
    //                         'rgb(64, 64, 64)'
    //                     ],
    //                     borderWidth: 1
    //                 }]
    //             },
    //             options: {
    //                 elements: {
    //                     center: {
    //                         text: 'test',
    //                         // color: '#FF6384', // Default is #000000
    //                         // fontStyle: 'Arial', // Default is Arial
    //                         // sidePadding: 20, // Default is 20 (as a percentage)
    //                         // minFontSize: 20, // Default is 20 (in px), set to false and text will not wrap.
    //                         // lineHeight: 25 // Default is 25 (in px), used for when text wraps
    //                     }
    //                 },
    //                 plugins: {
    //                     legend: {
    //                         display: true,
    //                         labels: {
    //                             color: 'rgb(128, 128, 128)',
    //                             font: {
    //                                 family: "'Noto Sans Thai', sans-serif"
    //                             }
    //                         },
    //                         position: 'top'
    //                     }
    //                 },
    //                 scales: {
    //                     y: {
    //                         beginAtZero: true,
    //                         grid: {
    //                             display: false
    //                         }
    //                     },
    //                     x: {
    //                         grid: {
    //                             display: false
    //                         }
    //                     },


    //                 },
    //                 responsive: true,
    //                 maintainAspectRatio: false
    //             }
    //         });
    //     } catch (error) {
    //         console.log(error);
    //     }
    // }
</script>
@endsection
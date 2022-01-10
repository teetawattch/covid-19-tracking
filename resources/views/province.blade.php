@extends('layouts.app')

@section('content')
<div class="container">
    <div class="p-3 text-center">
        <h3>แยกตามจังหวัด</h3>
        <h5 id="date"></h5>
    </div>
    <div class="row text-center pb-2">
        <div class="col">
            จังหวัด
        </div>
        <div class="col">
            ผู้ป่วยรายใหม่
        </div>
        <div class="col">
            ผู้ป่วยสะสม
        </div>
        <div class="col">
            เสียชีวิต
        </div>
        <div class="col">
            เสียชีวิตสะสม
        </div>
    </div>
    <div id="showData"></div>
</div>
@endsection

@section('localScript')
<script>
    getDataSeperateProvince()
    async function getDataSeperateProvince() {
        try {
            var res = await fetch('https://covid19.ddc.moph.go.th/api/Cases/today-cases-by-provinces')
            var data = await res.json()

            console.log(data[0]);
            document.getElementById('date').innerHTML = "<div class='pb-4'> อัปเดทข้อมูลล่าสุดเมื่อวันที่ : " + data[0].update_date + "</div>"
            var divData = document.getElementById('showData')

            // showDate.innerText = data[0].update_date
            for (var i = 0; i < data.length; i++) {
                if(data[i].total_case > 30000){
                    divData.innerHTML += "<div class='card text-center bg-danger text-white pt-3 pb-3'><div class='row'><div class='col'>" + data[i].province + " </div> <div class='col'>" + data[i].new_case + "</div><div class='col'>" + data[i].total_case + "</div><div class='col'>" + data[i].new_death + "</div><div class='col'>" + data[i].total_death + "</div></div></div>"
                }else if(data[i].total_case > 10000){
                    divData.innerHTML += "<div class='card text-center bg-warning text-white pt-3 pb-3'><div class='row'><div class='col'>" + data[i].province + " </div> <div class='col'>" + data[i].new_case + "</div><div class='col'>" + data[i].total_case + "</div><div class='col'>" + data[i].new_death + "</div><div class='col'>" + data[i].total_death + "</div></div></div>"
                }else if(data[i].total_case > 5000){
                    divData.innerHTML += "<div class='card text-center bg-success text-white pt-3 pb-3'><div class='row'><div class='col'>" + data[i].province + " </div> <div class='col'>" + data[i].new_case + "</div><div class='col'>" + data[i].total_case + "</div><div class='col'>" + data[i].new_death + "</div><div class='col'>" + data[i].total_death + "</div></div></div>"
                }else{
                    divData.innerHTML += "<div class='card text-center bg-secondary text-white pt-3 pb-3'><div class='row'><div class='col'>" + data[i].province + " </div> <div class='col'>" + data[i].new_case + "</div><div class='col'>" + data[i].total_case + "</div><div class='col'>" + data[i].new_death + "</div><div class='col'>" + data[i].total_death + "</div></div></div>"
                }
            }
        } catch (error) {
            console.log(error);
        }
    }
</script>
@endsection
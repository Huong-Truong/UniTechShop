@extends('admin_layout')
@section('admin-content')

<div class="row">
            <div class="col-lg-12">
                    <section class="panel ">
                        
                        <header class="panel-heading">
                            Thống kê đơn hàng trong 
                            <form action="" class="form-inline">
                               tháng
                                <input type="text" name = "month" class="input-small">
                                năm
                                <input type="text"  name = "year" class="input-medium">
                                <input type="submit" class = "btn btn-sm btn-default" value="Xem">
                            </form>
                        </header>
                       
                        <div class="panel-body">
                            {{----}}
                         
                                <div style="width: 90%;">
                                    <canvas id="donhangChart"></canvas>
                                </div>
                                <script>
                                    var ctx = document.getElementById('donhangChart').getContext('2d');
                                    var sanphamChart = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: @json( array_keys($soluong)),
                                            datasets: [{
                                                label: 'Số lượng đơn hàng',
                                                data: @json(array_values($soluong)),
                                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                                borderColor: 'rgba(54, 162, 235, 1)',
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                    ticks: {
                                                        stepSize: 1 // Thiết lập đơn vị hiển thị trên trục y
                                                    }
                                                }
                                            }
                                        }
                                    });
                                </script>
                        </div>              



@endsection

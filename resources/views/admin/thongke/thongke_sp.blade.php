@extends('admin_layout')
@section('admin-content')
<?php
    $message = Session::get('message');
    if($message){?>
    <div id="errorBox" class="error-box">
        {{$message}}
    </div>
<?php
    Session::forget('message');
    }
?>

<div class="row">
            <div class="col-lg-12">
                    <section class="panel ">
                        
                        <header class="panel-heading">
                            Thống kê sản phẩm
                        </header>
                       
                        <div class="panel-body">
                            {{----}}
                         
                                <div style="width: 90%;">
                                    <canvas id="sanphamChart"></canvas>
                                </div>
                                <script>
                                    var ctx = document.getElementById('sanphamChart').getContext('2d');
                                    var sanphamChart = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: @json($products->pluck('sanpham_ten')),
                                            datasets: [{
                                                label: 'Số lượng:',
                                                data: @json($products->pluck('tonkho_soluong')),
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

                    </section>

            </div>
           



@endsection

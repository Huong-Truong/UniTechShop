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
        <section class="panel">
            <header class="panel-heading">
                Sản phẩm bán chạy
            </header>

            <div class="custom-o btn" >
                <br>
                <br>
             
                <form action="{{route('thongke-sp')}}" method="GET" enctype="multipart/form-data" class="form-search">
                  @csrf
                  
                <div class="btn">
                  <select name="month" class="form-control input-sm m-bot15">
                    <option value="0" {{ $m == 0 ? 'selected' : '' }}>Tất cả</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $i == (int)$m ? 'selected' : '' }}>Tháng {{ $i }}</option>
                    @endfor
                </select>
              </div>
<<<<<<< HEAD
=======
              <p>Năm</p>
>>>>>>> 298d2494bfeb1ad29d1fb16c0a1f71f34261dea1
              <div class="btn">
                <select name="year" class="form-control input-sm m-bot15">
                 
                  <option value="0">Tất cả</option>
                  <?php $nam = date('Y');?>
                  @for ($i = $nam - 5; $i <= $nam + 5; $i ++)
                  <option value="{{$i}}" {{ $i == $y ? 'selected' : '' }} >{{$i}}</option>
                  @endfor
              </select>
                </div>
                  
<<<<<<< HEAD
                  <p id="fileName"></p>
              
=======
                <p>Top</p>
                                        <div class="btn">
                                            
                                            <input type="number" name="number" class="input-sm form-control m-bot15" style="width: 60px;">
                                        </div>
>>>>>>> 298d2494bfeb1ad29d1fb16c0a1f71f34261dea1
                  <br>
                  <input type="submit" value="Lọc" name="import_hdn" class="custom-file-upload">
                </form>
              <br>
              
           
 
        </div>
       
            <div class="panel-body">
                <div style="width: 90%;">
                    <canvas id="sanphamChart"></canvas>
                </div>
                <script>
                    var ctx = document.getElementById('sanphamChart').getContext('2d');
                    var sanphamChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: @json($products->pluck('sanpham_ten')->map(function($name) {
                                return strlen($name) > 15 ? substr($name, 0, 10) . '..' : $name;
                            })),
                            datasets: [{
                                label: 'Số lượng bán ra',
                                data: @json($products->pluck('ctdh_soluong')),
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
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            var index = context.dataIndex;
                                            var fullName = @json($products->pluck('sanpham_ten'))[index];
                                            return fullName + ': ' + context.raw;
                                        }
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>
        </section>
    </div>
</div>
@endsection
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
                            Thống kê khách hàng
                        </header>
                       
                        <div class="row w3-res-tb">
                           
                               
                                    <br>
                                    <div class="custom-o btn" >
                                        Bảng xếp hạng<br><br>
                                         <form class="form-search" action="{{route('thongke-kh')}}" method="get">
                                            <p>Xếp theo</p>
                                            <div class="btn">
                                                <select name="trangthai" class="form-control input-sm m-bot15">
                                                    <option value="1"  {{ $t == 1 ? 'selected' : '' }}>Lượt mua</option>
                                                    <option value="2" {{ $t == 2 ? 'selected' : '' }}>Chi tiêu</option>  
                                                </select>
                                            </div>
                                            <p>Tháng</p>
                                            <div class="btn">
                                                <select name="month" class="form-control input-sm m-bot15">
                                                <option value="0" {{ $m == 0 ? 'selected' : '' }}>Tất cả</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}" {{ $i == (int)$m ? 'selected' : '' }}>Tháng {{ $i }}</option>
                                                @endfor
                                            </select>
                                            </div>
                                            <p>Năm</p>
                                            <div class="btn">
                                                
                                            <select name="year" class="form-control input-sm m-bot15">
                                            
                                                <option value="0">Tất cả</option>
                                                <?php $nam = date('Y');?>
                                                @for ($i = $nam - 5; $i <= $nam + 5; $i ++)
                                                <option value="{{$i}}" {{ $i == $y ? 'selected' : '' }} >{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <p>Top</p>
                                        <div class="btn">
                                            
                                            <input type="text" name="number" class="input-sm form-control m-bot15" style="width: 30px;">
                                        </div>
                             
                              <button class="btn btn-sm btn-default " type="submit" >Xem</button>  
                              
                                  </form>
                                    
                                 
                                
                                
                         <div class="col-sm-4">
                            
                         </div>
                         <div class="col-sm-3">
                           <div class="input-group">
                           
                             
                           </div>
                         </div>
                       </div>
                       
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
                                            labels: @json($khachhangs->pluck('khachhang_sdt')),
                                            datasets: [{
                                                label: '<?php  echo $tieude = ($t == 0) ? "Số lượt mua" : "Tổng chi tiêu (triệu VND)";?>',
                                                data: @json($khachhangs->pluck('total')),
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

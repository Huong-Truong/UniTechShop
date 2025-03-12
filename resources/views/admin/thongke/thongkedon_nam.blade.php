@extends('admin_layout')
@section('admin-content')

<div class="row">
            <div class="col-lg-12">
                    <section class="panel ">
                        
                        <header class="panel-heading">
                            Thống kê đơn hàng trong năm
                            <form action="" class="form-inline"  method="get">
                                <input type="text"  name = "year" class="input-medium" value="{{$year}}">
                                <input type="submit" class = "btn btn-sm btn-default" value="Xem">
                            </form>
                        </header>
                         <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Số lượng</option>
          <option value="1">Doanh số</option>
        
        </select>
        <button class="btn btn-sm btn-default">Apply</button>                
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
        
          <span class="input-group-btn">
       
            <button class="btn btn-sm btn-default" type="button"> <a href="{{route('thongke-don-thang')}}"> Xem thống kê theo tháng</a></button>

          </span>
        </div>
      </div>
    </div>
                       
                        <div class="panel-body">
                            {{----}}
                         
                                <div style="width: 100%;">
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

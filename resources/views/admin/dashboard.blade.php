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
{{-- <button class="styled-button">
    <a href="{{route('thongke-sp')}}">Thống kê sản phẩm</a>
</button> --}}
{{-- <button class="styled-button">
    <a href="{{route('thongke-kh')}}">Thống kê khách hàng</a>
</button> --}}
<div class="charts-container">
    <div class="chart" id="chartTopProducts"></div>
    <div  class="chart" id="chartTopCustomers"></div>
    <div class="chart" id="chartMonthlySales"></div>
    <div class="chart" id="chartPTTT"></div>
    <div class="chart" id="chartBrand"></div>
    <div class="chart" id="chartCategory"></div>
  
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    const paymentData = @json($paymentData);
    const brandData = @json($brandData);
    const categoryData = @json($categoryData);
    const monthlySalesData = @json($monthlySalesData);
    const topProductsData = @json($topProductsData);
    const topCustomersData = @json($topCustomersData);



    const commonChartOptions = {
        chart: {
            type: 'pie',
            backgroundColor: 'rgba(255, 255, 255, 0.9)'
        },
        plotOptions: {
            series: {
                point: {
                    events: {
                        click: function() {
                            if (this.options.url) {
                                window.location.href = this.options.url;
                            }
                        }
                    }
                }
            }
        },
        series: [{
            name: 'Tổng cộng',
            colorByPoint: true,
            data: []
        }]
    };

    function createPieChart(chartId, title, data) {
        if (!data || data.length === 0) {
            console.warn(`Không có dữ liệu cho biểu đồ ${chartId}`);
            return;
        }

        const chartOptions = {
            ...commonChartOptions,
            title: {
                text: title
            },
            series: [{
                ...commonChartOptions.series[0],
                data: data
            }]
        };

        Highcharts.chart(chartId, chartOptions);
    }

    createPieChart('chartPTTT', 'Thống kê phương thức thanh toán', paymentData.map(item => ({
        name: item.pttt_ten,
        y: item.count
    })));

    createPieChart('chartBrand', 'Số lượng sản phẩm theo hãng', brandData.map(item => ({
        name: item.hang_ten,
        y: item.count
    })));

    createPieChart('chartCategory', 'Số lượng sản phẩm theo danh mục', categoryData.map(item => ({
        name: item.danhmuc_ten,
        y: item.count
    })));

    createPieChart('chartMonthlySales', 'Số lượng đơn hàng trong năm 2025', monthlySalesData.map(item => ({
        name: `Tháng ${item.month}`,
        y: item.count,
        url: `{{ route('thongke-don-nam') }}`
    })));

    createPieChart('chartTopProducts', 'Top 10 sản phẩm bán chạy nhất năm', topProductsData.slice(0, 10).map(item => ({
        name: item.sanpham_ten,
        y: item.count,
        url: `{{ route('thongke-sp') }}`
    })));

    createPieChart('chartTopCustomers', 'Top 10 khách hàng chi tiêu cao nhất năm', topCustomersData.slice(0, 10).map(item => ({
        name: item.khachhang_ten,
        y: item.count,
        url: `{{ route('thongke-kh') }}`
    })));
</script>
@endsection

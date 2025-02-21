@extends ('layout')
@section('slide')
<!-- services Start -->
<div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-9 table-responsive mb-5">
            <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Bảng thông tin dịch vụ</span></h2>
        </div>
                <table class="table table-bordered text-center mb-0">
                    <?php 
                
                    ?>
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Tên dịch vụ</th>
                            <th>Giá dịch vụ</th>
                            <th>Mô tả</th>
                            <!-- <th>Số lượng</th>
                            <th>Tổng tiền</th>
                            <th>Xóa</th> -->
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($content as $v_content)
                        <tr>
                            <td><img src="{{ asset('img/sp' . $v_content->id . '/' . $v_content->options->image) }}" alt="" style="width: 50px;"></td>
                            <td class="align-middle"> {{$v_content->name}}</td>
                            <td class="align-middle">{{ number_format($v_content->price). ' VNĐ' }}</td>
                            <td class="align-middle">
                                <form action="{{route('update-cart-qty')}}" method="post">
                                    @csrf
                                <div class="input-group quantity mx-auto" style="width: 100px;">

                                    <input type="text" class="form-control form-control-sm bg-secondary text-center" name="cart_qty" value="{{$v_content->qty}}">
                                    <input type="hidden" class="form-control form-control-sm bg-secondary text-center" name ="rowID_cart" value="{{$v_content->rowId}}">
                                     <input type="submit" class="btn btn-sm btn-primary text-center" value="CN">
                                </div>
                                </form>
                            </td>
                            <td class="align-middle"><?php 
                                $sub = $v_content->price * $v_content->qty;
                                echo number_format($sub) . ' VNĐ';
                            ?></td>
                            <td class="align-middle"><a href="{{route('delete-to-cart', ['rowID'=> $v_content->rowId])}}" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></a></td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
        </div>
    </div>
    <!-- services End -->
@endsection



<!-- @section('slide')
<div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Liên hệ</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Liên hệ</p>
            </div>
        </div>
    </div>
@endsection -->
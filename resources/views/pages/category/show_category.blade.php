@extends('layout')
@section('content')



  <!-- Shop Start -->
  <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-12">
                <!-- Price Start -->
                <div class="border-bottom mb-4 pb-4">
    <h5 class="font-weight-semi-bold mb-4">Lọc theo loại sản phẩm</h5>
 
      
    @foreach($phanloai as $key => $pl)
    <form action="{{route('phan-loai',['phanloai_id' => $pl->phanloai_id])}}" method="get">
        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
            <input type="checkbox" class="custom-control-input" id="price-{{$pl->phanloai_id}}" name="{{$pl->phanloai_id}}" onchange="this.form.submit()">
            <label class="custom-control-label" for="price-{{$pl->phanloai_id}}">{{$pl->phanloai_ten}}</label>
            <span class="badge border font-weight-normal">150</span>
        </div>
    </form>
@endforeach


    </form>
    </div>
<!-- Price End -->

<!-- Color Start -->
<div class="border-bottom mb-4 pb-4">
    <h5 class="font-weight-semi-bold mb-4">Lọc theo danh mục</h5>

        
        @foreach($danhmuc as $key => $pl)
        <form action="{{route('danh-muc',['danhmuc_id' => $pl->danhmuc_id])}}" method="get" >
        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
        <input type="checkbox" class="custom-control-input" id="color-{{ $pl->danhmuc_id }}" name="danhmuc_id" value="{{ $pl->danhmuc_id }}" onchange="this.form.submit()">
            <label class="custom-control-label" for="color-{{$pl->danhmuc_id}}">{{$pl->danhmuc_ten}}</label>
            <span class="badge border font-weight-normal">150</span>
        </div>
        </form>
        @endforeach
</div>
</div>

            <!-- Shop Product Start -->
<!-- Shop Product Start --> 
       <!-- Shop Product Start -->
       <div class="col-lg-9 col-md-12">
    <div class="row pb-3">
        <div class="col-12 pb-1">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <!-- <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search by name">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form> -->
                <div class="dropdown ml-4">
                    <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort by
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                        <a class="dropdown-item" href="#">Latest</a>
                        <a class="dropdown-item" href="#">Popularity</a>
                        <a class="dropdown-item" href="#">Best Rating</a>
                    </div>
                </div>
            </div>
        </div>
        @foreach($sanpham as $value)
        <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <a href="{{route('xem-san-pham', ['sanpham_id' => $value->sanpham_id])}}"> 
                        <img class="img-fluid w-100" src="{{ asset('img/sp' . $value->sanpham_id . '/' . $value->sanpham_hinhanh) }}" alt=""></a>
               

                </div>
                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                    <h6 class="text-truncate mb-3">{{$value->sanpham_ten}}</h6>
                    <div class="d-flex justify-content-center">
                      <h6>{{number_format($value->sanpham_gia) . ' VNĐ'}}</h6>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between bg-light border">
                    <a href="{{route('xem-san-pham', ['sanpham_id' => $value->sanpham_id])}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem chi tiết</a>
                    <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm vào giỏ hàng</a>
                    
                </div>
            </div>
        </div>
        @endforeach

        <div class="col-12 pb-1">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mb-3">
                    @if ($sanpham->onFirstPage())
                        <li class="page-item disabled">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $sanpham->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                    @endif

                    @for ($i = 1; $i <= $sanpham->lastPage(); $i++)
                        <li class="page-item {{ $sanpham->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $sanpham->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($sanpham->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $sanpham->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- Shop Product End -->

    </div>
    <!-- Shop End -->


@endsection

@section('slide')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5 ">
        <div class="d-flex flex-column align-items-center justify-content-center"  style="height: 410px;">
          
            <h1 class="font-weight-semi-bold text-uppercase mb-3">{{$ten_page}}</h1>

            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shop</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
@endsection

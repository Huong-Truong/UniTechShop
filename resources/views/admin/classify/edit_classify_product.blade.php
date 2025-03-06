@extends('admin_layout')
@section('admin-content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Chỉnh sửa phân loại sản phẩm
                        </header>
                       
                        <div class="panel-body">
                            @foreach ($edit_classify as $key => $edit_value)
                            <div class="position-center">
                                <form role="form" action="{{route('update-classify', ['classify_id' => $edit_value->phanloai_id])}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên hãng</label>
                                    <input value="{{ $edit_value->phanloai_ten}}"name="classify_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                </div>               
                                <button type="submit" name="update_classify_product" class="btn btn-info">Cập nhật </button>
                            </form>
                            </div>
                            @endforeach
                        </div>
                    </section>

            </div>
           
@endsection

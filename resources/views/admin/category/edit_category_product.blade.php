@extends('admin_layout')
@section('admin-content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Chỉnh sửa danh mục sản phẩm
                        </header>
                       
                        <div class="panel-body">
                            @foreach ($edit_category as $key => $edit_value)
                            <div class="position-center">
                                <form role="form" action="{{route('update-category', ['category_id' => $edit_value->danhmuc_id])}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục</label>
                                    <input value="{{ $edit_value->danhmuc_ten}}"name="danhmuc_ten" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                                    <select name="classify" class="form-control input-sm m-bot15">
                                        @foreach ($classify as $key=>$value)
                                            <option value = "{{$value->phanloai_id}}" {{ $value->phanloai_id == $edit_value->phanloai_id ? 'selected' : '' }}>
                                                {{$value->phanloai_ten}}
                                            </option>
                                        @endforeach
                                    </select>
                                    </div>
                                <button type="submit" name="update_category_product" class="btn btn-info">Cập nhật danh mục</button>
                            </form>
                            </div>
                            @endforeach
                        </div>
                    </section>

            </div>
           
@endsection

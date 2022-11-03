@extends('admin.layout.master')
@section('content')
    <h1>Edit Product</h1>  
    <form action="{{ route('UpdateSP',[$product->id])}}" method="post" role="form" enctype="multipart/form-data">
        @csrf
        @method('put') <!-- <input name="_method" type="hidden" value="PATCH">  -->
    <div class="form-group">
        <label for="">Ten</label>
        <input type="text" name="name" id="" class="form-control" value="{{$product->name}}">
        <label for="">Type</label>
        <input type="number" name="type" id="" class="form-control" value="{{$product->id_type}}">
        <label for="">Mo ta</label>
        <input type="textarea" name="mota" id="" class="form-control" value="{{ isset($product->description)?$product->description:'' }}" height="250">
        <label for="">Gia</label>
        <input type="text" name="gia" id="" class="form-control" value="{{$product->unit_price}}">
        <label for="">Gia_km</label>
        <input type="text" name="gia_km" id="" class="form-control" value="{{$product->promotion_price}}">
        <label for="">Hinh anh</label>
        <input type="file" class="form-control-file" id="" name="image_file" placeholder="" onchange="changeImage(event)">
        <img id="image" src="" class="img-thumnail" style="width:10rem" alt=""><br>
            <script type="text/javascript">
                const  changeImage=(e)=>{
                    const img=document.getElementById('image');
                    const file=e.target.files[0]
                    img.src=URL.createObjectURL(file);
                }
            </script>
            </div>
        <label for="">Don vi</label>
        <input type="text" name="donvi" id="" class="form-control" value="{{$product->unit}}">
        <label for="">Moi</label>
        <input type="text" name="moi" id="" class="form-control" value="{{$product->new}}">

        <input name="btnSave" id="" class="btn btn-primary" type="submit" value="Edit">
    </div>
    </div>  
    </form>
@endsection
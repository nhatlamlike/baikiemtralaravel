@extends('admin.layout.master')
@section('content')
  <div class="container">
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <h1 style="text-align:center;color:green">ADD NEW TYPR_PRODUCT</h1>
    <form action="{{route('AddDM')}}" method="post" enctype="multipart/form-data">
        @csrf
    <div class="form-group">
        <label for="">Ten</label>
        <input type="text" name="name" id="" class="form-control" value="">
        <label for="">Type</label>
        <input type="number" name="type" id="" class="form-control" value="">
        <label for="">Mo ta</label>
        <input type="textarea" name="mota" id="" class="form-control" value="" height="250">
        <label for="">Gia</label>
        <input type="text" name="gia" id="" class="form-control" value="">
        <label for="">Gia_km</label>
        <input type="text" name="gia_km" id="" class="form-control" value="">
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
        <input type="text" name="donvi" id="" class="form-control" value="">
        <label for="">Moi</label>
        <input type="text" name="moi" id="" class="form-control" value="">
        <input name="btnADD" id="" class="btn btn-primary" type="submit" value="Thêm">
    </div>
    </div>
    </form>
    </div>
    @endsection

@extends('admin.layout.master')
@section('content')
    <h1>Edit Category</h1>  
    <form action="{{ route('UpdateDM',[$typesPro->id])}}" method="post" role="form" enctype="multipart/form-data">
        @csrf
        @method('put') <!-- <input name="_method" type="hidden" value="PATCH">  -->
    <div class="form-group">
        <label for="">Ten</label>
        <input type="text" name="name" id="" class="form-control" value="{{$typesPro->name}}">
        <label for="">Mo ta</label>
        <input type="textarea" name="description" id="" class="form-control" value="{{ isset($typesPro->description)?$typesPro->description:'' }}" height="250">
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
        <input name="btnSave" id="" class="btn btn-primary" type="submit" value="Edit">
    </div>
    </div>  
    </form>
@endsection
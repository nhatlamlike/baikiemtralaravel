@extends('admin.layout.master')
@section('content')
<div class="card-body">
    <a name="btnAdd" id="" class="btn btn-success" href="{{ route('CreateDM') }}" role="button">Add New Type_Product</a>
    <table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Ten</th>
            <th>Mo ta</th>
            <th>Hinh anh</th>
            <th>Action</th>
        </tr>
    </thead>
    
    <tbody>
        @foreach($typesPro as $pro)
        <tr>
            <form action="{{ route('Category',$pro->id)}}" method="get" >
                @csrf
                @method('delete') 
            <td>{{ $pro->id }}</td>
            <td>{{ $pro->name }}</td>
            <td>{{ $pro->description}}</td>
            <td>
                <img src="/source/image/product/{{ $pro->image }}" alt="" srcset="" width="120" height="90">
            </td>
            <td style="width:120px">
            <button type="button" class="btn btn-success" onclick="window.location='{{route('EditDM',['id'=>$pro->id])}}'"><i class="fas fa-pen"></i></button>
            <button type="submit" name="delete" ><i class="fas fa-trash"></i></button>
            </td>
            </form>
        </tr>
        @endforeach
    </tbody>
    </table>
    @endsection
    


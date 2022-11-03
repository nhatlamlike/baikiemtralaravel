@extends('admin.layout.master')
@section('content')
<div class="card-body">
    <a name="btnAdd" id="" class="btn btn-success" href="{{ route('CrProduct') }}" role="button">Add New Product</a>
    <table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Ten</th>
            <th>TD_type</th>
            <th>Mo ta</th>
            <th>Gia</th>
            <th>Gia_km</th>
            <th>Hinh anh</th>
            <th>Don vi</th>
            <th>Moi</th>
            <th>Action</th>
        </tr>
    </thead>
    
    <tbody>
        @foreach($products as $pro)
        <tr>
            <form action="{{ route('products.destroy',$pro->id)}}" method="post" >
                @csrf
                @method('delete') 
                <td>{{ $pro->id }}</td>
                <td>{{ $pro->name }}</td>
                <td>{{ $pro->id_type }}</td>
                <td>{{ $pro->description}}</td>
                <td>{{ $pro->unit_price }}</td>
                <td>{{ $pro->promotion_price }}</td>
                <td>
                    <img src="/source/image/product/{{ $pro->image }}" alt="" srcset="" width="100" height="90">
                </td>
                <td>{{ $pro->unit }}</td>
                <td>{{ $pro->new }}</td>
                <td style="width:120px">
                <button type="button" class="btn btn-success" onclick="window.location='{{route('Edit',['id'=>$pro->id])}}'"><i class="fas fa-pen"></i></button>
                <button type="submit" name="delete" ><i class="fas fa-trash"></i></button>
                </td>
            </form>
        </tr>
        @endforeach
    </tbody>
    </table>
    @endsection
    


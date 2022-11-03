<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $products = DB::table('products')->get();
        $products = Product::all();
        return view('banhang.sanpham.show_sanpham', compact('products')); // collection kieu mang
        
    }

    public function index2()
    {
        //
        // $products = DB::table('products')->get();
        $products = Product::all();
        return view('banhang.checkout', compact('products')); // collection kieu mang
        
    }

    public function listProducts(){
        $products = Product::all();
        return view('banhang.sanpham.show_sanpham', ['products' => $products]);
    }

    public function listCategory(){
        $typesPro = ProductType::all();
        return view('banhang.danhmuc.show_danhmuc', ['typesPro' => $typesPro]);
    }

    public function deleCategory($id){
        $typesPro = ProductType::find($id);
        $typesPro->delete();
        return redirect()->route('Category');
    }

    public function editCategory($id){
        $typesPro = ProductType::find($id);
        return view('banhang.danhmuc.edit_danhmuc', ['typesPro'=>$typesPro]);
    }

    public function updateCategory(Request $request, $id){
        $this->validate($request,[
            'name'=>'required',
            'description'=>'required',
            'image_file'=>'required',
            
        ],[
            'name.required'=>'Bạn chưa nhập tên',
            'description.required'=>'Bạn chưa nhập mo ta',
            'image_file.mimes' => 'Chỉ chấp nhận hình thẻ với đuôi .jpg .jpeg .png .gif',
            'image_file.max' => 'Hình thẻ giới hạn dung lượng không quá 10MB',
        ]);
        $name='';
        if($request->hasfile('image_file'))
        {
            $file = $request->file('image_file');
            $name=time().'_'.$file->getClientOriginalName();
            $destinationPath=public_path('source/image/product'); //project\public\images, //public_path(): trả về đường dẫn tới thư mục public
            $file->move($destinationPath, $name); //lưu hình ảnh vào thư mục public/images/cars
        }
        $type_product= ProductType::find($id);
        $type_product->name=$request->input('name');
        $type_product->description=$request->input('description');
        $type_product->image=$name;
        $type_product->save();
        // dd($type_product);
        return redirect()->route('UpdateDM')->with('success','Bạn đã cập nhật thành công');
    }

    public function createCate(){
        $product_types = ProductType::all();
        return view('banhang.danhmuc.add_danhmuc', compact('product_types'));
    }

    public function storeCate(Request $r){
        $r->validate([
            'name'=>'required',
            'description' => 'required',
            'image_file' => 'mimes:jpeg,jpg,png,gif|max:10000',
        ]);

        [
            'name.required' => 'Ban chua nhap thong tin day du',
            'description.required' => 'Ban chua nhap mo ta',
            'image_file.minmes' => 'Chi chap nhan anh voi dung kich thuoc',
            'image_file.max' => 'Anh gioi han dung luong khoang 10000',
        ];
        $name='';
        if($r->hasfile('image_file'))
        {
            $file = $r->file('image_file');
            $name=time().'_'.$file->getClientOriginalName();
            $destinationPath=public_path('image'); //project\public\car, //public_path(): trả về đường dẫn tới thư mục public
            $file->move($destinationPath, $name); //lưu hình ảnh vào thư mục public/images/cars
        }
        $product_type = new ProductType();
        $product_type->name = $r->input('name');
        $product_type->description = $r->input('description');
        $product_type->image = $name;
        $product_type->save();
        return redirect('Category')->with('success');
        }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $products = Product::all();
        return view('banhang.sanpham.add_sanpham', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'required',
            'type'=>'required',
            'mota'=>'required',
            'gia'=>'required',
            'gia_km'=>'required',
            'image_file'=>'required',
            'donvi'=>'required',
            'moi'=>'required',
        ],[
            'name.required'=>'Bạn chưa nhập tên',
            'type.required'=>'Bạn chưa nhập type',
            'mota.required'=>'Bạn chưa nhập mo ta',
            'gia.required'=>'Bạn chưa nhập gia',
            'gia_km.required'=>'Bạn chưa nhập gia_km',
            'image_file.mimes' => 'Chỉ chấp nhận hình thẻ với đuôi .jpg .jpeg .png .gif',
            'image_file.max' => 'Hình thẻ giới hạn dung lượng không quá 10MB',
            'donvi.required'=>'Bạn chưa nhập đơn vị',
            'moi.required'=>'Bạn chưa nhập mới',
        ]);
        $name='';
        if($request->hasfile('image_file'))
        {
            $file = $request->file('image_file');
            $name=time().'_'.$file->getClientOriginalName();
            $destinationPath=public_path('source/image/product'); //project\public\images, //public_path(): trả về đường dẫn tới thư mục public
            $file->move($destinationPath, $name); //lưu hình ảnh vào thư mục public/images/cars
        }
        $product= new Product();
        $product->name=$request->input('name');
        $product->id_type=$request->input('type');
        $product->description=$request->input('mota');
        $product->unit_price=$request->input('gia');
        $product->promotion_price=$request->input('gia_km');
        $product->image=$name;
        $product->unit=$request->input('donvi');
        $product->new=$request->input('new');
        $product->save();

        return redirect('product')->with('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $product=Product::find($id); //trước đó phải khai báo namespace tới model Product
        return view('banhang.product',compact('product'));
        // ['product'=>$product])
    }

    public function showProtype($id)
    {
        //
        $proT=ProductType::find($id); //trước đó phải khai báo namespace tới model Product
        return view('banhang.product_type',compact('proT'));
        // ['product'=>$product])
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd('sn');
        $product = Product::find($id);
        return view('banhang.sanpham.edit_sanpham', ['product'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request,[
            'name'=>'required',
            'type'=>'required',
            'mota'=>'required',
            'gia'=>'required',
            'gia_km'=>'required',
            'image_file'=>'required',
            'donvi'=>'required',
            'moi'=>'required',
        ],[
            'name.required'=>'Bạn chưa nhập tên',
            'type.required'=>'Bạn chưa nhập type',
            'mota.required'=>'Bạn chưa nhập mo ta',
            'gia.required'=>'Bạn chưa nhập gia',
            'gia_km.required'=>'Bạn chưa nhập gia_km',
            'image_file.mimes' => 'Chỉ chấp nhận hình thẻ với đuôi .jpg .jpeg .png .gif',
            'image_file.max' => 'Hình thẻ giới hạn dung lượng không quá 10MB',
            'donvi.required'=>'Bạn chưa nhập đơn vị',
            'moi.required'=>'Bạn chưa nhập mới',
        ]);
        $name='';
        if($request->hasfile('image_file'))
        {
            $file = $request->file('image_file');
            $name=time().'_'.$file->getClientOriginalName();
            $destinationPath=public_path('source/image/product'); //project\public\images, //public_path(): trả về đường dẫn tới thư mục public
            $file->move($destinationPath, $name); //lưu hình ảnh vào thư mục public/images/cars
        }
        $product= Product::find($id);
        $product->name=$request->input('name');
        $product->id_type=$request->input('type');
        $product->description=$request->input('mota');
        $product->unit_price=$request->input('gia');
        $product->promotion_price=$request->input('gia_km');
        $product->image=$name;
        $product->unit=$request->input('donvi');
        $product->new=$request->input('new');
        $product->save();
        // dd($productT);
        return redirect()->route('UpdateSP')->with('success','Bạn đã cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('Product');
    }
}

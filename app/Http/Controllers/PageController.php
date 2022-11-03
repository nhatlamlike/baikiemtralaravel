<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Product;
use App\Models\User;
use \App\Models\Cart;
use App\Models\ProductType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    // Đổ slide ra trang chủ
        $slide=Slide::all();
       
        // return view('banhang.home',['slide'=>$slide]);Cách 2
    //Đổ dữ liệu sản phẩm ra trang chủ
    $new_products = Product::where('new','=',1)->paginate(8,['*'],'page1')->withQueryString();
    $sale_products=Product::where('promotion_price','>',0)->paginate(8,['*'],'page2')->withQueryString();
    return view('banhang.home',compact('slide','new_products','sale_products'));  
    }

    public function getLoaisp($type){
        // dd($type);
        $sp_theoloai = Product::where('id_type',$type)->get();
        $sp_khac = Product::where('id_type','<>', $type)->paginate(3);
        $loai = ProductType::all();
        $loai_sp = ProductType::where('id', $type)->first();
        return view('banhang.product_type',compact('sp_theoloai', 'sp_khac', 'loai', 'loai_sp'));
    }

    // public function getProduct(){
    //     $products = Product::all();
    //     return view('banhang.sanpham.checkout', []);
    // }
    public function getSingup(){
        return view('banhang.singup');
    }
    public function postSignup(Request $req){
        $this->validate($req,
    	['email'=>'required|email|unique:users,email',
    		'password'=>'required|min:6|max:20',
    		'fullname'=>'required',
    		'repassword'=>'required|same:password'
    	],
    	['email.required'=>'Vui lòng nhập email',
    	'email.email'=>'Không đúng định dạng email',
    	'email.unique'=>'Email đã có người sử  dụng',
    	'password.required'=>'Vui lòng nhập mật khẩu',
    	'repassword.same'=>'Mật khẩu không giống nhau',
    	'password.min'=>'Mật khẩu ít nhất 6 ký tự'
		]);

		$user=new User();
		$user->full_name=$req->fullname;
		$user->email=$req->email;
		$user->password=Hash::make($req->password);
		$user->phone=$req->phone;
		$user->address=$req->address;
        $user->level=3;  //level=1: admin; level=2:kỹ thuật; level=3: khách hàng
		$user->save();
		return redirect()->back()->with('success','Tạo tài khoản thành công');
    }

    public function getLogin(){
        return view('banhang.login');
    }
    public function postLogin(Request $req){
        $this->validate($req,
        [
            'email'=>'required|email',
            'password'=>'required|min:6|max:20'
        ],
        [
            'email.required'=>'Vui lòng nhập email',
            'email.email'=>'Không đúng định dạng email',
            'password.required'=>'Vui lòng nhập mật khẩu',
            'password.min'=>'Mật khẩu ít nhất 6 ký tự',
            'password.max'=>'Mật khẩu tối đa 20 ký tự'
        ]
        );
        $credentials=['email'=>$req->email,'password'=>$req->password];
        if(Auth::attempt($credentials)){//The attempt method will return true if authentication was successful. Otherwise, false will be returned.
            return redirect('/home')->with(['flag'=>'alert','message'=>'Đăng nhập thành công']);
        }
        else{
            return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập không thành công']);
        }
    }

    public function getLogout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('banhang.index');
    }

    public function getAdminHome(){
        return view('admin.admin_home');
    }


    //Amin
    public function getLoginAdmin(){
        return view('admin.login');
    }

    public function postLoginAdmin(Request $req){
        // dd('test');
        $this->validate($req,
        [
            'email'=>'required|email',
            'password'=>'required|min:6|max:20'
        ],
        [
            'email.required'=>'Vui lòng nhập email',
            'email.email'=>'Không đúng định dạng email',
            'email.unique'=>'Email đã có người sử  dụng',
            'password.required'=>'Vui lòng nhập mật khẩu',
            'password.min'=>'Mật khẩu ít nhất 6 ký tự'
        ]
        );
        $credentials=array('email'=>$req->email,'password'=>$req->password);
        if(Auth::attempt($credentials)){
            dd($credentials);
            return redirect('/admin_home')->back()->with(['flag'=>'alert','message'=>'Đăng nhập thành công']);
        }
        else{
            return redirect()->back()->with(['flag'=>'danger','thongbao'=>'Đăng nhập không thành công']);
        }
        
    }

    //Logout Admin
    public function getLogoutAdmin(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('banhang.index');
    }

    public function getUser(){
        $user = User::all();
        // dd($user);
        return view('admin.user.index', compact('user'));
    }

    public function destroyUser($id){
        $user = User::find($id);
        $user->delete();
        return redirect()->route('User');
    }

    //Gio hang
//thêm 1 sản phẩm có id cụ thể vào model cart rồi lưu dữ liệu của model cart vào 1 session có tên cart (session được truy cập bằng thực thể Request)
    public function addToCart(Request $request,$id){
    $products=Product::find($id);
    $oldCart=Session('cart')?Session::get('cart'):null;
    $cart=new Cart($oldCart);
    $cart->add($products,$id);  
    $request->session()->put('cart',$cart);
    return redirect()->back();
    }

    public function deleToCart($id){
        $oldCart = Session::has('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
    
        if(count($cart->items)>0){
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
        }
        return redirect()->back();
    }

    public function getCheckout(){
        if(Session::has('cart')){
            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);

            return view('banhang.checkout', ['product_cart'=>$cart->items, 'totalPrice'=> $cart->totalPrice,
            'totalQty'=>$cart->totalQty]);
        }else{
            return view('banhang.checkout');
        }
    }
    public function postCheckout(Request $rq){

        $cart = Session::get('cart');

        $customer = new Customer(); 
        $customer->name = $rq->name;
        $customer->gender = $rq->gender;
        $customer->email = $rq->email;
        $customer->address = $rq->address;
        $customer->phone_number = $rq->phone;
        $customer->note = $rq->notes;
        $customer->save();
        
        $bill = new Bill();
        $bill->id_customer = $customer->id;
        $bill->date_order = date('Y-m-d');
        $bill->total = $cart->totalPrice;
        $bill->payment = $rq->payment_method;
        $bill->note = $rq->notes;
        $bill->save();

        foreach($cart->items as $key => $value ){
            $bill_detail = new BillDetail();
            $bill_detail->id_bill = $bill->id;
            $bill_detail->id_product = $key;
            $bill_detail->quantity = $value['qty'];
            $bill_detail->unit_price = ($value['price']/$value['qty']);
            $bill_detail->save();

        }
        Session::forget('cart');
        return redirect()->back()->with("Đặt hàng thành công");
        
        // if()
    }

    //hàm xử lý gửi email
    public function postInputEmail(Request $req){
        $email=$req->txtEmail;
        //validate

        // kiểm tra có user có email như vậy không
        $user=User::where('email',$email)->get();
        //dd($user);
        if($user->count()!=0){
            //gửi mật khẩu reset tới email
            $sentData = [
                'title' => 'Mật khẩu mới của bạn là:',
                'body' => '123456'
            ];
            Mail::to($email)->send(new \App\Mail\SendMail($sentData));
            Session::flash('message', 'Send email successfully!');
            return view('login');  //về lại trang đăng nhập của khách
        }
        else {
            return redirect()->route('getInputEmail')->with('message','Your email is not right');
        }
    }//hết postInputEmail

}

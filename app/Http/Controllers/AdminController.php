<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;
use App\Models\Employee;
use App\Models\Orders;
use App\Models\OrderDetail;
use App\Models\Products;
use App\Models\Categories;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;



class AdminController extends Controller
{

    public function dashboard(){
        return view('admin.dashboard');
    }
    public function customers(){
        $customers = Customers::select('customers.CustomerID', 'CompanyName', 'ContactName', 'Phone')
        ->distinct()
        ->join('orders', 'customers.CustomerID', '=', 'orders.CustomerID')
        ->join('order_details', 'orders.OrderID', '=', 'order_details.OrderID')
        ->groupBy('customers.CustomerID', 'CompanyName', 'ContactName', 'Phone')
        ->paginate(10);
    return view('admin.customers', ['customers' => $customers]);
    }




    public function customerOrder($custID){

        $orders = Orders::select('orders.OrderID', 'orders.OrderDate')
        ->selectRaw('SUM(order_details.UnitPrice * order_details.Quantity) AS tot')
        ->join('order_details', 'orders.OrderID', '=', 'order_details.OrderID')
        ->where('orders.CustomerID', '=', $custID)
        ->groupBy('orders.OrderID', 'orders.OrderDate')
        ->get();
        return  response()->json($orders);
    }
    public function customerSearch(Request $request){
        $request->get('customerSearch');

        $customers = Customers::select('customers.CustomerID', 'CompanyName', 'ContactName', 'Phone')
        ->distinct()
        ->join('orders', 'customers.CustomerID', '=', 'orders.CustomerID')
        ->join('order_details', 'orders.OrderID', '=', 'order_details.OrderID')
        ->groupBy('customers.CustomerID', 'CompanyName', 'ContactName', 'Phone')
        ->where('customers.CompanyName','like','%'.$request->get('customerSearch').'%')
        ->orwhere('customers.ContactName','like','%'.$request->get('customerSearch').'%')
        ->get();

        return json_encode($customers);

    }

    public function orderDetail($ordID){
        $orderDetail=OrderDetail::select('OrderID','OrderDate')
        ->join('products','products.OrderID','=','order_details.OrderID')
        ->where('Order_details.orderID','=', $ordID)
        ->get();

        $customerOrder=Customers::select('CompanyName','ContactName','Address','Phone')
        ->join('orders','orders.OrderID','=','Customer.OrderID')
        ->where('OrderID','=',$ordID)
        ->get();

        $response=[
            'orderDetails'=>$orderDetail,
            'customerOrder'=>$customerOrder
        ];
        return response()->json($response);

    }

    public function addproducts(){
        $companyName=DB::table('suppliers')
        ->select('CompanyName','SupplierID')
        ->get();

        $categories=DB::table('categories')
        ->select('CategoryName','CategoryID')
        ->get();
         return view('admin.addProducts')->with(['companyName'=>$companyName,'categories'=> $categories]);
    }

    public function productStore(Request $request){
        $request->validate([
            'productName' => 'required',
            'CompanyName' => 'required',
            'CategoryID' => 'required',
            'quantityPerUnit' => 'required',
            'unitPrice' => 'required',
            'unitsInStock' => 'required',
            'unitsOnOrder' => 'required',
            'productImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'required' => 'The :attribute field is required.',
            'image' => 'The :attribute must be an image.',
            'mimes' => 'The :attribute must be of type: :values.',
            'max' => 'The :attribute may not be greater than :max kilobytes.',
        ]);

        $imagePath = $request->file('productImage')->store('public/products/images');

        // Save data to database
        $product = new Products();
        $product->ProductName = $request->input('productName');
        $product->SupplierID = $request->input('SupplierID');
        $product->CategoryID = $request->input('CategoryID');
        $product-> QuantityPerUnit = $request->input('quantityPerUnit');
        $product->UnitPrice = $request->input('unitPrice');
        $product->UnitsInStock = $request->input('unitsInStock');
        $product->UnitsOnOrder = $request->input('unitsOnOrder');
        $product->product_cover = $imagePath;

        $product->save();


        return redirect()->back()->with('message','product has been inserted successfully');


}
public function showProducts(){
    $show=DB::table('products')
    ->select('ProductID','ProductName','QuantityPerUnit','UnitPrice','product_cover')
    ->paginate(10);
    $categories = Categories::all();
    $path = "/storage/products/images";

    // Add a default image path
    $defaultImagePath = '/storage/products/images/product.png';

    // Iterate through the products and set the image URL
    foreach ($show as $product) {
        $product->image_url = $product->product_cover
            ? asset($path . '/' . $product->product_cover)
            : asset($defaultImagePath);
    }

    return view('admin.showProducts')->with(['show'=>$show,'categories'=>$categories]);
}




public function productDetails(Request $request){
    $productID=$request->productID;
    $productDetails=Products::find($productID);
    return response()->json([
        'details'=>$productDetails
    ]);
}

public function updateProducts(Request $request){
    $productID=$request->productID;
    $validator=Validator::make($request::all(),[
        'productName'=>'required'.$productID,
        'categoryName'=>'required',
        'categoryID'=>'required',
        'quantity'=>'required',
        'unitPrice'=>'required',
        'stock'=>'required',
        'order'=>'required',
        'image'=>'required'

    ]);
    if($validator->passes()){
        return response()->json(['code'=>0,'error'=>$validator->error()->ToArray()]);

    }else{
        $imagePath = $request->file('productImage')->store('public/products/images');
          $product=Products::find($productID);
        $product->ProductName = $request->input('productName');
        $product->SupplierID = $request->input('SupplierID');
        $product->CategoryID = $request->input('CategoryID');
        $product-> QuantityPerUnit = $request->input('quantityPerUnit');
        $product->UnitPrice = $request->input('unitPrice');
        $product->UnitsInStock = $request->input('unitsInStock');
        $product->UnitsOnOrder = $request->input('unitsOnOrder');
        $product->product_cover = $imagePath;

        $query=$product->save();
        if($query){
               return response()->json(['code'=>1,'msg'=>'product details have been updated']);
        }else{
            return response()->json(['code'=>0,'msg'=>'there is something wrong']);
        }

    }
}

public function showCategories(){
    $categories=DB::table('categories')
    ->select('CategoryName','description','CategoryID')
    ->get();
    return view('admin.showcategories')->with(['categories'=>$categories]);
}
public function addCategories(){
    return view('admin.addCategory');
}


 public function categoryStore(Request $request){
      $request->validate([
        'categoryName'=>'required',
        'description'=>'required'
      ],[
        'required' => 'The :attribute field is required.',
      ]);

      $category=new Categories;
      $category->CategoryName=$request->input('categoryName');
      $category->Description=$request->input('description');

      $category->save();

      return redirect()->back()->with('message','category has been inserted successfully');
 }

 public function editCategories($id){
    $category=Categories::find($id);

    if($category){
         return response()->json([
            'status'=>200,
            'category'=>$category
         ]);
    }else{
        return response()->json([
            'status'=>404,
            'message'=>'category not found'
        ]);
    }

 }
 public function updateCategory(Request $request, $id)
 {
    $validator=validator::make($request->all(),[
        'categoryName'=>'required',
        'description'=>'required'
      ],[
        'required' => 'The :attribute field is required.',
      ]);



      if($validator->fails()){
        return response()->json([
            'status'=>400,
            'errors'=>$validator->message(),
        ]);
      }
      $category=Categories::find($id);

      if($category){
        $category->CategoryName=$request->input('categoryName');
        $category->Description=$request->input('description');

        $category->update();

        return response()->json([
          'status'=>200,
          'message'=>'Category updated successfully'
        ]);

   }else{
       return response()->json([
           'status'=>404,
           'message'=>'category not found'
       ]);
   }



 }



 public function outgoing(){

    $orders = DB::table('orders')
        ->select('orders.OrderDate', 'customers.CompanyName', 'order_details.Quantity', 'order_details.ProductID', 'products.ProductName')
        ->join('customers', 'orders.CustomerID', '=', 'customers.CustomerID')
        ->join('order_details', 'order_details.OrderID', '=', 'orders.OrderID')
        ->join('products', 'products.ProductID', '=', 'order_details.ProductID')
        ->orderBy('customers.CompanyName', 'asc')
        ->paginate(10);


    return view('admin.outgoing')->with('orders',$orders);
 }



 public function export_pdf($page = 1) {
    // Assuming you want to get all orders (not paginated) for the PDF
    $allOrders = DB::table('orders')
        ->select('orders.CustomerID','orders.OrderDate','orders.OrderID','customers.CompanyName','order_details.Quantity','products.ProductName')
        ->join('customers','orders.CustomerID','=','customers.CustomerID')
        ->join('order_details','order_details.OrderID','=','orders.OrderID')
        ->join('products','products.ProductID','=','order_details.ProductID')
        ->get();

    // Create a paginator manually using the all orders and the number of items you want per page
    $perPage = 10;
    $currentPage = $page;
    $currentItems = array_slice($allOrders->toArray(), ($currentPage - 1) * $perPage, $perPage);
    $orders = new LengthAwarePaginator($currentItems, count($allOrders), $perPage, $currentPage);

    $pdf = Pdf::loadView('admin.pdf.export_pdf', [
        'orders' => $orders
    ]);

    return $pdf->download('invoice.pdf');
}


public function search(rEQUEST $request){
    $request->get('searchQuest');

    $allOrders = DB::table('orders')
    ->select('orders.CustomerID','orders.OrderDate','orders.OrderID','customers.CompanyName','order_details.Quantity','products.ProductName')
    ->join('customers','orders.CustomerID','=','customers.CustomerID')
    ->join('order_details','order_details.OrderID','=','orders.OrderID')
    ->join('products','products.ProductID','=','order_details.ProductID')
    ->where('products.ProductName','like','%'.$request->get('searchQuest').'%')
    ->orwhere('customers.CompanyName','like','%'.$request->get('searchQuest').'%')
    ->get();

    return json_encode($allOrders);


}

public function chart(){
    $employees = Employee::select('EmployeeID', 'HireDate')->get()->groupBy(function ($employee) {
        return Carbon::parse($employee->HireDate)->format('M');
    });
    
    $labels = [];
    $data = [];
    $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#8BC34A', '#FF5722', '#009688', '#795548', '#9C27B0', '#2196F3', '#FF9800', '#CDDC39', '#607D88'];
    
    for ($i = 1; $i <= 12; $i++) {
        $monthAbbreviation = date('M', mktime(0, 0, 0, $i, 1));
        $count = 0;
    
        // Check if the month exists in the grouped data
        if (isset($employees[$monthAbbreviation])) {
            $count = $employees[$monthAbbreviation]->count();
        }
    
        array_push($labels, $monthAbbreviation);
        array_push($data, $count);
    }
    
    $datasets = [
        [
            'label' => 'employee',
            'data' => $data,
            'backgroundColor' => $colors,
        ]
    ];
    
    return view('admin.Chart', compact('labels', 'datasets'));
}
}







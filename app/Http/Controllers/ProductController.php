<?php
namespace App\Http\Controllers;
    
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
    
class ProductController extends Controller
{ 
    function __construct()
    {
         $this->middleware('permission:productsList|product-create|product-edit|product-delete');
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    
    public function productsList(): View
    {
        $products = Product::latest()->paginate(5);
        return view('products.index',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    
     public function create(): View
    {
                return view('products.create', [
                'Category' => Category::all(),
        ]);

    }
    
     public function store(Request $request): RedirectResponse
    {
         request()->validate([
            'name' => 'required',
            'qty' =>  'required|numeric|min:1',
            'price' =>  'required|numeric|min:1',
        ]);
        Product::create($request->all());
    
        return redirect()->route('productsList')
                        ->with('success','Product created successfully.');
    }
 
    public function edit(Product $product): View
    {
        return view('products.edit',compact('product'));
    }
    public function update(Request $request, Product $product): RedirectResponse
    {
         request()->validate([
            'name' => 'required',
            'qty' =>  'required|numeric',
            'price' =>  'required|numeric',
        ]);
    
        $product->update($request->all());
    
        return redirect()->route('productsList')
                        ->with('success','Product updated successfully');
    }
    
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();   
        return redirect()->route('productsList')
                        ->with('success','Product deleted successfully');
    }
    
    public function index()
    {
        $products = Product::latest()->paginate(5);
        return view('products', compact('products'));
    }
  
    public function productCart()
    {
        return view('cart');
    }
    public function addProducttoCart($id)
    {
        $product = Product::findOrFail($id);
        
        if($product->qty > 0){

        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
                        
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "description" => $product->description
            ];
       }
        session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product has been added to cart!');
        }else
        {
            return redirect()->back()->with('error', 'The Product Has 0 QTY!');
        }
    
    }
    
    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Product added to cart.');
        }
    }
  
    public function deleteProduct(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product successfully deleted.');
        }
    }


}
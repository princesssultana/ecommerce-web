<?php


namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        
        $allProducts = Product::all();

        return view('pages.product.index',compact('allProducts'));
    }


    public function create()
    {

        $categories= Category::all();
        
        return view('pages.product.create',compact('categories'));
    }

    public function store(Request $request)
    {
       

        $fileName ='';
        
        if($request->hasFile('image')){
            $file = $request->file('image');
            
            $fileName = date('Ymdhis') . str_replace(' ', '_', $file->getClientOriginalName());
          $file->storeAs('products', $fileName, 'public');
        }

       Product::create([
            'name' => $request->product_name,
            'category_id' => $request->category_id,
            'description' => $request->product_description,
            'price' => $request->product_price,
            'stock' => $request->product_stock,
            'stock' => $request->product_stock,
            'thumbnail'   => $fileName,  //
       ]);

       //notify()->success('⚡️ Product Created Successfully.');

       return redirect()->route('products.index');
        
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();

        return view ('pages.product.edit' , compact ('product', 'categories'));

    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $filename = $product->thumbnail;

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = date('Ymdhis') . str_replace(' ', '_', $file->getClientOriginalName());
            $file->storeAs('products', $filename, 'public');
        }

        $product->update([
            'name' => $request->product_name,
            'category_id' => $request->category_id,
            'description' => $request->product_description,
            'price' => $request->product_price,
            'stock' => $request->product_stock,
            'thumbnail'   => $filename,  //
            'status' => $request->status,
        ]);
         notify()->success('⚡️ Product Updated Successfully.');
    return redirect()->route('products.index');

    }


public function destroy($id)
{
    $product = Product::find($id);

    if(!$product){
        notify()->error('Product not found!');
        return redirect()->back();
    }

    $product->delete();

    notify()->success('⚡️ Product Deleted Successfully.');
    return redirect()->route('products.index');
}

    

    public function show($id) 
    {

        $product= Product::find($id);

        return view('pages.product.view', compact('product'));
        
    }
}

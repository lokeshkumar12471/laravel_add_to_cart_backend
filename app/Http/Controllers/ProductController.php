<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;



class ProductController extends Controller
{
    public function index(){
        $products=Product::get();
          $decryptedProducts = $products->map(function ($product) {
            $product->product_image = Crypt::decryptString($product->product_image);
            return $product;
});
        try{
        return response()->json([
            'products' => $decryptedProducts,
            'message'=>'successfully displaying',
            'status'=>200
        ]);
        }catch(error){
        return response()->json([
            'message'=>'products is not available',
            'status'=>200
        ]);
        }
    }

    public function store(Request $request){
         try{
        $validator=Validator::make($request->all(),[
        'product_title'=>'required',
        'product_price'=>'required',
        'product_image'=>'required',
        'product_checkbox'=>'required',
        'product_quantity'=>'required',
        'product_input'=>'required',
        ]);

        if($validator->fails())[
            'message' => 'please fill all the details',
            'errors'=> $validator->errors(),
            'status'=>404
        ];
        $product=new Product();
        $product->product_title=$request->product_title;
        $product->product_price=$request->product_price;
        $product->product_checkbox=$request->product_checkbox;
        $product->product_quantity= 1;
        $product->product_input=$request->product_input;
        if($request->hasFile('product_image')){
            $file =$request->file('product_image');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('upload/images',$filename);
            $product->product_image=encrypt($filename);
        }
        $product->save();
        return response()->json([
            'message'=>'Products Successfully Stored',
            'status'=>200
        ]);

        }catch(error){
            return response()->json(['message'=>'Product details was not stored successfully'],404);
        }
        }

          public function show($id){
            try{
             $product=Product::find($id);
            return response()->json(['product'=>$product,'message'=>'product detail successfully displaying','status'=>200]);
            }catch(error){
            return response()->json(['message'=>'product detail not displaying','status'=>404]);
            }
        }


    public function update(Request $request,$id){
         try{
        $validator=Validator::make($request->all(),[
        'product_title'=>'required',
        'product_price'=>'required',
        'product_image'=>'required',
        'product_checkbox'=>'required',
        'product_quantity'=>'required',
        'product_input'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
            'message' => 'please fill all the details',
            'errors'=> $validator->errors(),
            'status'=>404
            ]);
        }
        $product= Product::find($id);
        $product->product_title=$request->product_title;
        $product->product_price=$request->product_price;
        $product->product_checkbox=$request->product_checkbox;
        $product->product_quantity=1;
        $product->product_input=$request->product_input;
        if($request->hasFile('product_image')){
            $file =$request->file('product_image');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('upload/images',$filename);
            $product->product_image=encrypt($filename);
        }
        $product->update();

        return response()->json([
            'message'=>'Products Successfully Updated',
            'status'=>200
        ]);

        }catch(error){
            return response()->json(['message'=>'Product details was not updated successfully'],404);
        }
        }

        public function delete($id){
            $product=Product::find($id);
            if(!$product){
                return response()->json([
            'message'=>'The product was not deleted',
            'status'=>404]);
            }
             $product->delete();
            return response()->json([
            'message'=>'The product has been deleted',
            'status'=>200]);

        }

    }

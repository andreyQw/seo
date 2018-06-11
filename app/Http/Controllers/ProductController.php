<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateProductRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Model\Product;


class ProductController extends Controller
{
    public function listProducts()
    {
        $products = Product::where([
            'deleted' => 'existing',
        ])->get()->all();

        return view('admin.product.productList',[
            'products' => $products,
        ]);
    }

    public function addFormProduct()
    {
        return view('admin.product.addProductForm',[
            'action' => route('addNewProduct'),
        ]);
    }
    public function editFormProduct(Product $product)
    {
        return view('admin.product.addProductForm', [
            'product' => $product,
            'action' => route('editProduct', [
                $product
            ]),
        ]);
    }

    public function saveNewProduct(CreateProductRequest $request)
    {
        $data = $request->all();

        $product = new Product();
        $product->fill($data);
        $product->categorie_id = 1;
        $product->status = 'show';//hide
        $product->deleted = 'existing';//deleted

        $product->save();

        return redirect()->route('productList');
    }

    public function editProduct(CreateProductRequest $request, Product $product)
    {
        $data = $request->all();
        $product->fill($data);
        $product->categorie_id = 1;
        $product->save();

        return redirect(route('productList'));
    }

    public function deleteProduct(Product $product)
    {
        $product->deleted = 'deleted';
        $product->save();

        return redirect(route('productList'));
    }

    public function editProductStatus(Request $request)
    {
        $dataId = $request->id;
        $dataStatus = $request->status;
        $product = Product::where('id', $dataId)->first();
        $product->status = $dataStatus;
        $product->save();

        return true;
    }
    
}

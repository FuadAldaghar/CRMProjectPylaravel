<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Branch;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->search($request->search)
            ->latest()
            ->paginate(10);
            
             return $request->wantsJson()
            ? response()->json($products)
            : view('products.index', ['products' => $products]);
    }







    
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Factory
    {  $branches = Branch::where('status',1)->get();
        return view('products.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
 public function store(ProductStoreRequest $request)
{

    $productData = $request->validated();
// barcode is optional, if not provided, generate a unique barcode
     if (empty($productData['barcode'])) {
        $productData['barcode'] = 'PRD-' . time();
    }

    if ($request->hasFile('image')) {
        $productData['image'] = $request->file('image')->store('products', 'public');
    }
// dd($productData);
    Product::create($productData);

    return redirect()->route('products.index')
        ->with('success', __('product.success_creating'));
}

    /**
     * Display the specified resource.
     */
    public function show(Product $product): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Factory|View|\Illuminate\View\View
     */
    public function edit(Product $product)
    {   $branches = Branch::where('status',1)->get();
        return view('products.edit', compact('product', 'branches'));
        ///return view('products.edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return RedirectResponse
     */
    public function update(ProductUpdateRequest $request, Product $product): RedirectResponse
    {
        $productData = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $productData['image'] = $request->file('image')->store('products', 'public');
        }

        //$product->update($productData);
       Product::where('id', $product->id)->update($productData);
     

        return redirect()->route('products.index')
            ->with('success', __('product.success_updating'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return response()->json(['success' => true]);
    }
}

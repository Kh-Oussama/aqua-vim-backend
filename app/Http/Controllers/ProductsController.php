<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\ProductsImages;
use App\Models\ProductsSubcategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {


        $products = Product::with('images:product_id,image_path','mark:id,name','category:id,title','subcategory:id,title')->get();

        return response()->json([
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'description' => 'required',
            'mark_id' => 'required',
            'debit_max' => 'required',
            'hmt_max' => 'required',
            'power' => 'required',
            'liquid_temperature' => 'required',
            'engine_description' => 'required',
            'pump_description' => 'required',
            'voltage_description' => 'required',
            'productsSubcategory_id' => 'required',
            'pdf_path' => 'required',
            'image_path' => 'required',
            'first_image_path' => 'required',
            'second_image_path' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422);
        }

        try {
            $subcategory = ProductsSubcategory::findOrFail($request->input('productsSubcategory_id'));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'la catégorie n\'existe pas'], 422);
        }


        $Product = new Product();
        $Product->image_path = $request->file('image_path')->store('products');
        $Product->pdf_path = $request->file('pdf_path')->store('products-pdf');
        $Product->type = $request->input('type');
        $Product->description = $request->input('description');
        $Product->mark_id = $request->input('mark_id');
        $Product->debit_max = $request->input('debit_max');
        $Product->hmt_max = $request->input('hmt_max');
        $Product->power = $request->input('power');
        $Product->liquid_temperature = $request->input('liquid_temperature');
        $Product->engine_description = $request->input('engine_description');
        $Product->pump_description = $request->input('pump_description');
        $Product->voltage_description = $request->input('voltage_description');
        $Product->productsSubcategory_id = $request->input('productsSubcategory_id');
        $Product->productsCategory_id = $subcategory->productsCategory_id;
        $Product->save();

        $img1 = new ProductsImages();
        $img1->image_path = $request->file('first_image_path')->store('products');
        $img1->product_id = $Product->id;
        $img1->save();

        $img2 = new ProductsImages();
        $img2->image_path = $request->file('second_image_path')->store('products');
        $img2->product_id = $Product->id;
        $img2->save();

        if ($Product == null)
            return response()->json([
                'serverError' => 'le serveur a été arrêté',
            ], 422);

        return response()->json([
            'message' => 'Successfully created',
            'productsCategory' => $Product,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'le Produit n\'existe pas'], 422);
        }
        $product = Product::Where('id', '=', $id)->with('images:product_id,image_path','mark:id,name','category:id,title','subcategory:id,title')->get();

        return response()->json([
            'product' => $product,
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        try {
            $subcategory = ProductsSubcategory::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['ProductsCategoryNotFound' => 'la Category n\'existe pas'], 422);
        }

        $products = Product::Where('productsSubcategory_id', '=', $id)->with('images:product_id,image_path','mark:id,name')->get();

        return response()->json([
            'products' => $products,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        try {
            $Product = Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['ProductNotFound' => 'le produit n\'existe pas'], 422);
        }

        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'description' => 'required',
            'mark_id' => 'required',
            'debit_max' => 'required',
            'hmt_max' => 'required',
            'power' => 'required',
            'liquid_temperature' => 'required',
            'engine_description' => 'required',
            'pump_description' => 'required',
            'voltage_description' => 'required',
            'productsSubcategory_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422);
        }


        if ($request->image_path) {
            Storage::delete($Product->image_path);
            $Product->image_path = $request->file('image_path')->store('products-subcategories');
        }

        $Product->type = $request->input('type');
        $Product->description = $request->input('description');
        $Product->mark_id = $request->input('mark_id');
        $Product->debit_max = $request->input('debit_max');
        $Product->hmt_max = $request->input('hmt_max');
        $Product->power = $request->input('power');
        $Product->liquid_temperature = $request->input('liquid_temperature');
        $Product->engine_description = $request->input('engine_description');
        $Product->pump_description = $request->input('pump_description');
        $Product->voltage_description = $request->input('voltage_description');
        $Product->productsSubcategory_id = $request->input('productsSubcategory_id');
        $Product->save();

        return response()->json([
            'message' => 'Successfully updated',
            'product' => $Product,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(['notFoundError' => $e->getMessage()], 401);
        }

        try {
            $Product = Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['ProductNotFound' => 'le produit n\'existe pas'], 422);
        }

        Storage::delete($Product->image_path);
        Storage::delete($Product->pdf_path);
        $images = $Product->images;
        foreach ($images as $img) {
            Storage::delete($img->image_path);
            $img->delete();
        }

        $Product->delete();
        return response()->json([
            'message' => 'Successfully deleted',
        ], 201);
    }
}

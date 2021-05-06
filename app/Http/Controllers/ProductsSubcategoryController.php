<?php

namespace App\Http\Controllers;

use App\Models\ProductsCategory;
use App\Models\ProductsSubcategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;
use Illuminate\Support\Facades\Storage;

class ProductsSubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        try {
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        $validator = Validator::make($request->all(), [
            'image_path' => 'required',
            'title' => 'required',
            'productsCategory_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422);
        }


        try {
            $category = ProductsCategory::findOrFail($request->input('productsCategory_id'));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'la catégorie n\'existe pas'], 422);
        }

        $ProductsSubcategory = new ProductsSubcategory();
        $ProductsSubcategory->image_path=$request->file('image_path')->store('products-subcategories');
        $ProductsSubcategory->title=$request->input('title');
        $ProductsSubcategory->productsCategory_id=$request->input('productsCategory_id');
        $ProductsSubcategory->save();

        if ($ProductsSubcategory == null)
            return response()->json([
                'serverError' => 'le serveur a été arrêté',
            ], 422);

        return response()->json([
            'message' => 'Successfully created',
            'productsCategory' => $ProductsSubcategory,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $ProductsSubcategory = ProductsSubcategory::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'la Subcatégorie n\'existe pas'], 422);
        }
        $ProductsSubcategory = ProductsSubcategory::Where('id', '=', $id)->with('category:id,title')->get();

        return response()->json([
            'productsCategory' => $ProductsSubcategory,
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {

        try {
            $category = ProductsCategory::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['ProductsCategoryNotFound' => 'la Category n\'existe pas'], 422);
        }

        $subcategories = $category->productsSubcategories;

        return response()->json([
            'subcategories' => $subcategories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        try {
            $ProductsSubcategory = ProductsSubcategory::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['sliderNotFound' => 'la category n\'existe pas'], 422);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422);
        }

        if($request->image_path){
            Storage::delete($ProductsSubcategory->image_path);
            $ProductsSubcategory->image_path=$request->file('image_path')->store('products-subcategories');
        }

        $ProductsSubcategory->title=$request->input('title');
        $ProductsSubcategory->save();

        return response()->json([
            'message' => 'Successfully updated',
            'productsSubcategory' => $ProductsSubcategory,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(['notFoundError' => $e->getMessage()], 401);
        }

        try {
            $ProductsSubcategory = ProductsSubcategory::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'la subcategory n\'existe pas'], 422);
        }
        Storage::delete($ProductsSubcategory->image_path);
        $ProductsSubcategory->delete();
        return response()->json([
            'message' => 'Successfully deleted',
        ], 201);
    }
}

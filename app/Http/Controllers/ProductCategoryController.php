<?php

namespace App\Http\Controllers;


use App\Models\ProductsCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
        $categories = ProductsCategory::all();
        return response()->json([
            'categories' => $categories,
        ]);
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
            'subtitle' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422);
        }

        $ProductsCategory = new ProductsCategory();
        $ProductsCategory->image_path=$request->file('image_path')->store('products-categories');
        $ProductsCategory->title=$request->input('title');
        $ProductsCategory->subtitle=$request->input('subtitle');
        $ProductsCategory->description=$request->input('description');
        $ProductsCategory->save();

        if ($ProductsCategory == null)
            return response()->json([
                'serverError' => 'le serveur a été arrêté',
            ], 422);
        return response()->json([
            'message' => 'Successfully created',
            'productsCategory' => $ProductsCategory,
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
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        try {
            $ProductsCategory = ProductsCategory::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'la Catégorie n\'existe pas'], 422);
        }

        return response()->json([
            'productsCategory' => $ProductsCategory,
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            $ProductsCategory = ProductsCategory::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['sliderNotFound' => 'la category n\'existe pas'], 422);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422);
        }

        if($request->image_path){
            Storage::delete($ProductsCategory->image_path);
            $ProductsCategory->image_path=$request->file('image_path')->store('products-categories');
        }

        $ProductsCategory->title=$request->input('title');
        $ProductsCategory->subtitle=$request->input('subtitle');
        $ProductsCategory->description=$request->input('description');
        $ProductsCategory->save();

        return response()->json([
            'message' => 'Successfully updated',
            'productsCategory' => $ProductsCategory,
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
            $ProductsCategory = ProductsCategory::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'la Category n\'existe pas'], 422);
        }
        Storage::delete($ProductsCategory->image_path);
        $ProductsCategory->delete();
        return response()->json([
            'message' => 'Successfully deleted',
        ], 201);
    }
}

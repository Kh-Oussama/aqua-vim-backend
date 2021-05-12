<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\ProductsCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $marks = Mark::all();
        return response()->json([
            'marks' => $marks,
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
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422);
        }

        $mark = new Mark();
        $mark->image_path=$request->file('image_path')->store('marks');
        $mark->name=$request->input('name');
         $mark->save();

        if ($mark == null)
            return response()->json([
                'serverError' => 'le serveur a été arrêté',
            ], 422);
        return response()->json([
            'message' => 'Successfully created',
            'mark' => $mark,
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
            $mark = Mark::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'la mark n\'existe pas'], 422);
        }

        return response()->json([
            'mark' => $mark,
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
            $mark = Mark::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['markNotFound' => 'la marque n\'existe pas'], 422);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422);
        }

        if($request->image_path){
            Storage::delete($mark->image_path);
            $mark->image_path=$request->file('image_path')->store('marks');
        }

        $mark->name=$request->input('name');
        $mark->save();

        return response()->json([
            'message' => 'Successfully updated',
            'mark' => $mark,
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
            $mark = Mark::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'la marque n\'existe pas'], 422);
        }
        Storage::delete($mark->image_path);
        $mark->delete();
        return response()->json([
            'message' => 'Successfully deleted',
        ], 201);
    }
}

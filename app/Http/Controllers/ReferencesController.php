<?php

namespace App\Http\Controllers;

use App\Models\Reference;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;
use Illuminate\Support\Facades\Storage;

class ReferencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        $references = Reference::with('category:id,name','service:id,name')->get();
        return response()->json([
            'references' => $references,
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
            'state' => 'required',
            'service_id' => 'required',
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422);
        }

        $reference = new Reference;
        $reference->image_path=$request->file('image_path')->store('references');
        $reference->name=$request->input('name');
        $reference->service_id=$request->input('service_id');
        $reference->category_id=$request->input('category_id');
        $reference->state=$request->input('state');
        $reference->save();

        if ($reference == null)
            return response()->json([
                'serverError' => 'le serveur a été arrêté',
            ], 422);
        return response()->json([
            'message' => 'Successfully created',
            'reference' => $reference,
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
            $reference = Reference::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'la réference n\'existe pas'], 422);
        }
        $reference = Reference::Where('id','=',$id)->with('category:id,name','service:id,name')->get();
        return response()->json([
            'reference' => $reference,
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
            $reference = Reference::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['sliderNotFound' => 'la réference n\'existe pas'], 422);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'service_id' => 'required',
            'category_id' => 'required',
            'state' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422);
        }

        if($request->image_path){
            Storage::delete($reference->image_path);
            $reference->image_path=$request->file('image_path')->store('references');
        }
        $reference->name=$request->input('name');
        $reference->service_id=$request->input('service_id');
        $reference->category_id=$request->input('category_id');
        $reference->state=$request->input('state');
        $reference->save();

        return response()->json([
            'message' => 'Successfully updated',
            'reference' => $reference,
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
            $reference = Reference::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'la réference n\'existe pas'], 422);
        }
        Storage::delete($reference->image_path);
        $reference->delete();
        return response()->json([
            'message' => 'Successfully deleted',
        ], 201);
    }
}

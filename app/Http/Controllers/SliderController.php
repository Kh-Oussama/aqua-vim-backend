<?php

namespace App\Http\Controllers;

use App\Models\slider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
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
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()],401);
        }
        $sliders = slider::all();
        return response()->json([
            'sliders' => $sliders,
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
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()],401);
        }
        $validator = Validator::make($request->all(), [
            'image_path' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422);
        }
        $input = $request->all();
        $slider = slider::create($input);
        if ($slider == null)  return response()->json('an error occurred', 422);
        return response()->json([
            'message' => 'Successfully created',
            'slider' => $slider,
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
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()],401);
        }

        try
        {
            $slider = Slider::findOrFail($id);
        }catch(ModelNotFoundException $e) {
            return response()->json(['error' => 'the slider not found'],422);
        }
        return response()->json([
            'slider' => $slider,
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
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()],401);
        }

        try {
            $slider = Slider::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return response()->json(['error' => 'the slider not found'],422);
        }

        $validator = Validator::make($request->all(), [
            'image_path' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422);
        }
        $input = $request->all();
        $slider->update($input);
        return response()->json([
            'message' => 'Successfully updated',
            'slider' => $slider,
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
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()],401);
        }

        try {
            $slider = Slider::findOrFail($id);
        }catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'the slider not found'],422);
        }

        $slider->delete();
        return response()->json([
            'message' => 'Successfully deleted',
        ], 201);
    }
}

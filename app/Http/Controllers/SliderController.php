<?php

namespace App\Http\Controllers;

use App\Models\slider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
//        sleep(5200);
        try {
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
        $sliders = slider::all();
        return response()->json([
            'sliders' => $sliders,
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
            'image_path' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422);
        }

        $slider = new Slider;
        $slider->image_path=$request->file('image_path')->store('sliders');
        $slider->save();
        if ($slider == null)
            return response()->json([
                'serverError' => 'le serveur a été arrêté',
            ], 422);
        return response()->json([
            'message' => 'Successfully created',
            'slider' => $slider,
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
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        try {
            $slider = Slider::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'the slider not found'], 422);
        }
        return response()->json([
            'slider' => $slider,
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
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
            $slider = Slider::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['sliderNotFound' => 'the slider not found'], 422);
        }

        $validator = Validator::make($request->all(), [
            'image_path' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422);
        }
        Storage::delete($slider->image_path);
        $slider->image_path=$request->file('image_path')->store('sliders');
        $slider->save();
        return response()->json([
            'message' => 'Successfully updated',
            'slider' => $slider,
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
            $slider = Slider::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'the slider not found'], 422);
        }
        Storage::delete($slider->image_path);
        $slider->delete();
        return response()->json([
            'message' => 'Successfully deleted',
        ], 201);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $events = Event::all();
        return response()->json([
            'events' => $events,
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
            'title' => 'required',
            'date' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422);
        }

        $Event = new Event();
        $Event->title=$request->input('title');
        $Event->description=$request->input('description');
        $Event->date=$request->input('date');
        $Event->save();

        if ($Event == null)
            return response()->json([
                'serverError' => 'le serveur a été arrêté',
            ], 422);
        return response()->json([
            'message' => 'Successfully created',
            'event' => $Event,
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
            $event = Event::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'l\'evenement n\'existe pas'], 422);
        }

        return response()->json([
            'event' => $event,
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
            $event = Event::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['eventNotFound' => 'l\'evenment n\'existe pas'], 422);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'date' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422);
        }



        $event->title=$request->input('title');
        $event->description=$request->input('description');
        $event->date=$request->input('date');
        $event->save();

        return response()->json([
            'message' => 'Successfully updated',
            'event' => $event,
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
            $event = Event::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'l\'evenement n\'existe pas'], 422);
        }
        $event->delete();
        return response()->json([
            'message' => 'Successfully deleted',
        ], 201);
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Announcement::active()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAnnouncementRequest $request)
    {
        Announcement::create($request->all());
        return response()->json(['message' => 'Announcement created successfully!'], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        return $announcement;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcement $announcement)
    {
        $announcement->update($request->all());
        return response()->json(['message' => 'Announcement Updated successfully!'], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return response()->json(['message' => "Announcement deleted"]);
    }
}

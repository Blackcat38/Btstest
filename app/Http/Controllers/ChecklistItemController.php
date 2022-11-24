<?php

namespace App\Http\Controllers;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ChecklistItemController extends Controller
{
    protected $user;
 
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return ChecklistItem::find($id);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $data = $request->only('items_name');
        $validator = Validator::make($data, [
            'items_name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $items = ChecklistItem::create([
            'checklist_id' => $id,
            'items_name' => $request->items_name
        ]);

        //Product created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Created successfully',
            'data' => $items
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChecklistItem  $checklistItem
     * @return \Illuminate\Http\Response
     */
    public function show($id, $id_items)
    {
        return ChecklistItem::where(['checklist_id' => $id, 'id' => $id_items])->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChecklistItem  $checklistItem
     * @return \Illuminate\Http\Response
     */
    public function edit(ChecklistItem $checklistItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChecklistItem  $checklistItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $id_items)
    {
        $data = $request->only('items_name');
        $validator = Validator::make($data, [
            'items_name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $items = ChecklistItem::find($id_items);
        $items->items_name = $request->items_name;
        $items->save();

        //Product created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Update successfully',
            'data' => $items
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChecklistItem  $checklistItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $id_items)
    {
        ChecklistItem::where('id', $id_items)->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully'
        ], Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\HubItem;
use App\Services\HubItemService;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;

class HubItemController extends Controller
{

    /**
     * Create a new controller instance
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = HubItem::orderBy('date', 'desc')->get();
        $latest = 0;

        /* find latest entry */
        foreach($items as $i){

            if($i->date <= \Carbon\Carbon::now()){
                $latest = $i->id;
                break;
            }
        }
        return view('hub.index')->with(
            array('items' => $items, 'latest' => $latest)
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hub.form')->with('method', 'POST');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'       => 'required',
            'date'        => 'required',
            'type_name'   => 'required',
        ]);

        return HubItemService::storeHubIem($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = HubItem::find($id);
        $type = strtolower(str_replace("App\\Models\\", "", $item->hub_itemable_type));

        return view('hub.form')->with(
            array('method' => 'PUT', 'item' => $item, 'type' => $type)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'       => 'required',
            'date'        => 'required',
        ]);

        return HubItemService::updateHubItem($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $item = HubItem::find($id);
            $item->hubItemable->delete();
        } catch (Exception $e) {

        }
        return redirect('/');
    }
}

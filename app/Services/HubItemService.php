<?php
/**
 * Created by PhpStorm.
 * User: donherre
 * Date: 5/10/16
 * Time: 2:02 PM
 */

namespace app\Services;

use App\Models\Deliverable;
use App\Models\HubFile;
use App\Models\Meeting;
use App\Models\Milestone;

use App\Http\Requests;
use App\Models\HubItem;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exception;

class HubItemService
{
    /**
     * Store a new project hub item based of $request
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function storeHubIem($request){

        $fail_mess = array();

        /*
         * Attempt to create a HubItem
         */
        try{
            $item = HubItem::create($request->input());
            \Session::flash('success', 'The item was successfully stored.');
        } catch (Exception $e){
            \Session::flash('fail', array_push($fail_mess,'The item was not created.'));
        }

        // date not getting caught on creation
        $item->date = $request->input('date');

        // polymorphic object
        $t = null;

        /*
         * Create polymorphic relationship based on type
         */
        try {
            if ($request->input('type_name') == 'deliverable') {
                $t = Deliverable::create($request->input());
                $t->hubItems()->save($item);

            } elseif ($request->input('type_name') == 'meeting') {
                $t = Meeting::create($request->input());
                $t->hubItems()->save($item);

            } elseif ($request->input('type_name') == 'milestone') {
                $t = Milestone::create($request->input());
                $t->hubItems()->save($item);

            }
        } catch (Exception $e) {
            \Session::flash('fail', array_push($fail_mess,'The item type was not created.'));
        }

        if($request->hasFile('files')){
            self::storeFiles($request, $t);
        }


        return redirect('/');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function updateHubItem($request, $id){
        
        $item = HubItem::find($id);
        $item->title        = $request->input('title');
        $item->description  = $request->input('description');
        $item->date         = $request->input('date');
        $item->save();

        // polymorphic type
        $t = null;

        /*
         * Make changes on polymorphic relationship based on type
         */
        if ($item->hub_itemable_type == 'App\\Models\\Deliverable'){

            $t = Deliverable::find($item->hub_itemable_id);
            $t->save();

        } elseif ($item->hub_itemable_type == 'App\\Models\\Meeting'){

            $t = Meeting::find($item->hub_itemable_id);
            $t->objectives = $request->input('objectives');
            $t->notes = $request->input('notes');
            $t->attendees = $request->input('attendees');
            $t->action_items = $request->input('action_items');
            $t->save();

        } elseif ($item->hub_itemable_type == 'App\\Models\\Milestone') {
            $t = Milestone::find($item->hub_itemable_id);
            $t->save();

        }

        if($request->hasFile('files')){
            self::storeFiles($request, $t);
        }

        return redirect('/');
        
    }

    /**
     * This method stores files from user input form on the server.
     * @param $request
     * @param $type
     */
    private static function storeFiles($request, $type){

        $files = $request->file('files');

        foreach($files as $f){

            try {
                $file = HubFile::create([
                    'name' => $f->getClientOriginalName(),
                    'size' => ($f->getSize() / 1000) . ' KB',
                ]);
            } catch (Exception $e) {
                \Session::flash('fail', array_push($fail_mess,'The file '. $f->getClientOriginalName() . ' could not be uploadedl.'));
            }

            $type->files()->save($file);



            $f->move(public_path($file->getStoragePath()), $file->name);

        }

    }
}
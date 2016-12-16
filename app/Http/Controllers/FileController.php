<?php

namespace App\Http\Controllers;

use App\Models\HubFile;
use File;
use Illuminate\Http\Request;

use App\Http\Requests;

class FileController extends Controller
{

    /**
     * Create a new controller instance
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $r_id = 0;

        try {
            $file = HubFile::find($id);
            $r_id = $file->hubFileable->hubItems->id;
            File::delete(public_path().$file->getStoragePath().$file->name);
            $file->delete();
        } catch (Exception $e) {
            return redirect('/hub');
        }
        return redirect('/' . $r_id . '/edit');
    }
}

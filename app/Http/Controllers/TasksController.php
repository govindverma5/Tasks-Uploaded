<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TasksController extends Controller
{
    public function index(Request $request)
    {
        $task = Tasks::paginate(100);
        return view('tasks.index')->with(compact('task'));
    }

    public function create(Request $request){
        $checkName = Tasks::where('name',$request->name)->first();
        if($checkName){
            return response(["status" => 400, 'message' => 'Name Already Exist!']);
        }else{
            $data = Tasks::create($request->all());
            $task = Tasks::get();
            return view('tasks.list')->with(compact('task'));
        }
    }

    public function destroy(Request $request){
        $data = Tasks::find($request->id)->delete();
        $task = Tasks::get();
        return view('tasks.list')->with(compact('task'));
    }

    public function Status(Request $request){
        if($request->status == '2'){
            $status = 1;
        }if($request->status == '1'){
            $status = 2;
        }
        $data = Tasks::where('id',$request->id)->first();
        $data->status = $status;
        $data->save();
        $task = Tasks::where('status','2')->get();
        return view('tasks.list')->with(compact('task'));
    }

    public function show(Request $request){
        $task = Tasks::get();
        return view('tasks.list')->with(compact('task'));
    }
}

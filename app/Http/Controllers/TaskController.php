<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\task;
use Carbon\Carbon;
use Illuminate\Console\View\Components\Task as ComponentsTask;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        return view('tasks.task');
    }
    public function tasks()
    {
        $data=Task::latest()->paginate(5);

        return view('tasks.tasks',['data'=>$data]);
    }
    public function store(Request $request)
    {

            $validated=Validator::make($request->all(),[
              'title'=>'required',
              'description'=>'required',


            ]);
            if ($validated->passes()) {
                $task=new task();
                $task->title=$request->title;
                $task->description=$request->description;

                $task->priority=$request->priority;
                $task->due_date=$request->due_date;

                $task->save();
                session()->flash('success','Task Added Successfully!');
                return response()->json([
                 'status'=>true
                ]);
            }else{
                return response()->json([
                    'status'=>false,
                    'errors'=>$validated->errors()
                   ]);
            }



    }
    public function create(){
        return view('tasks.create');
    }

    public function edit($id){
        $edit=Task::find($id);
        return view('tasks.edit',compact('edit'));
    }
    public function update(Request $request, $id)
    {
        $validated=Validator::make($request->all(),[
            'title'=>'required',
            'description'=>'required',
          ]);
          if ($validated->passes()) {
              $task=task::find($id);
              $task->title=$request->title;
              $task->description=$request->description;
              $task->priority=$request->priority;
              $task->due_date=$request->due_date;
              $task->save();
              session()->flash('success','Task updated Successfully!');
              return response()->json([
               'status'=>true
              ]);
          }else{
              return response()->json([
                  'status'=>false,
                  'errors'=>$validated->errors()
                 ]);
          }

    }
    public function destroy(Request $request, $id)
    {
        // Find the item
        $item = Task::findOrFail($id);

        // Delete the item
        $item->delete();

        // Return a response
        return redirect()->back()->with('delete','Task deleted Successfully!');
    }

    public function complete($id)
    {
        // Find the task
        $task = Task::findOrFail($id);

        // Update task status to "completed" or perform any necessary logic
        $task->priority=2;
        $task->save();

        // Return a response
        return redirect()->back()->with('success','Task Updated Successfully!');
    }

}

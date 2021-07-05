<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;


class TasksController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $tasks = Task::orderBy('id','desc')->paginate(25);
        // return view('tasks.index',['tasks'=>$tasks]);
        
        $data = [];
        if(\Auth::check()) {
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at','desc')->paginate(10);
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }
        return view('tasks.index',$data);
        
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;
        return view('tasks.create',['task'=>$task]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation
        $request->validate([
            'content' => 'required|max:255',
            'status' => 'required|max:10',
        ]);
        
        // $task = new Task;
        // $task->content = $request->content;
        // $task->status = $request->status;
        // //追記
        // $task->user_id = auth()->id();
        // // dd($request->all());
        // $task->save();
        
        $request->user()->tasks()->create([
            'content' => $request->content,
            'status' => $request->status,
            'user_id' => auth()->id(),
        ]);
        
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $task = Task::findOrFail($id);
        // return view('tasks.show',['task'=>$task]);
       
        // return redirect('/');
        
        
        $task = Task::findOrFail($id);
        $user = \Auth::user();
        // dd($task);
        
        //$userがNULL（未ログイン）の場合の確認
        if(!empty($user)) {
            //ログイン中のユーザーのidとタスクのuser_idの一致を確認
            if($task->user_id === $user->id) {
                return view('tasks.show',['task'=>$task]);
            } 
        }
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $user = \Auth::user();
        
        if(!empty($user)) {
            if($task->user_id === $user->id) {
                return view('tasks.edit',['task'=>$task]);
            }
        }
        return redirect('/');
        
        // return view('tasks.edit',['task'=>$task]);
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
        //validation
        $request->validate([
            'content' => 'required|max:255',
            'status' => 'required|max:10',
        ]);

        
        $task = Task::findOrFail($id);
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();
        
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        // $task->delete();
        if(\Auth::id() === $task->user_id) {
            $task->delete();
        }
        
        return redirect('/');
    }
}

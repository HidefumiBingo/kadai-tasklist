@extends('layouts.app')

@section('content')

<!-- ここにページ毎のコンテンツを書く -->

    <h1>id = {{ $task->id }}のタスク詳細</h1>
    
    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <th>{{ $task->id }}</th>
        </tr>
        <tr>
            <th>タスク</th>
            <td>{{ $task->content }}</td>
        </tr>
        <tr>
            <th>ステータス</th>
            <td>{{ $task->status }}</td>
        </tr>
    </table>
    
    {{-- 編集画面リンク --}}
    {!! link_to_route('tasks.edit','タスクの編集',[$task->id],['class'=>'btn btn-light']) !!}
    
    {{-- タスク完了ボタン --}}
    {!! Form::model($task,['route'=>['tasks.destroy',$task->id],'method'=>'delete']) !!}
        {!! Form::submit('完了',['class'=>'btn btn-danger']) !!}
    {!! Form::close() !!}


@endsection

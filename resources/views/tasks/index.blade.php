@extends('layouts.app')

@section('content')

<!-- ここにページ毎のコンテンツを書く -->

    @if(Auth::check())
        <h1>{{ Auth::user()->name }} タスク一覧</h1>
        @if(count($tasks) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>タスク</th>
                        <th>ステータス</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                    <tr>
                        <td>{!! link_to_route('tasks.show',$task->id,[$task->id]); !!}</td>
                        <td>{{ $task->content }}</td>
                        <td>{{ $task->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
                
        @endif
        
        {{ $tasks->links() }}
        
        {{-- 新規作成画面リンク --}}
        {!! link_to_route('tasks.create','タスクの追加',[],['class'=>'btn btn-primary']); !!}
    
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to the Tasklist!</h1>
                {{-- ユーザ登録ページへのリンク --}}
                {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif
    
@endsection

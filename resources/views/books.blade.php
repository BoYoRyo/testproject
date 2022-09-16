<!-- resources/views/books.blade.php -->
@extends('layouts.app')
@section('content')

    <!-- Bootstrapの定形コード… -->
    <div class="card-body">
        <div class="card-title offset-md-3">
            <h3>本の登録</h3>
        </div>
        <!-- 登録完了メッセージ -->
        @if(session("message"))
            <div class="alert alert-success text-center">
                {{session("message")}}
            </div>
        @endif
        <!-- 本のタイトル -->
        <form action="{{ url('books') }}" method="POST" class="form-horizontal">
            @csrf
            <div class="form-group col-sm-6 offset-md-3">
                <label for="book" class="col-sm-3 control-label">タイトル</label>
                <input type="text" name="item_name" id="book" placeholder="タイトル" class="form-control @if($errors->has('item_name')) is-invalid @endif" value="{{ old('item_name') }}">
                <div class="invalid-feedback">
                    @foreach ($errors->get('item_name') as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            </div>
                
            <div class="row">
                <div class="form-group col-sm-3 offset-md-3 col-auto">
                    <label for="number" class="col-sm-3 control-label">冊数</label>
                    <input type="number" name="item_number" id="number" placeholder="冊数" class="form-control col-auto @if($errors->has('item_number')) is-invalid @endif" value="{{ old('item_number') }}">
                    <div class="invalid-feedback">
                        @foreach ($errors->get('item_number') as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                    
                </div>
                
                <div class="form-group col-sm-3 col-auto">
                    <label for="amount" class="col-sm-3 control-label">金額</label>
                    <input type="number" name="item_amount" id="amount" placeholder="金額" class="form-control form-inline @if($errors->has('item_amount')) is-invalid @endif" value="{{ old('item_amount') }}">
                    <div class="invalid-feedback">
                        @foreach ($errors->get('item_amount') as $error)
                        {{ $error }}<br>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-sm-6 offset-md-3">
                    <label for="published" class="col-sm-3 control-label">公開日</label>
                    <input type="date" name="published" id="published" placeholder="公開日" class="form-control @if($errors->has('published')) is-invalid @endif" value="{{ old('published') }}">
                    <div class="invalid-feedback">
                        @foreach ($errors->get('published') as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                </div>
            </div><br>
            
            <!-- 本 登録ボタン -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6 offset-md-3 ">
                    <button type="submit" class="btn btn-primary">
                        登録
                    </button>
                </div>
            </div>
        </form>
    </div><br>
    
    <!-- Book: 既に登録されてる本のリスト -->
    <!-- 現在の本 -->
    @if (count($books) > 0)
        <div class="card-body">
            <div class="card-body">
                <table class="table table-striped task-table">
                    <!-- テーブルヘッダ -->
                    <thead>
                        <th>タイトル</th>
                        <th>冊数</th>
                        <th>金額</th>
                        <th>公開日</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </thead>
                    <!-- テーブル本体 -->
                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <!-- 本タイトル -->
                                <td class="table-text">
                                    <div>{{ $book->item_name }}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $book->item_number }}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ number_format( $book->item_amount )}}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ date('Y/m/d', strtotime($book->published)) }}</div>
                                </td>
                                <!-- 本: 更新ボタン -->
                                <td>
                                    <form action="{{url('booksedit/' . $book->id)}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            更新
                                        </button>
                                    </form>
                                </td>
                                <!-- 本: 削除ボタン -->
                                <td>
                                    <form action="{{url('book/' . $book->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            削除
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 offset-md-5">
                {{ $books->links('pagination::bootstrap-4') }}
            </div>
        </div>
    @endif

@endsection
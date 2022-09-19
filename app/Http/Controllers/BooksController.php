<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BooksController extends Controller
{

    //登録
    public function store(Request $request){
        //変数の出力　確認用
        //dd($request);

        //バリデーション
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|min:3|max:255',
            'item_image' => 'required',
            'item_number' => 'required|min:1|max:3',
            'item_amount' => 'required|max:6',
            'published' => 'required',
        ]);

        //バリデーション:エラー
        if ($validator->fails()) {
            return redirect('/')
            ->withInput()
            ->withErrors($validator);
        }

        $file = $request->file("item_image");
        if(!empty($file)){
            $filename = $file->getClientOriginalName();//ファイル名を取得
            $file->move("./upload/",$filename);//ファイルを移動
        } else {
            $filename = "";
        }

        // Eloquentモデル（登録処理）
        $books = new Book;
        $books->user_id = Auth::user()->id;
        $books->item_name = $request->item_name;
        $books->item_image = $filename;
        $books->item_number = $request->item_number;
        $books->item_amount = $request->item_amount;
        $books->published = $request->published;
        $books->save();
        return redirect('/')->with("message", "本登録が完了しました。");
        }

    //更新
    public function update(Request $request){
        //バリデーション
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'item_name' => 'required|min:3|max:255',
            'item_number' => 'required|min:1|max:3',
            'item_amount' => 'required|max:6',
            'published' => 'required',
        ]);
        //バリデーション:エラー
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }
        //データ更新
        $books = Book::where("user_id",Auth::user()->id)->find($request->id);
        $books->item_name = $request->item_name;
        $books->item_number = $request->item_number;
        $books->item_amount = $request->item_amount;
        $books->published = $request->published;
        $books->save();
        return redirect('/');
    }

    //一覧表示
    public function index(){
        $books = Book::where("user_id",Auth::user()->id)->orderBy("created_at", "asc")->paginate(5);
        return view('books', ["books" => $books]);
    }

    //更新画面へ遷移
    public function toedit($book_id){
        $books = Book::where("user_id",Auth::user()->id)->find($book_id);
        //{books}id値を取得=>Book $books id値の１レコード取得
        return view("booksedit", ["book" => $books]);
    }

    //削除
    public function destroy(Book $book){
        $book->delete();
        return redirect("/");
    }

    //コンストラクタ（このクラスが呼ばれたら最初に処理をする）ログインしてなかったらAuthというログイン画面（larabelの仕様）に遷移するような作り
    public function __construct()
    {
        $this->middleware('auth');
    }
}

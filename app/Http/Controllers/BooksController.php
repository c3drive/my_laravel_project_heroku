<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Validator;
use Auth;

class BooksController extends Controller{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // ダッシュボード
    public function index(){
        $books = Book::where('user_id', Auth::user()->id)
                ->orderBy('created_at', 'asc')
                ->paginate(3);
        // dddを定義してブラウザ実行するとデバッグモード情報がブラウザで確認できる
        // ddd($books);
        return view('books', ['books' => $books]);
    }
    
    // 更新
    public function update(Request $request){
        // ddを定義してブラウザ実行するとvar_dump($request)と同等の情報がブラウザで確認できる
        // dd($request);
        // バリデーション
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'item_name' => 'required|min:3|max:255',
            'item_number' => 'required|min:1|max:3',
            'item_amount' => 'required|max:6',
            'published' => 'required',
        ]);
        
        // バリデーションエラー
        // ユーザ入力値をセッション値に保存。参照する時は{{ old('name XXX') }}
        // バリデーションエラー内容を$errorへ渡す
        if($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }
        
        // データ更新
        // whereはwhere句、findは主キー検索
        $books = Book::where('user_id', Auth::user()->id)->find($request->id);
        $books->item_name = $request->item_name;
        $books->item_number = $request->item_number;
        $books->item_amount = $request->item_amount;
        $books->published = $request->published;
        $books->save();
        return redirect('/');
    }
    // 登録
    public function store(Request $request){
        // ddを定義してブラウザ実行するとvar_dump($request)と同等の情報がブラウザで確認できる
        // dd($request);
        
        // バリデーション
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|min:3|max:255',
            'item_number' => 'required|integer|min:1|max:3',
            'item_amount' => 'required|max:6',
            'published' => 'required|date',
        ]);
    
        // バリデーションエラー
        if($validator->fails()) {
             // ユーザ入力値をセッション値に保存。参照する時は{{ old('name XXX') }}
             // バリデーションエラー内容を$errorへ渡す
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }
        
        $file = $request->file('item_img');
        if(!empty($file)) {
            $filename = $file->getClientOriginalName();
            $move = $file->move('../upload/', $filename); // ファイルを移動
        }else{
            $filename = "";
        }
    
        // Eloquentモデル（登録処理）
        $books = new Book;
        $books->user_id = Auth::user()->id;
        $books->item_name = $request->item_name;
        $books->item_number = $request->item_number;
        $books->item_amount = $request->item_amount;
        $books->item_img = $filename;
        $books->published = $request->published;
        $books->save();
        return redirect('/')
            ->with('message', '本登録が完了しました');
    }
    
    // 更新画面
    public function edit($book_id){
        $books = Book::where('user_id', Auth::user()->id)->find($book_id);
        return view('/booksedit', ['book' => $books]);
    }
    
    // 削除画面
    public function delete(Book $book){
        $book->delete();
        return redirect('/');
    }
}

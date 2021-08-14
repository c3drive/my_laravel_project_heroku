
<!-- resources/views/booksedit.blade.php -->
@extends('layouts.app')
@section('content')
<div class="row container">
    <div class="col-md-12">

    <!-- バリデーションエラーの表示に使用-->
    @include('common.errors')
    <!-- バリデーションエラーの表示に使用-->

    <form action="{{ url('books/update') }}" method="POST">

        <!-- 本のタイトル -->
        <div class="form-group">
            <label for="item-name">Book</label>
            <input type="text" name="item_name" class="form-control" value="{{$book->item_name}}">
        </div>
        
        <div class="form-group ">
            <label for="item_number">数</label>
            <input type="text" name="item_number" class="form-control" value="{{$book->item_number}}">
        </div>
        
        <div class="form-group">
            <label for="item_amount">金額</label>
            <input type="text" name="item_amount" class="form-control" value="{{$book->item_amount}}">
        </div>
        
        <div class="form-group">
            <label for="published">公開日</label>
            <input type="datetime" name="published" class="form-control" value="{{$book->published}}">
        </div>
        <div class="col-sm-6">
            <label>画像</label>
            <input type="file" name="item_img">
        </div>

        <!-- 本 Save/ Back -->
        <div class="well well-sm">
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link pull-right" href="{{ url('/') }}">Back</a>
        </div>
        <!-- id値を送信 -->
        <input type="hidden" name="id" value="{{$book->id}}">
        @csrf
    </form>
    </div>
</div>
@endsection



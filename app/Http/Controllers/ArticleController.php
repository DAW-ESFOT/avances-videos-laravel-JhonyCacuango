<?php

namespace App\Http\Controllers;

use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\ArticleCollection;
use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{


    private static $messages=[
        'required'=>'El campo :attribute es obligatorio.',
        'body.required'=>'El body no es valido',

    ];



    public function index()
    {

        //return new ArticleResource(Articles::all());
        return new ArticleCollection(Article::paginate(10));


    }

    public function show(Article $article)
    {


        //return new ArticleResource($article);
        return response()->json(new ArticleResource($article), 200);

    }

    public function image(Article $article){
        return response()->download(public_path(Storage::url($article->image)), $article->title);
    }



    public function store(Request $request)
    {
//

        $request ->validate([
            'title' => 'required|string|unique:articles|max:255',
            'body' => 'required',
            'category_id'=>'required|exists:categories,id',
            'image' => 'required|image|dimensions:min_width=200,min_height=200',
        ],self::$messages);


       // $article = Article::create($request->all());
        $article = new Article($request->all());
        $path = $request->image->store('public/articles');
       // $path = $request->image->storeAs('public/articles', $request->user()->id . '_' . $article->title . '.' . $request->image->extension());

        $article->image = $path;
        $article->save();

        return response()->json(new ArticleResource($article), 201);
    }

    public function update(Request $request, Article $article)
    {
        $request ->validate([
            'title' => 'required|string|unique:articles,title,'.$article->id.'|max:255',
            'body' => 'required',
            'category_id'=>'required|exists:categories,id'

        ],self::$messages);

        $article->update($request->all());
        return response()->json($article, 200);
    }

    public function delete(Article $article)
    {
        $article->delete();
        return response()->json(null, 204);
    }


}

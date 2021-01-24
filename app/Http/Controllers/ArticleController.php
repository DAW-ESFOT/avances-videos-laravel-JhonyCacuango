<?php

namespace App\Http\Controllers;

use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\ArticleCollection;
use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{


    private static $messages=[
        'required'=>'El campo :attribute es obligatorio.',
        'body.required'=>'El body no es valido',

    ];



    public function index()
    {
        //return Article::all();
        //return new ArticleResource(Articles::all());
        return new ArticleCollection(Article::paginate(10));
        //return response()->json(new ArticleResource($article),200);
        //return ArticleResource::collection(Articles::all(),200);
        //return  response()->json(new ArticleCollection(Article::all()),200);


    }

    public function show(Article $article)
    {


        //return new ArticleResource($article);
        return response()->json(new ArticleResource($article), 200);

    }

    public function store(Request $request)
    {
//        $messages=[
//            'required'=>'Elcampo :attribute es obligatorio.',
//            'body'=>'Elc body no es valido.',
//
//        ];

        $request ->validate([
            'title' => 'required|string|unique:articles|max:255',
            'body' => 'required',
            'category_id'=>'required|exists:categories,id'

        ],self::$messages);


//        $validator = Validator::make($request->all(), [
//            'title' => 'required|string|unique:articles|max:255',
//            'body' => 'required|string']);
//        if ($validator->fails()) {
//            return response()->json(['error' => 'data_validation_failed', "error_list" => $validator->errors()], 400);
//        }


        $article = Article::create($request->all());
        return response()->json($article, 201);
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

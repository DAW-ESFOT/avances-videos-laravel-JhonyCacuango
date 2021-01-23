<?php

namespace App\Http\Controllers;

use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\ArticleCollection;
use App\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
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
        return response()->json(new ArticleResource($article),200);

    }

    public function store(Request $request)
    {
        $article = Article::create($request->all());
        return response()->json($article, 201);
    }

    public function update(Request $request, Article $article){

        $article->update($request->all());
        return response()->json($article, 200);
    }

    public function delete(Article $article){
        $article->delete();
        return response()->json(null, 204);
    }


}

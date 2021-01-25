<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Article;
use App\Http\Resources\Comment as CommentResource;

use App\Mail\NewComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function index(Article $article)
    {
        return response ()->json(CommentResource::collection( $article->comments),200);
    }


    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @param \App\Comment $comments
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article, Comment $comments)
    {
        $comments = $article->comments()->where('id', $comments->id)->firstOrFail();

        return response()->json(new CommentResource($comments),200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Article $article)
    {
        $request->validate([
            'text'=>'required|string'
        ]);
        $comments =$article->comments()->save(new Comment ($request->all()));
        //Mail::to($article->user)->send(new NewComment($comment));
        return response()->json(new CommentResource($comments), 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comments)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comments
     * @return \Illuminate\Http\Response
     */
    public function delete (Comment $comments)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\RComment;
use App\Http\Resources\CommentResourse;
use App\Service\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $commentService = new CommentService();
        $comments = $commentService->getRoot();
        $child = $commentService->getChild();

        //return CommentResourse::collection($comments);
        return response()->json(['root' => $comments, 'child' => $child]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RComment $request)
    {

        $commentService = new CommentService();
        $comment = $commentService->create($request->text, $request->parent_id);

        return response()->json([$comment]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function like(Request $request){
        $comment_id=$request->comment_id;


        $comment=Comment::select(['*'])->where('id',$comment_id)->first();
        if(!$comment){
            return false;
        }
        if($request->action=="like") {
           $rez=$comment->newLike('like');
        }else{
            $rez=$comment->newLike('dislike');
        }

        return response()->json(['result'=>$rez]);
    }
}

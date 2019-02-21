<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Posts;
use App\Comment;
class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except'=>['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = Posts::all();

        // gets post in asc order by title we can write id here too
        //$posts = Posts::orderBy('created_at',  'desc')->get();
        //paginate
        $posts = Posts::orderBy('created_at',  'desc')->paginate(3);  //note if paginate(3) then paginate appears after post is >3

        return view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    public function comment(Request $request, $id, $user)
    {
        /*
            task remaining
            1.delete own comment not others
        */
        $this -> validate($request,[
            'comment' => 'required'
        ]);
        $comment = new Comment;
        $comment->posts_id = $id;
        $comment->body = $request->input('comment');
        $comment->comment_by = $user;
        $comment->save();
        return redirect('/posts/'.$id)->with('success','comment successful');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this -> validate($request,[
            'title' => 'required',
            'body'  => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);
        //handle file upload
        if($request->hasFile('cover_image')){
            //get filename with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get file name only
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get extension of file
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //file name to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_image', $fileNameToStore);
        }else{
            $fileNameToStore = 'noimage.jpg';
        }

        $post = new Posts;
        $post->title = $request -> input('title');
        $post->body = $request -> input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();
        return redirect('/posts')->with('success', "Post Created Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Posts::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Posts::find($id);

        if(auth()->user()->id != $post->user_id){
            return redirect('/posts')->with('error', "You are not Authorized to edit others post");
        }

        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this -> validate($request,[
            'title' => 'required',
            'body'  => 'required'
        ]);

        //handle file upload
        if($request->hasFile('cover_image')){
            //get filename with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get file name only
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get extension of file
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //file name to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_image', $fileNameToStore);
        }

        $post = Posts::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
            if($post->cover_image != 'noimage.jpg'){
                Storage::delete('public/cover_image/'.$post->cover_image);
            }
            $post->cover_image = $fileNameToStore;
        }
        $post->save();
        return redirect('/dashboard')->with('success', "Post Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //deleting all post of user
        $post = Posts::find($id);
        //fetch all comment related with the post
        $comment =Comment::select()->where('posts_id',$id);

        if(auth()->user()->id != $post->user_id){
            return redirect('/posts')->with('error', "You are not Authorized to delete others post");
        }
        if($post->cover_image != 'noimage.jpg'){
            Storage::delete('public/cover_image/'.$post->cover_image);
        }
        
        //delete post
        $post->delete();
        //delete the comment related with the post
        $comment->delete();

        return redirect('/dashboard')->with('success', "Post Deleted Successfully");
    }
}

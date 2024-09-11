<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create(){
        return view('create');
    }
    public function ourfilestore(Request $request){

        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|mimes:jpeg,bmp,png',
        ]);


        $imageName = null;
        if(isset($request->image)){
            // Upload images
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'),$imageName);
        }

        

        // Add new post
        $post = new Post;
        $post->name = $request->name; 
        $post->description = $request->description; 
        $post->image = $imageName; 
        $post->save();
        return redirect()->route('home')->with('success', 'Your post successfully created!');
    }

    public function editData($id){
        $post = Post::findOrfail($id);
        return view("edit",['ourPost'=>$post]);
    }


    public function updateData($id, Request $request){
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|mimes:jpeg,bmp,png',
        ]);

    

        

        // Update post
        $post = Post::findOrfail($id);
        $post->name = $request->name; 
        $post->description = $request->description; 
        if(isset($request->image)){
            // Upload images
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'),$imageName);
            $post->image = $imageName; 
        }

        $post->save();
        return redirect()->route('home')->with('success', 'Your post successfully updated!');
    }
}

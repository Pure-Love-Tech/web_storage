<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('article_id')) {
            $comments = BlogComment::where('article_id', $request->article_id)->with(['user', 'blogArticle'])->get();
        } else {
            $comments = BlogComment::with(['user', 'blogArticle'])->get();
        }
        return view('backend.blog.comments.index', ['comments' => $comments]);
    }

    public function viewComment($id)
    {
        $comment = BlogComment::find($id);
        if (!$comment) {
            return response()->json(['error' => 'Comment not exists']);
        }
        return response()->json([
            'success' => true,
            'comment' => $comment->comment,
            'publish_link' => route('admin.blog.comments.update', $comment->id),
            'delete_link' => route('admin.blog.comments.destroy', $comment->id),
            'status' => $comment->status,
        ]);
    }

    public function updateComment(Request $request, $id)
    {
        $comment = BlogComment::find($id);
        if (!$comment) {
            toastr()->error(admin_trans('Comment not exists'));
            return back();
        }
        if ($comment->status) {
            toastr()->info(admin_trans('Comment already published'));
            return back();
        }
        $comment->update(['status' => true]);
        toastr()->success(admin_trans('Published Successfully'));
        return back();
    }

    public function destroy($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->delete();
        toastr()->success(admin_trans('Deleted Successfully'));
        return back();
    }
}

<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author:id,name,email')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['articles' => $articles]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category' => 'nullable|string|in:analysis,report,insight',
            'published' => 'nullable|boolean',
        ]);

        $article = Article::create([
            'author_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
            'category' => $request->category ?? 'analysis',
            'published' => $request->published ?? true,
        ]);

        return response()->json(['article' => $article], 201);
    }

    public function show($id)
    {
        $article = Article::with('author:id,name,email')->find($id);
        if (!$article) {
            return response()->json(['error' => 'Article not found'], 404);
        }
        return response()->json(['article' => $article]);
    }

    public function update(Request $request, $id)
    {
        $article = Article::find($id);
        if (!$article) {
            return response()->json(['error' => 'Article not found'], 404);
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'category' => 'nullable|string|in:analysis,report,insight',
            'published' => 'nullable|boolean',
        ]);

        $article->update($request->all());

        return response()->json(['article' => $article]);
    }

    public function destroy($id)
    {
        $article = Article::find($id);
        if (!$article) {
            return response()->json(['error' => 'Article not found'], 404);
        }

        $article->delete();
        return response()->json(['ok' => true]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Article;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function show($locale, $slug)
    {
        $author = Author::where('slug', $slug)->firstOrFail();
        
        // Eager load current translation for performance
        $author->load(['translations' => function($q) use ($locale) {
            $q->where('locale', $locale)->orWhere('locale', 'id');
        }]);

        // Get articles written by this author that are published
        // Paginated to handle authors with many articles
        $articles = Article::with(['translations', 'authorRel'])
            ->where('author_id', $author->id)
            ->where('is_published', true)
            ->latest()
            ->paginate(12);

        return view('author.show', compact('author', 'articles', 'locale'));
    }
}

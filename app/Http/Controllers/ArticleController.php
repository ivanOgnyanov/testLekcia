<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Валидация в контролера с $request->validate() - лекция 5, слайдове 30-34.
 *
 * Статията не се записва в базата - примерът показва само валидацията.
 */
class ArticleController extends Controller
{
    /**
     * Show the article form.
     */
    public function create(): View
    {
        return view('articles.create');
    }

    /**
     * Validate the article and redirect back with a message.
     *
     * При неуспех Laravel сам връща към формуляра с грешките и стария вход.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => ['required', 'string', 'min:10'],
        ]);

        return redirect()->route('articles.create')
            ->with('success', "Статията „{$validated['title']}“ премина валидацията.");
    }
}

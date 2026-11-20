<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Методите на Request: input(), integer(), boolean(), string(), has(), filled() и масиви.
 * Лекция 5, слайдове 20-22.
 */
class SurveyController extends Controller
{
    /**
     * Show the survey form.
     */
    public function create(): View
    {
        return view('surveys.create', [
            'availableCities' => ['Варна', 'София', 'Тетевен', 'Пловдив'],
        ]);
    }

    /**
     * Show how each Request method reads the submitted survey.
     */
    public function store(Request $request): View
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cities' => 'array',
            'cities.*' => 'string|max:50',
            'per_page' => 'nullable|integer|min:1|max:100',
            'comment' => 'nullable|string|max:500',
        ]);

        return view('surveys.result', [
            'name' => $request->string('name')->title(),
            'cities' => $request->input('cities', []),
            'firstCity' => $request->input('cities.0', 'няма избран'),
            'wantsNewsletter' => $request->boolean('newsletter'),
            'perPage' => $request->integer('per_page', 10),
            'hasComment' => $request->has('comment'),
            'filledComment' => $request->filled('comment'),
        ]);
    }
}

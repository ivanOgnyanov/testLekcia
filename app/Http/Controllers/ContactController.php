<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Request в контролер и зареждане на изглед с входа - лекция 5, слайдове 17-19 и 27.
 */
class ContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function create(): View
    {
        return view('contacts.create');
    }

    /**
     * Show the submitted contact data.
     *
     * Данните само се показват (не се записват), затова се зарежда изглед, а не се пренасочва.
     */
    public function store(Request $request): View
    {
        $input = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'nullable|string|max:1000',
        ]);

        return view('contacts.result')->with('input', $input);
    }
}

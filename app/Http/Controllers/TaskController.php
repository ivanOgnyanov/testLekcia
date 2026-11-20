<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\View\View;

/**
 * Данни от контролера към изглед - лекция 5, слайд 8.
 */
class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index(): View
    {
        return view('tasks.index', ['tasks' => Task::all()]);
    }
}

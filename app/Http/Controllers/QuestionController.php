<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function show(Question $question)
    {
        $question->load(['user', 'subject', 'answers']);

        return inertia('Question/Show', ['question' => $question]);
    }

    public function create()
    {
        return inertia('Question/Create', ['subjects' => Subject::orderBy('name', 'desc')->get()]);
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function edit(Question $question)
    {
        $question->load(['user', 'subject', 'answers']);

        return inertia('Question/Edit', ['question' => $question]);
    }

    public function update(Request $request, Question $post)
    {

    }

    public function destroy(Question $question)
    {
        $question->deleteOrFail();
        return redirect()->back()->with('success', 'Otázku ste úspešne vymazali.');
    }

    public function results(Question $question)
    {
        return inertia('Question/Results', ['answers' => $question->answers()->get()]);
    }
}

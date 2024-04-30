<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function show(Question $question)
    {
        return inertia('Question/Show', [
            'question' => $question->load(['user', 'subject', 'answers'])
        ]);
    }

    public function create()
    {
        return inertia('Question/Create', ['subjects' => Subject::orderBy('name', 'desc')->get()]);
    }

    public function store(QuestionRequest $request)
    {
        $request->user()->questions()->create($request->validated());

        return redirect()->back()->with('success', 'Vytvorili ste novú otázku.');
    }

    public function edit(QuestionRequest $request, Question $question)
    {
        $question->update($request->validated());

        return inertia('Question/Edit', [
            'question' => $question->load(['user', 'subject', 'answers'])
        ]);
    }

    public function update(QuestionValidateRequest $request, Question $post)
    {
        $request->validated();
        return redirect()->back()->with('success', 'Upravili ste otázku.');
    }

    public function destroy(Question $question)
    {
        $question->deleteOrFail();
        return redirect()->back()->with('success', 'Otázku ste úspešne vymazali.');
    }

    public function results(Question $question)
    {
        return inertia('Question/Results', [
            'answers'         => $question->answers()->get(),
            'count_correct'   => $question->withCount(['answers' => fn($q) => $q->where('is_correct', true)])->first()->answers_count,
            'count_incorrect' => $question->withCount(['answers' => fn($q) => $q->where('is_correct', false)])->first()->answers_count
        ]);
    }
}

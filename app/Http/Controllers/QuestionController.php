<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class QuestionController extends Controller
{
    public function show(Question $question)
    {
        Gate::authorize('viewAny', $question);
        return inertia('Question/Show', [
            'question' => $question->load(['user', 'subject', 'answers'])
        ]);
    }

    public function create()
    {
        Gate::authorize('create', Question::class);
        return inertia('Question/Create', ['subjects' => Subject::orderBy('name', 'desc')->get()]);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Question::class);

        $validated_data = $request->validate([
            'description' => 'required|min:5',
            'type'        => 'required|string|in:answers,opened',
            'subject'     => 'exists:subjects,id',
            'answers'     => 'required_if:type,answers|array',
            'answers.*'   => 'nullable|required_if:type,answers|string|min:1'
        ]);

        $question = $request->user()->questions()->save(
            Question::make($validated_data)->subject()->associate($request->subject)
        );

        if ($validated_data['type'] === 'answers') {
            foreach ($validated_data['answers'] as $index => $answerText) {
                $question->answers()->create([
                    'question_id' => $question->id,
                    'user_id'     => $request->user()->id,
                    'text'        => $answerText,
                    'is_correct'  => $request->correctAnswers[$index],
                ]);
            }
        }

        return redirect()
            ->route('question.show', ['question' => $question])
            ->with('success', 'Vytvorili ste novú otázku.');
    }

    public function edit(QuestionRequest $request, Question $question)
    {
        Gate::authorize('update', $question);

        return inertia('Question/Edit', [
            'question' => $question->load(['user', 'subject', 'answers'])
        ]);
    }

    public function update(QuestionRequest $request, Question $question)
    {
        Gate::authorize('update', $question);

        $request->validated();
        return redirect()->back()->with('success', 'Upravili ste otázku.');
    }

    public function destroy(Question $question)
    {
        Gate::authorize('delete', $question);

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

<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QuestionController extends Controller
{
    public function show(Question $question)
    {
        Gate::authorize('view', $question);

        return inertia('Question/Show', [
            'question' => $question->load(['user', 'subject', 'answers']),
            'qrcode' => str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', QrCode::size(200)->format('svg')->generate(route('question.show', ['question' => $question])))
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

        $question->update($request->validate([
            'description' => 'required|min:5',
            'type'        => 'required|string|in:answers,opened',
            'subject'     => 'exists:subjects,id',
            'answers'     => 'required_if:type,answers|array',
            'answers.*'   => 'nullable|required_if:type,answers|string|min:1'
        ]));

        if ($request->only('type') == 'answers') {
            foreach ($request->only('answers') as $index => $answerText) {
                $question->answers()->updateOrCreate([
                    'question_id' => $question->id,
                    'user_id'     => $request->user()->id,
                    'text'        => $answerText,
                    'is_correct'  => $request->correctAnswers[$index],
                ]);
            }
        }

        return redirect()->back()->with('success', 'Upravili ste otázku.');
    }

    public function destroy(Question $question)
    {
        Gate::authorize('delete', $question);

        $question->deleteOrFail();
        return redirect()->route('homepage')->with('success', 'Otázku ste úspešne vymazali.');
    }

    public function results(Question $question)
    {
        return inertia('Question/Results', [
            'answers'         => $question->answers()->get(),
            'count_correct'   => $question->withCount(['answers' => fn($q) => $q->where('is_correct', true)])->first()->answers_count,
            'count_incorrect' => $question->withCount(['answers' => fn($q) => $q->where('is_correct', false)])->first()->answers_count
        ]);
    }

    public function setActive(Question $question)
    {
        Gate::authorize('setActive', $question);

        $question->update(['is_active' => $question->is_active ? 0 : 1]);
        return redirect()->back()->with('success', 'Upravili ste stav aktívnosti otázky.');
    }

    public function duplicate(Question $question)
    {
        Gate::authorize('duplicate', $question);

        $new_question = $question->replicate();
        $new_question->created_at = Carbon::now();
        $new_question->save();

        return redirect()->back()->with('success', 'Duplikovali ste otázku.');
    }

    public function closeVoting(Question $question, Request $request)
    {
        Gate::authorize('closeVoting', $question);

        $request->validate(['archive_note' => 'required|string|min:5']);

        $question->update([
            'is_active' => 0,
            'archive_note' => $request->only('archive_note')
        ]);

        return redirect()->route('homepage')->with('success', 'Archivovali ste otázku.');
    }
}

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
            'qrcode' => str_replace(
                '<?xml version="1.0" encoding="UTF-8"?>',
                '',
                QrCode::size(200)->format('svg')->generate(
                    route('question.show', ['question' => $question])
                )
            )
        ]);
    }

    public function create()
    {
        Gate::authorize('create', Question::class);
        return inertia('Question/Create', ['subjects' => Subject::orderBy('name', 'desc')->get()]);
    }

    public function store(QuestionRequest $request)
    {
        Gate::authorize('create', Question::class);

        $question = $request->user()->questions()->save(
            Question::make($request->validated())->subject()->associate($request->subject)
        );

        if ($request->subject === 'answers') {
            foreach ($request->answers as $index => $answerText) {
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
            ->with('success', __('You have created a new question.'));
    }

    public function edit(Question $question)
    {
        Gate::authorize('update', $question);

        $question = $question->load(['user', 'subject', 'answers']);
        return inertia('Question/Edit', [
            'question' => $question,
            'subjects' => Subject::orderBy('name', 'desc')->get()
        ]);
    }

    public function update(QuestionRequest $request, Question $question)
    {
        Gate::authorize('update', $question);

        // Delete all answers if user wants specific answers, not opened
        if ($request->type === 'opened' && $question->type === 'answers') {
            $question->answers()->delete();
        }

        $question->update($request->validated());

        if ($request->type === 'answers') {
            $answer_ids = [];

            foreach ($request->answers as $index => $answerText) {
                $answer = $question->answers()->updateOrCreate([
                    'question_id' => $question->id,
                    'user_id'     => $request->user()->id,
                    'text'        => $answerText,
                    'is_correct'  => $request->correctAnswers[$index],
                ]);

                $answer_ids[] = $answer->id;
            }

            $question->answers()->whereNotIn('id', $answer_ids)->delete();
        }

        return redirect()->back()->with('success', __('You have modified the question.'));
    }

    public function destroy(Question $question)
    {
        Gate::authorize('delete', $question);

        $question->deleteOrFail();
        return redirect()->route('homepage')->with('success', __('You have successfully deleted the question.'));
    }

    public function results(Question $question)
    {
        return inertia('Question/Results', [
            'answers'         => $question->answers()->get(),
            'archives' => $question->archive()->get(),
            'count_correct'   => $question->withCount(['answers' => fn($q) => $q->where('is_correct', true)])->first()->answers_count,
            'count_incorrect' => $question->withCount(['answers' => fn($q) => $q->where('is_correct', false)])->first()->answers_count
        ]);
    }

    public function setActive(Question $question)
    {
        Gate::authorize('setActive', $question);

        $question->update(['is_active' => $question->is_active ? 0 : 1]);
        return redirect()->back()->with('success', __('You have edited the active status of the query.'));
    }

    public function duplicate(Question $question)
    {
        Gate::authorize('duplicate', $question);

        $new_question = $question->replicate();
        $new_question->created_at = Carbon::now();
        $new_question->save();

        return redirect()->back()->with('success', __('You have duplicated the question.'));
    }
}

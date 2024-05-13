<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function create()
    {
        return inertia('Admin/Question/Create', [
            'subjects' => Subject::orderBy('name', 'desc')->get(),
            'users' => User::orderByDesc('email')->get()
        ]);
    }

    public function store(QuestionRequest $request)
    {
        $question = User::findOrFail($request->user_id)->questions()->save(
            Question::make($request->validated())->subject()->associate($request->subject)
        );

        if ($request->subject === 'answers') {
            foreach ($request->answers as $index => $answerText) {
                $question->answers()->create([
                    'question_id' => $question->id,
                    'user_id'     => $request->user_id,
                    'text'        => $answerText,
                    'is_correct'  => $request->correctAnswers[$index],
                ]);
            }
        }

        return redirect()
            ->route('question.show', ['question' => $question])
            ->with('success', __('You have created a new question.'));
    }
}

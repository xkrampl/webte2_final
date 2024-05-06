<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(Question $question, Request $request)
    {
        $request->validate([
            'text' => 'required|string|min:1'
        ]);

        $question->answers()->save(
            Answer::make([
                'user_id' => $request->user() ? $request->user()->id : null,
                'text'    => $request->text
            ])
        );

        return redirect()
            ->route('question.results.show', ['question' => $question])
            ->with('success', 'Zaznamenali sme odpoveď na otázku.');
    }
}

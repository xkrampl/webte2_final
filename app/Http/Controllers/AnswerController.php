<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(Question $question, Request $request)
    {
        $request->validate([
           'text' => 'required|string|min:1'
        ]);

        $question->answers()->create([
            'question_id' => $question->id,
            'user_id'     => $request->user() ? $request->user()->id : null,
            'text'        => $request->text
        ]);

        return redirect()->back()->with('success', 'Úspešne ste odpovedali na otázku.');
    }
}

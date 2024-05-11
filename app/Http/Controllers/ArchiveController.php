<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Archive;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArchiveController extends Controller
{
    public function store(Request $request, Question $question)
    {
        Gate::authorize('create', $question);

        $archive = Archive::create($request->validate([
            'note' => 'required|min:5',
        ]));

        $archive->questions()->attach($question);

        foreach (Answer::where('question_id', $question->id)->get() as $answer) {
            $archive->answers()->attach($answer);
        }

        return redirect()->back()->with('success', __('Successfully created archive for this question.'));
    }
}

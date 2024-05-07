<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExportDataController extends Controller
{
    public function __invoke()
    {
        $data = json_encode([
            'questions' => Question::latest()->with(['answers', 'subject'])->get()
        ]);

        $file_name = time() . '_db_data.json';
        Storage::disk('public')->put($file_name, $data);
        return response()->download(storage_path('/app/public/'. $file_name));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QualifyingQuestion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminSettingsController extends Controller
{
    public function qualifyingQuestions()
    {
        $questions = QualifyingQuestion::ordered()->get();

        return Inertia::render('Admin/Settings/QualifyingQuestions', [
            'questions' => $questions,
        ]);
    }

    public function storeQualifyingQuestion(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:1000',
            'type' => 'required|in:multiple_choice,text,boolean',
            'options' => 'nullable|array',
            'order' => 'required|integer|min:0',
        ]);

        QualifyingQuestion::create($request->all());

        return redirect()->back()->with('success', 'Question added successfully.');
    }

    public function updateQualifyingQuestion(Request $request, QualifyingQuestion $question)
    {
        $request->validate([
            'question' => 'required|string|max:1000',
            'type' => 'required|in:multiple_choice,text,boolean',
            'options' => 'nullable|array',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $question->update($request->all());

        return redirect()->back()->with('success', 'Question updated successfully.');
    }

    public function destroyQualifyingQuestion(QualifyingQuestion $question)
    {
        $question->delete();

        return redirect()->back()->with('success', 'Question deleted successfully.');
    }

    public function toggleQuestionStatus(QualifyingQuestion $question)
    {
        $question->update(['is_active' => !$question->is_active]);

        $status = $question->is_active ? 'activated' : 'deactivated';

        return redirect()->back()->with('success', "Question {$status} successfully.");
    }
}

<?php

namespace App\Services\Dashboard;

use App\Repositories\Dashboard\FaqQuestionRepository;
use Yajra\DataTables\Facades\DataTables;

class FaqQuestionService
{
    /**
     * Create a new class instance.
     */
    protected $faqQuestionRepository;
    public function __construct(FaqQuestionRepository $faqQuestionRepository)
    {
        $this->faqQuestionRepository = $faqQuestionRepository;
    }

    public function getFaqQuestionForDatatables()
    {
        $questions = $this->faqQuestionRepository->getFaqQuestions();
        return DataTables::of($questions)
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                return view('dashboard.faq-questions.datatables.action', compact('item'))->render();
            })
            ->addColumn('message', function ($item) {
                return view('dashboard.faq-questions.datatables.content', compact('item'));
            })
            ->make(true);
    }

    public function deleteFaqQuestion($faqQuestionId)
    {
        $question = $this->faqQuestionRepository->getFaqQuestionById($faqQuestionId);
        if (!$question) {
            return false;
        }
        return $this->faqQuestionRepository->deleteFaqQuestion($question);
    }
}
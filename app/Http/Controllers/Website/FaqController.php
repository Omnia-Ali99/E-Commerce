<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Services\Website\FaqService;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    protected $faqServiec;
    public function __construct(FaqService $faqService)
    {
        $this->faqServiec = $faqService;
    }
    public function faqShowPage(){
        $faqs = $this->faqServiec->getFaqs();
        return view('website.faq-page', compact('faqs'));
    }
}

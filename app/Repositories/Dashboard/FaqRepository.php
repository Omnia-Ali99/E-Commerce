<?php

namespace App\Repositories\Dashboard;

use App\Models\Faq;

class FaqRepository
{
   public function getFaq($id)
    {
        return Faq::find($id);
    }
    public function getFaqs()
    {
        return Faq::orderBy('id', 'desc')->get();
    }
    public function storeFaq($data)
    {
        return Faq::create($data);
    }
    public function updateFaq($data, $faq)
    {
        return $faq->update($data);
    }
    public function deleteFaq($faq)
    {
        return $faq->delete();
    }
   
}

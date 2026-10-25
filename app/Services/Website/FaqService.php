<?php

namespace App\Services\Website;

use App\Models\Faq;
use App\Models\FaqQuestion;

class FaqService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
      public function getFaqs(){
            return Faq::get();
        }
      public function createFaqQuestion($data){

           return FaqQuestion::create($data);
      }  
    
}

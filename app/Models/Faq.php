<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PHPUnit\Framework\MockObject\Generator\TemplateLoader;

class Faq extends Model
{
    use HasFactory, HasTranslations;
    public $translatable = ['question', 'answer'];

    protected $fillable = ['id', 'question', 'answer'];
    public $timestamps = false;
}

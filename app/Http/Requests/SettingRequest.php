<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'site_name.*'=>['required','string','max:255'],
            'site_desc.*'=>['required','string','max:255'],
            'site_address.*'=>['required','string','max:255'],
            'meta_description.*'=>['required','string','min:10','max:160'],

            'site_phone*'=>['required','string','max:20'],
            'site_email'=>['required','email','string','max:255'],
            'email_support'=>['required','email','string','max:255'],

            'facebook_url'=>['required','url','max:255'],
            'youtube_url'=>['required','url','max:255'],
            'twitter_url'=>['required','url','max:255'],
            'promotion_video_url'=>['required','url','max:255'],

            'logo'=>['nullable','max:255' ],
            'favicon'=>['nullable','max:255','mimes:jpeg,jpg,png,gif,bmp,webp,svg,ico,tiff'],
            'site_copyright'=>['required','string','max:255'],
        ];
    }
}

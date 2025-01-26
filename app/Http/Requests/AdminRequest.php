<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        $data = [
            'name'=>['required' , 'min:2' , 'max:60'],
            'email'=>['required' , 'email' , 'max:100' , Rule::unique('admins' , 'email')->ignore($this->id)],
            'role_id'=>['required' , 'exists:roles,id'],
            'status'=>['in:1,0'],
        ];
        
        if(in_array($this->method() , ['PUT' , 'PATCH'])){
            $rules['password']              =['nullable' , 'confirmed' , 'min:8' , 'max:100'];
            $rules['password_confirmation'] =['nullable'];
        }else{
            $rules['password']=['required' , 'confirmed' , 'min:8' , 'max:100'];
            $rules['password_confirmation']=['required'];
        }
        return $data;
    }
}

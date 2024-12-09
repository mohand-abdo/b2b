<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'tree4_name' => 'required|unique:tree4s,tree4_name',
            'iden' => 'required|unique:tree4s,iden',
            'phone' => 'required|unique:tree4s,phone',
            'type' => 'required|in:حاج,معتمر',
            'email' => 'nullable|email|unique:tree4s,email',
        ];
    }

    public function messages()
    {
        return [
            'tree4_name.required' => 'اسم الحاج مطلوب.',
            'tree4_name.unique' => 'اسم الحاج مستخدم بالفعل.',
            'iden.required' => 'رقم الهوية مطلوب.',
            'iden.unique' => 'رقم الهوية مستخدم بالفعل.',
            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.unique' => 'رقم الهاتف مستخدم بالفعل.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
            'type.required' => 'النوع مطلوب.',
            'type.in' => 'القيمة المدخلة في الحقل النوع يجب أن تكون إما حاج أو معتمر.',
        ];
    }
}

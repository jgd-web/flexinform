<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientSearchRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'client_name' => ['nullable', 'required_without:idcard'],
            'idcard' => ['nullable', 'required_without:client_name', 'numeric', 'gt:0']
        ];
    }

    public function messages(): array
    {
        return [
            'client_name.required_without' => 'Az Ügyfél mező kitöltése kötelező ha az Okmányazonosító mező nincs kitöltve!',
            'idcard.required_without' => 'Az Okmányazonosító mező kitöltése kötelező ha az Ügyfél mező nincs kitöltve!',
            'idcard.numeric' => 'Az Okmányazonosító mező csak pozitív számokat fogad el!',
            'idcard.gt' => 'Az Okmányazonosító mező csak 0-tól nagyobb számokat fogad el!'
        ];
    }
}

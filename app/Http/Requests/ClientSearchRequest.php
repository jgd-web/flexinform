<?php

namespace App\Http\Requests;

use App\Rules\OnlyOneOf;
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
            'client_name' => ['nullable', new OnlyOneOf(['idcard', 'client_name'], 'Mindkét mező kitöltése nem engedélyezett!')],
            'idcard' => ['nullable', 'required_without:client_name', 'numeric', 'gt:0']
        ];
    }

    public function messages(): array
    {
        return [
            'idcard.required_without' => 'Az Okmányazonosító mező kitöltése kötelező ha az Ügyfél mező nincs kitöltve!',
            'idcard.numeric' => 'Az Okmányazonosító mező csak pozitív számokat fogad el!',
            'idcard.gt' => 'Az Okmányazonosító mező csak 0-tól nagyobb számokat fogad el!'
        ];
    }
}

<?php

namespace App\Http\Requests\UserChat;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StoreFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id|not_in:' . Auth::user()->id,
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException(
            Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY],
            $validator->errors()->messages()
        );
    }
}

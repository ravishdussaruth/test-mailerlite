<?php

namespace App\Http\Requests\Bank;

use App\Repositories\Bank\Accounts;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateNewTransaction extends FormRequest
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
    public function rules()
    {
        return [
            'to'      => ['required', Rule::exists('accounts', 'id')->whereNot('id', $this->account)],
            'details' => ['required', 'string'],
            'amount'  => ['required']
        ];
    }

    /**
     * The data needed for the transfer.
     *
     * @return array
     */
    public function data(): array
    {
        return [
            resolve(Accounts::class)->find($this->to),
            $this->amount,
            $this->details
        ];
    }
}

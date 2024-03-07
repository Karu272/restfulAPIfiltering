<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreInvoiceRequest extends FormRequest
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
            '*.customerId' => ['required', 'integer'],
            '*.amount' => ['required', 'numeric'],
            '*.status' => ['required', Rule::in(['Billed', 'Paid', 'Void', 'billed', 'paid', 'void'])],
            '*.billedDate' => ['required', 'date_format:Y-m-d H:i:s'],
            '*.paidDate' => ['date_format:Y-m-d H:i:s', 'nullable'],
        ];
    }

    protected function prepareForValidation(){
        // to make this work, becuase we are insersting an array with multiple values
        // we need to loop through all and change the name to match the database
        $data = [];
        // because its prepare for validation it could be empty there for we have to use ?? null
        foreach ($this->toArray() as $columnNames) {
            $columnNames['customer_id'] = $columnNames['customerId'] ?? null;
            $columnNames['billed_date'] = $columnNames['billedDate'] ?? null;
            $columnNames['paid_date'] = $columnNames['paidDate'] ?? null;
            // Adding the looped child array to the parent array => $data
            $data[] = $columnNames;
        }
        // last merge everything to each customer id
        $this->merge($data);
        // this will create the issue that not onlu customer_id will be added but also the customerId
        // we will solve this in the InvoiceController at the bulkStore method
    }
}

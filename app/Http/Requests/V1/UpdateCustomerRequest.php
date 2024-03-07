<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
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
    public function rules()
    {
        // Determine the HTTP method of the request (e.g., GET, POST, PUT, DELETE)
        $method = $this->method();

        // If the request method is 'PUT' (typically used for updating resources)
        if ($method === 'PUT') {
            // Define validation rules for updating a customer
            return [
                'name' => ['required', 'string', 'max:255'],
                'type' => ['required', Rule::in(['Individual', 'Business', 'individual', 'business'])],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
                'address' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:255'],
                'state' => ['required', 'string', 'max:255'],
                'postalCode' => ['required', 'string', 'max:255'],
            ];
        }
        // For other request methods (typically 'POST' for creating resources)
        else {
            // Define validation rules for creating a new customer
            return [
                //'sometimes' rule: This rule is used to indicate that the field under validation
                //should only be validated if it is present in the input data. If the field is not
                //present, validation rules specified for that field will be ignored. Useful when editing.
                //or else you have to fill in all information AGAIN not just update whe 1 or 2 things.
                'name' => ['sometimes', 'required', 'string', 'max:255'],
                'type' => ['sometimes', 'required', Rule::in(['Individual', 'Business', 'individual', 'business'])],
                'email' => ['sometimes', 'required', 'string', 'email', 'max:255', 'unique:customers'],
                'address' => ['sometimes', 'required', 'string', 'max:255'],
                'city' => ['sometimes', 'required', 'string', 'max:255'],
                'state' => ['sometimes', 'required', 'string', 'max:255'],
                'postalCode' => ['sometimes', 'required', 'string', 'max:255'],
            ];
        }
    }

    protected function prepareForValidation()
    {
        // Before validation, this method is called to prepare the input data for validation

        // Check if the 'postalCode' field exists in the input data
        if ($this->postalCode) {
            // If 'postalCode' exists, merge it into the input data with a different key name
            // This is done to standardize the field names according to a consistent naming convention
            // In this case, 'postalCode' is merged into 'postal_code'
            $this->merge([
                'postal_code' => $this->postalCode,
            ]);
        }
    }
}

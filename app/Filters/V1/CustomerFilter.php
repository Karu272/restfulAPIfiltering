<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class CustomerFilter extends ApiFilter {
    // Define the parameters that can be used in the query and their allowed operators
    protected $safeParms = [
        'name' => ['eq'],           // name equal to
        'type' => ['eq'],           // type equal to
        'email' => ['eq'],          // email equal to
        'address' => ['eq'],        // address equal to
        'city' => ['eq'],           // city equal to
        'state' => ['eq'],          // state equal to
        'postalCode' => ['eq', 'gt', 'lt']  // postalCode equal to, greater than, less than
    ];

    // Map the column names to their corresponding database column names
    protected $columnMap = [
        'postalCode' => 'postal_code'
    ];

    // Map the operators to their corresponding SQL operators
    protected $operatorMap = [
        'eq' => '=',  // equal to
        'lt' => '<',  // less than
        'gt' => '>',  // greater than
        // 'gte' => '>=', // greater than or equal to
        // 'lte' => '<='  // less than or equal to
    ];

    // Transform the HTTP request parameters into Eloquent query conditions will be in the ApiFilter class
}

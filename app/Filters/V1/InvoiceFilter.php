<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class InvoiceFilter extends ApiFilter {
    // Define the parameters that can be used in the query and their allowed operators
    protected $safeParms = [
        'customerId' => ['eq'],           // name equal to
        'amount' => ['eq', 'lt', 'gt', 'lte', 'gte'],           // type equal to
        'email' => ['eq'],          // email equal to
        'status' => ['eq', 'ne'],        // address equal to & not equal to
        'billedDate' => ['eq', 'lt', 'gt', 'lte', 'gte'],           // city equal to & less than or equal to
        'paidDate' => ['eq', 'lt', 'gt', 'lte', 'gte'],          // state equal to
    ];

    // Map the column names to their corresponding database column names
    protected $columnMap = [
        'customerId' => 'customer_id',
        'billedDatate' => 'billed_date',
        'paidDate' => 'paid_date',
    ];

    // Map the operators to their corresponding SQL operators
    protected $operatorMap = [
        'eq' => '=',  // equal to
        'lt' => '<',  // less than
        'gt' => '>',  // greater than
        'gte' => '>=', // greater than or equal to
        'lte' => '<=',  // less than or equal to
        'ne' => '!='  // not equal to
    ];

    // Transform the HTTP request parameters into Eloquent query conditions will be in the ApiFilter class
}

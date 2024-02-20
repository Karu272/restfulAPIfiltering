<?php

namespace App\Filters;

use Illuminate\Http\Request;

class  ApiFilter {
    // Define the parameters that can be used in the query and their allowed operators
    protected $safeParms = [];

    // Map the column names to their corresponding database column names
    protected $columnMap = [];

    // Map the operators to their corresponding SQL operators
    protected $operatorMap = [];

    // Transform the HTTP request parameters into Eloquent query conditions
    public function transform(Request $request) {
        $eloQuery = []; // Initialize an array to store the Eloquent query conditions

        // Loop through each safe parameter and its operators
        foreach ($this->safeParms as $parm => $operators) {
            $query = $request->query($parm); // Get the query parameter value from the request

            // If the query parameter is not set, skip to the next parameter
            if(!isset($query)) {
                continue;
            }

            // Get the corresponding column name from the column map or use the parameter name itself
            $column = $this->columnMap[$parm] ?? $parm;

            // Loop through each operator for the parameter
            foreach ($operators as $operator) {
                // If the query parameter with the current operator is set
                if(isset($query[$operator])) {
                    // Add the condition to the Eloquent query array
                    $eloQuery[] = [$column,  $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }

        // Return the transformed Eloquent query conditions
        return $eloQuery;
    }
}

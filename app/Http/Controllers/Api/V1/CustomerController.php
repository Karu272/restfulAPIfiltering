<?php

namespace App\Http\Controllers\Api\V1; // change this to your own namespace

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Requests\V1\UpdateCustomerRequest;
use App\Http\Controllers\Controller; // add this
use App\Http\Resources\V1\CustomerResource;
use App\Http\Resources\V1\CustomerCollection;
use App\Filters\V1\CustomerFilter;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Building a filter to narrow down the data we want to show in the api
        $filter = new CustomerFilter();
        // transform the query parameters into an array
        $filterItems = $filter->transform($request); //[['column', 'operator', 'value'], ...]

        // In the URL we can add "includeInvoices" to show the invoices of the customer
        $includeInvoice = $request->query('includeInvoices');

        // we create a query to get the customers
        $customers = Customer::where($filterItems);
        // if we want to show the invoices of the customer we add the with() method
        if ($includeInvoice) {
            // invoices is the name of the relationship in the CustomerResource.php
            $customers = $customers->with('invoices');
        }

        // to be able to see the filter even in the other pages with paginator we need to add it to the url code "http://127.0.0.1:8000/api/v1/invoices?status[ne]=Paid&page=1" with the append() and the query() to show it to the rest of the pages
        return new CustomerCollection($customers->paginate()->appends($request->query()));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        // Retrieve the value of the 'includeInvoices' query parameter from the request
        $includeInvoice = request()->query('includeInvoices');

        // If the 'includeInvoices' query parameter is present and has a truthy value
        if ($includeInvoice) {
            // Load the 'invoices' relationship for the customer, even if it has been previously loaded
            // loadMissing() ensures that the 'invoices' relationship is loaded if it hasn't been loaded yet,
            // and avoids redundant database queries if it has already been loaded
            return new CustomerResource($customer->loadMissing('invoices'));
        }

        // Return a CustomerResource instance representing the customer
        return new CustomerResource($customer);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}

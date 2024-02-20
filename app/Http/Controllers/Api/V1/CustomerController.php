<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Controllers\Controller;
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
        $filter = new CustomerFilter();
        $queryItems = $filter->transform($request); //[['column', 'operator', 'value'], ...]

        if (count($queryItems) == 0) {
            // scaling down the data we get from the database with the CustomerCollection.php for all customers aka localhost:8000/api/customers
            // the reason we didnt have to add any specific code is because its connected to the CustomerResource.php through magic
            // insted of using the Customer::all() we use the Customer::paginate() to be able to brows through the data like a book
            return new CustomerCollection(Customer::paginate());
        } else {
            $customers = Customer::where($queryItems)->paginate();
            // to be able to see the filter even in the other pages with paginator we need to add it to the url code "http://127.0.0.1:8000/api/v1/invoices?status[ne]=Paid&page=1" with the append() and the query() to show it to the rest of the pages
            return new CustomerCollection($customers->appends($request->query()));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        // scaling down the data we get from the database with the CustomerResource.php for induvidual id of a customer aka localhost:8000/api/v1/customers/1
        return new CustomerResource($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}

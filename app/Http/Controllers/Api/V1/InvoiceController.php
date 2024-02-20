<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\InvoiceCollection;
use App\Http\Resources\V1\InvoiceResource;
use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Filters\V1\InvoiceFilter;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new InvoiceFilter();
        $queryItems = $filter->transform(request()); //[['column', 'operator', 'value'], ...]

        if (count($queryItems) == 0) {
            // scaling down the data we get from the database with the InvoiceCollection.php for all customers aka localhost:8000/api/invoices/
            return new InvoiceCollection(Invoice::paginate());
        } else {
            // to be able to see the filter even in the other pages with paginator we need to add it to the url code "http://127.0.0.1:8000/api/v1/invoices?status[ne]=Paid&page=1" with the append() and the query() to show it to the rest of the pages
            $invoices = Invoice::where($queryItems)->paginate();
            return new InvoiceCollection($invoices->appends($request->query()));
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
    public function store(StoreInvoiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        // scaling down the data we get from the database with the InvoiceResource.php for induvidual id of a customer aka localhost:8000/api/v1/invoices/1
        return new InvoiceResource($invoice);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}

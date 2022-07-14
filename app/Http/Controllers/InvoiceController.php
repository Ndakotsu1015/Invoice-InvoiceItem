<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Staff;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
        
        $invoice['q'] = $request->get('q');

        $invoice['invoices'] = Invoice::where('status', 'like', '%' . $invoice['q'] . '%')->get();

        return view('invoices.index', $invoice);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Invoice $invoice)
    {
        $clients = Client::all(['id', 'name']);

        $staff = Staff::all(['id', 'name']);

        return view('invoices.create', compact('clients', 'staff'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clients = Client::all(
            [
                'id', 'name'
            ]);

        $staff = Staff::all(
            [
                'id', 'name'
        ]);

        //$clients[$clients->id] = $clients->name;
        //$staff[$staff->id] = $staff->name;

       $invoices= $request->validate([
            'invoice_no' => 'required',
            'client_id' => 'required',
            'staff_id' => 'required',
            'date_invoice' => 'required',
            'due_date' => 'required',
            'created_by' => 'required',
            'status' => 'required',
            'address' => 'required'
        ]);

        
        //$invoices['client_id'] = $invoices['client'];
        //$invoices['staff_id'] = $invoices['staff'];
        //$arr = [];
        //$items = Item::all();
        //foreach($items as $item){
           // $arr[$item->id] = $item->name;
        
        

        $invoices = Invoice::create($invoices);

        return redirect()->route('invoices.index')->with('success', 'Record Added Successfully!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return view('invoices.show',compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        return view('invoices.edit',compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice )
    {
        $invoices = $request->validate([
            'invoice_no' => 'required',
            'client_id' => 'required',
            'staff_id' => 'required',
            'date_invoice' => 'required',
            'due_date' => 'required',
            'created_by' => 'required',
            'status' => 'required'
        ]);

        $invoice->invoice_no = $request->invoice_no;
        $invoice->client_id = $request->client_id;
        $invoice->staff_id = $request->staff_id;
        $invoice->date_invoice = $request->date_invoice;
        $invoice->due_date = $request->due_date;
        $invoice->created_by = $request->created_by;
        $invoice->status = $request->status;
        $invoice->save();

       

        return redirect()->route('invoices.index')->with('success', 'Invoice Updated Successfully');

        //Alternatively
        //$invoice->update($request->all());

      

        //return redirect()->route('invoices.index')

                        //->with('success','Invoice updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        
        return redirect()->route('invoices.index')->with('success', 'Invoice Deleted Successfully');

       
    }
}

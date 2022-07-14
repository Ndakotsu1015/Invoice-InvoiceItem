<?php

namespace App\Http\Controllers;

//use App\Http\Resources\Product;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $invoiceItem['q'] = $request->get('q');
        $invoiceItem['invoiceItems'] = InvoiceItem::where('id', 'like', '%' . $invoiceItem['q'] . '%')->get();

        return view('invoiceItems.index', $invoiceItem);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(InvoiceItem $invoiceItem)
    {
        $invoiceItem = InvoiceItem::all();

        $products = Product::all();
        $invoices = Invoice::all();

        return view('invoiceItems.create', compact('invoiceItem', 'products', 'invoices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invoices = Invoice::all();
        $products = Product::all();

       $invoiceItems= $request->validate([
            'invoice_id' => 'required',
            'product_id' => 'required',
            'unit_price' => 'required',
            'quantity' => 'required',
            'narration' => 'required'
            
        ]);

       
        //$invoiceItems['invoice_id'] = $invoiceItems['invoice_id'];
        //$invoiceItems['prodcut_id'] = $invoiceItems['product'];

        $invoiceItems = InvoiceItem::create($invoiceItems);

        return redirect()->route('invoiceItems.index')->with('success', 'Record Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoiceItem  $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceItem $invoiceItem)
    {
        return view('invoiceItems.show',compact('invoiceItem'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoiceItem  $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceItem $invoiceItem)
    {
        return view('invoiceItems.edit',compact('invoiceItem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoiceItem  $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceItem $invoiceItem)
    {       
       $invoiceItems = $request->validate([
            'invoice_id' => 'required',
            'product_id' => 'required',
            'unit_price' => 'required',
            'quantity' => 'required',
            'narration' => 'required'
            
        ]);

        $invoiceItem->invoice_id = $request->invoice_id;
        $invoiceItem->product_id = $request->product_id;
        $invoiceItem->unit_price = $request->unit_price;
        $invoiceItem->quantity = $request->quantity;
        $invoiceItem->narration = $request->narration;
        
        $invoiceItem->save();

        return redirect()->route('invoiceItems.index')->with('success', 'Invoice Item Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceItem  $invoiceItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceItem $invoiceItem)
    {
        $invoiceItem->delete();
        
        return redirect()->route('invoiceItems.index')->with('success', 'Invoice Deleted Successfully');
    }
}

<?php

namespace App\Http\Controllers\Pos;

use App\Models\PaymentDetail;
use App\Models\Unit;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class InvoiceController extends Controller implements HasMiddleware
{

    public static function middleware(): array{

        return [
            // new Middleware('permission:manage.customer.menu', only: ['CustomerAll']),

            new Middleware('permission:all.invoice.submenu', only: ['InvoiceAll']),
            new Middleware('permission:approval.invoice.submenu', only: ['InvoiceApprove']),
            new Middleware('permission:manage.invoice.menu', only: ['InvoiceAll']),
            new Middleware('permission:print.invoice.list.submenu', only: ['PrintInvoiceList']),

            new Middleware('permission:all.invoice.list', only: ['InvoiceAll']),


            new Middleware('permission:approval.invoice.list', only: ['InvoiceApprove']),
            new Middleware('permission:daily.invoice.report', only: ['DailyInvoicePdf']),
            new Middleware('permission:daily.invoice.report.list', only: ['DailyInvoiceReport']),
            new Middleware('permission:invoice.add', only: ['InvoiceAdd']),
            new Middleware('permission:print.invoice', only: ['PrintInvoice']),

            new Middleware('permission:print.invoice.list', only: ['PrintInvoiceList']),

            // new Middleware('permission:invoice.delete', only: ['InvoiceDelete']), todo: need to add permission

        ];

    }

    public function InvoiceAll(){

        $invoices = Invoice::orderBy('date','DESC')->orderBy('id','DESC')->where('status','1')->get();

        return view('backend.invoice.invoice_all',compact('invoices'));

    } //todo: End Method

    public function InvoiceAdd(){

        $category = Category::orderBy('name','DESC')->get();

        $customer = Customer::orderBy('name','DESC')->get();

        $invoice_data = Invoice::orderBy('id','desc')->first();

        if($invoice_data == null){
            $firstReg = '0';
            $invoice_no = $firstReg + 1;
        }else{
            $invoice_data = Invoice::orderBy('id','desc')->first()->invoice_no;
            $invoice_no = $invoice_data + 1;
        }

        $date = date('Y-m-d');

        return view('backend.invoice.invoice_add',compact('invoice_no','category','date','customer'));

    }

    public function InvoiceStore(Request $request){

        if($request->category_id == ''){
            $notification = array(
                'message' => 'Sorry You do not select any item',
                'alert-type' => 'error',
            );

            return redirect()->back()->with($notification);
        } else{
            if($request->paid_amount > $request->estimated_amount){
                $notification = array(
                    'message' => 'Sorry Paid Amount is Maximum the total price',
                    'alert-type' => 'error',
                );

                return redirect()->back()->with($notification);
            } else{

                $invoice = new Invoice();
                $invoice->invoice_no = $request->invoice_no;
                $invoice->date = date('Y-m-d',strtotime($request->date));
                $invoice->description = $request->description;
                $invoice->status = '0';
                $invoice->created_by = Auth::user()->id;

                DB::transaction(function() use($request, $invoice) {

                    if($invoice->save()){
                        $count_category = count($request->category_id);

                        for($i = 0; $i < $count_category; $i++){

                            $invoice_details = new InvoiceDetail();

                            $invoice_details->date = date('Y-m-d', strtotime($request->date));

                            $invoice_details->invoice_id = $invoice->id;
                            $invoice_details->category_id = $request->category_id[$i];
                            $invoice_details->product_id = $request->product_id[$i];
                            $invoice_details->selling_qty = $request->selling_qty[$i];
                            $invoice_details->unit_price = $request->unit_price[$i];
                            $invoice_details->selling_price = $request->selling_price[$i];
                            $invoice_details->status = '0';
                            $invoice_details->save();

                        }

                        if($request->customer_id == '0'){
                            $customer = new Customer();
                            $customer->name = $request->name;
                            $customer->mobile_no = $request->mobile_no;
                            $customer->email = $request->email;
                            $customer->save();
                            $customer_id = $customer->id;
                        } else{
                            $customer_id = $request->customer_id;
                        }

                        $payment = new Payment();
                        $payment_details = new PaymentDetail();

                        $payment->invoice_id = $invoice->id;
                        $payment->customer_id = $customer_id;
                        $payment->paid_status = $request->paid_status;
                        $payment->discount_amount = $request->discount_amount;
                        $payment->total_amount = $request->estimated_amount;

                        if($request->paid_status == 'full_paid'){
                            $payment->paid_amount = $request->estimated_amount;
                            $payment->due_amount = '0';
                            $payment_details->current_paid_amount = $request->estimated_amount;
                        }else if($request->paid_status == 'full_due'){
                            $payment->paid_amount = '0';
                            $payment->due_amount = $request->estimated_amount;
                            $payment_details->current_paid_amount = '0';
                        }else if($request->paid_status == 'partial_paid'){
                            $payment->paid_amount = $request->partial_paid_amount;
                            $payment->due_amount = ($request->estimated_amount - $request->partial_paid_amount);
                            $payment_details->current_paid_amount = $request->partial_paid_amount;
                        }

                        $payment->save();

                        $payment_details->invoice_id = $invoice->id;
                        $payment_details->date = date('Y-m-d',strtotime($request->date));
                        $payment_details->save();

                    }

                });

            } // todo: End Else

        }

        $notification = array(
            'message' => 'Invoice Data Added Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('invoice.all')->with($notification);

    }  // todo: End Method

    public function PendingList(){

        $invoices = Invoice::orderBy('date','DESC')->orderBy('id','DESC')->where('status','0')->get();

        return view('backend.invoice.invoice_pending_list',compact('invoices'));

    }

    public function InvoiceDelete($id){

        $invoice = Invoice::findOrFail($id);

        $invoice->delete();

        InvoiceDetail::where('invoice_id',$invoice->id)->delete();

        Payment::where('invoice_id',$invoice->id)->delete();

        PaymentDetail::where('invoice_id',$invoice->id)->delete();


        $notification = array(
            'message' => 'Invoice Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);

    }

    public function InvoiceApprove($id){

        $invoice = Invoice::with('invoice_details')->findOrFail($id);

        return view('backend.invoice.invoice_approve',compact('invoice'));

    }

    public function ApprovalStore(Request $request,$id){

        foreach($request->selling_qty as $key => $val){

            // dd($key);
            $invoice_details = InvoiceDetail::where('id',$key)->first();
            // dd($invoice_details);
            $product = Product::where('id',$invoice_details->product_id)->first();

            if($product->quantity < $request->selling_qty[$key]){
                $notification = array(
                    'message' => 'Sorry you approve maximum value',
                    'alert-type' => 'error',
                );

                return redirect()->back()->with($notification);
            }

        } // todo: End foreach

        $invoice = Invoice::findOrFail($id);
        $invoice->updated_by = Auth::user()->id;
        $invoice->status = '1';

        DB::transaction(function() use($request, $invoice){

            foreach($request->selling_qty as $key => $val){

                $invoice_details = InvoiceDetail::where('id',$key)->first();

                $invoice_details->status = '1';
                $invoice_details->save();

                $product = Product::where('id',$invoice_details->product_id)->first();

                $product->quantity  = ((float) $product->quantity) - ((float) $request->selling_qty[$key]);

                $product->save();

            } //todo: End foreach

            $invoice->save();

        });

        $notification = array(
            'message' => 'Invoice Approve Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('invoice.pending.list')->with($notification);

    } // todo: End Method

    public function PrintInvoiceList(){

        $invoices = Invoice::orderBy('date','DESC')->orderBy('id','DESC')->where('status','1')->get();

        return view('backend.invoice.print_invoice_list',compact('invoices'));

    } // todo: End Method

    public function PrintInvoice($id){

        $invoice = Invoice::with('invoice_details')->findOrFail($id);

        return view('backend.pdf.invoice_pdf',compact('invoice'));

    } // todo: End Method

    public function DailyInvoiceReport(){
        return view('backend.invoice.daily_invoice_report');
    }

    public function DailyInvoicePdf(Request $request){

        $sdate = date('Y-m-d',strtotime($request->start_date));

        $edate = date('Y-m-d',strtotime($request->end_date));

        $invoice = Invoice::whereBetween('date',[$sdate, $edate])->where('status',1)->get();

        $start_date = date('Y-m-d',strtotime($request->start_date));

        $end_date = date('Y-m-d',strtotime($request->end_date));

        return view('backend.pdf.daily_invoice_report_pdf',compact('invoice','start_date','end_date'));


    } // todo: End Method

}

<?php

namespace App\Http\Controllers\Pos;

use App\Models\PaymentDetail;
use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CustomerController extends Controller
{

    public function CustomerAll(){

        $customers = Customer::latest()->get();

        return view('backend.customer.customer_all',compact('customers'));

    } // todo: End Method

    public function CustomerAdd(){

        return view('backend.customer.customer_add');

    } // todo: End Method

    public function CustomerStore(Request $request){

        $image = $request->file('customer_image');

        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        $path = public_path('upload/customer/'.$name_gen);

        $manager = new ImageManager(new Driver());

        $imageInt = $manager->read($image);

        $imageInt->resize(200,200);

        $imageInt->save($path);

        $save_url = 'upload/customer/'.$name_gen;

        Customer::insert([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'customer_image' => $save_url,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Customer Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('customer.all')->with($notification);

    } // todo: End Method

    public function CustomerEdit($id){

        $customer = Customer::findOrFail($id);

        return view('backend.customer.customer_edit',compact('customer'));

    } // todo: End Method

    public function CustomerUpdate(Request $request){

        $customer_id = $request->id;

        if($request->file('customer_image')){

            // todo: Delete Old Image
            $customer = Customer::select('customer_image')->where('id',$customer_id)->first();

            $old_image = $customer->customer_image;

            if(file_exists($old_image)){
                unlink($old_image);
            }else{
                echo "File does not exist";
            }


            $image = $request->file('customer_image');

            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            $path = public_path('upload/customer/'.$name_gen);

            $manager = new ImageManager(new Driver());

            $imageInt = $manager->read($image);

            $imageInt->resize(200,200);

            $imageInt->save($path);

            $save_url = 'upload/customer/'.$name_gen;

            Customer::findOrFail($customer_id)->update([
                'name' => $request->name,
                'mobile_no' => $request->mobile_no,
                'email' => $request->email,
                'address' => $request->address,
                'customer_image' => $save_url,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Customer Updated With Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('customer.all')->with($notification);

        }else{

            Customer::findOrFail($customer_id)->update([
                'name' => $request->name,
                'mobile_no' => $request->mobile_no,
                'email' => $request->email,
                'address' => $request->address,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Customer Updated Without Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('customer.all')->with($notification);

        }

    } // todo: End Method

    public function CustomerDelete($id){

        $customer = Customer::findOrFail($id);

        $old_img = $customer->customer_image;

        if(file_exists($old_img)){
            unlink($old_img);
        }

        Customer::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Customer Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // todo: End Method

    public function CreditCustomer(){

        $allData = Payment::whereIn('paid_status',['full_due','partial_paid'])->get();

        return view('backend.customer.customer_credit',compact('allData'));

    }

    public function CreditCustomerPrintPdf(){

        $allData = Payment::whereIn('paid_status',['full_due','partial_paid'])->get();

        return view('backend.pdf.customer_credit_pdf',compact('allData'));

    } // todo: End Method

    public function CustomerEditInvoice($invoice_id){

        $payment = Payment::where('invoice_id',$invoice_id)->first();

        return view('backend.customer.edit_customer_invoice',compact('payment'));

    }

    public function CustomerUpdateInvoice(Request $request, $invoice_id){

        if($request->new_paid_amount < $request->partial_paid_amount){
            $notification = array(
                'message' => 'Sorry You Paid Maximum Value',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }else{

            $payment = Payment::where('invoice_id',$invoice_id)->first();

            $payment_details = new PaymentDetail();

            $payment->paid_status = $request->paid_status;

            if($request->paid_status == 'full_paid'){
                $payment->paid_amount = Payment::where('invoice_id',$invoice_id)->first()->paid_amount + $request->new_paid_amount;

                $payment->due_amount = '0';

                $payment_details->current_paid_amount = $request->new_paid_amount;
            }else if($request->paid_status == 'partial_paid'){
                $payment->paid_amount =  Payment::where('invoice_id',$invoice_id)->first()->paid_amount + $request->partial_paid_amount;

                $payment->due_amount = Payment::where('invoice_id',$invoice_id)->first()->due_amount - $request->partial_paid_amount;

                $payment_details->current_paid_amount = $request->partial_paid_amount;
            }

            $payment->save();
            $payment_details->invoice_id = $invoice_id;
            $payment_details->date = date('Y-m-d',strtotime($request->date));
            $payment_details->updated_by = Auth::user()->id;
            $payment_details->save();

            $notification = array(
                'message' => 'Invoice Update Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('credit.customer')->with($notification);
        }

    }

    public function CustomerInvoiceDetails($invoice_id){

        $payment = Payment::where('invoice_id',$invoice_id)->first();

        return view('backend.pdf.invoice_details_pdf',compact('payment'));

    }

    public function PaidCustomer(){

        $allData = Payment::where('paid_status','!=','full_due')->get();

        return view('backend.customer.customer_paid',compact('allData'));

    }

    public function PaidCustomerPrintPdf(){

        $allData = Payment::where('paid_status','!=','full_due')->get();

        return view('backend.pdf.customer_paid_pdf',compact('allData'));

    }

    public function CustomerWiseReport(){

        $customers =  Customer::all();

        return view('backend.customer.customer_wise_report',compact('customers'));

    }

    public function CustomerWiseCreditReport(Request $request){

        $allData = Payment::where('customer_id',$request->customer_id)->whereIn('paid_status',['full_due','partial_paid'])->get();

        return view('backend.pdf.customer_wise_credit_pdf',compact('allData'));

    } // End Method

    public function CustomerWisePaidReport(Request $request){

        $allData = Payment::where('customer_id',$request->customer_id)->where('paid_status','!=','full_due')->get();

        return view('backend.pdf.customer_wise_paid_pdf',compact('allData'));

    }

}

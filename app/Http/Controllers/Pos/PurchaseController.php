<?php

namespace App\Http\Controllers\Pos;

use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Product;
use App\Models\Category;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PurchaseController extends Controller implements HasMiddleware
{

    public static function middleware(): array{

        return [

            new Middleware('permission:manage.purchase.menu', only: ['PurchaseAll']),
            new Middleware('permission:all.purchase.add', only: ['PurchaseAdd']),
            new Middleware('permission:all.purchase.list', only: ['PurchaseAll']),
            new Middleware('permission:all.purchase.delete', only: ['PurchaseDelete']),

            // new Middleware('permission:all.purchase.submenu', only: ['ProductEdit']),
            // new Middleware('permission:approval.purchase.add', only: ['ProductEdit']),
            new Middleware('permission:approval.purchase.approve', only: ['PurchaseApprove']),
            new Middleware('permission:approval.purchase.list', only: ['PurchaseApprove']),
            new Middleware('permission:daily.purchase.report.list', only: ['DailyPurchaseReport']),
            new Middleware('permission:approval.purchase.submenu', only: ['PurchaseApprove']),
            new Middleware('permission:daily.purchase.report.submenu', only: ['DailyPurchaseReport']),

        ];

    }


    public function PurchaseAll()
    {

        $purchases = Purchase::orderBy('date', 'DESC')->orderBy('id', 'DESC')->get();

        return view('backend.purchase.purchase_all', compact('purchases'));

    }

    public function PurchaseAdd()
    {

        $supplier = Supplier::orderBy('name', 'ASC')->get();

        $unit = Unit::orderBy('name', 'ASC')->get();

        $category = Category::orderBy('name', 'ASC')->get();

        return view('backend.purchase.purchase_add', compact('supplier', 'unit', 'category'));

    }

    public function PurchaseStore(Request $request)
    {

        if ($request->category_id == null) {

            $notification = array(
                'message' => 'Sorry you do not select any item',
                'alert-type' => 'error',
            );

            return redirect()->back()->with($notification);

        } else {

            $count_category = count($request->category_id);

            for ($i = 0; $i < $count_category; $i++) {

                $purchase = new Purchase();
                $purchase->date = date('Y-m-d',
                    strtotime($request->date[$i]));
                $purchase->purchase_no = $request->purchase_no[$i];
                $purchase->supplier_id = $request->supplier_id[$i];
                $purchase->category_id = $request->category_id[$i];

                $purchase->product_id = $request->product_id[$i];
                $purchase->buying_qty = $request->buying_qty[$i];
                $purchase->unit_price = $request->unit_price[$i];
                $purchase->buying_price = $request->buying_price[$i];
                $purchase->description = $request->description[$i];

                $purchase->created_by = Auth::user()->id;
                $purchase->status = '0';
                $purchase->created_at = Carbon::now();
                $purchase->save();

            }

        } //todo: end for loop

        $notification = array(
            'message' => 'Purchase Added Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('purchase.all')->with($notification);

        // todo: copilot version
        // if (is_array($request->category_id) && count($request->category_id) > 0) {
        //     $count_category = count($request->category_id);

        //     for ($i = 0; $i < $count_category; $i++) {
        //         if (isset($request->date[$i], $request->purchase_no[$i], $request->supplier_id[$i], $request->category_id[$i], $request->product_id[$i], $request->buying_qty[$i], $request->unit_price[$i], $request->buying_price[$i], $request->description[$i])) {
        //             $purchase = new Purchase();
        //             $purchase->date = date('Y-m-d', strtotime($request->date[$i]));
        //             $purchase->purchase_no = $request->purchase_no[$i];
        //             $purchase->supplier_id = $request->supplier_id[$i];
        //             $purchase->category_id = $request->category_id[$i];
        //             $purchase->product_id = $request->product_id[$i];
        //             $purchase->buying_qty = $request->buying_qty[$i];
        //             $purchase->unit_price = $request->unit_price[$i];
        //             $purchase->buying_price = $request->buying_price[$i];
        //             $purchase->description = $request->description[$i];
        //             $purchase->created_by = Auth::user()->id;
        //             $purchase->status = '0';
        //             $purchase->created_at = Carbon::now();
        //             $purchase->save(); // Don't forget to save the purchase
        //         }
        //     }

        //     $notification = array(
        //         'message' => 'Purchase Added Successfully',
        //         'alert-type' => 'success'
        //     );

        //     return redirect()->route('purchase.all')->with($notification);
        // } else {
        //     $notification = array(
        //         'message' => 'Sorry you do not select any item',
        //         'alert-type' => 'error'
        //     );

        //     return redirect()->back()->with($notification);
        // }

    } // todo: end method

    public function PurchaseDelete($id){

        Purchase::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Purchase Item Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);

    }

    public function PurchasePending(){

        $purchases = Purchase::orderBy('date','DESC')->orderBy('id','DESC')->where('status','0')->get();

        return view('backend.purchase.purchase_pending',compact('purchases'));

    }

    public function PurchaseApprove($id){

        $purchase = Purchase::findOrFail($id);

        $product = Product::where('id',$purchase->product_id)->first();

        $purchase_qty = ((float)($purchase->buying_qty)) + ((float)($product->quantity));

        $product->quantity = $purchase_qty;

        if($product->save()){
            Purchase::findOrFail($id)->update([
                'status' => '1'
            ]);

            $notification = array(
                'message' => 'Purchase Status Approved Successfully',
                'alert-type' => 'success',
            );

            return redirect()->route('purchase.all')->with($notification);

        }

    }

    public function DailyPurchaseReport(){

        return view('backend.purchase.daily_purchase_report');

    }

    public function DailyPurchasePdf(Request $request){

        $sdate = date('Y-m-d',strtotime($request->start_date));

        $edate = date('Y-m-d',strtotime($request->end_date));

        $purchase = Purchase::whereBetween('date',[$sdate, $edate])->where('status',1)->get();

        $start_date = date('Y-m-d',strtotime($request->start_date));

        $end_date = date('Y-m-d',strtotime($request->end_date));

        return view('backend.pdf.daily_purchase_report_pdf',compact('purchase','start_date','end_date'));

    }

}

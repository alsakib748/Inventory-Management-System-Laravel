<?php

namespace App\Http\Controllers\Pos;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class StockController extends Controller implements HasMiddleware
{

    public static function middleware(): array{

        return [

            new Middleware('permission:manage.stock.menu', only: ['StockReport']),
            new Middleware('permission:stock.report.list', only: ['StockReport']),
            new Middleware('permission:stock.report.print', only: ['StockReportPdf']),

            new Middleware('permission:stock.report.submenu', only: ['PurchaseDelete']),
            new Middleware('permission:supplier.product.wise.list', only: ['StockSupplierWise']),
            new Middleware('permission:supplier.product.wise.submenu', only: ['PurchaseDelete']),

        ];

    }

    public function StockReport(){

        $product = Product::orderBy('supplier_id','asc')->orderBy('category_id','asc')->get();

        return view('backend.stock.stock_report',compact('product'));

    } // End Method

    public function StockReportPdf(){

        $product = Product::orderBy('supplier_id','asc')->orderBy('category_id','asc')->get();

        return view('backend.pdf.stock_report_pdf',compact('product'));

    } // End Method

    public function StockSupplierWise(){

        $supplier = Supplier::orderBy('name','ASC')->get();

        $category = Category::orderBy('name','ASC')->get();

        return view('backend.stock.supplier_product_wise_report',compact('supplier','category'));

    } // End Method

    public function SupplierWisePdf(Request $request){

        if($request->supplier_id == ''){
            $notification = array(
                'message' => 'Please Select Supplier Name',
                'alert-type' => 'error',
            );

            return redirect()->back()->with($notification);
        }

        $product = Product::orderBy('supplier_id','asc')->orderBy('category_id','asc')->where('supplier_id',$request->supplier_id)->get();

        return view('backend.pdf.supplier_wise_report_pdf',compact('product'));

    }

    public function ProductWisePdf(Request $request){

        if($request->category_id == '' || $request->product_id == ''){
            $notification = array(
                'message' => 'Please Select Category and Product Name',
                'alert-type' => 'error',
            );

            return redirect()->back()->with($notification);
        }

        $product = Product::orderBy('category_id','asc')->orderBy('id','asc')->where('category_id',$request->category_id)->where('id',$request->product_id)->get();

        return view('backend.pdf.product_wise_report_pdf',compact('product'));

    }

}

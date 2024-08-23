<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

use App\Models\Order;
use App\Models\OrderItem;
use App\Helpers\BarcodeGenerator;
use Illuminate\support\Facades\Mail;

use App\Http\Controllers\InvoiceController;

class InvoiceController extends Controller
{
   public function generateInvoicePdf($id)
   {
    $order = Order::findorFail($id);
   
    $order_item = OrderItem::where('order_id',$order->id)->get();

    //  dd($order_item);

    $data = [
        'order' => $order,
        'order_items' => $order_item,
        // 'upi_qr' => $upi_qr
    ];
    //load the view and pass the data

    $pdf = PDF::loadview('pdf.invoice',$data);
     
    return $pdf;
   }
   public function sendInvoiceEmail(Request $request,$id)
   {
    $order = Order::findOrFail($id);

    $recipient_email = $order->customer->email;
    $recipient_name = $order->customer->name;
    $subject = $order->order_number;

    //Generate the Pdf
    $pdf = $this->generateInvoicePdf($id);
    $data = [
        'order' => $order,
        'order_items' => OrderItem::where('order_id', $order->id)->get(),
        // 'upi_qr' => BarcodeGenerator::generateQrcode('9994219286@icici')
    ];
    //Send email with the invoice attached
    Mail::send('email.invoice',$data, function($message) use ($pdf, $recipient_email, $recipient_name, $subject) {
        $message->to($recipient_email, $recipient_name)
                ->subject($subject)
                ->attachData($pdf->output(), "invoice.pdf");
    });

    //Optionally,you can provide a response to indicate the email was sent
    return response()->json(['message'=> 'Invoice email sent successfully']);
   }

   public function downloadInvoicePdf($id)
   {
        //Generate the Pdf
        $pdf = $this->generateInvoicePdf($id);

        //Download the Pdf
        return $pdf->download('invoice.pdf');
   }

   public function streamInvoicePdf($id)
   {
        // Generate the Pdf
        $pdf = $this->generateInvoicePdf($id);

        // Stream the Pdf to the browser
        return $pdf->stream('invoice.pdf');
   }
}
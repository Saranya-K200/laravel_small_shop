<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;// Import the PDF facade
use App\Models\Order;
use App\Model\OrderItem;
use App\Helpers\BarcodeGenerator;
use Illuminate\Support\facade\Mail;

class InvoiceController extends Controller
{
    public function generateInvoicepdf($id)
    {
        //find the order by its ID
        $order = Order::findOrFail($id);

        //get order items
        $order_items = OrderItem::where('order_id',$order->id)->get();

        //generate UPI QR code
        $upi_qr = BarcodeGenerate::generateQRcode('saranya101105@gmail.com');

        //prepare data for the PDF
        $data = [
            'order' => $order,
            'order_items' => $order_items,
            'upi_qr' => $upi_qr
        ];
        //load the view and pass the data
        $pdf = PDF::loadView('pdf.invoice',$data);

        //return the generate PDF
        return $pdf;
    }

    public function sendInvoiceEmail(Request $request, $id)
    {
        //find the order by its ID
        $order = Order::findOrFail($id);

        $recipient_email = $order->customer->email;
        $recipient_name = $order->customer->name;
        $subject = $order->order_number;
        //genrenate the pdf
        $pdf = $this->generateINvoicepdf($id);
        
        //prepare data for the email
        $data = [
            'order' => $order,
            'order_items' => OrderItem::where('order_id',$order->id)->get(),
            'upi_qr' => BarcodeGenerate::generateQRcode('saranya101105@gmail.com')
        ];

        //send email with the invoice attached
        Mail::send('email.invoice',$data,function($message)use($pdf,$recipient_email,$recipient_name,$subject){
            $message->to($recipient_email, $recipient_name)
                    ->subject($subject)
                    ->attachData($pdf->output(), "invoice.pdf");
        });

        // Optionally, you can provide a response to indicate the email was sent
        return response()->json(['message' => 'Invoice email sent successfully']);
    }

    public function downloadInvoicePdf($id)
    {
        // Generate the PDF
        $pdf = $this->generateInvoicePdf($id);

        // Download the PDF
        return $pdf->download('invoice.pdf');
    }

    public function streamInvoicePdf($id)
    {
        // Generate the PDF
        $pdf = $this->generateInvoicePdf($id);

        // Stream the PDF to the browser
        return $pdf->stream('invoice.pdf');
    }
}


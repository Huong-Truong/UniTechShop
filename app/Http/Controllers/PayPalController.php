<?php
  //sb-47tqlq38597850@personal.example.com
  //7OYieP}-
namespace App\Http\Controllers;
  
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;
use Session;
use Cart;
use Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Mail\OrderDetails;


class PayPalController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('auth.paypal');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function payment(Request $request)
    {   
        
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        
        $paypalToken = $provider->getAccessToken();
        $tiendv = 0;
        $dichvu = Session::get('dichvu');
    
        if($dichvu){
            foreach($dichvu as $dv){
                $tiendv = $tiendv + $dv->giadichvu;
            }
            $subtotal = Cart::subtotal();
            $subtotal = preg_replace('/[^\d.]/', '', $subtotal); // Loại bỏ các ký tự không phải số
            $subtotal = floatval($subtotal);
           
            $subtotal = Cart::total();
            $subtotal = preg_replace('/[^\d.]/', '', $subtotal); // Loại bỏ các ký tự không phải số
    
            if (is_numeric($subtotal)) {
                $subtotal = floatval($subtotal); // Chuyển đổi thành giá trị số thập phân
                $subtotal = $subtotal + $tien_dv; // Cộng thêm phí dịch vụ vào tổng số
            }
          
        }else{
            $subtotal = Cart::total();
            $subtotal = preg_replace('/[^\d.]/', '', $subtotal); // Loại bỏ các ký tự không phải số
            $subtotal = floatval($subtotal);
            
        }

        $subtotal = $subtotal/230000;
        $subtotal = $subtotal = number_format((float)$subtotal, 2, '.', '');

       
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
           "return_url" => route('paypal.success'),
            "cancel_url" => route('paypal.cancel'),

            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $subtotal
                    ]
                ]
            ]
        ]);
  
        if (isset($response['id']) & $response['id'] != null) {
  
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
  
            return redirect()
                ->route('cancel.payment')
                ->with('error', 'Something went wrong.');
  
        } else {
            return redirect()
                ->route('create.payment')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function paymentCancel()
    {
        $message = "Thanh toán không thành công!";
        return Redirect::to('/')->with('message', $message);
        // return redirect()
        //       ->route('paypal')
        //       ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
  
        if (isset($response['status']) & $response['status'] == 'COMPLETED') {
            $tb="Thanh toán thành công, vui lòng kiểm tra email";
           Session::put('success',  $tb);
            $mail_nhan = DB::table('vanchuyen')->where('vanchuyen_id', Session::get('shipping_order'))->pluck('vanchuyen_email')->first();
            $this->send_order_email($mail_nhan);
            return Redirect::to('/');
        } else {
            $tb="Thanh toán không thành công";
            Session::put('error',  $tb);
            return Redirect::to('/');
        }
    }

    public function send_order_email($mail_nhan)
    {
        $new_mail = new OrderDetails();
        Mail::to($mail_nhan)->send($new_mail);
    
    }
    
    
}

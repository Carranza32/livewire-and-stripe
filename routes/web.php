<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Facades\Cart as CartFacade;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/carrito', function () {
        $params = [
            "intent" => Auth::user()->createSetupIntent(),
        ];

        return view('shopping-cart', $params);
    })->name('shopping-cart');



    Route::post('/checkout', function (Request $request) {
        $validator = Validator::make($request->all(), [
            'payment_method' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($request, 404);
        }

        $cart = CartFacade::get();
        $total = 0;

        foreach ($cart['products'] as $product) {
            $total += $product->price * $product->amount;
        }

        //Payment
        $paymentMethod = $request['payment_method'];
        $user = Auth::user();

        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            // 2000 = 20$
            $charge = $total * 100;
            $user->charge($charge, $paymentMethod, [
                "receipt_email" => $user->email,
                'description' => 'Compra online',
            ]);

            CartFacade::clear();

            return response()->json('Pago realizado con exito', 201);

        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 404);
        }
    })->name('checkout');
});

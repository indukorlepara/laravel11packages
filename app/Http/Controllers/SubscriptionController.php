<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Subscription;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        // Set Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Create Stripe customer with the payment method
            $customer = Customer::create([
                'email' => $request->email,
                'payment_method' => $request->payment_method_id,
                'invoice_settings' => [
                    'default_payment_method' => $request->payment_method_id,
                ]
            ]);

            // Create a subscription for the customer
            Subscription::create([
                'customer' => $customer->id,
                'items' => [
                    ['price' => 'your_stripe_price_id'],  // Replace with your Price ID from Stripe
                ],
                'expand' => ['latest_invoice.payment_intent'],
            ]);

            // Return success response
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            // Handle any errors and return failure response
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}

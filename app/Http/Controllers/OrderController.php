<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Stripe\Stripe;

class OrderController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function checkout(Course $course)
    {
        return Inertia::render('Checkout', [
            'course' => $course,
            'stripeKey' => config('services.stripe.key'),
        ]);
    }

    public function processPayment(Request $request, Course $course)
    {
        $request->validate([
            'payment_method_id' => 'required|string',
        ]);

        try {
            $user = Auth::user();
            
            // Create or retrieve Stripe customer
            if (!$user->stripe_customer_id) {
                $customer = \Stripe\Customer::create([
                    'email' => $user->email,
                    'name' => $user->name,
                    'payment_method' => $request->payment_method_id,
                ]);
                
                $user->update(['stripe_customer_id' => $customer->id]);
            } else {
                $customer = \Stripe\Customer::retrieve($user->stripe_customer_id);
            }

            // Create payment intent
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $course->price * 100, // Convert to cents
                'currency' => 'usd',
                'customer' => $customer->id,
                'payment_method' => $request->payment_method_id,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'metadata' => [
                    'course_id' => $course->id,
                    'user_id' => $user->id,
                ],
            ]);

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'amount' => $course->price,
                'status' => $paymentIntent->status === 'succeeded' ? 'completed' : 'pending',
                'stripe_payment_intent_id' => $paymentIntent->id,
                'stripe_customer_id' => $customer->id,
            ]);

            if ($paymentIntent->status === 'succeeded') {
                return response()->json([
                    'success' => true,
                    'redirect' => route('courses.show', $course),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Payment failed. Please try again.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function success(Request $request)
    {
        $paymentIntentId = $request->get('payment_intent');
        
        if ($paymentIntentId) {
            $order = Order::where('stripe_payment_intent_id', $paymentIntentId)->first();
            
            if ($order) {
                $order->update(['status' => 'completed']);
                return redirect()->route('courses.show', $order->course)
                    ->with('success', 'Payment successful! You can now access the course.');
            }
        }

        return redirect()->route('dashboard')
            ->with('error', 'Payment verification failed.');
    }

    public function cancel()
    {
        return redirect()->route('courses.index')
            ->with('error', 'Payment was cancelled.');
    }
}

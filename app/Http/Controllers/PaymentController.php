<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:student');
        
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function checkout(Course $course)
    {
        if ($course->isEnrolledBy(auth()->user())) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'Vous êtes déjà inscrit à ce cours.');
        }

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'unit_amount' => $course->price * 100, // Stripe utilise les centimes
                        'product_data' => [
                            'name' => $course->title,
                            'description' => $course->description,
                            'images' => $course->thumbnail ? [asset('storage/' . $course->thumbnail)] : [],
                        ],
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success', ['course' => $course->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel', ['course' => $course->id]),
                'customer_email' => auth()->user()->email,
                'metadata' => [
                    'course_id' => $course->id,
                    'user_id' => auth()->id(),
                ],
            ]);

            return view('payment.checkout', [
                'course' => $course,
                'sessionId' => $session->id
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la création de la session de paiement.');
        }
    }

    public function success(Request $request, Course $course)
    {
        try {
            $session = Session::retrieve($request->get('session_id'));

            if ($session->payment_status === 'paid') {
                $enrollment = Enrollment::create([
                    'student_id' => auth()->id(),
                    'course_id' => $course->id,
                ]);

                return redirect()->route('courses.show', $course)
                    ->with('success', 'Paiement réussi ! Vous êtes maintenant inscrit au cours.');
            }
        } catch (\Exception $e) {
            // Log l'erreur
        }

        return redirect()->route('courses.show', $course)
            ->with('error', 'Une erreur est survenue lors de la validation du paiement.');
    }

    public function cancel(Course $course)
    {
        return redirect()->route('courses.show', $course)
            ->with('info', 'Le paiement a été annulé.');
    }

    public function webhook(Request $request)
    {
        $endpoint_secret = config('services.stripe.webhook_secret');
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            return response('', 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            return response('', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            
            // Créer l'inscription
            Enrollment::create([
                'student_id' => $session->metadata->user_id,
                'course_id' => $session->metadata->course_id,
            ]);
        }

        return response('', 200);
    }
}

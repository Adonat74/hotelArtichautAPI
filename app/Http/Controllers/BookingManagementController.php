<?php

namespace App\Http\Controllers;

use App\Mail\QrCodeMail;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Service;
use App\Services\BookingPriceCalculationService;
use App\Services\BookingService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;
use UnexpectedValueException;

class BookingManagementController extends Controller
{

    protected BookingPriceCalculationService $bookingPriceCalculationService;

    public function __construct(BookingPriceCalculationService $bookingPriceCalculationService)
    {
        $this->bookingPriceCalculationService = $bookingPriceCalculationService;
    }


    public function handleWebhook(Request $request)
    {
        // Set your Stripe secret key to verify signatures
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $endpointSecret = env('STRIPE_WEBHOOK_SECRET'); // from Stripe dashboard
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            // Verify the event with the endpoint signing secret
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                // Retrieve the session object
                $session = $event->data->object;

                $payment = new Payment();
                $payment->amount_in_cent = $session->amount_total;
                $payment->method = 'Master Card';
                $payment->booking_id = $session->metadata->booking_id;
                $payment->save();

                break;
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                // Handle successful payment here as well
                break;
            default:
                Log::info('Unhandled event type: ' . $event->type);
        }

        return response()->json(['status' => 'success'], 200);
    }


    /**
     * @OA\Post(
     *     path="/api/booking-management/checkout/{id}",
     *     summary="Add services to a booking",
     *     tags={"BookingManagement"},
     *     @OA\Response(response=201, description="Successful operation"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function checkout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $domain = env('FRONT_URL');

        try {
            $validatedData = $request->validate([
                'booking_id' => 'bail|required|exists:bookings,id'
            ]);

            $booking = Booking::findOrFail($validatedData['booking_id']);
            $this->authorize('view', $booking); // policy check

            $checkoutSession = Session::create([
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Custom Amount',
                        ],
                        'unit_amount' => $booking->total_price_in_cent,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'http://192.168.1.245:8000/qr/reservation/15',  // Assuming you use Vue router's hash mode or adjust accordingly
                'cancel_url'  => 'http://192.168.1.245:8000/qr/reservation/15',
                'metadata' => [
                    'booking_id' => $validatedData['booking_id'],
                ],
            ]);

            return response()->json(['url' => $checkoutSession->url]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred during the payment',
                'message'=>    $e->getMessage(),
            ], 500);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/booking-management/add-services/booking-{id}",
     *     summary="Add services to a booking",
     *     tags={"BookingManagement"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *             required={"services"},
     *             @OA\Property(property="services", type="array", @OA\Items(type="integer"), example={5,6})
     *         )
     *     ),
     *     @OA\Response(response=201, description="Successful operation"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function addServicesToBooking(Request $request, int $id): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'services' => 'nullable|array',
                'services.*' => 'nullable|exists:services,id',
            ]);

            $booking = Booking::findOrFail($id);
            $this->authorize('update', $booking); // policy check

            if (isset($validatedData['services'])) {
                $booking->services()->attach($validatedData['services']);
            }

            foreach ($booking->services as $service) {
                $booking->total_price_in_cent += $service->price_in_cent;
            }

            $booking->save();

            return response()->json($booking->load(['rooms', 'services', 'user']), 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while adding the booking',
                'message'=>    $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/booking-management/qr-code",
     *     summary="Send a mail with a qr code to the user - need to be authentified and role = user",
     *     tags={"BookingManagement"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function sendQrCode(): JsonResponse
    {
        try {
            $user = Auth::user();

            Mail::to($user->email)->send(new QrCodeMail($user));

            return response()->json(["message" => "mail successfully sent"]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while sending email',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/booking-management/total-price",
     *     summary="Get the total price of a booking",
     *     tags={"BookingManagement"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *             required={"check_in", "check_out", "to_be_paid_in_cent", "rooms"},
     *             @OA\Property(property="check_in", type="string", format="date", example="2025-04-10"),
     *             @OA\Property(property="check_out", type="string", format="date", example="2025-04-15"),
     *             @OA\Property(property="to_be_paid_in_cent", type="integer", example=5000),
     *             @OA\Property(property="number_of_persons", type="integer", example=2),
     *             @OA\Property(property="rooms", type="array", @OA\Items(type="integer"), example={1,2,3}),
     *             @OA\Property(property="services", type="array", @OA\Items(type="integer"), example={5,6})
     *         )
     *     ),
     *     @OA\Response(response=201, description="Successful operation"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getTotalPrice(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'check_in' => 'bail|required|date|after_or_equal:now',
                'check_out' => 'bail|required|date|after:check_in',
                'to_be_paid_in_cent' => 'bail|required|integer',
                'number_of_persons' => 'bail|required|integer',
                'rooms' => 'bail|required|array',
                'rooms.*' => 'bail|required|exists:rooms,id',
                'services' => 'nullable|array',
                'services.*' => 'nullable|exists:services,id',
            ]);

            $bookingService = new BookingService();
            forEach($validatedData['rooms'] as $room){
                if (!$bookingService->checkRoomAvailability($room, $validatedData['check_in'], $validatedData['check_out'])) {
                    throw new Exception("The room ". $room ." is not available for the given date");
                }
            }

            $rooms = Room::whereIn('id', $validatedData['rooms'])->get();
            $services = Service::whereIn('id', $validatedData['services'])->get();
            $totalPrice = $this->bookingPriceCalculationService->calculatePrice($validatedData['check_in'], $validatedData['check_out'], $rooms, $services);


            return response()->json(['total_price_in_cent' => $totalPrice], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while adding the booking',
                'message'=>    $e->getMessage(),
            ], 500);
        }
    }
}

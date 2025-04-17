<?php

namespace App\Http\Controllers;

use App\Mail\QrCodeMail;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Service;
use App\Services\BookingPriceCalculationService;
use App\Services\BookingService;
use App\Services\ErrorsService;
use App\Services\PaymentService;
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
    protected PaymentService $paymentService;
    protected ErrorsService $errorsService;

    public function __construct(
        BookingPriceCalculationService $bookingPriceCalculationService,
        PaymentService $paymentService,
        ErrorsService $errorsService
    )
    {
        $this->paymentService = $paymentService;
        $this->bookingPriceCalculationService = $bookingPriceCalculationService;
        $this->errorsService = $errorsService;
    }


    /**
     * @OA\Post(
     *     path="/api/booking-management/add-payment need to be authenticated and role = employee",
     *     summary="Add a payment for the admins",
     *     tags={"BookingManagement"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *             required={"booking_id", "payment_amount"},
     *             @OA\Property(property="booking_id", type="integer", example=2),
     *             @OA\Property(property="payment_amount", type="integer", example=2),
     *         )
     *     ),
     *     @OA\Response(response=201, description="Successful operation"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function addPayment(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'booking_id' => 'bail|required|exists:bookings,id',
                'payment_amount' => 'bail|required|numeric',
            ]);
            $booking = Booking::findOrFail($validatedData['booking_id']);
            $booking->to_be_paid_in_cents -= $validatedData['payment_amount'];
            $booking->save();

            $payment = new Payment();
            $payment->amount_in_cent = $validatedData['payment_amount'];
            $payment->method = 'master card';
            $payment->booking_id = $validatedData['booking_id'];
            $payment->save();

            return response()->json($booking->load(['payments']), 201);
        } catch (ValidationException $e) {
            return $this->errorsService->validationException('booking', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('booking', $e);
        }
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

        $session = $event->data->object;

        $payment = new Payment();
        $payment->amount_in_cent = $session->amount_total;
        $payment->method = 'Master Card';
        $payment->booking_id = $session->metadata->booking_id;
        $payment->save();

        $booking = Booking::findOrFail($session->metadata->booking_id);
        $booking->to_be_paid_in_cent -= $session->amount_total;
        $booking->save();


        return response()->json(['status' => 'success'], 200);
    }


    /**
     * @OA\Post(
     *     path="/api/booking-management/checkout needs to be authenticated and role = user",
     *     summary="initiate a checkout with stripe",
     *     tags={"BookingManagement"},
     *     @OA\RequestBody(
     *        required=true,
     *           @OA\JsonContent(
     *              required={"booking_id"},
     *              @OA\Property(property="booking_id", type="integer", example=2),
     *        )
     *     ),
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

            $this->paymentService->checkPaymentAlreadyExist($booking);
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
                'success_url' => $domain . '/success',  // Assuming you use Vue router's hash mode or adjust accordingly
                'cancel_url'  => $domain . '/error',
                'metadata' => [
                    'booking_id' => $validatedData['booking_id'],
                ],
            ]);

            return response()->json(['url' => $checkoutSession->url]);
        } catch (Exception $e) {
            return $this->errorsService->exception('booking', $e);
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
                $booking->to_be_paid_in_cent += $service->price_in_cent;
            }

            $booking->save();

            return response()->json($booking->load(['rooms', 'services', 'user']), 201);
        } catch (ValidationException $e) {
            return $this->errorsService->validationException('booking', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('booking', $e);
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
            return $this->errorsService->exception('booking', $e);
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
     *             required={"check_in", "check_out", "rooms"},
     *             @OA\Property(property="check_in", type="string", format="date", example="2025-04-10"),
     *             @OA\Property(property="check_out", type="string", format="date", example="2025-04-15"),
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
            return $this->errorsService->exception('booking', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('booking', $e);
        }
    }
}

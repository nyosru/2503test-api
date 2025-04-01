<?php

namespace App\Http\Controllers\Api;

use App\Contracts\BookingServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Booking",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="resource_id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="start_time",
 *         type="string",
 *         format="date-time",
 *         example="2025-04-01T14:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="end_time",
 *         type="string",
 *         format="date-time",
 *         example="2025-04-01T16:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         example="2025-04-01T12:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         example="2025-04-01T12:00:00Z"
 *     )
 * )
 */
/*
 * @OA\Schema(
 *     schema="Booking",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="resource_id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="start_time", type="string", format="date-time", example="2025-04-01T14:00:00Z"),
 *     @OA\Property(property="end_time", type="string", format="date-time", example="2025-04-01T16:00:00Z"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-01T12:00:00Z")
 * )
 */
class BookingController extends Controller
{

    public function __construct(
        protected BookingServiceInterface $bookingService
    ) {}

    /**
     * Получить список всех бронирований
     *
     * @OA\Get(
     *     path="/api/bookings",
     *     summary="Получить список всех бронирований",
     *     tags={"Bookings"},
     *     @OA\Response(
     *         response=200,
     *         description="Успешное получение списка бронирований",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Booking")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера"
     *     )
     * )
     */
    public function index()
    {
        return BookingResource::collection(Booking::all());
    }

    /**
     * Создать новое бронирование
     *
     * @OA\Post(
     *     path="/api/bookings",
     *     summary="Создать новое бронирование",
     *     tags={"Bookings"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"resource_id", "user_id", "start_time", "end_time"},
     *             @OA\Property(property="resource_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="start_time", type="string", format="date-time", example="2025-04-01T14:00:00Z"),
     *             @OA\Property(property="end_time", type="string", format="date-time", example="2025-04-01T16:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Бронирование успешно создано",
     *         @OA\JsonContent(ref="#/components/schemas/Booking")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера"
     *     )
     * )
     */
    public function store(StoreBookingRequest $request, BookingService $service)
    {
        $booking = $service->createBooking($request->validated());
//        dd($booking);
        return response(new BookingResource($booking), 201);
    }

    /**
     * Удалить бронирование
     *
     * @OA\Delete(
     *     path="/api/bookings/{id}",
     *     summary="Удалить бронирование",
     *     tags={"Bookings"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID бронирования",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Бронирование успешно удалено"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Бронирование не найдено"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера"
     *     )
     * )
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->noContent();
    }
}

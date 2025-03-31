<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Resource;
use Illuminate\Http\Request;

class ResourceBookingController extends Controller
{
    /**
     * Получить все бронирования выбранного ресурса
     *
     * @OA\Get(
     *     path="/api/resources/{id}/bookings",
     *     summary="Получить все бронирования выбранного ресурса",
     *     tags={"Resources"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID ресурса",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешное получение списка бронирований",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Booking")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ресурс не найден"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера"
     *     )
     * )
     */
    public function index($id)
    {
        try {
            $resource = Resource::findOrFail($id);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }

        $bookings = $resource->bookings;
        return BookingResource::collection($bookings);

    }

}

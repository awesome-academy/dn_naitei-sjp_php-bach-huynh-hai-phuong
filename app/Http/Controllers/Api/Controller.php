<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Info(
 *     title="Distant Worlds III",
 *     version="0.1",
 *     @OA\Contact(
 *         email="void@void.void"
 *     )
 * ),
 * @OA\Server(
 *     description="Discover the answer to life, the universe, and everything.",
 *     url="http://localhost:8000/api"
 * )
 */
abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Handle a successful response.
     *
     * @param mixed $result
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function success($result, string $message = '', int $code = Response::HTTP_OK): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message ?: __('response.success'),
        ];
        return response()->json($response, $code);
    }

    /**
     * Handle an error response.
     *
     * @param string $errorMessage
     * @param array $errors
     * @param int $code
     * @return JsonResponse
     */
    public function error(string $errorMessage = '', array $errors = [], int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $errorMessage ?: __('response.error'),
            'errors' => $errors,
        ];
        return response()->json($response, $code);
    }
}

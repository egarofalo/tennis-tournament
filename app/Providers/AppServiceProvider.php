<?php

namespace App\Providers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Add apiResponse method to laravel response service.
        Response::macro('apiResponse', $this->getApiResponseCallable());

        // Remove data key in json resources
        JsonResource::withoutWrapping();
    }

    /**
     * Return a callable added at runtime into the Response service.
     * The returned callable is used to normalize all API responses.
     *
     * @return callable
     */
    protected function getApiResponseCallable(): callable
    {
        return function (
            mixed $data = null,
            int $status = HttpResponse::HTTP_OK,
            ?string $message = null
        ): JsonResponse {
            $message = $message ?? HttpResponse::$statusTexts[$status];
            $response = transform($data, function ($data) {
                if ($data instanceof JsonResource) {
                    return $data->response()->getData(true);
                }

                return $data;
            });

            return Response::json([
                'data' => $response,
                'message' => $message,
                'status' => $status
            ])->setStatusCode($status);
        };
    }
}

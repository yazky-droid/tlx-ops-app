<?php
namespace App\Filament\Resources\ShipmentResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\ShipmentResource;
use Illuminate\Routing\Router;


class ShipmentApiService extends ApiService
{
    protected static string | null $resource = ShipmentResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}

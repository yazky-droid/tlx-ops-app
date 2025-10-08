<?php
namespace App\Filament\Resources\ShipmentResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\ShipmentResource;
use App\Filament\Resources\ShipmentResource\Api\Requests\CreateShipmentRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = ShipmentResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create Shipment
     *
     * @param CreateShipmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateShipmentRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}
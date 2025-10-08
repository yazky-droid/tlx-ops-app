<?php
namespace App\Filament\Resources\ShipmentResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use App\Filament\Resources\ShipmentResource;
use App\Filament\Resources\ShipmentResource\Api\Transformers\ShipmentTransformer;

class PaginationHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = ShipmentResource::class;
    // public static bool $public = true;

    /**
     * List of Shipment
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function handler()
    {
        $query = static::getEloquentQuery();

        $query = QueryBuilder::for($query)
        ->allowedFields($this->getAllowedFields() ?? [])
        ->allowedSorts($this->getAllowedSorts() ?? [])
        ->allowedFilters($this->getAllowedFilters() ?? [])
        ->allowedIncludes($this->getAllowedIncludes() ?? [])
        ->with('invoice')
        ->paginate(request()->query('per_page'))
        ->appends(request()->query());

        return ShipmentTransformer::collection($query);
    }
}

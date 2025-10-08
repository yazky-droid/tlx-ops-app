<?php

namespace App\Filament\Resources\ShipmentResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'shipper_id' => 'required',
			'consignee_id' => 'required',
			'service_type' => 'required',
			'destination_port' => 'required',
			'cargo_description' => 'required',
			'weight_kg' => 'required|numeric',
			'volume_cbm' => 'required|numeric',
			'goods_value' => 'required|numeric',
			'cargo_condition' => 'required|string',
			'etd' => 'required|date',
			'eta' => 'required|date',
			'current_status' => 'required',
			'user_id' => 'required'
		];
    }
}

<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "name" => $this->name,
            "created_at" => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            "updated_at" => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
            "categories" => CategoryResource::collection($this->shop_categories)
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $category = Category::where('id', $this->pivot->category_id)->first();

        // return parent::toArray($request);
        return [
            "shop_id" => $this->pivot->shop_id,
            "category_id" => $category->id,
            "category_name" => $category->name,
            "products" => ProductResource::collection($category->products)
        ];
    }
}

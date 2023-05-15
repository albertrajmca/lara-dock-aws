<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'units' => $this->units,
            'price' => $this->price,
            'image' => $this->image,
            // 'rating' => $this->rating,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'avg_rating' => number_format($this->reviews_avg_rating,1),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
        ];
    }
}


<?php


namespace Code95\Page\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SeoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'description' => $this->description,
            'title' => $this->title,
            'keywords' => $this->keywords,
        ];
    }
}

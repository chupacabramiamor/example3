<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SuccessResource extends JsonResource
{
    public function __construct($resource = null)
    {
        $this->resource = $resource ?? 'ok';
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = (!is_array($this->resource)) ? ['message' => $this->resource ?? 'ok'] : $this->resource;

        return array_merge([
            'message' => 'ok'
        ], $result);
    }
}

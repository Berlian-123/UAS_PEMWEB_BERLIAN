<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class KegiatanResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'judul'     => $this->judul,
            'deskripsi' => $this->deskripsi,
            'tanggal'   => $this->tanggal,
            'status'    => $this->status,
            'user_id'   => $this->user_id,
            'created_at'=> $this->created_at->toDateTimeString(),
            'updated_at'=> $this->updated_at->toDateTimeString(),
        ];
    }
}

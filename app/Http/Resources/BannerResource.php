<?php


namespace App\Http\Resources;
use App\Models\Banner;
use App\Models\BannerSize;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $this->load('bannerSize');
        // $size = [
        //     'height'         => $this->bannerSize->height,
        //     'width'          => $this->bannerSize->width,
        //     // 'location'       => $this->bannerSize->location,
        // ];
        return [
          'id'                  => $this->id,
          'photo'               => url(Banner::PHOTO_UPLOAD_PATH.$this->photo),
          'title'               => $this->title,
          'status'              => $this->status == 1 ? 'Active' : 'Inactive',          
          'type'                => $this->type == 1 ? 'Banner' : ($this->type == 2 ? 'Slider' : 'Advertisement'),
          'location'            => $this->location,
        //   'location'            => $this->bannerSize->location,
        //   'serial'              =>$this->serial,

        //   'banner_size_id'      => $this->banner_size_id,
        //   'size'                => $size,
          
        ];
    }
}

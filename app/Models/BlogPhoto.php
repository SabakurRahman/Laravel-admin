<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPhoto extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function blogPosts():BelongsTo
    {
        return $this->belongsTo(BlogPost::class,'blog_id');
    }
}

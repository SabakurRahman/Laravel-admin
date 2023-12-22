<?php

namespace App\Models;

use App\Http\Requests\StoreBlogCommentRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogComment extends Model
{
    use HasFactory;
    protected $guarded = [];
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public function blogPost()
    {
        return $this->belongsTo(BlogPost::class);
    }

    public function replies()
    {
        return $this->hasMany(BlogComment::class, 'blog_comment_id');
    }

    public function storeBlogComment(array $validatedData, $blog_id,$parent_comment_id)
    {
        return self::query()->create($this->prepareBlogCommentData($validatedData,$blog_id,$parent_comment_id));
    }

    private function prepareBlogCommentData($validatedData,$blog_id,$parent_comment_id)
    {
        $data = [
            'comment' => $validatedData['comment'],
            'status'  => self::STATUS_ACTIVE,
            'blog_id' => $blog_id,
            'user_id' => Auth::id(),
        ];

        if ($parent_comment_id !== null) {
            $data['blog_comment_id'] = $parent_comment_id;
        }
        return $data;
    }

    public function allBlogCommentList()
    {
        return self::all();
    }

    public function blogStatusChang($id, $status)
    {
        $blogPost = self::query()->find($id);
        $blogPost->status = $status;
        return $blogPost->save();
    }

    public function getBlogComment($blog_id)
    {
        return self::query()->with('replies','user.profile')
            ->where('blog_id',$blog_id)
            ->whereNull('blog_comment_id')
            ->where('status',self::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();
    }


    public  function user()
    {
        return $this->belongsTo(User::class);
    }


}

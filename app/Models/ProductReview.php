<?php

namespace App\Models;

use App\Manager\ImageUploadManager;
use App\Manager\Utility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReview extends Model
{
    use HasFactory;

    protected $guarded =[];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public const PHOTO_UPLOAD_PATH = 'uploads/product-review/';
    public const PHOTO_UPLOAD_PATH_THUMB = 'uploads/product-review/thumb/';
    public const PHOTO_WIDTH = 600;
    public const PHOTO_HEIGHT = 450;
    public const PHOTO_WIDTH_THUMB = 150;
    public const PHOTO_HEIGHT_THUMB = 150;

    public function productReviewSave(Request $request)
    {
        $productReviewData = $this->preparedProductReviewData($request);
        $productReview = self::query()->create($productReviewData);


        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $imageUpload = (new ImageUploadManager)
                    ->file($photo)
                    ->name(Utility::prepare_name($request->input('comment'))) // Use 'comment' instead of 'comments' for input field
                    ->path(self::PHOTO_UPLOAD_PATH)
                    ->height(self::PHOTO_HEIGHT)
                    ->width(self::PHOTO_WIDTH)
                    ->upload();
                if ($imageUpload) {
                    $productReview->photos()->create([
                        'photo' => $imageUpload
                    ]);
                }
            }
        }

        return $productReview;
    }





    private function preparedProductReviewData(Request $request)
    {
        return [
            'customer_id'  =>Auth::id(),
            'comment'      =>$request->input('comment'),
            'product_review_id'   =>$request->input('product_review_id'),
            'product_id'   =>$request->input('product_id'),
            'like'         =>$request->input('like'),
            'star'         =>$request->input('star'),
            'status'       => self::STATUS_ACTIVE


        ];
    }




    public function productReviewRetrive(Request $request)
    {
        $productReview = self::query()->with('user','replies','photos')
            ->whereNull('product_review_id')
            ->where('product_id', $request->product_id)
            ->where('status',self::STATUS_ACTIVE)
            ->get();
        $totalStars = 0;
        $totalReviews = count($productReview);
        $starsCount = [];
        $totalLikes = 0;

        foreach ($productReview as $review) {
            $totalStars += $review['star'];


            $totalLikes += $review['like'];


            if (isset($starsCount[$review['star']])) {
                $starsCount[$review['star']]++;
            } else {
                $starsCount[$review['star']] = 1;
            }
        }


        $formattedStarsCount = [];
        for ($i = 1; $i <= 5; $i++) {
            $formattedStarsCount[$i] = isset($starsCount[$i]) ? $starsCount[$i] : 0;
        }


        $averageScore = $totalReviews > 0 ? $totalStars / $totalReviews : 0;

        $summary = [
            'score' => $averageScore,
            'stars' => $formattedStarsCount,
            'like_count' => $totalLikes,
            'reviews' => $productReview,
        ] ;

        return $summary;
    }



    public function photos() :HasMany
    {
        return $this->hasMany(Photo::class,'product_review_id');
    }

    public  function user()
    {
        return $this->belongsTo(User::class,'customer_id');
    }

    public function replies()
    {
        return $this->hasMany(ProductReview::class, 'product_review_id');
    }

}

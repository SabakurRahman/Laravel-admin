<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory;
     protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

        protected $fillable = [
        'question_title',
        'description',
        'status',
        'faqable_id',
        'faqable_type',
    ];


       public function allFaqList(Request $request)
    {
        $paginate  = $request->input('per_page') ?? 10;
        $query = self::query()->where('faqable_type','App\Models\FaqPage');
        if ($request->input('question_title')){
            $query->where('question_title', 'like', '%'.$request->input('question_title').'%');
        }
        if ($request->input('status')){
            $query->where('status', $request->input('status'));
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }


    public function storeFaq($data)
    {
        $faq = new self;
        $faq->question_title = $data['question_title'];
        $faq->description = $data['description'];
        $faq->status = $data['status'];
        $faq->faqable_id = $data['faqable_id'];
        $faq->faqable_type = $data['faqable_type'];
        $faq->user_id= Auth::id();
        $faq->save();

        return $faq;
    }
   
    public function allFaqLifst()
    {
        return self::query()->with('faq_page')->orderBy('id','desc')->paginate(10);
    }

    public function getFaqDetails(Request $request)
    {
        $faq=self::all();

        $faq_page  = FaqPage::query()->where('name',$request->input('page'))->first();
        if($faq_page)
        {
            $faq = self::query()->where('faq_page_id',$faq_page->id)->get();
        }
        return $faq;
    }


        public function faq_page()
    {
       return  $this->belongsTo(FaqPage::class,'faqable_id','id');
    }

        final public function activity_logs():MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

        public function faqable()
    {
        return $this->morphTo();
    }
        public function user()
    {
        return $this->belongsTo(User::class);
    }

}

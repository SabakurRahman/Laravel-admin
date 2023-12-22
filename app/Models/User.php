<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Http\Requests\StoreUserProfileRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // use HasRoles;
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'status',
    ];

    public const DEFAULT_PASSWORD = '12345678';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public const STATUS_ACTIVE = 1;
    public const STATUS_PENDING = 2;
    public const STATUS_BLOCKED = 3;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE  => 'Active',
        self::STATUS_PENDING => 'Pending',
        self::STATUS_BLOCKED => 'Blocked',
    ];



    public const PROFILE_PHOTO_PATH = 'images/uploads/users/';
    public const PROFILE_PHOTO_PATH_THUMB = 'images/uploads/users/thumb/';
    public const PROFILE_PHOTO_WIDTH = 300;
    public const PROFILE_PHOTO_HEIGHT = 300;
    public const PROFILE_PHOTO_WIDTH_THUMB = 75;
    public const PROFILE_PHOTO_HEIGHT_THUMB = 75;
    public const ONLINE_THRESHOLD_TIME = 2; //in minutes
    public const NID_PHOTO_PATH = 'images/uploads/nid/';
    public const NID_PHOTO_PATH_THUMB = 'images/uploads/nid/thumb/';


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];


    public function customerGroups()
    {
        return $this->belongsToMany(CustomerGroup::class);
    }



    public function userList(Request $request)
    {
        // return User::query()
        //     ->orderByDesc('id')
        //     ->paginate(10);
        $paginate  = $request->input('per_page') ?? 10;
        $query = self::query();
        if ($request->input('name')){
            $query->where('name', 'like', '%'.$request->input('name').'%');
        }
        if ($request->input('email')){
            $query->where('email', 'like', '%'.$request->input('email').'%');
        }
              if ($request->input('phone')){
            $query->where('phone', 'like', '%'.$request->input('phone').'%');
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }

    public function findUser($id)
    {
        return self::query()->findOrFail($id);
    }

    public function updateUserData(StoreUserProfileRequest $request)
    {
        $user = self::query()->findOrFail(Auth::id());
        $user?->update($this->prepareData($request));
        return $user;
    }

    private function prepareData(StoreUserProfileRequest $request)
    {
        return [
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ];
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }



    final public function storeUser(array $data): Builder|Model
    {
        return self::query()->create($data);
    }


    /**
     * @param string $column
     * @param string $value
     * @param bool $only_active
     * @return Model|null
     */
    final public function getUserByColumn(string $column, string $value, bool $only_active = false): Model|null
    {
        return self::query()->where($column, $value)->first();
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }


}

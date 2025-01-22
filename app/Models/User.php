<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Spatie\Activitylog\Traits\LogsActivity;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements LaratrustUser,JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRolesAndPermissions;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'password_show',
        'profile_picture',
        'address',
        'region',
        'supplier_id',
        'supplier_names',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'oauth_token_expires_at' => 'datetime',
        'last_activity' => 'datetime',
        'suppliers_added_at' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function passwordHistories()
    {
        return $this->hasMany(PasswordHistory::class);
    }
    // In User.php model
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function userEmails()
    {
        return $this->hasMany(UserEmail::class, 'username', 'username'); // Assuming 'username' is the foreign key
    }

    public function userStore()
    {
        return $this->hasMany(UserStore::class, 'user_id', 'username'); // Assuming 'username' is the foreign key
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @mixin Builder;
 * @mixin QueryBuilder;
 * Class User
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const COLUMN_ID                    = 'id';
    const COLUMN_NAME                  = 'name';
    const COLUMN_EMAIL                 = 'email';
    const COLUMN_PASSWORD              = 'password';
    const COLUMN_REMEMBER_TOKEN        = 'remember_token';
    const COLUMN_EMAIL_VERIFIED_AT     = 'email_verified_at';
    const COLUMN_CREATED_AT            = 'created_at';
    const COLUMN_UPDATED_AT            = 'updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::COLUMN_NAME,
        self::COLUMN_EMAIL,
        self::COLUMN_PASSWORD,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        self::COLUMN_PASSWORD,
        self::COLUMN_REMEMBER_TOKEN,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        self::COLUMN_EMAIL_VERIFIED_AT => 'datetime',
    ];

    public function getId(): string
    {
        return $this->{self::COLUMN_ID};
    }
    public function setId(string $value): self
    {
        $this->{self::COLUMN_ID} = $value;

        return $this;
    }

    public function hasId(): bool
    {
        return $this->{self::COLUMN_ID} !== null;
    }

    public function getEmail(): string
    {
        return $this->{self::COLUMN_EMAIL};
    }
    public function setEmail(string $value): self
    {
        $this->{self::COLUMN_EMAIL} = $value;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->{self::COLUMN_PASSWORD};
    }
    public function setPassword(string $value): self
    {
        $this->{self::COLUMN_PASSWORD} = $value;

        return $this;
    }

    public function getName(): string
    {
        return $this->{self::COLUMN_NAME};
    }
    public function setName(string $value): self
    {
        $this->{self::COLUMN_NAME} = $value;

        return $this;
    }

    public function getCreatedAt(): ?Carbon
    {
        if($this->{self::COLUMN_CREATED_AT} === null)
        {
            return null;
        }

        return Carbon::parse($this->{self::COLUMN_CREATED_AT});
    }

    public function getUpdatedAt(): ?Carbon
    {
        if($this->{self::COLUMN_UPDATED_AT} === null)
        {
            return null;
        }

        return Carbon::parse($this->{self::COLUMN_UPDATED_AT});
    }
}

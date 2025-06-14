<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Utils\Enum\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public $incrementing = false;
    protected $keyType = "string";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'username',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public static function getNextId(Role $role): string
    {
        $seed = 10000000;
        $totalUserWithPreferredRole = User::where('role', $role)->count();

        $initals = match ($role) {
            Role::ADMIN => 'AD',
            Role::DISTRIBUTOR => 'BSP',
        };

        return $initals . ($totalUserWithPreferredRole + $seed + 1);
    }

    public static function getUserById(string $id): self
    {
        $user = User::find($id);

        if ($user === null) {
            throw new \Exception("Upline does not exist");
        }

        return $user;
    }

    public function getUpline(): Upline
    {
        $upline = $this->upline;

        if ($upline === null) {
            $upline = Upline::create(['user_id' => $this->id]);
        }

        return $upline;
    }

    public function upline()
    {
        return $this->hasOne(Upline::class);
    }

    public function distributor()
    {
        return $this->hasOne(Distributor::class);
    }

    public static function createViaDistributorData(string $name, string $username, string $password): self
    {
        $role = Role::DISTRIBUTOR;

        return self::create([
            'id' => self::getNextId($role),
            'name' => $name,
            'username' => $username,
            'password' => $password,
            'role' => $role->name
        ]);
    }
}

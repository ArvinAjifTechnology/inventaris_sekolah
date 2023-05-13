<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'full_name',
        'username',
        'name',
        'email',
        'password',
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
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Fungsi CRUD
     */

    public static function getAll()
    {
        return DB::select('SELECT * FROM users ORDER BY created_at DESC');
    }

    public static function insert($request)
    {
        DB::insert('INSERT INTO users (name,username,user_code,email,first_name, last_name,level, gender, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->input('name'),
            $request->input('username'),
            $request->input('user_code'),
            $request->input('email'),
            $request->input('first_name'),
            $request->input('last_name'),
            $request->input('level'),
            $request->input('gender'),
            bcrypt($request->input('email'))
        ]);
    }

    public static function edit($fullName, $request, $username)
    {
        DB::update('UPDATE users SET name = ?, username = ?, user_code = ?, email = ?, first_name = ?, last_name = ?, level = ?, gender = ?, password = ? WHERE username = ?', [
            $fullName,
            $request->input('username'),
            $request->input('user_code'),
            $request->input('email'),
            $request->input('first_name'),
            $request->input('last_name'),
            $request->input('level'),
            $request->input('gender'),
            bcrypt($request->input('email')),
            $username
        ]);
    }

    public static function destroy($username)
    {
        DB::delete('DELETE FROM users WHERE username = ?', [$username]);
    }

    /**
     * Fungsi Ini Digunakan Untuk Mengambil FullName User
     */

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}

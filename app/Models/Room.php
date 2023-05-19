<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    public static function getAll()
    {
        return DB::table('rooms')
            ->join('users', 'rooms.user_id', '=', 'users.id')
            ->select('rooms.*', DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS user_name"))
            ->get();
    }

    public static function findId($id)
    {
        return DB::select('select * from rooms where id = ?', [$id]);
    }

    public static function insert($request)
    {
        DB::insert('INSERT INTO rooms (room_name,user_id,description) VALUES ( ?, ?, ?)', [
            $request->input('room_name'),
            $request->input('user_id'),
            $request->input('description')
        ]);
    }

    public static function edit($request)
    {
        DB::update('UPDATE rooms SET room_name = ? ,user_id = ? ,description = ? WHERE id = ?', [
            $request->input('room_name'),
            $request->input('user_id'),
            $request->input('description'),
            $request->input('id')
        ]);
    }

    public static function destroy($id)
    {
        DB::delete('DELETE FROM users WHERE id = ?', [$id]);
    }

    /**
     * Relasi Yang Digunakan
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}

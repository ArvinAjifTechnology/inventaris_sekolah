<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    public static function getAll()
    {
        return DB::table('items')
            ->join('rooms', 'items.room_id', '=', 'rooms.id')
            ->select('items.*', "rooms.room_name AS room_name")
            ->get();
    }

    public static function findId($id)
    {
        DB::select('select * from items where id = ?',[$id]);
    }

    public static function insert($request)
    {
        DB::insert('INSERT INTO items (item_code,item_name,room_id,description, `condition`, amount) VALUES (?, ?, ?, ?, ?,?)', [
            $request->input('item_code'),
            $request->input('item_name'),
            $request->input('room_id'),
            $request->input('description'),
            $request->input('condition'),
            $request->input('amount'),
        ]);
    }

    public static function edit($request)
    {
        DB::insert('UPDATE items SET item_code= ? ,item_name= ? ,room_id= ? ,description= ? , `condition`= ? , amount= ? WHERE id = ?', [
            $request->input('item_code'),
            $request->input('item_name'),
            $request->input('room_id'),
            $request->input('description'),
            $request->input('condition'),
            $request->input('amount'),
            $request->input('id')
        ]);
    }

    public static function destroy($id)
    {
        DB::delete('DELETE FROM items WHERE id = ?', [$id]);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}

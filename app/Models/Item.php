<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $casts = [
        'rental_price' => 'float',
    ];

    public static function getAll()
    {
        return DB::table('items')
            ->join('rooms', 'items.room_id', '=', 'rooms.id')
            ->select('items.*', "rooms.room_name AS room_name")
            ->get();
    }

    public static function findId($id)
    {
        return DB::select('select * from items where id = ?', [$id]);
    }

    public static function insert($request)
    {
        // DB::unprepared('CREATE TRIGGER tr_item_insert
        //     BEFORE INSERT ON items
        //     FOR EACH ROW
        //     BEGIN
        //         SET NEW.item_code = CONCAT("ITM", LPAD((SELECT COUNT(*) + 1 FROM items), 6, "0"));
        //     END;
        // ');
        DB::insert('INSERT INTO items (item_name,room_id,description, `condition`, rental_price, late_fee_per_day, quantity) VALUES (?, ?, ?, ?, ?, ?, ?)', [
            $request->input('item_name'),
            $request->input('room_id'),
            $request->input('description'),
            $request->input('condition'),
            $request->input('rental_price'),
            $request->input('late_fee_per_day'),
            $request->input('quantity'),
        ]);
    }

    public static function edit($request)
    {
        DB::insert('UPDATE items SET item_code= ? ,item_name= ? ,room_id= ? ,description= ? , `condition`= ? , rental_price= ?, late_fee_per_day= ?, quantity= ? WHERE id = ?', [
            $request->input('item_code'),
            $request->input('item_name'),
            $request->input('room_id'),
            $request->input('description'),
            $request->input('condition'),
            $request->input('rental_price'),
            $request->input('late_fee_per_day'),
            $request->input('quantity'),
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

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}

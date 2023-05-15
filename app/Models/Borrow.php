<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Borrow extends Model
{
    use HasFactory;

    public static function getAll()
    {
        // return DB::select('select * from borrows');
        // return DB::table('borrows')
        //     ->join('users', 'borows.user_id', '=', 'users.id')
        //     ->select('borows.*', DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS user_name"))
        //     ->get();
        return DB::table('borrows')
            ->join('users', 'borrows.user_id', '=', 'users.id')
            ->join('items', 'borrows.item_id', '=', 'items.id')
            ->select('borrows.*', 'items.item_name', 'items.item_code', DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS user_name"))
            ->get();
    }

    public static function findId($id)
    {
        DB::select('select * from items where id = ?', [$id]);
    }

    public function borrowCode()
    {
    }

    public static function insert($request)
    {

        // DB::unprepared('CREATE TRIGGER tr_borrow_insert
        //     BEFORE INSERT ON borrows
        //     FOR EACH ROW
        //     BEGIN
        //         SET NEW.borrow_code = CONCAT("ITM", LPAD((SELECT COUNT(*) + 1 FROM items), 6, "0"));
        //     END;
        // ');
        DB::insert('INSERT INTO borrows (borrow_date,return_date,item_id, user_id, borrow_status) VALUES (?, ?, ?, ?, ?)', [
            $request->input('borrow_date'),
            $request->input('return_date'),
            $request->input('item_id'),
            $request->input('user_id'),
            'dipinjam',
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

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

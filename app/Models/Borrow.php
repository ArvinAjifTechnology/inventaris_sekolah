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
        return DB::select('select * from borrows');
    }

    public static function findId($id)
    {
        DB::select('select * from items where id = ?', [$id]);
    }

    public static function insert($request)
    {
        DB::insert('INSERT INTO items (item_id,user_id,borrow_code,borrow_date, retun_date, borrow_status) VALUES (?, ?, ?, ?, ?,?)', [
            $request->input('item_id'),
            $request->input('user_id'),
            $request->input('borrow_code'),
            $request->input('borrow_date'),
            $request->input('retun_date'),
            $request->input('borrow_status'),
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
}

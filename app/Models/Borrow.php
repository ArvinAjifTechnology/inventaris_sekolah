<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function calculateLateFee($borrow)
    {
        // hitung selisih hari dari tanggal pengembalian yang seharusnya
        $dueDate = Carbon::parse($this->return_date);
        $actualReturnDate = Carbon::now();
        $daysLate = $actualReturnDate->diffInDays($dueDate, false);
        // dd($daysLate);
        // $daysLate = 99;
        if ($actualReturnDate < $dueDate) {
            $daysLate = 0;
        }
        // hitung denda
        $lateFee = 0;
        $late_fee_per_day  = $this->item->late_fee_per_day;
        if ($daysLate > 0) {
            $lateFee = $daysLate * $late_fee_per_day * $borrow->borrow_quantity;
        }

        return $lateFee;
    }

    public function calculateTotalRentalPrice($borrow)
    {
        // $borrowDate = Carbon::parse($this->borrow_date);
        // $returnDate = Carbon::parse($this->return_date);
        // $totalDays = $returnDate->diffInDays($borrowDate);
        // // $totalDays = 99;
        // $rental_price = $this->item->rental_price;

        // // $total_rental_price = $totalDays * $borrow->borrow_quantity  * $rental_price;

        // if ($totalDays > 0) {
        //     $total_rental_price = $totalDays * $rental_price * $borrow->borrow_quantity;
        //     return $total_rental_price;
        // }
        // // $this->load('borrow');
        // $total_rental_price = 0;

        // // if ($totalDays >= 0 && $this->borrow) {
        // //     $total_rental_price = $totalDays * $rental_price * $borrow->borrow_quantity;
        // //     return $total_rental_price;
        // // } else {
        // //     $total_rental_price = $totalDays * $rental_price * $borrow->borrow_quantity;
        // //     return $total_rental_price;
        // // }
        // return $total_rental_price;

        $borrowDate = Carbon::parse($this->borrow_date);
        $returnDate = Carbon::parse($this->return_date);
        $actualReturnDate = Carbon::now();

        if ($actualReturnDate <= $returnDate) {
            // Pengembalian dilakukan sebelum atau pada tanggal pengembalian
            $totalDays = $actualReturnDate->diffInDays($borrowDate) + 1;
        } else {
            // Pengembalian dilakukan setelah tanggal pengembalian
            $totalDays = $returnDate->diffInDays($borrowDate) + 1;
        }

        $rental_price = $this->item->rental_price;
        $total_rental_price = $totalDays * $rental_price * $borrow->borrow_quantity;

        return $total_rental_price;
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

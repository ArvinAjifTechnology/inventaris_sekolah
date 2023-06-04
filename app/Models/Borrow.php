<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\BorrowNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrow extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function getAll()
    {
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

    public static function createBorrow($request)
    {
        $borrow = new Borrow();
        $borrow->borrow_date = $request->input('borrow_date');
        $borrow->return_date = $request->input('return_date');
        $borrow->item_id = $request->input('item_id');
        $borrow->user_id = $request->input('user_id');
        $borrow->borrow_quantity = $request->input('borrow_quantity');
        $borrow->late_fee = 0;
        $borrow->total_rental_price = 0;
        $borrow->borrow_status = 'borrowed';
        $borrow->sub_total = 0;
        $borrow->save();
        // dd($borrow->borrow_code);
        return $borrow;
    }

    public function calculateLateFee($borrow)
    {
        // hitung selisih hari dari tanggal pengembalian yang seharusnya
        $dueDate = $this->return_date;
        $actualReturnDate = date('Y-m-d');
        // $daysLate = $actualReturnDate->diffInDays($dueDate, false);
        $daysLate = DB::select('SELECT DATEDIFF(?,?) AS daysLate', [$actualReturnDate, $dueDate])[0]->daysLate;
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

    public static function destroy($id)
    {
        DB::delete('DELETE FROM borrows WHERE id = ?', [$id]);
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

        // $borrowDate = Carbon::parse($this->borrow_date);
        // $returnDate = Carbon::parse($this->return_date);
        // $actualReturnDate = Carbon::now();
        $borrowDate = $this->borrow_date;
        $returnDate = $this->return_date;
        $actualReturnDate = date('Y-m-d');

        $daysLate = 0;

        if ($actualReturnDate <= $returnDate) {
            // Pengembalian dilakukan sebelum atau pada tanggal pengembalian
            $totalDays = DB::select("SELECT DATEDIFF(?, ?)  AS daysDiff", [$actualReturnDate, $borrowDate])[0]->daysDiff + 1;
        } else {
            // Pengembalian dilakukan setelah tanggal pengembalian
            // $totalDays = $returnDate->diffInDays($borrowDate) + 1;
            $totalDays = DB::select("SELECT DATEDIFF(?, ?)  AS daysDiff", [$returnDate, $borrowDate])[0]->daysDiff + 1;
        }

        $rental_price = $this->item->rental_price;
        $total_rental_price = $totalDays * $rental_price * $borrow->borrow_quantity;

        return $total_rental_price;
    }

    public function calculateSubTotal()
    {
        $sub_total = $this->late_fee + $this->total_rental_price;

        return $sub_total;
    }

    public static function returnItem($id)
    {
        $borrow = Borrow::find($id);
        if (!$borrow) {
            return redirect()->back()->with('error', 'Data not found');
        }

        $item = Item::find($borrow->item_id);
        $item->quantity += $borrow->borrow_quantity;
        $item->update();

        $borrow->total_rental_price = $borrow->calculateTotalRentalPrice($borrow);
        $borrow->late_fee = $borrow->calculateLateFee($borrow);
        $borrow->sub_total = $borrow->calculateSubTotal();
        $borrow->borrow_status = 'completed';
        $borrow->update();

        $borrow->user->notify(new BorrowNotification($borrow));
    }

    public static function submitBorrowRequest($request)
    {
        // dd($request->all());
        $borrow = new Borrow();
        $borrow->verification_code_for_borrow_request = $request->input('uniqid');
        $borrow->borrow_date = $request->input('borrow_date');
        $borrow->return_date = $request->input('return_date');
        $borrow->item_id = $request->input('item_id');
        $borrow->user_id = $request->input('user_id');
        $borrow->borrow_quantity = $request->input('borrow_quantity');
        $borrow->late_fee = 0;
        $borrow->total_rental_price = 0;
        $borrow->borrow_status = 'pending';
        $borrow->sub_total = 0;
        $borrow->save();
        // dd($borrow->borrow_code);
        return $borrow;
    }

    public static function verifySubmitBorrowRequest($request, $borrow_code)
    {
        $borrow = Borrow::where('borrow_code', '=', $borrow_code)->first();
        $borrow->borrow_date = $request->borrow_date;
        $borrow->return_date = $request->input('return_date');
        $borrow->item_id = $request->input('item_id');
        $borrow->user_id = $request->input('user_id');
        $borrow->borrow_quantity = $request->input('borrow_quantity');
        $borrow->late_fee = 0;
        $borrow->total_rental_price = 0;
        $borrow->borrow_status = 'borrowed';
        $borrow->sub_total = 0;
        $borrow->save();

        return $borrow;
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

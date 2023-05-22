<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Rules\SufficientQuantityRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('admin')) {
            $borrows = Borrow::latest()->get();
        } elseif (Gate::allows('operator')) {
            $borrows = Borrow::latest()->get();
        } elseif (Gate::allows('borrower')) {
            $borrows = Borrow::latest()->where('user_id', Auth::user()->id)->get();
        } else {
            abort(403, 'Unauthorized');
        }
        return view('borrows.index', compact('borrows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all()->where('condition', '=', 'good');
        $users = User::all()->where('role', '=', 'borrower');

        return view('borrows.create', compact('items', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'borrow_date' => ['required', 'date', 'after_or_equal:today'],
            'return_date' => ['required', 'date', 'after:borrow_date'],
            'item_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'borrow_quantity' => ['required', 'integer', new SufficientQuantityRule],
        ]);


        if (Gate::allows('admin')) {
            if ($validator->fails()) {
                return redirect('/admin/borrows/create')
                    ->withErrors($validator)
                    ->withInput();
            }
        } elseif (Gate::allows('operator')) {
            if ($validator->fails()) {
                return redirect('/operator/borrows/create')
                    ->withErrors($validator)
                    ->withInput();
            }
        } else {
            abort(403, 'Unauthorized');
        }


        // Borrow::insert($request);

        // $item = Item::find($borrow->item_id);
        // $item->quantity += 1;
        // $item->save();

        $item = Item::find($request->input('item_id'));
        if ($item->quantity > 0) {
            $borrow = new Borrow();
            $borrow->borrow_date = $request->input('borrow_date');
            $borrow->return_date = $request->input('return_date');
            $borrow->item_id = $request->input('item_id');
            $borrow->user_id = $request->input('user_id');
            $borrow->borrow_quantity = $request->input('borrow_quantity');
            $borrow->late_fee = 0;
            $borrow->total_rental_price = 0;
            $borrow->borrow_status = 'dipinjam';
            $borrow->save();

            $item->quantity -= $request->input('borrow_quantity');
            $item->save();
            if (Gate::allows('admin')) {
                return redirect('/admin/borrows')->withErrors($validator)->withInput()->with('status', 'Selamat Data Berhasil Di Tambahkan');
            } elseif (Gate::allows('operator')) {
                return redirect('/operator/borrows')->withErrors($validator)->withInput()->with('status', 'Selamat Data Berhasil Di Tambahkan');
            } else {
                abort(403, 'Unauthorized');
            }
            // return redirect('/borrows')->withErrors($validator)->withInput()->with('status', 'Selamat Data Berhasil Di Tambahkan');
        } else {
            if (Gate::allows('admin')) {
                return redirect('admin/borrows/create')->withErrors(['error' => 'Stok barang habis'])->withInput();
            } elseif (Gate::allows('operator')) {
                return redirect('operator/borrows/create')->withErrors(['error' => 'Stok barang habis'])->withInput();
            } else {
                abort(403, 'Unauthorized');
            }
        }


        // return redirect('/borrows')->withErrors($validator)->withInput()->with('status', 'Selamat Data Berhasil Di Tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $borrow = Borrow::find($id);
        return view('borrows.show', compact('borrow'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $borrow = Borrow::find($id);
        $items = Item::all()->where('condition', '=', 'good');
        $users = User::all()->where('role', '=', 'borrower');
        return view('borrows.edit', compact('borrow', 'items', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'borrow_date' => ['required', 'date', 'after_or_equal:today'],
            'return_date' => ['required', 'date', 'after:borrow_date'],
            'item_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'borrow_quantity' => ['required', 'integer', new SufficientQuantityRule],
        ]);

        if (Gate::allows('admin')) {
            if ($validator->fails()) {
                return redirect('/admin/borrows/' . $id . '/edit')
                    ->withErrors($validator)
                    ->withInput();
            }
        } elseif (Gate::allows('operator')) {
            if ($validator->fails()) {
                return redirect('/operator/borrows/' . $id . '/edit')
                    ->withErrors($validator)
                    ->withInput();
            }
        } else {
            abort(403, 'Unauthorized');
        }

        $item = Item::find($request->input('item_id'));
        if ($item->quantity > 0) {
            $borrow = Borrow::find($id); // Ambil data peminjaman yang akan diupdate

            $borrow->borrow_date = $request->input('borrow_date');
            $borrow->return_date = $request->input('return_date');
            $borrow->item_id = $request->input('item_id');
            $borrow->user_id = $request->input('user_id');
            // Dapatkan jumlah peminjaman sebelumnya
            $previousQuantity = $borrow->borrow_quantity;
            // $borrow->borrow_quantity = $request->input('borrow_quantity');
            $borrow->late_fee = 0;
            $borrow->total_rental_price = 0;
            $borrow->borrow_status = 'dipinjam';


            // dd($previousQuantity);
            // Update model Borrow dengan input pengguna
            $borrow->borrow_quantity = $request->input('borrow_quantity');

            // Dapatkan perubahan absolut pada jumlah peminjaman
            $absoluteChange = $borrow->borrow_quantity - $previousQuantity;

            // Dapatkan model Item yang terkait
            $item = $borrow->item;

            // Tentukan apakah akan menambah atau mengurangi stok barang
            if ($borrow->borrow_quantity > $previousQuantity) {
                // Jika jumlah peminjaman bertambah, tambahkan ke stok barang
                $item->quantity -= $absoluteChange;
                // dd($previousQuantity, $absoluteChange, $item->quantity);
            } elseif ($borrow->borrow_quantity < $previousQuantity) {
                // Jika jumlah peminjaman berkurang, kurangi dari stok barang
                $item->quantity -= $absoluteChange;
            }

            // Simpan perubahan pada model Borrow dan Item
            $borrow->save();
            $item->save();

            if (Gate::allows('admin')) {
                return redirect('/admin/borrows')->with('status', 'Data berhasil diperbarui');
            } elseif (Gate::allows('operator')) {
                return redirect('/operator/borrows')->with('status', 'Data berhasil diperbarui');
            } else {
                abort(403, 'Unauthorized');
            }
        } else {
            if (Gate::allows('admin')) {
                return redirect('admin/borrows/' . $id . '/edit')->withErrors(['error' => 'Stok barang habis'])->withInput();
            } elseif (Gate::allows('operator')) {
                return redirect('operator/borrows/' . $id . '/edit')->withErrors(['error' => 'Stok barang habis'])->withInput();
            } else {
                abort(403, 'Unauthorized');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $borrow = Borrow::all()->where('id', '=', $id);
        $borrow->item()->delete();
        $borrow->user()->delete();
        Borrow::destroy($id);

        return redirect('/items')->with('status', 'Data berhasil Di Hapus');
    }

    public function returnBorrow(Request $request, $id)
    {
        $borrow = Borrow::find($id);
        if (!$borrow) {
            return redirect()->back()->with('error', 'Data not found');
        }
        $item = Item::find($borrow->item_id);
        $item->quantity += $borrow->borrow_quantity;
        $item->update();
        // dd($borrow->item->quantity);
        // $borrow->return_date = date('Y-m-d');
        $borrow->total_rental_price = $borrow->calculateTotalRentalPrice($borrow);
        $borrow->late_fee = $borrow->calculateLateFee($borrow);
        $borrow->borrow_status = 'selesai';
        $borrow->update();


        return redirect()->back()->with('status', 'Item returned successfully');
    }
}

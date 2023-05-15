<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrows = Borrow::all();
        return view('borrows.index', compact('borrows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::getAll();
        $users = User::all();

        return view('borrows.create', compact('items', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'borrow_date' => ['required', 'string'],
            'return_date' => ['required', 'string'],
            'item_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'borrow_quantity' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return redirect('/borrows/create')
                ->withErrors($validator)
                ->withInput();
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
            $borrow->fine = 0;
            $borrow->borrow_status = 'dipinjam';
            $borrow->save();

            $item->quantity -= $request->input('borrow_quantity');
            $item->save();

            return redirect('/borrows')->withErrors($validator)->withInput()->with('status', 'Selamat Data Berhasil Di Tambahkan');
        } else {
            return redirect('/borrows/create')->withErrors(['error' => 'Stok barang habis'])->withInput();
        }


        // return redirect('/borrows')->withErrors($validator)->withInput()->with('status', 'Selamat Data Berhasil Di Tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
        $borrow->return_date = date('Y-m-d');
        $borrow->borrow_status = 'tersedia';
        $borrow->update();


        return redirect()->back()->with('success', 'Item returned successfully');
    }
}

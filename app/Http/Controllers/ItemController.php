<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::getAll();
        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::all();
        return view('items.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => ['required', 'string'],
            'item_code' => ['required', 'string', Rule::unique('items')],
            'room_id' => ['required', 'integer'],
            'description' => ['required', 'string'],
            'condition' => ['required', 'string'],
            'amount' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return redirect('/items/create')
                ->withErrors($validator)
                ->withInput();
        }
        Item::insert($request);

        return redirect('/items')->withErrors($validator)->withInput()->with('status', 'Selamat Data Berhasil Di Tambahkan');
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
        $item = Item::findId($id);
        $rooms = Room::getAll();
        return view('items.edit', compact('item', 'rooms', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = $request->input('id');
        $item = DB::select('select * from items where id = ?', [$id]);
        $validator = Validator::make($request->all(), [
            'item_name' => ['required', 'string'],
            'item_code' => ['required', 'string', Rule::unique('items')->ignore($item[0]->id)],
            'room_id' => ['required', 'integer'],
            'description' => ['required', 'string'],
            'condition' => ['required', 'string'],
            'amount' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return redirect('/items/edit')
                ->withErrors($validator)
                ->withInput();
        }

        Item::edit($request);

        return redirect('/items')->withErrors($validator)->with('status', 'Selamat Data Berhasil Di Update')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Item::deleted($id);
        return redirect('/items')->with('status', 'Data berhasil Di Hapus');
    }
}

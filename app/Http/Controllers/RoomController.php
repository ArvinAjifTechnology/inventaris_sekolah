<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $rooms= DB::select('select * from rooms');
        $rooms = Room::getAll(); //model

        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::latest()->get();
        // $user = Collection::make($user);
        return view('rooms.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_name' => ['required', 'string'],
            // 'room_code' => ['required', 'string', Rule::unique('rooms')],
            'user_id' => ['required', 'integer'],
            'description' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect('/rooms/create')
                ->withErrors($validator)
                ->withInput();
        }
        $fullName = $request->first_name . $request->last_name;

        Room::insert($request);

        return redirect('/rooms')->withErrors($validator)->withInput()->with('status', 'Selamat Data Berhasil Di Tambahkan');
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
        $room = Room::findId($id);
        $users = User::latest()->get();
        return view('rooms.edit', compact('room', 'id', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = $request->input('id');
        $room = DB::select('select * from rooms where id = ?', [$id]);
        $validator = Validator::make($request->all(), [
            'room_name' => ['required', 'string'],
            // 'room_code' => ['required', 'string', Rule::unique('rooms')->ignore($room[0]->id)],
            'user_id' => ['required', 'integer'],
            'description' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect('/rooms/edit')
                ->withErrors($validator)
                ->withInput();
        }
        $fullName = $request->input('first_name') . $request->input('last_name');
        // Mengupdate User
        Room::edit($request);

        return redirect('/rooms')->withErrors($validator)->with('status', 'Selamat Data Berhasil Di Update')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Room::destroy($id);
        return redirect('/rooms')->with('status', 'Data berhasil Di Hapus');
    }
}

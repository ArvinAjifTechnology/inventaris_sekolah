<?php

namespace App\Http\Controllers;

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
        $rooms = DB::table('rooms')
            ->join('users', 'rooms.user_id', '=', 'users.id')
            ->select('rooms.*', DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS user_name"))
            ->get();

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
            'room_code' => ['required', 'string', Rule::unique('rooms')],
            'capacity' => ['required', 'string'],
            'user_id' => ['required', 'integer'],
            'description' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect('/rooms')
            ->withErrors($validator)
            ->withInput();
        }
        $fullName = $request->first_name . $request->last_name;

        DB::insert('INSERT INTO rooms (room_code,room_name,capacity,user_id,description) VALUES (?, ?, ?, ?, ?)', [
            $request->input('room_code'),
            $request->input('room_name'),
            $request->input('capacity'),
            $request->input('user_id'),
            $request->input('description')
        ]);

        return redirect('/rooms')->withErrors($validator)->withInput()->withSuccess('Selamat Data Bberhasil Di Tambahkan');
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
        $room = DB::select('select * from rooms');
        $users = User::latest()->get();
        return view('rooms.edit', compact('room', 'id', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = DB::select('select * from users where id = ?', [$id]);

        $validator = Validator::make($request->all(), [
            'room_name' => ['required', 'string'],
            'room_code' => ['required', 'string', Rule::unique('rooms')->ignore($user[0]->id)],
            'capacity' => ['required', 'string'],
            'user_id' => ['required', 'integer'],
            'description' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect('/rooms/edit')
            ->withErrors($validator)
            ->withInput();
        }
        $fullName = $request->input('first_name') . $request->input('last_name');
        DB::update('UPDATE rooms SET room_code = ? ,room_name = ? ,capacity = ? ,user_id = ? ,description = ? ', [
            $request->input('room_code'),
            $request->input('room_name'),
            $request->input('capacity'),
            $request->input('user_id'),
            $request->input('description')
        ]);

        return redirect('/rooms')->withErrors($validator)->withSuccess('Selamat Data Berhasil Di Update')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::delete('DELETE FROM users WHERE id = ?', [$id]);
            return redirect('/users')->with('success', 'Data berhasil Di Hapus');
    }
}

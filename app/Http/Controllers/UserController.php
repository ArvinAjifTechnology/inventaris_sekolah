<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::getAll();
        // $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id = NULL)
    {
        $user = DB::select('select * from users where id = ?', [1]);
        $user = Collection::make($user);
        return view('users.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'user_code' => ['required', 'string', Rule::unique('users')],
            'username' => ['required', 'string', Rule::unique('users')],
            'email' => ['required', 'email', Rule::unique('users')],
            'role' => ['required', 'string'],
            'gender' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect('/users/create')
                ->withErrors($validator)
                ->withInput();
        }
        $fullName = $request->first_name . $request->last_name;

        User::insert($request);

        return redirect()->back()->withErrors($validator)->with('status', 'Selamat Data Berhasil Di Tambahkan')->withInput();
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
        $user = DB::select('select * from users  where username = ?', [$id]);
        // $user = Collection::make($user);
        // $user = collect($user)->map(function($item) {
        //     return (object) $item;
        // });
        // $user = User::find($id);
        // dd($user);
        return view('users.edit', compact('user', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $username)
    {
        $user = DB::select('select * from users where username = ?', [$username]);

        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'user_code' => ['required', 'string', Rule::unique('users')->ignore($user[0]->id)],
            'username' => ['required', 'string', Rule::unique('users')->ignore($user[0]->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user[0]->id)],
            'role' => ['required', 'string'],
            'gender' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect('/users/create')
                ->withErrors($validator)
                ->withInput();
        }
        $fullName = $request->input('first_name') . $request->input('last_name');
        User::edit($fullName, $request, $username);

        return redirect('/users')->withErrors($validator)->withSuccess('Selamat Data Berhasil Di Update')->with('status', 'Selamat Data Berhasil Di Update')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $username)
    {
        User::destroy($username);
        return redirect('/users')->with('status', 'Data berhasil Di Hapus');
    }
}

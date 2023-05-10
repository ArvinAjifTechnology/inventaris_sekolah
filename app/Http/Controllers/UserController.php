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
    //   $users=   DB::select('SELECT * FROM users ORDER BY created_at DESC');
        $users = User::all();
      return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id=NULL)
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
            'name' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'user_code' => ['required', 'string', Rule::unique('users')],
            'username' => ['required', 'string', Rule::unique('users')],
            'email' => ['required', 'email', Rule::unique('users')],
            'level' => ['required', 'string'],
            'gender' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect('/users/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        DB::insert('INSERT INTO users (name,username,user_code,email,first_name, last_name,level, gender, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->input('name'),
            $request->input('username'),
            $request->input('user_code'),
            $request->input('email'),
            $request->input('first_name'),
            $request->input('last_name'),
            $request->input('level'),
            $request->input('gender'),
            bcrypt($request->input('email'))
        ]);

        return redirect()->back()->withErrors($validator)->withInput();
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
        $user = DB::select('select * from users');
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
            'name' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'user_code' => ['required', 'string', Rule::unique('users')->ignore($user[0]->id)],
            'username' => ['required', 'string', Rule::unique('users')->ignore($user[0]->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user[0]->id)],
            'level' => ['required', 'string'],
            'gender' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect('/users/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        DB::update('UPDATE users SET name = ?, username = ?, user_code = ?, email = ?, first_name = ?, last_name = ?, level = ?, gender = ?, password = ? WHERE username = ?', [
            $request->input('name'),
            $request->input('username'),
            $request->input('user_code'),
            $request->input('email'),
            $request->input('first_name'),
            $request->input('last_name'),
            $request->input('level'),
            $request->input('gender'),
            bcrypt($request->input('email')),
            $username
        ]);

        return redirect()->back()->withErrors($validator)->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $username)
    {
        DB::delete('DELETE FROM users WHERE username = ?', [$username]);
        return redirect('/users')->with('success', 'Data berhasil Di Hapus');
    }
}

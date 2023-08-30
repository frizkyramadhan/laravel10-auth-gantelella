<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('admin_auth:superadmin');
    // }

    public function index()
    {
        $title = 'Users';
        $subtitle = 'List of Users';
        $users = User::orderBy('name', 'asc')->get();

        return view('users.index', compact('title', 'subtitle', 'users'));
    }

    public function getUsers(Request $request)
    {
        $users = User::orderBy('name', 'asc');

        return datatables()->of($users)
            ->addIndexColumn()
            ->addColumn('name', function ($users) {
                return $users->name;
            })
            ->addColumn('email', function ($users) {
                return $users->email;
            })
            ->addColumn('level', function ($users) {
                return $users->level;
            })
            ->addColumn('user_status', function ($users) {
                if ($users->user_status == '1') {
                    return '<span class="badge badge-success">Active</span>';
                } elseif ($users->user_status == '0') {
                    return '<span class="badge badge-danger">Inactive</span>';
                }
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', "%$search%")
                            ->orWhere('level', 'LIKE', "%$search%")
                            ->orWhere('user_status', 'LIKE', "%$search%");
                    });
                }
            })
            ->addColumn('action', 'users.action')
            ->rawColumns(['user_status', 'action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Users';
        $subtitle = 'Add User';

        return view('users.create', compact('title', 'subtitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email:dns|unique:users|ends_with:@arka.co.id',
        //     'password' => 'required|min:5',
        //     'level' => 'required',
        //     'status' => 'required',
        // ], [
        //     'name.required' => 'Name is required',
        //     'email.required' => 'Email is required',
        //     'password.required' => 'Password is required'
        // ]);
        // $validatedData['password'] = Hash::make($validatedData['password']);

        // User::create($validatedData);

        $data = $request->all();

        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->role = $data['role'];
        $user->status = $data['status'];
        $user->save();

        return redirect('users')->with('success', 'User added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Users';
        $subtitle = 'Edit User';
        $user = User::find($id);

        return view('users.edit', compact('title', 'subtitle', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $this->validate($request, [
        //     'name' => 'required'
        // ], [
        //     'name.required' => 'Name is required',
        //     'email.required' => 'Email is required'
        // ]);

        $input = $request->all();
        $user = User::find($id);

        // if ($request->email != $user->email) {
        //     $this->validate($request, [
        //         'email' => 'required|unique:users|ends_with:@arka.co.id'
        //     ]);
        // }

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user->update($input);

        return redirect('users')->with('success', 'User edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('users')->with('success', 'User deleted successfully');
    }

    // buat fungsi untuk parsley.js check email unique dari table users
    public function checkNewEmail(Request $request)
    {
        if ($request->has('email')) {
            $email = trim($request->input('email'));

            $total_row = DB::table('users')
                ->where('email', $email)
                ->count();

            if ($total_row === 0) {
                $output = [
                    'success' => true,
                ];

                return response()->json($output);
            }
        }
    }

    // buat fungsi untuk parsley.js check email unique dari table users jika email yang diinput sama dengan email yang sudah ada
    public function checkEditEmail(Request $request, $id)
    {
        $user = User::find($id);
        if ($request->has('email')) {
            $email = trim($request->input('email'));

            if ($email == $user->email) {
                $output = [
                    'success' => true,
                ];

                return response()->json($output);
            } else {
                $total_row = DB::table('users')
                    ->where('email', $email)
                    ->count();

                if ($total_row === 0) {
                    $output = [
                        'success' => true,
                    ];

                    return response()->json($output);
                }
            }
        }
    }
}

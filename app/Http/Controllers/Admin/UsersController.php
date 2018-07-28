<?php

namespace App\Http\Controllers\Admin;

use App\Entity\User;
use App\Http\Controllers\Controller;
use App\UseCases\Auth\RegisterService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\Admin\Users\{
    CreateRequest, UpdateRequest
};


class UsersController extends Controller
{
    private $service;

    public function __construct(RegisterService $service)
    {
        $this->service = $service;
        $this->middleware('can:manage-users');
    }

    public function index(Request $request)
    {
        $query = User::orderBy('id', 'desc');

        if (!empty($value = $request->get('id'))){
            $query->where('id', $value);
        }

        if (!empty($value = $request->get('name'))){
            $query->where('name', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('email'))){
            $query->where('email', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('status'))){
            $query->where('status', $value);
        }

        if (!empty($value = $request->get('role'))){
            $query->where('role', $value);
        }

        $users = $query->paginate(20);

        $statuses = [User::STATUS_ACTIVE => 'Active', User::STATUS_WAIT => 'Wait'];
        $roles = User::rolesList();

        return view('admin.users.index', compact('users', 'statuses', 'roles'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(CreateRequest $request)
    {
        $user = User::create($request->only(['name', 'email']) + [
                'password' => bcrypt(Str::random()),
                'status' => User::STATUS_ACTIVE,
            ]);

        return redirect()->route('admin.users.show', $user);
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = User::rolesList();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateRequest $request, User $user)
    {
        $user->update($request->only(['name', 'email', 'status', 'role']));
        return redirect()->route('admin.users.show', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index');
    }

    public function verify(User $user)
    {
        $this->service->verify($user->id);
        return redirect()->route('admin.users.show', $user);
    }
}

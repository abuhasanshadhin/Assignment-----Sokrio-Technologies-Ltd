<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function getUsers()
    {
        $users = $this->userRepo->get();
        return response()->json(['users' => $users]);
    }

    public function addUser(Request $req)
    {
        $res = $this->userRepo->add($req->all());
        return response()->json(['message' => $res->message], $res->code);
    }

    public function updateUser(Request $req, $id)
    {
        $res = $this->userRepo->update($req->all(), $id);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function deleteUser($id)
    {
        $res = $this->userRepo->delete($id);
        return response()->json(['message' => $res->message], $res->code);
    }
}

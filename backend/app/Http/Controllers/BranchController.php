<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BranchRepository;

class BranchController extends Controller
{
    private $branchRepo;

    public function __construct(BranchRepository $branchRepo)
    {
        $this->branchRepo = $branchRepo;
    }

    public function getBranches()
    {
        $branches = $this->branchRepo->get();
        return response()->json(['branches' => $branches]);
    }

    public function addBranch(Request $req)
    {
        $res = $this->branchRepo->add($req->all());
        return response()->json(['message' => $res->message], $res->code);
    }

    public function updateBranch(Request $req, $id)
    {
        $res = $this->branchRepo->update($req->all(), $id);
        return response()->json(['message' => $res->message], $res->code);
    }

    public function deleteBranch($id)
    {
        $res = $this->branchRepo->delete($id);
        return response()->json(['message' => $res->message], $res->code);
    }
}

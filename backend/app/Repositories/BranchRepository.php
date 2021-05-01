<?php

namespace App\Repositories;

use App\Models\Branch;
use Exception;
use stdClass;

class BranchRepository
{
    public function get()
    {
        return Branch::latest()->get();
    }

    public function getById($id)
    {
        return Branch::find($id);
    }

    public function add($data)
    {
        $res = new stdClass;

        try {
            $branch = new Branch();
            $branch->create($data);

            $res->message = 'Branch added successfully';
            $res->code = 200;
        } catch (Exception $e) {
            $res->message = $e->getMessage();
            $res->code = 500;
        }

        return $res;
    }

    public function update($data, $id)
    {
        $res = new stdClass;

        try {
            $branch = $this->getById($id);
            $branch->update($data);

            $res->message = 'Branch updated successfully';
            $res->code = 200;
        } catch (Exception $e) {
            $res->message = $e->getMessage();
            $res->code = 500;
        }

        return $res;
    }

    public function delete($id)
    {
        $res = new stdClass;

        try {
            $branch = $this->getById($id);
            $branch->delete();

            $res->message = 'Branch deleted successfully';
            $res->code = 200;
        } catch (Exception $e) {
            $res->message = $e->getMessage();
            $res->code = 500;
        }

        return $res;
    }
}

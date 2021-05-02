<?php

namespace App\Repositories;

use App\Models\User;
use Exception;
use stdClass;

class UserRepository
{
    public function get()
    {
        $user = User::query();

        if (request('branch_id')) {
            $user->where('branch_id', request('branch_id'));
        }

        return $user->with('branch')->latest()->get();
    }

    public function getById($id)
    {
        return User::with('branch')->find($id);
    }

    public function add($data)
    {
        $res = new stdClass;

        try {

            if ($data['role'] == 'manager') {

                $manager = User::where('branch_id', $data['branch_id'])
                    ->where('role', 'manager')
                    ->first();

                if ($manager) {
                    $res->message = 'Manager already exists for this branch';
                    $res->code = 409;
                    return $res;
                }
            }

            $user = new User();
            $data['password'] = bcrypt($data['password']);
            $user->create($data);

            $res->message = 'Employee added successfully';
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

            if ($data['role'] == 'manager') {
                
                $manager = User::where('branch_id', $data['branch_id'])
                    ->where('role', 'manager')
                    ->where('id', '!=', $id)
                    ->first();

                if ($manager) {
                    $res->message = 'Manager already exists for this branch';
                    $res->code = 409;
                    return $res;
                }
            }

            $user = $this->getById($id);

            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }

            $user->update($data);

            $res->message = 'Employee updated successfully';
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
            $user = $this->getById($id);
            $user->delete();

            $res->message = 'Employee deleted successfully';
            $res->code = 200;
        } catch (Exception $e) {
            $res->message = $e->getMessage();
            $res->code = 500;
        }

        return $res;
    }
}

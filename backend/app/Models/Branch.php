<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'address'];

    protected $appends = ['total_users'];

    public function getTotalUsersAttribute()
    {
        return $this->users()->count();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

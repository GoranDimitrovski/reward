<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {

    protected $fillable = [
        'uuid',
        'bio',
        'name',
        'company_id',
        'title',
        'avatar'
    ];

    public function company() {
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }

}

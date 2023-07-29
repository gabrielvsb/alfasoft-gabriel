<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pearson extends Model
{
    use HasFactory;

    protected $table = 'persons';

    protected $fillable = ['name', 'email'];

    public $timestamps = false;

    public function contacts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Contact::class);
    }

}

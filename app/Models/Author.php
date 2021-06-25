<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'surname'];
    public $timestamps = false;

    public function getFullNameAttribute(): string
    {
        return $this->name.' '.$this->surname;
    }
}

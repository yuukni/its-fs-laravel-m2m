<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'bio',
    ];

    public function mangas()
    {
        return $this->hasMany(Manga::class);
    }
}

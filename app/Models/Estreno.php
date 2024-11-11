<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Estreno extends Model
{
    use HasFactory;
    protected $fillable = ['isbn','title','description','publisher','release_date','image'];
    public function usuarios() : BelongsToMany{
        return $this->belongsToMany(Usuario::class);
    }
}

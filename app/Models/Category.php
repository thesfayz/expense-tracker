<?php

// declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// final readonly class
// а где контроллер? как создавать категории? :(
class Category extends Model
{
    protected $fillable = [
        'name',
    ];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}

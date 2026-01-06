<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    use HasFactory;

    protected $fillable = [
        'treeId',
        'treeType',
        'datePlanted',
        'height',
        'diameter',
        'location',
        'description',
        'user_id',
    ];

    public const TREE_TYPES = [
        'Fruit-Bearing' => 'Fruit-Bearing',
        'Timber'        => 'Timber',
        'Medicinal'     => 'Medicinal',
        'Ornamental'    => 'Ornamental',
    ];
}

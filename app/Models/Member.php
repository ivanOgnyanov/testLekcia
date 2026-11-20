<?php

namespace App\Models;

use Database\Factories\MemberFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Член на клуба - примерът с FormRequest от лекция 5 (слайдове 36-46).
 */
#[Fillable(['name', 'email'])]
class Member extends Model
{
    /** @use HasFactory<MemberFactory> */
    use HasFactory;
}

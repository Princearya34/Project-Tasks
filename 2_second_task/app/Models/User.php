<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory;

    // Allow these fields to be mass assigned
    protected $fillable = ['name', 'email', 'phone', 'image'];

    // Define many-to-many relationship with Project model
    public function projects(): BelongsToMany
{
    return $this->belongsToMany(Project::class, 'project_user');
}


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTag extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Correct pivot table and keys for userTags relationship
    public function links()
    {
        return $this->belongsToMany(Link::class, 'link_user_tag', 'user_tag_id', 'link_id')->withTimestamps();
    }
}

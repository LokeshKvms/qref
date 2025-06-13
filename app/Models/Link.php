<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'url', 'image_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function globalTags()
    {
        return $this->belongsToMany(Tag::class, 'link_tag', 'link_id', 'tag_id');
    }

    public function userTags()
    {
        return $this->belongsToMany(UserTag::class, 'link_user_tag', 'link_id', 'user_tag_id');
    }

    // Added accessor for all tags merged
    public function getTagsAttribute()
    {
        return $this->globalTags->merge($this->userTags);
    }
}

<?php
// app/Policies/LinkPolicy.php
namespace App\Policies;

use App\Models\Link;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LinkPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Link $link)
    {
        return $link->user_id === $user->id;
    }

    public function delete(User $user, Link $link)
    {
        return $link->user_id === $user->id;
    }
}

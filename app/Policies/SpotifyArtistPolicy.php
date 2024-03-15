<?php

namespace App\Policies;

use App\Models\SpotifyArtist;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SpotifyArtistPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SpotifyArtist $spotifyArtist): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SpotifyArtist $spotifyArtist): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function detach(User $user, SpotifyArtist $spotify_artist): bool
    {
        return $spotify_artist->users->contains(auth()->user());
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SpotifyArtist $spotifyArtist): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SpotifyArtist $spotifyArtist): bool
    {
        //
    }
}

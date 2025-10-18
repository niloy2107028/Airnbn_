<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the listings owned by this user.
     * Equivalent to Mongoose populate('owner')
     */
    public function listings()
    {
        return $this->hasMany(Listing::class, 'owner_id');
    }

    /**
     * Get the reviews authored by this user.
     * Equivalent to Mongoose populate('author')
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'author_id');
    }

    /**
     * Get the bookings made by this user (as guest)
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if user is a host
     */
    public function isHost()
    {
        return $this->role === 'host';
    }

    /**
     * Check if user is a guest
     */
    public function isGuest()
    {
        return $this->role === 'guest';
    }

    /**
     * Check if host can create more listings (max 5)
     */
    public function canCreateListing()
    {
        return $this->isHost() && $this->listings()->count() < 5;
    }

    /**
     * Get pending bookings for host's listings
     */
    public function pendingBookings()
    {
        return Booking::whereHas('listing', function ($query) {
            $query->where('owner_id', $this->id);
        })->where('status', 'pending')->with(['listing', 'user'])->get();
    }

    /**
     * Check if guest has a pending or confirmed booking
     */
    public function hasActiveBooking()
    {
        return $this->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('check_out_date', '>=', now())
            ->exists();
    }
}

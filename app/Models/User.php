<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  protected $fillable = [
    'name',
    'email',
    'password',
    'country_id',
    'state_id',
    'city_id',
    'address',
    'postal_code',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];


  public function country()
  {
    return $this->belongsTo(Country::class);
  }


  public function calendars()
  {
    return $this->belongsToMany(Calendar::class);
  }


  public function departments()
  {
    return $this->belongsToMany(Department::class);
  }


  public function holidays()
  {
    return $this->hasMany(Holiday::class);
  }


  public function timesheets()
  {
    return $this->hasMany(Timesheet::class);
  }
}

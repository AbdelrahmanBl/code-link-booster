<?php

namespace CodeLink\Booster\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Otp extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $primaryType = 'string';

    protected $fillable = [
        'id',
        'code',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * setCodeAttribute
     *
     * @param  string $code
     * @return void
     */
    public function setCodeAttribute(string $code): void
    {
        $this->attributes['code'] = Hash::make($code);
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        parent::creating(function($otp) {
            $otp->created_at = now();
        });
    }
}

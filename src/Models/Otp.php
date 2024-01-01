<?php

namespace CodeLink\Booster\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string id
 * @property string otp
 * @property object created_at
 * @property object updated_at
 * @property bool is_expired
 */
class Otp extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $primaryType = 'string';

    protected $fillable = [
        'id',
        'otp',
    ];

    public function setOtpAttribute(string $otp): void
    {
        $this->attributes['otp'] = Hash::make($otp);
    }

    public function verify(string $otp): bool
    {
        return Hash::check($otp, $this->otp);
    }

    public function getIsExpiredAttribute(): bool
    {
        return now()->subMinutes(config('booster.services.otp_service.otp_timeout'))->greaterThanOrEqualTo($this->updated_at);
    }
}

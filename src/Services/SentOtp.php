<?php

namespace CodeLink\Booster\Services;

use Illuminate\Support\Str;
use CodeLink\Booster\Models\Otp;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use CodeLink\Booster\Contracts\SmsContract;
use Illuminate\Contracts\Mail\Mailable as MailableContract;

class SentOtp
{
    private string $email;

    private string $mobile;

    /**
     * notify by [email | sms]
     *
     * @var string
     */
    private string $by;

    private SmsContract $smsService;

    private MailableContract $mailable;

    private int $otpLength = 4;

    CONST BY_EMAIL = 'email';
    CONST BY_SMS = 'sms';

    public static function create(): self
    {
        return new self;
    }

    public function setOtpLength(?int $length): self
    {
        $this->otpLength = $length ?? $this->otpLength;

        return $this;
    }

    public function toEmail($email): bool
    {
        $this->email = $email;

        $this->by = static::BY_EMAIL;

        return $this->sent();
    }

    public function toMobile($mobile): bool
    {
        $this->mobile = $mobile;

        $this->by = static::BY_SMS;

        return $this->sent();
    }

    public function sent(): bool
    {
        // set the otp static for the local mode and dynamic for the production...
        $otp = Str::otp($this->otpLength);

        // save the otp hashed in database...
        Otp::query()->updateOrCreate(
            ['id' => $this->email ?? $this->mobile],
            ['otp' => $otp]
        );

        $message = trans('booster::message.sent_otp_message', [
            'otp' => $otp,
            'minutes' => config('booster.services.otp_service.otp_timeout'),
        ]);

        try {
            switch ($this->by) {
                case static::BY_EMAIL:
                    $mailable = config('booster.services.otp_service.mailable');
                    $this->mailable = new $mailable($message);
                    Mail::to($this->email)->send($this->mailable);
                    break;

                case static::BY_SMS:
                    $smsService = config('booster.services.otp_service.sms_service');
                    $this->smsService = new $smsService;
                    $this->smsService->send($this->mobile, $message);
                    break;

                default:
                    throw new \Exception('Unhandled sent otp way');
                    break;
            }
        }
        catch(\Exception $e) {
            Log::error(static::class . ': ' . $e->getMessage());
            return false;
        }


        return true;
    }
}

<?php

namespace CodeLink\Booster\Services\Otp;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use CodeLink\Booster\Contracts\SmsContract;
use CodeLink\Booster\Enums\OtpGateway;
use Illuminate\Contracts\Mail\Mailable as MailableContract;

class SentOtp
{
    private SmsContract $smsService;

    private MailableContract $mailable;

    private int $otpLength;

    public static function create(): self
    {
        return new self;
    }

    public function setOtpLength(?int $length): self
    {
        $this->otpLength = $length ?? $this->getDefaultOtpLength();

        return $this;
    }

    public function getDefaultOtpLength()
    {
        return config('booster.services.otp_service.otp_length');
    }

    public function toEmail($email): bool
    {
        return $this->sent($email, OtpGateway::EMAIL);
    }

    public function toMobile($mobile): bool
    {
        return $this->sent($mobile, OtpGateway::SMS);
    }

    // TODO add enum param $gateway...
    public function sent(string $target, OtpGateway $gateway): bool
    {
        // set the otp static for the local mode and dynamic for the production...
        $otp = Str::otp($this->otpLength ?? $this->getDefaultOtpLength());

        // save the otp hashed in database...
        $otpModel = config('booster.services.otp_service.model');
        $otpModel::query()->updateOrCreate(
            ['id' => $target],
            ['otp' => $otp]
        );

        $message = trans('booster::message.sent_otp_message', [
            'otp' => $otp,
            'minutes' => config('booster.services.otp_service.otp_timeout'),
        ]);

        try {
            switch ($gateway) {
                // handle sending otp by email...
                case OtpGateway::EMAIL:
                    $mailable = config('booster.services.otp_service.mailable');
                    $this->mailable = new $mailable($message);
                    Mail::to($target)->send($this->mailable);
                    break;

                // handle sending otp by sms...
                case OtpGateway::SMS:
                    $smsService = config('booster.services.otp_service.sms_service');
                    $this->smsService = new $smsService;
                    $this->smsService->send($target, $message);
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

<?php

namespace CodeLink\Booster\Services\Otp;

use Illuminate\Support\Str;
use CodeLink\Booster\Models\Otp;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use CodeLink\Booster\Contracts\SmsContract;
use CodeLink\Booster\Enums\OtpGateway;
use Illuminate\Contracts\Mail\Mailable as MailableContract;

class SentOtp
{
    private string $email;

    private string $mobile;

    private OtpGateway $gateway;

    private SmsContract $smsService;

    private MailableContract $mailable;

    private int $otpLength;

    public static function create(): self
    {
        return new self;
    }

    public function setOtpLength(?int $length): self
    {
        $this->otpLength = $length ?? config('booster.services.otp_service.otp_length');

        return $this;
    }

    public function toEmail($email): bool
    {
        $this->email = $email;

        $this->gateway = OtpGateway::EMAIL;

        return $this->sent();
    }

    public function toMobile($mobile): bool
    {
        $this->mobile = $mobile;

        $this->gateway = OtpGateway::SMS;

        return $this->sent();
    }

    // TODO add enum param $gateway...
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
            switch ($this->gateway) {
                // handle sending otp by email...
                case OtpGateway::EMAIL:
                    $mailable = config('booster.services.otp_service.mailable');
                    $this->mailable = new $mailable($message);
                    Mail::to($this->email)->send($this->mailable);
                    break;

                // handle sending otp by sms...
                case OtpGateway::SMS:
                    $smsService = config('booster.services.otp_service.sms_service');
                    $this->smsService = new $smsService;
                    $this->smsService->send($this->mobile, $message);
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

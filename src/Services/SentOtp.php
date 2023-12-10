<?php

namespace CodeLink\Booster\Services;

use CodeLink\Booster\Contracts\SmsContract;
use CodeLink\Booster\Models\Otp;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

    private int $otpLength = 4;

    CONST BY_EMAIL = 'email';
    CONST BY_SMS = 'sms';

    public function __construct()
    {
        $smsService = config('booster.services.otp_service.sms_service');
        $this->smsService = new $smsService;
    }

    public static function create(): self
    {
        return new self;
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

    public function setFiveOtpLength(): self
    {
        $this->otpLength = 5;

        return $this;
    }

    public function setSixOtpLength(): self
    {
        $this->otpLength = 6;

        return $this;
    }

    public function sent(): bool
    {
        $code = $code = app()->isLocal()  // || isDevelopmentServer()

        ? match($this->otpLength) {
            4 => '1234',
            5 => '12345',
            6 => '123456',
        }
        : (string) match($this->otpLength) {
            4 => rand(1111, 9999),
            5 => rand(11111, 99999),
            6 => rand(111111, 999999),
        };

        Otp::query()->updateOrCreate(
            ['id' => $this->email ?? $this->mobile],
            ['code' => $code]
        );

        $message = __(
            'message.reset_code_message',
            [
                'code'      => $code,
                'minutes'   => config('app.reset_timeout'),
            ]
        );

        try {
            switch ($this->by) {
                case static::BY_EMAIL:
                    // TODO sent message to email...
                    // Mail::send();
                    break;

                case static::BY_SMS:
                    $this->smsService->send($this->mobile, $message);
                    break;

                default:
                    throw new \Exception('Unhandled by type');
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

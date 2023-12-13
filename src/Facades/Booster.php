<?php

namespace CodeLink\Booster\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool sentOtpByEmail(string $email, int $otpLength = null)
 * @method static bool sentOtpBySms(string $mobile, int $otpLength = null)
 * @method static bool verifyOtp(string $target, string $otp)
 * @method \CodeLink\Booster\Services\Chart\Chart chart(string $title = '', $data = [])
 * @method \CodeLink\Booster\Services\Chart\ChartGenerator report()
 * @method array generateMonthlyReportFromNow(Builder $builder, string $dateField = null)
 * @method array generateMonthlyReportBeforeNow(Builder $builder, string $dateField = null)
 * @method array generateCountReportDesc(Builder $builder, string $relationName, string $labelKey = null)
 * @method array generateCountReportAsc(Builder $builder, string $relationName, string $labelKey = null)
 * @method array generateSumReportDesc(Builder $builder, string $relationName, string $sumKey, string $labelKey = null)
 * @method array generateSumReportAsc(Builder $builder, string $relationName, string $sumKey, string $labelKey = null)
 */
class Booster extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'booster';
    }
}

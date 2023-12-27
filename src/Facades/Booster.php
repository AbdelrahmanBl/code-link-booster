<?php

namespace CodeLink\Booster\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool sendOtpByEmail(string $email, int $otpLength = null)
 * @method static bool sendOtpBySms(string $mobile, int $otpLength = null)
 * @method static bool verifyOtp(string $target, string $otp)
 * @method static array getSelectBoxEnumOptions(array $cases, string $locale = NULL)
 * @method static array getSelectBoxTableOptions(Builder $queryBuilder, string $labelKey = null, string $valueKey = null)
 * @method static array getSelectBoxTableCastOptions(Builder $queryBuilder, array $extraSelect, string $labelKey = null, string $valueKey = null)
 * @method static \CodeLink\Booster\Notifications\MixedNotification localeNotification(string $locale, array $localeBody, string $target = null, string $targetId = null, array|NotifyBy $via = [])
 * @method static \CodeLink\Booster\Notifications\MixedNotification customNotification(string $title, string $body, string $target = null, string $targetId = null, array|NotifyBy $via = [])
 * @method static \CodeLink\Booster\Services\Chart\Chart chart(string $title = '', $data = [])
 * @method static \CodeLink\Booster\Services\Chart\ChartGenerator report()
 * @method static array generateMonthlyReportFromNow(Builder $builder, string $dateField = null)
 * @method static array generateMonthlyReportBeforeNow(Builder $builder, string $dateField = null)
 * @method static array generateCountReportDesc(Builder $builder, string $relationName, string $labelKey = null)
 * @method static array generateCountReportAsc(Builder $builder, string $relationName, string $labelKey = null)
 * @method static array generateSumReportDesc(Builder $builder, string $relationName, string $sumKey, string $labelKey = null)
 * @method static array generateSumReportAsc(Builder $builder, string $relationName, string $sumKey, string $labelKey = null)
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

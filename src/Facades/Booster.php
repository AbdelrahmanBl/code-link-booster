<?php

namespace CodeLink\Booster\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void ping()
 * @method static bool sendOtpByEmail(string $email, int $otpLength = null)
 * @method static bool sendOtpBySms(string $mobile, int $otpLength = null)
 * @method static bool verifyOtp(string $target, string $otp)
 * @method static array getSelectBoxEnumOptions(array $cases, string $locale = NULL)
 * @method static array getSelectBoxTableOptions(Builder $queryBuilder, string $labelKey = null, string $valueKey = null)
 * @method static array getSelectBoxTableCastOptions(Builder $queryBuilder, array $extraSelect, string $labelKey = null, string $valueKey = null)
 * @method static \CodeLink\Booster\Notifications\MixedNotification localeNotification(string $locale, array $localeBody, string $target = null, string $targetId = null, array|NotifyBy $via = [])
 * @method static \CodeLink\Booster\Notifications\MixedNotification customNotification(string $title, string $body, string $target = null, string $targetId = null, array|NotifyBy $via = [])
 * @method static \CodeLink\Booster\Services\Chart\Chart chart(string $title = '', $data = [])
 * @method static \CodeLink\Booster\Services\Chart\Chart fullWidthChart(string $title = '', $data = [])
 * @method static \CodeLink\Booster\Services\Chart\ChartGenerator report()
 * @method static array generateMonthlyReportAfterNow(Builder $builder, string $dateField = null)
 * @method static array generateMonthlyReportBeforeNow(Builder $builder, string $dateField = null)
 * @method static array generateCountReportDesc(Builder $builder, string|array $relation, string|callable $label = null, array $extraSelect = []): array
 * @method static array generateCountReportAsc(Builder $builder, string|array $relation, string|callable $label = null, array $extraSelect = []): array
 * @method static array generateSumReportDesc(Builder $builder, string|array $relation, string $sumKey, string|callable $label = null, array $extraSelect = [], int $roundBy = 0)
 * @method static array generateSumReportAsc(Builder $builder, string|array $relation, string $sumKey, string|callable $label = null, array $extraSelect = [], int $roundBy = 0)
 * @method static array generateAvgReportDesc(Builder $builder, string|array $relation, string $avgKey, string|callable $label = null, array $extraSelect = [])
 * @method static array generateAvgReportAsc(Builder $builder, string|array $relation, string $avgKey, string|callable $label = null, array $extraSelect = [])
 * @method static array generateEnumReportDesc(Builder $builder, array $cases, string $labelKey = null, $locale = null): array
 * @method static array generateEnumReportAsc(Builder $builder, array $cases, string $labelKey = null, $locale = null): array
 * @method static bool detectExcelExport()
 * @method static bool detectShowReport()
 * @method static bool detectDownloadDraft()
 * @method static \Symfony\Component\HttpFoundation\BinaryFileResponse handleExcelExport($queryBuilder, $fields, $exportFileName = NULL)
 * @method static \Symfony\Component\HttpFoundation\BinaryFileResponse handleExcelExportWithCustomHeaders($queryBuilder, $fields, $headers = [], $exportFileName = NULL)
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

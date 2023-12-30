<?php

namespace CodeLink\Booster\Helpers;

use Illuminate\Support\Str;
use CodeLink\Booster\Enums\NotifyBy;
use Illuminate\Database\Eloquent\Builder;
use CodeLink\Booster\Services\Chart\Chart;
use CodeLink\Booster\Services\Otp\SendOtp;
use CodeLink\Booster\Services\Otp\VerifyOtp;
use CodeLink\Booster\Services\Chart\ChartBuilder;
use CodeLink\Booster\Services\Chart\ChartGenerator;
use CodeLink\Booster\Notifications\MixedNotification;
use CodeLink\Booster\Services\Chart\FullWidthChart;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use CodeLink\Booster\Transformers\CaseSelectBoxTransformer;
use CodeLink\Booster\Transformers\TableSelectBoxTransformer;

class BoosterHelper
{
    public function ping(): void
    {
        dd('Welcome in code link booster');
    }

    public function sendOtpByEmail(string $email, int $otpLength = null): bool
    {
        return SendOtp::create()->setOtpLength($otpLength)->toEmail($email);
    }

    public function sendOtpBySms(string $mobile, int $otpLength = null): bool
    {
        return SendOtp::create()->setOtpLength($otpLength)->toMobile($mobile);
    }

    public function verifyOtp(string $target, string $otp): bool
    {
        return VerifyOtp::create()->verify($target, $otp);
    }

    public function getSelectBoxEnumOptions(array $cases, string $locale = NULL): array
    {
        return CaseSelectBoxTransformer::make()->transform($cases, $locale);
    }

    public function getSelectBoxTableOptions(Builder $queryBuilder, string $labelKey = null, string $valueKey = null): array
    {
        return TableSelectBoxTransformer::make()->transform($queryBuilder, $labelKey, $valueKey);
    }

    public function getSelectBoxTableCastOptions(Builder $queryBuilder, array $extraSelect, string $labelKey = null, string $valueKey = null)
    {
        return TableSelectBoxTransformer::make()->transform($queryBuilder, $labelKey, $valueKey, $extraSelect);
    }

    // TODO add to readMe
    // php artisan notifications:table && php artisan migrate
    // install package `laravel-notification-channels/fcm` for NotifyBy::FCM
    public function localeNotification(string $locale, array $localeBody, string $target = null, string $targetId = null, array|NotifyBy $via = [])
    {
        return new MixedNotification($locale, $localeBody, $target, $targetId, $via);
    }

    public function customNotification(string $title, string $body, string $target = null, string $targetId = null, array|NotifyBy $via = [])
    {
        return new MixedNotification(null, compact('title', 'body'), $target, $targetId, $via);
    }

    public function chart(string $title = '', $data = []): Chart
    {
        return new Chart($title, $data);
    }

    public function fullWidthChart(string $title = '', $data = []): FullWidthChart
    {
        return new FullWidthChart($title, $data);
    }

    public function report(): ChartGenerator
    {
        return new ChartGenerator;
    }

    public function generateMonthlyReportAfterNow(Builder $builder, string $dateField = null): array
    {
        return ChartBuilder::monthly($builder, $dateField, true);
    }

    public function generateMonthlyReportBeforeNow(Builder $builder, string $dateField = null): array
    {
        return ChartBuilder::monthly($builder, $dateField, false);
    }

    public function generateCountReportDesc(Builder $builder, string|array $relation, string|callable $label = null, array $extraSelect = []): array
    {
        return ChartBuilder::count($builder, $relation, $label, 'desc', $extraSelect);
    }

    public function generateCountReportAsc(Builder $builder, string|array $relation, string|callable $label = null, array $extraSelect = []): array
    {
        return ChartBuilder::count($builder, $relation, $label, 'asc', $extraSelect);
    }

    public function generateSumReportDesc(Builder $builder, string|array $relation, string $sumKey, string|callable $label = null, array $extraSelect = []): array
    {
        return ChartBuilder::sum($builder, $relation, $sumKey, $label, 'desc', $extraSelect);
    }

    public function generateSumReportAsc(Builder $builder, string|array $relation, string $sumKey, string|callable $label = null, array $extraSelect = []): array
    {
        return ChartBuilder::sum($builder, $relation, $sumKey, $label, 'asc', $extraSelect);
    }

    public function generateEnumReportDesc(Builder $builder, array $cases, string $labelKey = null, $locale = null): array
    {
        return ChartBuilder::enum($builder, $cases, $labelKey, 'desc', $locale);
    }

    public function generateEnumReportAsc(Builder $builder, array $cases, string $labelKey = null, $locale = null): array
    {
        return ChartBuilder::enum($builder, $cases, $labelKey, 'asc', $locale);
    }

    /**
     * detect excel export from the request.
     *
     * @return bool
     */
    public function detectExcelExport(): bool
    {
        return request(config('booster.requests.export_excel_key')) ?? false;
    }

    /**
     * detect show report from the request.
     *
     * @return bool
     */
    public function detectShowReport(): bool
    {
        return request(config('booster.requests.show_report_key')) ?? false;
    }

    /**
     * detect download draft from the request.
     *
     * @return bool
     */
    public function detectDownloadDraft(): bool
    {
        return request(config('booster.requests.download_draft_key')) ?? false;
    }

    /**
     * handleExport
     *
     * @param  Builder $queryBuilder
     * @param  array $fields
     * @param  ?string $exportFileName
     * @param  array $thead
     * @return BinaryFileResponse
     */
    public function handleExcelExport($queryBuilder, $fields, $exportFileName = NULL): BinaryFileResponse
    {
        // generate file name...
        $fileName = ($exportFileName ?? Str::plural(class_basename($queryBuilder->getModel()))) . '_' . today()->format('Y-m-d');
        // add excel extension...
        $fileName .= '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \CodeLink\Booster\Exports\ExcelExport($queryBuilder->get(), $fields, []), $fileName
        );
    }

    public function handleExcelExportWithCustomHeaders($queryBuilder, $fields, $headers = [], $exportFileName = NULL): BinaryFileResponse
    {
        // generate file name...
        $fileName = ($exportFileName ?? Str::plural(class_basename($queryBuilder->getModel()))) . '_' . today()->format('Y-m-d');
        // add excel extension...
        $fileName .= '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \CodeLink\Booster\Exports\ExcelExport($queryBuilder->get(), $fields, $headers), $fileName
        );
    }
}

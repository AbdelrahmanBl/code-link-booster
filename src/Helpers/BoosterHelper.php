<?php

namespace CodeLink\Booster\Helpers;

use Illuminate\Database\Eloquent\Builder;
use CodeLink\Booster\Services\Chart\Chart;
use CodeLink\Booster\Services\Otp\SendOtp;
use CodeLink\Booster\Services\Otp\VerifyOtp;
use CodeLink\Booster\Services\Chart\ChartBuilder;
use CodeLink\Booster\Services\Chart\ChartGenerator;
use CodeLink\Booster\Notifications\DatabaseNotification;
use CodeLink\Booster\Notifications\FcmNotification;
use CodeLink\Booster\Transformers\CaseSelectBoxTransformer;
use CodeLink\Booster\Transformers\TableSelectBoxTransformer;

class BoosterHelper
{
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

    public function chart(string $title = '', $data = []): Chart
    {
        return new Chart($title, $data);
    }

    public function report(): ChartGenerator
    {
        return new ChartGenerator;
    }

    public function generateMonthlyReportFromNow(Builder $builder, string $dateField = null): array
    {
        return ChartBuilder::monthly($builder, $dateField, true);
    }

    public function generateMonthlyReportBeforeNow(Builder $builder, string $dateField = null): array
    {
        return ChartBuilder::monthly($builder, $dateField, false);
    }

    public function generateCountReportDesc(Builder $builder, string $relationName, string $labelKey = null): array
    {
        return ChartBuilder::count($builder, $relationName, $labelKey, 'desc');
    }

    public function generateCountReportAsc(Builder $builder, string $relationName, string $labelKey = null): array
    {
        return ChartBuilder::count($builder, $relationName, $labelKey, 'asc');
    }

    public function generateSumReportDesc(Builder $builder, string $relationName, string $sumKey, string $labelKey = null): array
    {
        return ChartBuilder::sum($builder, $relationName, $sumKey, $labelKey, 'desc');
    }

    public function generateSumReportAsc(Builder $builder, string $relationName, string $sumKey, string $labelKey = null): array
    {
        return ChartBuilder::sum($builder, $relationName, $sumKey, $labelKey, 'asc');
    }

    public function getSelectBoxEnumOptions(array $cases, string $locale = NULL): array
    {
        return CaseSelectBoxTransformer::make()->transform($cases, $locale);
    }

    public function getSelectBoxTableOptions(Builder $queryBuilder, string $labelKey = null, string $valueKey = null): array
    {
        return TableSelectBoxTransformer::make()->transform($queryBuilder, $labelKey, $valueKey);
    }

    // TODO for handle casts attributes....
    // public function getSelectBoxTableWithCastsOptions(Builder $queryBuilder, array $extraSelect, string $labelKey = null, string $valueKey = null)
    // {
    //     return TableSelectBoxTransformer::make()->transform($queryBuilder, $labelKey, $valueKey, $extraSelect);
    // }


    // TODO add to readMe
    // php artisan notifications:table
    // php artisan migrate
    public function localeDatabaseNotification(string $locale, string $localeBody, string $target = null, string $targetId = null)
    {
        return new DatabaseNotification($locale, $localeBody, $target, $targetId);
    }

    public function customDatabaseNotification(string $title, string $body, string $target = null, string $targetId = null)
    {
        return new DatabaseNotification(null, compact('title', 'body'), $target, $targetId);
    }

    // TODO add to readMe
    // install package `laravel-notification-channels/fcm`
    public function localeFcmNotification(string $locale, string $localeBody, string $target = null, string $targetId = null)
    {
        return new FcmNotification($locale, $localeBody, $target, $targetId);
    }

    public function customFcmNotification(string $title, string $body, string $target = null, string $targetId = null)
    {
        return new FcmNotification(null, compact('title', 'body'), $target, $targetId);
    }
}

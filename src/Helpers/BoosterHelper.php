<?php

namespace CodeLink\Booster\Helpers;

use CodeLink\Booster\Transformers\CaseSelectBoxTransformer;
use CodeLink\Booster\Transformers\TableSelectBoxTransformer;
use CodeLink\Booster\Services\Chart\Chart;
use CodeLink\Booster\Services\Chart\ChartBuilder;
use CodeLink\Booster\Services\Chart\ChartGenerator;
use CodeLink\Booster\Services\Otp\SentOtp;
use CodeLink\Booster\Services\Otp\VerifyOtp;
use Illuminate\Database\Eloquent\Builder;

class BoosterHelper
{
    public function sentOtpByEmail(string $email, int $otpLength = null): bool
    {
        return SentOtp::create()->setOtpLength($otpLength)->toEmail($email);
    }

    public function sentOtpBySms(string $mobile, int $otpLength = null): bool
    {
        return SentOtp::create()->setOtpLength($otpLength)->toMobile($mobile);
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
}

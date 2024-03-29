<div style="padding: 2rem;">
    <h1>{{ trans('booster::message.otp') }}</h1>
    <h2>{{ $message }}</h2>
    <div style="margin-top: 1rem;">
        <h3>{{ trans('booster::message.thanks') }},</h3>
        <b>{{ config('app.name') }}</b>
    </div>
</div>

@if(app()->getLocale() === 'ar')
<style>
    * {
        direction: rtl;
        text-align: right !important;
    }
</style>
@endif

<div style="padding: 2rem;">
    <h2>{{ $body }}</h2>
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

<x-mail::message>
# {{ trans('booster::message.otp') }}

{{ $message }}

{{ trans('booster::message.thanks') }},<br>
{{ config('app.name') }}
</x-mail::message>

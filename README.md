# Code Link Booster
This package will help you to develop your projects 10x faster than the normal way. you can achieve many of the repeated features by less coding with high performance and this will make your project clean, faster, secure and organized.

## Install
Firstly, you must add the package as a submodule in your project.
Kinldy run these commands in your root project directory.
```
git submodule add https://github.com/AbdelrahmanBl/code-link-booster.git
git submodule init
git submodule update

```
Then go to composer.json and add to autoload.psr-4
```
"CodeLink\\Booster\\": "code-link-booster/src/"
```
Then autoload the files by
```
composer dump-autoload
```

## Setup
Go to config/app.php and then add booster service provider to providers
```
CodeLink\Booster\BoosterServiceProvider::class,
```
Then add Booster facade as alias
```
'Booster' => CodeLink\Booster\Facades\Booster::class,
```
You can run this command in your console to ensure that the package is installed successfully
```
php artisan tinker
```
Then
```
Booster::ping();
```
And you will see the dump message `Welcome in code link booster`.

## Publishes
The booster has many publish files that you can overwrite them.
### Config file
```
php artisan vendor:publish --tag=booster-config
```
### View files
```
php artisan vendor:publish --tag=booster-views
```
### Translation files
```
php artisan vendor:publish --tag=booster-lang
```
### Stub files
```
php artisan vendor:publish --tag=booster-stubs
```

## Commands
You can create files by an artisan command.
### Reports
```
php artisan make:report FILE_NAME
```
### Enums
```
php artisan make:enum FILE_NAME
```
### Array Exports
```
php artisan make:array-export FILE_NAME
```
### Transformers
```
php artisan make:transformer FILE_NAME
```
### Builders
```
php artisan make:builder FILE_NAME
```

# Documentation

## Otp Verification
You must allow otp from config `booster.services.otp_service.allow` (set to true).
Then kindly run 
```
php artisan migrate
```
You can set the timeout of the otp from config `booster.services.otp_service.otp_timeout` (in minutes).
### Otp Generator
Otp configured to be static zeros with the default length `0000` length in the develope server and randomly in the live server. 
To setup a develope server you can set the APP_ENV to local or modify the develop server url from config `booster.develop_server_url` when your APP_ENV is production.
To setup live server you can set the APP_ENV to production.
### Email Otp
You can send otp by email with default otp length from config `booster.services.otp_service.otp_length`
You can customize email class `booster.services.otp_service.mailable`.
You can customize email title `booster.services.otp_service.mailable_subject`.
You can publish the markdown from booster-views tag or customize from config `booster.services.otp_service.mailable_markdown`. 
```
Booster::sendOtpByEmail('test@gmail.com');
```
You can send otp by email with custom otp length = 4
```
Booster::sendOtpByEmail('test@gmail.com', 4);
```
### Sms Otp
You can send otp by sms with default otp length from config `booster.services.otp_service.otp_length`
You can customize the sms service from config `booster.services.otp_service.sms_service` (must be instance of `CodeLink\Booster\Contracts\SmsContract`).
```
Booster::sendOtpBySms('+966501234567');
```
You can send otp by sms with custom otp length = 4
```
Booster::sendOtpBySms('+966501234567', 4);
```
### Verify Otp
You can verify otp for `[Sms - Email]` by
```
Booster::verifyOtp('test@gmail.com', '0000');
```

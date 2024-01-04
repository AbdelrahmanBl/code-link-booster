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

# Documentation

## Otp Verification
You can sent otp by [sms - email] by
```
Booster::sentOtpByEmail('test@gmail.com');
Booster::sentOtpBySms('+966501234567');
```

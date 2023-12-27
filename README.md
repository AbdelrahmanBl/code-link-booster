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
'providers' => ServiceProvider::defaultProviders()->merge([
    /*
     * Package Service Providers...
     */
    CodeLink\Booster\BoosterServiceProvider::class,
])->toArray(),
```
Then add Booster facade as alias
```
'aliases' => Facade::defaultAliases()->merge([
    'Booster' => CodeLink\Booster\Facades\Booster::class,
])->toArray(),
```

## Publishes
Publishes

## Config
Config

# Documentation

## Otp Verification
You can sent otp by [sms - email] by
```
Booster::sentOtpByEmail('test@gmail.com');
Booster::sentOtpBySms('+966501234567');
```

# Code Link Booster
This package will help you to develop your projects 10x faster than the normal way. you can achieve many of the repeated features by less coding with high performance and this will make your project clean, faster, secure and organized.

## Install
Firstly, you must add the package as a submodule in your project.
Kinldy run these commands in your root project directory.
```
git submodule add https://github.com/AbdelrahmanBl/code-link-booster.git
git submodule update --init
```
Then go to composer.json and add to autoload.psr-4
```
"CodeLink\\Booster\\": "code-link-booster/src/"
```
Then autoload the files by
```
composer dump-autoload
```
> **_Note:_** when you deploy your project you must run this command or add them to your deployment script to install/update the submodule.

```
git submodule update --init
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
Create a report class with a static `generate` method for chart report use. 
```
php artisan make:report FILE_NAME
```
### Enums
Create an enum class with CodeLink\Booster\Traits\EnumHandler trait that have these methods (names - values - options).
names() return a collection of enum's names
values() return a collection of enum's values
options() return an array of options for select box. 
```
php artisan make:enum FILE_NAME
```
### Array Exports
Create an array export class that have a static `toArray` method for excel export handler (fields & values). 
```
php artisan make:array-export FILE_NAME
```
### Arrayable
Create an arrayable class that have a `toArray` method to prepare data for [Edit - Create] pages. 
```
php artisan make:arrayable FILE_NAME
```
### Transformers
Create a transformer class that have a `transform` method to prepare data for database or similar things.
```
php artisan make:transformer FILE_NAME
```
### Builders
Create a builder class that have methods for filterable queries.
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
You can publish the markdown from booster-views tag.
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

## Select Box Options
You can get options for select box from 3 different types.
### 1- Table Options
You can select the data from a table by entering these parameters:
- [x] 1st the select query builder.
- [ ] 2nd the column name for option's label.
- [ ] 3rd the column name for option's value.
> **_Note:_** You can customize the label/value key or define them from the booster config in `booster.transformers.select_box_table.label_key/value_key`.

You can get the options by default label/value key name from the booster config by that way:
```
Booster::getSelectBoxTableOptions(User::query());
```
Or customize the label/value columns by:
```
Booster::getSelectBoxTableOptions(User::query(), 'id', 'name');
```
### 2- Table Cast Options
You can select the data from a table for a casting fields by entering these parameters:
- [x] 1st the select query builder.
- [x] 2nd the extra select (you must enter all the fields that you need to perform your select query).
- [ ] 3rd the casting attribute/column name for option's label.
- [ ] 4th the casting attribute/column for option's value.
> **_Note:_** You can customize the label/value key or define them from the booster config in `booster.transformers.select_box_table.label_key/value_key`.

You can get label/value when they represented as a casting attributes by:
```
Booster::getSelectBoxTableCastOptions(User::query(), ['firstname', 'lastname', 'birthdate'], 'fullname', 'age');
```
> **_Note:_** In the previous example we need to get all the users and display thier `fullname` for the label key (that is a casting attribute = firstname . ' ' . lastname) and for the id key we have pass the casting attribute `age` which depends on the birthdate.

### 3- Enum Options
You can select the data from an enum class by entering these parameters:
- [x] 1st the cases that you want to get options for.
- [ ] 2nd the locale path to translate the data for.
> **_Note:_** You can customize the default locale path or define it from the booster config in `booster.transformers.enum_translation_path`.

You can get the options by the default locale path from the booster config by that way:
```
Booster::getSelectBoxEnumOptions(Sort::cases()); 
```
Or customize the locale translation path by:
```
Booster::getSelectBoxEnumOptions(Sort::cases(), 'enums.options.Sort'); 
```

Addition to you can get an enum cases as options directly from the enum class if using the `CodeLink\Booster\Traits\EnumHandler` trait inside your enum class 
```
App\Enums\Sort::options();
```
or customize the locale translation path by:
```
App\Enums\Sort::options('enums.options.Sort');
```
> **_Note:_** You can create the enum class by running this command and it will add the `EnumHandler` automatically to your class.

```
php artisan make:enum Sort
```

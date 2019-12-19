## Smart VAT

System to automate the VAT process of municipal council of Gale

## VAT categories and process

-   Business Tax.
-   Land Tax.
-   Vehicle Tax.
-   Club licence Tax.
-   Licence Tax.
-   Slautering Fees.
-   Three-wheel parking.
-   Shop rental.
-   Advetisment Tax.
-   Booking Tax.
-   Industrial Tax.
-   Land auction Tax.
-   Entertainment Tax.

## Laravel .evn setup

<code>
MAIL_DRIVER=smtp<br>
MAIL_HOST=smtp.gmail.com<br>
MAIL_PORT=465<br>
MAIL_USERNAME=municipal@gmail.com #need to allow permissions<br>
MAIL_PASSWORD=yourpassword<br>
MAIL_ENCRYPTION=ssl<br>
MAIL_FROM_NAME="Municipal-Council Gale"<br>
MAIL_FROM_ADDRESS=municipal@gmail.com <br>
</code>

## External package dependencies

### barryvdh/laravel-dompdf

-   composer require barryvdh/laravel-dompdf
-   edit config/app.php
    -   'providers' => [Barrsyvdh\DomPDF\ServiceProvider::class,],
    -   'aliases' => ['PDF' => Barryvdh\DomPDF\Facade::class,]
-   php artisan vendor:publish
    -   select the Barryvdh\DomPDF\ServiceProvider from the list

## Naming conventions and comments

-   class names : PascalCase
-   variable names : camelCase
-   database columns : Underscore ex: column_name
-   id,class names in blade templates : Hypens ex: class-id

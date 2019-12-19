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

MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=municipal@gmail.com #need to allow permissions
MAIL_PASSWORD=yourpassword
MAIL_ENCRYPTION=ssl

MAIL_FROM_NAME="Municipal-Council Gale"
MAIL_FROM_ADDRESS=municipal@gmail.com

## External package dependencies

### barryvdh/laravel-dompdf

-   composer require barryvdh/laravel-dompdf
-   edit config/app.php
    -   'providers' => [Barrsyvdh\DomPDF\ServiceProvider::class,],
    -   'aliases' => ['PDF' => Barryvdh\DomPDF\Facade::class,]
-   php artisan vendor:publish
    -   select the Barryvdh\DomPDF\ServiceProvider from the list

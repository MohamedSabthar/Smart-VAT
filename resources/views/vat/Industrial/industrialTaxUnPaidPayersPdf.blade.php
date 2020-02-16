<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- Favicon --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>

        {{-- CSS Files --}}
        <link href="{{ ltrim(public_path('assets/css/argon-dashboard.css?v=1.1.0'))}}" rel="stylesheet"
            type="text/css" />


        <title>Document</title>
    </head>

<body>

    <div class="text-center display-4 py-2"><span class="text-uppercase">Industrial Tax Unpaid payer for year
            {{$year}}</span>
    </div>
    <table id="Industrial_tax_report" class="table">



        <thead class="thead-light">
            <tr>
                <th class="text-center">{{__('menu.VAT Payers NIC')}}</th>
                <th class="text-center">{{ __('menu.VAT Payer Name')}}</th>
                <th class="text-center">{{ __('menu.Shop')}}</th>
                <th class="text-center">{{ __('menu.Due Payment')}}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($payersDue as $payerDue)
            <tr>
                <td class="text-center">{{ $payerDue->payer->nic }}</td>
                <td>{{ $payerDue->payer->full_name }}</td>
                <td>{{ $payerDue->shop_id."-".$payerDue->industrialTaxShop->shop_name }}</td>
                <td class="text-center">Rs. {{ number_format($payerDue->due_ammount, 2) }}</td>
            </tr>
            @endforeach

        </tbody>

    </table>

    <div class="px-4">Due-payment sum : Rs. {{number_format($payersDue->sum('due_ammount'),2)}}</div>

    {{-- <img
        src="https://quickchart.io/chart?c={type:'pie',data:{labels:['January','February', 'March','April', 'May'], datasets:[{data:[50,60,70,180,190]}]}}"
    />
</body> --}}

</html>
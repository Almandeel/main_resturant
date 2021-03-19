<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>card</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        .container {
            margin-top: 5%; 
        }
        .barcode {
            text-align: center;
            padding: 10px;
        }
        .barcode-b > div{
            margin: auto;
        }
    </style>
    <style>
        @media print {
            body {
                background-size: cover
            }
            .barcode h4 {
                font-size: 40px;
            }
            button , a {
                display: none !important;
            }
            .barcode  {
                margin-top: 60%;
                font-size: 40px !important;
            }
        }
    </style>
</head>
<body style="background-image: url({{ asset('dashboard/img' . '/' . $setting->value) }}); background-size:cover">
    <div class="container">
        <div class="row">
            <div style="margin:auto" class="col-md-6">
                <div class="barcode" >
                    <h4>{{ $customer->name }}</h4>
                    <div class="barcode-b">
                        <p>{!! DNS1D::getBarcodeHTML(number_format($customer->id), "C128",3,100, "black") !!}</p>
                    </div>
                </div>
            </div>    
        </div>
        <div class="row">
            <div class="col-md-6" style="margin:5% 0">
                <button onclick="window.print()" class="btn btn-primary btn-block">طباعة</button>
            </div>
            <div class="col-md-6" style="margin-top:5%">
                <a href="{{ route("subscriptions.index") }}" class="btn btn-primary btn-block">عودة</a>
            </div>
        </div>
    </div>


    <script>
        window.onload = (event) => {
            window.print()
        };
    </script>
</body>
</html>
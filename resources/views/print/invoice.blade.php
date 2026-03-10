<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        @media print {
            body {
                font-family: "Times New Roman", Times, serif;
                font-size: 12px;
            }


            .section {
                margin-bottom: 12px;
            }

            .label {
                font-weight: bold;
            }

            .amount {
                margin-top: 20px;
                text-align: right;
                font-weight: bold;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <table width="100%" class="mb-3">
        <tr>
            <td width="50%" valign="top">
                <p>{!! format_inline($header) !!}</p>
            </td>

            <td width="50%" valign="top" halign="right">
                <p>{!! format_inline($documentNumber) !!}</p>
            </td>
        </tr>
    </table>

    <h2 class="text-center">{!! format_inline($title) !!}</h2>

    <table width="100%" class="mb-3">
        @foreach ($sections as $section)
            <tr>
                <td width="30%" valign="top">
                    <p>{!! format_inline($section['label']) !!}:</p>
                </td>

                <td width="70%" valign="top">
                    <p>{!! format_inline($section['value']) !!}</p>
                </td>
            </tr>
        @endforeach
    </table>

    <table width="100%" class="mb-3">
        <tr>
            <td width="50%" valign="middle" halign="center">
                {{ $totalWithCurrencyLabel }}
                <div
                    style="
                        display: inline-block;
                        border: 2px solid #000;
                        padding: 5px 10px;
                        font-weight: bold;
                        min-width: 250px;
                        text-align: center;
                    "
                >
                    <strong>{{ number_format($amount, 0, ',', '.') }}</strong>
                </div>
            </td>


            <td width="50%" valign="top" halign="center">
                <p class="text-center">{!! format_inline($city) !!}, {!! format_inline($dayDate) !!}</p>

                <br>
                <br>
                <br>

                <p class="text-center">
                    <strong>{!! format_inline($name) !!}</strong><br>
                    {!! format_inline($position) !!}
                </p>
            </td>
        </tr>
    </table>

    <p>{!! format_inline($note) !!}</p>

</body>
</html>

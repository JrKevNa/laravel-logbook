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
                <p class="fs-6">{!! format_inline($header) !!}</p>
            </td>

            <td width="50%" valign="top" halign="right">
                <p class="fs-6">{!! format_inline($documentNumber) !!}</p>
            </td>
        </tr>
    </table>

    <div class="mb-3">
        <h2 class="text-center">{!! format_inline($title) !!}</h2>
    </div>

    <table width="100%" class="fs-6 mb-3">
        @foreach ($sections as $section)
            <tr>
                <!-- Label cell, right-aligned -->
                <td width="20%" valign="top" style="padding-right: 5px;">
                    {!! format_inline($section['label']) !!}
                </td>

                <!-- Colon cell -->
                <td width="1%" valign="top">
                    :
                </td>

                <!-- Value cell -->
                <td width="79%" valign="top">
                    {!! format_inline($section['value']) !!}
                </td>
            </tr>
        @endforeach
    </table>

    <table width="100%" class="fs-6 mb-3">
        <tr>
            <td width="50%" valign="middle" align="center">
                {{ $totalWithCurrencyLabel }}
                <div
                    style="
                        display: inline-block;   /* shrink to content */
                        border: 2px solid #000;
                        padding: 5px 10px;
                        font-weight: bold;
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

    <p class="fs-6">{!! format_inline($note) !!}</p>

</body>
</html>

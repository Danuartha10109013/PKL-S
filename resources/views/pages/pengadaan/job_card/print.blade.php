<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Card Details</title>
<link rel="icon" type="image/png" href="{{asset('PT. Bersama Sahabat Makmur Logo.png')}}">

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            margin-right: 20mm;
        }

        .container {
            margin: auto;
            padding: 20px;
            border: 1px solid #000;
            background-color: #fff;
            width: 100%;
            max-width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .details {
            margin-bottom: 20px;
            font-size: 12px;
        }

        .details table {
            width: 100%;
            border-collapse: collapse;
        }

        .details th, .details td {
            text-align: left;
            padding: 5px;
        }

        .details th {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            table-layout: fixed;
            word-wrap: break-word;
        }

        table th, table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-size: 10px;
        }

        table th {
            background-color: #f0f0f0;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            text-align: right;
        }

        .btn {
            margin-top: 20px;
            display: block;
            width: 100px;
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            margin-right: 15mm;
            font-size: 10px;
            }

            .container {
                margin: 0;
                width: 100%;
            }

            table {
                width: 100%;
                font-size: 9px;
                border-collapse: collapse;
            }

            table th, table td {
                padding: 4px;
                font-size: 9px;
            }

            .footer {
                font-size: 10px;
            }

            @page {
                size: A4 landscape;
                margin: 10mm;
            }

            .btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="font-weight: bold">Job Card</h2>
        <div class="details" style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <div style="flex: 1;">
                <p><strong>JC No:</strong> {{ $data->no_jobcard }}</p>
                <p><strong>Customer Name:</strong> {{ $data->customer_name }}</p>
                <p><strong>Kurs:</strong> {{ $data->kurs }} IDR/USD</p>
            </div>
            <div style="flex: 1; text-align: right;">
                <p><strong>Date:</strong> {{ $data->date }}</p>
                <p><strong>PO No:</strong> {{ $data->no_po }}</p>
                <p><strong>PO Date:</strong> {{ $data->po_date }}</p>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Qty</th>
                    <th rowspan="2">Description</th>
                    <th colspan="2">Bottom Price</th>
                    <th colspan="2">Selling Price</th>
                    <th colspan="3">Buying Price</th>
                    <th rowspan="2">Remarks</th>
                </tr>
                <tr>
                    <th>Unit Price</th>
                    <th>Total</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                    <th>Supplier</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->qty }}</td>
                        <td>{{ $d->description }}</td>
                        <td>Rp. {{ number_format($d->unit_bop, 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($d->total_bop, 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($d->unit_sp, 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($d->total_sp, 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($d->unit_bp, 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($d->total_bp, 0, ',', '.') }}</td>
                        <td>{{ $d->supplier }}</td>
                        <td>{{ $d->remarks }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold;">Total in Rupiah</td>
                    <td>Rp. {{ number_format($data->totalbop, 0, ',', '.') }}</td>
                    <td></td>
                    <td>Rp. {{ number_format($data->totalsp, 0, ',', '.') }}</td>
                    <td></td>
                    <td>Rp. {{ number_format($data->totalbp, 0, ',', '.') }}</td>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>
        <div class="footer">
            <p><strong>PO Received:</strong> {{ $data->po_received }}</p>
            <p><strong>No Form:</strong> {{ $data->no_form }}</p>
            <p><strong>Effective Date:</strong> {{ $data->effective_date }}</p>
            <p><strong>No Revisi:</strong> {{ $data->no_revisi }}</p>
            
            
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>

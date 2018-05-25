<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-weight: 500;
            color: #575757;
        }
        .cont {
            width: 725px;
        }
        p {
            margin-top: 0;
            margin-bottom: 0;
        }
        /*.right {
            width: 440px;
        }
        .left {
            width: 300px;
        }*/
        th, td {
            height: 30px;
        }
        .tableone {
            width: 450px;
        }
        td {
            border-bottom: 1px solid gray;
        }
    </style>
</head>
<body>

    <div class="cont" style="width: 700px;">

        <div style="height: 125px;">
            <div class="right" style="width: 450px; float: left;">
                <img src="{{ asset('img/logo_fossoter.png') }}" alt="" style="width: 400px; height: 125px;">
            </div>

            <div class="left" style="width: 250px; float: left;">
                <p style="font-weight: 900; color: black;">The No Bs Agency</p>
                <p>6a East, 3-35 Mackey Street,</p>
                <p>North GeeLong VIC 3215</p>
                <p>USA 18552036751</p>
                <p>UK 448000119057</p>
                <p>accounts@nobs.link</p>
            </div>
        </div>

        <div style="height: 20px; display: block; margin-top: 30px;">
            <h3 style=" color: black;">INVOICE</h3>
        </div>

        <div style="width: 700px; height: 100px;">
            <div class="right" style="width: 450px; height: 100px; float: left;">
                <p>{{ $invoice->order->user->first_name }} {{ $invoice->order->user->last_name }}</p>
                <p>{{ $invoice->order->user->email }}</p>
                @if($invoice->order->user->phone)
                    <p>{{ $invoice->order->user->phone }}</p>
                @endif
            </div>

            <div style=" width: 125px; height: 100px; float: left;">
                <p>Invoice Number:</p>
                <p>Invoice Date:</p>
                <p>Order Number:</p>
                <p>Order Date:</p>
                {{--<p>Payment Method:</p>--}}
            </div>

            <div style="width: 125px; height: 100px; float: left;">
                <p>{{ $invoice->id }}</p>
                <p>{{ (new \DateTime($invoice->created_at))->format('M j, Y') }}</p>
                <p>{{ $invoice->order->id }}</p>
                <p>{{ (new \DateTime($invoice->order->created_at))->format('M j, Y') }}</p>
                {{--<p>PayPal</p>--}}
            </div>

        </div>

        <div style="width: 700px; height: {{ ($invoice->order->products()->count() * 30) + 40 }}px;">
            <table style="width: 700px; margin-top: 20px; margin-left: 0; margin-right: 0; padding-left: 0; padding-right: 0; border: none; border-collapse: collapse;">
                <thead style="background-color: #000; color: #fff;">
                <tr>
                    <th class="tableone">Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
                </thead>
                <tbody style="">

                @foreach($invoice->order->products as $product)
                    <tr style="height: 30px;">
                        <td style="height: 30px;" class="tableone">{{ $product->title }}</td>
                        <td style="height: 30px;">{{ $product->pivot->quantity }}</td>
                        <td style="height: 30px;">{{ number_format($product->pivot->price) }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        <div style="width: 700px; margin-top: 20px;">
            <div class="right" style="width: 450px; float: left;">

            </div>

            <div style="float: left; width: 125px;">
                <p style="border-top: 1px solid gray; line-height: 30px; font-weight: 900; color: black;">Subtotal</p>
                <p style="border-top: 1px solid gray; line-height: 30px; font-weight: 900; color: black;">Discount</p>
                <p style="border-top: 2px solid black; border-bottom: 2px solid black; line-height: 30px; font-weight: 900; color: black;">Total</p>
            </div>

            <div style="float: left; width: 125px;">
                <p style="border-top: 1px solid gray; line-height: 30px;">USD ${{ number_format($invoice->order->without_discount, 2) }}</p>
                <p style="border-top: 1px solid gray; line-height: 30px;">-USD ${{ number_format($invoice->order->without_discount - $invoice->order->amount, 2) }}</p>
                <p style="border-top: 2px solid black; border-bottom: 2px solid black; line-height: 30px; font-weight: 900; color: black;">USD ${{ number_format($invoice->order->amount, 2) }}</p>
            </div>
        </div>

    </div>

</body>
</html>
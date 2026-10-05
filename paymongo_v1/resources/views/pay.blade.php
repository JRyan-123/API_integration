<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment</title>
    <style>
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 10% 0;


        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Payment</h2>
        <form method="POST" action="{{ route('checkout') }}">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <select name="payment_method" id="payment_method">
                    <option value="gcash">GCash</option>
                    <option value="paymaya">PayMaya</option>
                    <option value="card">Card</option>
                </select>
                <input type="number" name="amount" placeholder="Amount in PHP (e.g. 100)" required>
                <button type="submit">Pay Now</button>
            </div>

        </form>
    </div>
</body>

</html>

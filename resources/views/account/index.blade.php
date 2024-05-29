<!-- resources/views/account/index.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Banking System</h1>
        <div class="card mt-3">
            <div class="card-body">
                <h3>Balance: ${{ number_format($account->balance, 2) }}</h3>
            </div>
        </div>

        <div class="mt-3">
            <form action="/account/deposit" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="amount" class="form-label">Deposit Amount</label>
                    <input type="number" step="0.01" class="form-control" id="amount" name="amount">
                </div>
                <button type="submit" class="btn btn-primary">Deposit</button>
            </form>
        </div>

        <div class="mt-3">
            <form action="/account/withdraw" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="amount" class="form-label">Withdraw Amount</label>
                    <input type="number" step="0.01" class="form-control" id="amount" name="amount">
                </div>
                <button type="submit" class="btn btn-danger">Withdraw</button>
            </form>
        </div>
    </div>
</body>

</html>

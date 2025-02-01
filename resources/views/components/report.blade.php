<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Expense Report</h2>

    <p><strong>From:</strong> {{ $from->format('d M Y') }} <strong>To:</strong> {{ $to->format('d M Y') }}</p>

    <h3>Summary</h3>
    <table>
        <tr>
            <th>Total Income</th>
            <td>Rp.{{ number_format($reportData['total_income'], 2) }}</td>
        </tr>
        <tr>
            <th>Total Expense</th>
            <td>Rp.{{ number_format($reportData['total_expense'], 2) }}</td>
        </tr>
        <tr>
            <th>Profit</th>
            <td>Rp.{{ number_format($reportData['profit'], 2) }}</td>
        </tr>
    </table>

    <h3>Income Breakdown</h3>
    <table>
        <tr><th>Category</th><th>Amount</th></tr>
        @foreach($reportData['income_summary'] as $item)
            <tr><td>{{ $item['name'] }}</td><td>Rp. {{ number_format($item['amount'], 2) }}</td></tr>
        @endforeach
    </table>

    <h3>Expense Breakdown</h3>
    <table>
        <tr><th>Category</th><th>Amount</th></tr>
        @foreach($reportData['expense_summary'] as $item)
            <tr><td>{{ $item['name'] }}</td><td>Rp. {{ number_format($item['amount'], 2) }}</td></tr>
        @endforeach
    </table>
</body>
</html>

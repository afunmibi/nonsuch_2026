<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Payment Advice - {{ $bill->pa_code }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; color: #333; line-height: 1.4; font-size: 12px; }
        .header { border-bottom: 2px solid #0ea5e9; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { font-size: 20px; font-weight: bold; color: #0ea5e9; text-transform: uppercase; }
        .meta { float: right; text-align: right; }
        .section-title { font-size: 14px; font-weight: bold; margin-bottom: 10px; text-transform: uppercase; color: #555; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .row { display: table; width: 100%; margin-bottom: 20px; }
        .col { display: table-cell; width: 50%; vertical-align: top; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #eee; padding: 8px; text-align: left; }
        th { background: #f8fafc; font-weight: bold; text-transform: uppercase; font-size: 10px; color: #64748b; }
        .text-right { text-align: right; }
        .total-row td { background: #f1f5f9; font-weight: bold; border-top: 2px solid #cbd5e1; }
        .footer { position: fixed; bottom: 0; left: 0; right: 0; padding: 20px; border-top: 1px solid #eee; text-align: center; font-size: 10px; color: #94a3b8; }
        .stamp { border: 2px solid #0ea5e9; color: #0ea5e9; display: inline-block; padding: 5px 10px; font-weight: bold; text-transform: uppercase; transform: rotate(-5deg); margin-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">NONSUCH MEDICARE LIMITED</div>
        <div class="meta">
            <strong>Payment Advice</strong><br>
            PA Code: {{ $bill->pa_code }}<br>
            Date: {{ now()->format('M d, Y') }}
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="row">
        <div class="col">
            <div class="section-title">Provider Details (Payee)</div>
            <strong>{{ $bill->sec_hcp ?? $bill->pry_hcp }}</strong><br>
            {{ $bill->sec_hcp_code ?? $bill->pry_hcp_code }}<br>
            @if($bill->sec_hcp_email) Email: {{ $bill->sec_hcp_email }} @endif
        </div>
        <div class="col">
            <div class="section-title">Patient Information</div>
            <strong>{{ $bill->full_name }}</strong><br>
            Policy No: {{ $bill->policy_no }}
        </div>
    </div>

    <div class="section-title">Clinical Summary</div>
    <table>
        <tr>
            <th style="width: 150px;">Diagnosis</th>
            <td>{{ $bill->diagnosis }}</td>
        </tr>
        <tr>
            <th>Treatment Plan</th>
            <td>{{ $bill->treatment_plan }}</td>
        </tr>
    </table>

    <div class="section-title">Payment Breakdown</div>
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Tariff</th>
                <th class="text-right">Claimed</th>
                <th class="text-right">Approved</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bill->services as $service)
            <tr>
                <td>{{ $service->service_name }} (Service)</td>
                <td class="text-right">{{ $service->qty }}</td>
                <td class="text-right">&#8358;{{ number_format($service->tariff, 2) }}</td>
                <td class="text-right text-red-500">&#8358;{{ number_format($service->hcp_amount_claimed_total_services, 2) }}</td>
                <td class="text-right">&#8358;{{ number_format($service->hcp_amount_due_total_services, 2) }}</td>
            </tr>
            @endforeach

            @foreach($bill->drugs as $drug)
            <tr>
                <td>{{ $drug->drug_name }} (Drug)</td>
                <td class="text-right">{{ $drug->qty }}</td>
                <td class="text-right">&#8358;{{ number_format($drug->tariff, 2) }}</td>
                <td class="text-right text-red-500">&#8358;{{ number_format($drug->hcp_amount_claimed_total_drugs, 2) }}</td>
                <td class="text-right">&#8358;{{ number_format($drug->hcp_amount_due_total_drugs, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" class="text-right">Totals:</td>
                <td class="text-right">&#8358;{{ number_format($bill->hcp_amount_claimed_grandtotal, 2) }}</td>
                <td class="text-right text-emerald-600">&#8358;{{ number_format($bill->hcp_amount_due_grandtotal, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="row">
        <div class="col">
            <div class="section-title">Authorization</div>
            <p><strong>Clinical Approval:</strong> {{ $bill->approved_by }} (MD)<br>
            <strong>Date:</strong> {{ $bill->authorized_at ? \Carbon\Carbon::parse($bill->authorized_at)->format('M d, Y') : 'N/A' }}</p>
            
            <p><strong>Processed By:</strong> {{ $bill->paid_by }} (CM)<br>
            <strong>Date:</strong> {{ $bill->paid_at ? \Carbon\Carbon::parse($bill->paid_at)->format('M d, Y') : 'N/A' }}</p>

            <div class="stamp">PAID / CLOSED</div>
        </div>
        <div class="col">
             <div class="section-title">Bank Settlement Details</div>
             Bank: {{ $bill->sec_hcp_bank_name ?? 'N/A' }}<br>
             Acct Name: {{ $bill->sec_hcp_account_name ?? 'N/A' }}<br>
             Acct No: {{ $bill->sec_hcp_account_number ?? 'N/A' }}
        </div>
    </div>

    <div class="footer">
        NONSUCH MEDICARE LIMITED | Confidential Document | Generated {{ now() }}
    </div>
</body>
</html>

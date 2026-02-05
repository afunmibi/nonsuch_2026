<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bill Summary - {{ $bill->pa_code }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; color: #1e293b; line-height: 1.5; font-size: 11px; margin: 20px; }
        .header { border-bottom: 3px solid #0ea5e9; padding-bottom: 15px; margin-bottom: 25px; }
        .logo { font-size: 20px; font-weight: bold; color: #0ea5e9; text-transform: uppercase; letter-spacing: 1px; }
        .doc-title { font-size: 14px; font-weight: bold; color: #475569; margin-top: 5px; }
        .meta-info { text-align: right; font-size: 10px; color: #64748b; }
        .section { margin-bottom: 20px; }
        .section-title { font-size: 13px; font-weight: bold; color: #334155; background: #f1f5f9; padding: 8px; margin-bottom: 10px; border-left: 4px solid #0ea5e9; }
        .info-grid { display: table; width: 100%; }
        .info-row { display: table-row; }
        .info-label { display: table-cell; width: 35%; font-weight: 600; color: #475569; padding: 5px 0; }
        .info-value { display: table-cell; width: 65%; color: #1e293b; padding: 5px 0; }
        .totals-box { background: #f8fafc; border: 2px solid #cbd5e1; padding: 15px; margin-top: 20px; border-radius: 4px; }
        .total-item { display: flex; justify-content: space-between; padding: 5px 0; font-size: 12px; }
        .total-item.grand { font-size: 16px; font-weight: bold; color: #0284c7; border-top: 2px solid #cbd5e1; padding-top: 10px; margin-top: 10px; }
        .footer { position: fixed; bottom: 20px; left: 20px; right: 20px; text-align: center; font-size: 9px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    <style>
        /* Add table specific styles if not already there */
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table th { background: #f1f5f9; padding: 10px; border: 1px solid #e2e8f0; text-align: left; width: 35%; font-weight: 600; color: #475569; }
        .info-table td { padding: 10px; border: 1px solid #e2e8f0; color: #1e293b; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">NONSUCH MEDICARE LIMITED</div>
        <div class="doc-title">Bill Summary Report</div>
        <div class="meta-info">
            Generated: {{ now()->format('M d, Y H:i:s') }}<br>
            PA Code: <strong>{{ $bill->pa_code }}</strong>
        </div>
    </div>

    <!-- Patient Information -->
    <div class="section">
        <div class="section-title">PATIENT INFORMATION</div>
        <table class="info-table">
            <tr>
                <th>Full Name:</th>
                <td>{{ $bill->full_name }}</td>
            </tr>
            <tr>
                <th>Policy Number:</th>
                <td>{{ $bill->policy_no }}</td>
            </tr>
            <tr>
                <th>PA Code:</th>
                <td>{{ $bill->pa_code }}</td>
            </tr>
        </table>
    </div>

    <!-- Healthcare Provider Information -->
    <div class="section">
        <div class="section-title">HEALTHCARE PROVIDER DETAILS</div>
        <table class="info-table">
            <tr>
                <th>Primary HCP:</th>
                <td>{{ $bill->pry_hcp }} ({{ $bill->pry_hcp_code }})</td>
            </tr>
            @if($bill->sec_hcp)
            <tr>
                <th>Secondary HCP:</th>
                <td>{{ $bill->sec_hcp }} ({{ $bill->sec_hcp_code }})</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- Clinical Information -->
    <div class="section">
        <div class="section-title">CLINICAL SUMMARY</div>
        <table class="info-table">
            <tr>
                <th>Diagnosis:</th>
                <td>{{ $bill->diagnosis }}</td>
            </tr>
            <tr>
                <th>Treatment Plan:</th>
                <td>{{ $bill->treatment_plan }}</td>
            </tr>
        </table>
    </div>

    <!-- Bank Account Details -->
    @if($bill->sec_hcp_bank_name || $bill->hcp_bank_name)
    <div class="section">
        <div class="section-title">PAYMENT ACCOUNT DETAILS</div>
        <table class="info-table">
            <tr>
                <th>Bank Name:</th>
                <td>{{ $bill->sec_hcp_bank_name ?? $bill->hcp_bank_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Account Name:</th>
                <td>{{ $bill->sec_hcp_account_name ?? $bill->hcp_account_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Account Number:</th>
                <td>{{ $bill->sec_hcp_account_number ?? $bill->hcp_account_number ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>
    @endif

    <!-- Financial Summary -->
    <div class="totals-box">
        <div class="total-item">
            <span>Total Amount Claimed:</span>
            <span>₦{{ number_format($bill->hcp_amount_claimed_grandtotal, 2) }}</span>
        </div>
        <div class="total-item grand">
            <span>Total Amount Due:</span>
            <span>₦{{ number_format($bill->hcp_amount_due_grandtotal, 2) }}</span>
        </div>
    </div>

    <div class="footer">
        Nonsuch Health AI System | Confidential Document | Page 1 of 1
    </div>
</body>
</html>

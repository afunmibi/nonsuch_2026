<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .section-title { background: #f0f0f0; padding: 5px; font-weight: bold; margin-top: 20px; text-transform: uppercase; border: 1px solid #ccc; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .workflow { margin-top: 30px; font-size: 10px; }
        .workflow-box { border: 1px dashed #999; padding: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>HCP PAYMENT VOUCHER</h2>
        <p>PA Code: <strong>{{ $bill->pa_code }}</strong> | Status: PAID</p>
    </div>

    <div class="section-title">Initial Authorization Details (Log)</div>
    <table>
        <tr>
            <td><strong>Patient Name:</strong> {{ $logRequest->full_name ?? 'N/A' }}</td>
            <td><strong>Policy No:</strong> {{ $logRequest->policy_no ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Diagnosis:</strong> {{ $logRequest->diagnosis ?? 'N/A' }}</td>
            <td><strong>Admission Date:</strong> {{ $logRequest->admission_date ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="section-title">Itemized Vetting Results</div>
    <table>
        <thead>
            <tr style="background: #eee;">
                <th>Description</th>
                <th>Category</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Tariff</th>
                <th class="text-right">Amount Due</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $s)
            <tr>
                <td>{{ $s->service_name }}</td>
                <td>Service</td>
                <td class="text-right">{{ $s->qty }}</td>
                <td class="text-right">{{ number_format($s->tariff, 2) }}</td>
                <td class="text-right">{{ number_format($s->hcp_amount_due_total_services, 2) }}</td>
            </tr>
            @endforeach
            @foreach($drugs as $d)
            <tr>
                <td>{{ $d->drug_name }}</td>
                <td>Drug</td>
                <td class="text-right">{{ $d->qty }}</td>
                <td class="text-right">{{ number_format($d->tariff, 2) }}</td>
                <td class="text-right">{{ number_format($d->hcp_amount_due_total_drugs, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bold">
                <td colspan="4" class="text-right">GRAND TOTAL:</td>
                <td class="text-right" style="color: #d00;">₦{{ number_format($grandTotal, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="section-title">HCP Beneficiary Information</div>
    <table>
        <tr>
            <td><strong>Bank:</strong> {{ $bill->hcp_bank_name }}</td>
            <td><strong>Account No:</strong> {{ $bill->hcp_account_number }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Account Name:</strong> {{ $bill->hcp_account_name }}</td>
        </tr>
    </table>

    <div class="workflow">
        <div class="section-title">Approval Workflow Audit Trail</div>
        <div class="workflow-box">
            <p><strong>1. Staff Vetting:</strong> {{ $bill->vetted_by }} | {{ $bill->created_at }}</p>
            <p><strong>2. UD Checked:</strong> {{ $bill->checked_by }} | {{ $bill->updated_at }}</p>
            <p><strong>3. GM Re-Checked:</strong> {{ $bill->re_checked_by }} | {{ $bill->re_checked_at }}</p>
            <p><strong>4. MD Authorized:</strong> {{ $bill->authorized_by }} | {{ $bill->authorized_at }}</p>
            <p><strong>5. CM Bank Link:</strong> {{ $bill->cm_processed_by }} | {{ $bill->cm_processed_at }}</p>
            <p><strong>6. Account Paid:</strong> {{ $bill->paid_by }} | {{ now() }}</p>
        </div>
    </div>
</body>
</html>
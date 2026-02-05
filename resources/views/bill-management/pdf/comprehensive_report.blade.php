<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Comprehensive Vetting Report - {{ $bill->pa_code }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; color: #1e293b; line-height: 1.4; font-size: 10px; margin: 15px; }
        .header { border-bottom: 3px solid #0ea5e9; padding-bottom: 12px; margin-bottom: 20px; }
        .logo { font-size: 18px; font-weight: bold; color: #0ea5e9; text-transform: uppercase; }
        .doc-title { font-size: 12px; font-weight: bold; color: #475569; margin-top: 3px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 9px; }
        th, td { border: 1px solid #e2e8f0; padding: 6px; text-align: left; }
        th { background: #f1f5f9; font-weight: bold; color: #475569; text-transform: uppercase; font-size: 8px; }
        .text-right { text-align: right; }
        .total-row td { background: #fef3c7; font-weight: bold; border-top: 2px solid #fbbf24; }
        .section-title { font-size: 11px; font-weight: bold; color: #1e293b; background: #f8fafc; padding: 6px; margin: 15px 0 8px; border-left: 4px solid #0ea5e9; }
        .vetting-stage { background: #f0fdf4; border-left: 4px solid #22c55e; padding: 8px; margin-bottom: 8px; font-size: 9px; }
        .vetting-stage.rejected { background: #fef2f2; border-left-color: #ef4444; }
        .stage-name { font-weight: bold; color: #15803d; font-size: 10px; }
        .info-line { padding: 2px 0; }
        .info-label { font-weight: 600; color: #64748b; display: inline-block; width: 120px; }
        .footer { position: fixed; bottom: 15px; left: 15px; right: 15px; text-align: center; font-size: 8px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 8px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">NONSUCH MEDICARE LIMITED</div>
        <div class="doc-title">Comprehensive Bill Vetting Report</div>
        <div style="text-align: right; font-size: 9px; color: #64748b; margin-top: 5px;">
            Generated: {{ now()->format('M d, Y H:i') }} | PA Code: <strong>{{ $bill->pa_code }}</strong>
        </div>
    </div>

    <!-- Patient & Policy Information -->
    <div class="section-title">PATIENT & POLICY INFORMATION</div>
    <div style="display: table; width: 100%; font-size: 9px; margin-bottom: 15px;">
        <div style="display: table-row;">
            <div style="display: table-cell; width: 50%; padding-right: 10px;">
                <div class="info-line"><span class="info-label">Full Name:</span> {{ $bill->full_name }}</div>
                <div class="info-line"><span class="info-label">Policy Number:</span> {{ $bill->policy_no }}</div>
                <div class="info-line"><span class="info-label">Phone:</span> {{ $bill->phone_no }}</div>
            </div>
            <div style="display: table-cell; width: 50%;">
                <div class="info-line"><span class="info-label">PA Code:</span> {{ $bill->pa_code }}</div>
                <div class="info-line"><span class="info-label">Package Code:</span> {{ $bill->package_code }}</div>
                <div class="info-line"><span class="info-label">Package Limit:</span> ₦{{ number_format($bill->package_limit ?? 0, 2) }}</div>
            </div>
        </div>
    </div>

    <!-- Healthcare Providers -->
    <div class="section-title">HEALTHCARE PROVIDER DETAILS</div>
    <div style="font-size: 9px; margin-bottom: 15px;">
        <div class="info-line"><span class="info-label">Primary HCP:</span> {{ $bill->pry_hcp }} ({{ $bill->pry_hcp_code }})</div>
        @if($bill->sec_hcp)
        <div class="info-line"><span class="info-label">Secondary HCP:</span> {{ $bill->sec_hcp }} ({{ $bill->sec_hcp_code }})</div>
        @endif
    </div>

    <!-- Clinical Summary -->
    <div class="section-title">CLINICAL SUMMARY</div>
    <table>
        <tr>
            <th style="width: 150px;">Diagnosis</th>
            <td>{{ $bill->diagnosis }}</td>
        </tr>
        <tr>
            <th>Treatment Plan</th>
            <td>{{ $bill->treatment_plan }}</td>
        </tr>
        @if($bill->further_investigation)
        <tr>
            <th>Investigation</th>
            <td>{{ $bill->further_investigation }}</td>
        </tr>
        @endif
        @if($bill->admission_date)
        <tr>
            <th>Admission Period</th>
            <td>{{ $bill->admission_date }} to {{ $bill->discharge_date }} ({{ $bill->admission_days }} days)</td>
        </tr>
        @endif
    </table>

    <!-- Itemized Services -->
    @if($bill->services && $bill->services->count() > 0)
    <div class="section-title">VETTED SERVICES</div>
    <table>
        <thead>
            <tr>
                <th>Service Name</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Tariff</th>
                <th class="text-right">Claimed Total</th>
                <th class="text-right">Approved Total</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bill->services as $service)
            <tr>
                <td>{{ $service->service_name }}</td>
                <td class="text-right">{{ $service->qty }}</td>
                <td class="text-right">₦{{ number_format($service->tariff, 2) }}</td>
                <td class="text-right">₦{{ number_format($service->hcp_amount_claimed_total_services ?? 0, 2) }}</td>
                <td class="text-right">₦{{ number_format($service->hcp_amount_due_total_services, 2) }}</td>
                <td style="font-size: 8px;">{{ $service->remarks ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Itemized Drugs -->
    @if($bill->drugs && $bill->drugs->count() > 0)
    <div class="section-title">VETTED DRUGS</div>
    <table>
        <thead>
            <tr>
                <th>Drug Name</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Tariff</th>
                <th class="text-right">Copay (10%)</th>
                <th class="text-right">Approved Net</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bill->drugs as $drug)
            <tr>
                <td>{{ $drug->drug_name }}</td>
                <td class="text-right">{{ $drug->qty }}</td>
                <td class="text-right">₦{{ number_format($drug->tariff, 2) }}</td>
                <td class="text-right">₦{{ number_format($drug->copayment_10 ?? 0, 2) }}</td>
                <td class="text-right">₦{{ number_format($drug->hcp_amount_due_total_drugs, 2) }}</td>
                <td style="font-size: 8px;">{{ $drug->remarks ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Financial Summary -->
    <div class="section-title">FINANCIAL SUMMARY</div>
    <table style="width: 50%; margin-left: auto;">
        <tr>
            <td style="font-weight: bold;">Total Amount Claimed by HCP:</td>
            <td class="text-right" style="font-weight: bold;">₦{{ number_format($bill->hcp_amount_claimed_grandtotal, 2) }}</td>
        </tr>
        <tr class="total-row">
            <td>Total Amount Approved for Payment:</td>
            <td class="text-right">₦{{ number_format($bill->hcp_amount_due_grandtotal, 2) }}</td>
        </tr>
    </table>

    <!-- Payment Details -->
    @if($bill->sec_hcp_bank_name || $bill->hcp_bank_name)
    <div class="section-title">PAYMENT ACCOUNT DETAILS</div>
    <div style="font-size: 9px;">
        <div class="info-line"><span class="info-label">Bank Name:</span> {{ $bill->sec_hcp_bank_name ?? $bill->hcp_bank_name ?? 'N/A' }}</div>
        <div class="info-line"><span class="info-label">Account Name:</span> {{ $bill->sec_hcp_account_name ?? $bill->hcp_account_name ?? 'N/A' }}</div>
        <div class="info-line"><span class="info-label">Account Number:</span> {{ $bill->sec_hcp_account_number ?? $bill->hcp_account_number ?? 'N/A' }}</div>
    </div>
    @endif

    <!-- Vetting History/Workflow -->
    <div class="section-title">VETTING WORKFLOW & APPROVALS</div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 40px;">Stage</th>
                <th>Process / Department</th>
                <th>Officer Name</th>
                <th>Status</th>
                <th>Date & Time</th>
            </tr>
        </thead>
        <tbody>
            @if($bill->vetted_by)
            <tr>
                <td>1</td>
                <td>STAFF VETTING</td>
                <td>{{ $bill->vetted_by }}</td>
                <td><span style="color: #15803d; font-weight: bold;">PROCESSED</span></td>
                <td>{{ $bill->staff_vetted_at ? \Carbon\Carbon::parse($bill->staff_vetted_at)->format('M d, Y H:i') : 'N/A' }}</td>
            </tr>
            @endif

            @if($bill->checked_by)
            <tr>
                <td>2</td>
                <td>UNDERWRITER (UD)</td>
                <td>{{ $bill->checked_by }}</td>
                <td><span style="color: #15803d; font-weight: bold;">CHECKED</span></td>
                <td>{{ $bill->checked_at ? \Carbon\Carbon::parse($bill->checked_at)->format('M d, Y H:i') : 'N/A' }}</td>
            </tr>
            @endif

            @if($bill->re_checked_by)
            <tr>
                <td>3</td>
                <td>GENERAL MANAGER (GM)</td>
                <td>{{ $bill->re_checked_by }}</td>
                <td><span style="color: #15803d; font-weight: bold;">REVIEWED</span></td>
                <td>{{ $bill->re_checked_at ? \Carbon\Carbon::parse($bill->re_checked_at)->format('M d, Y H:i') : 'N/A' }}</td>
            </tr>
            @endif

            @if($bill->approved_by)
            <tr>
                <td>4</td>
                <td>MEDICAL DIRECTOR (MD)</td>
                <td>{{ $bill->approved_by }}</td>
                <td><span style="color: #15803d; font-weight: bold;">AUTHORIZED</span></td>
                <td>{{ $bill->authorized_at ? \Carbon\Carbon::parse($bill->authorized_at)->format('M d, Y H:i') : 'N/A' }}</td>
            </tr>
            @endif

            @if($bill->scheduled_for_payment_by)
            <tr>
                <td>5</td>
                <td>CASE MANAGER (CM)</td>
                <td>{{ $bill->scheduled_for_payment_by }}</td>
                <td><span style="color: #15803d; font-weight: bold;">SCHEDULED</span></td>
                <td>{{ $bill->cm_processed_at ? \Carbon\Carbon::parse($bill->cm_processed_at)->format('M d, Y H:i') : 'N/A' }}</td>
            </tr>
            @endif

            @if($bill->paid_by)
            <tr>
                <td>6</td>
                <td>ACCOUNTS DEPT</td>
                <td>{{ $bill->paid_by }}</td>
                <td><span style="color: #15803d; font-weight: bold;">PAID</span></td>
                <td>{{ $bill->paid_at ? \Carbon\Carbon::parse($bill->paid_at)->format('M d, Y H:i') : 'N/A' }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        NONSUCH MEDICARE LIMITED | Confidential Document | Generated {{ now()->format('Y-m-d H:i:s') }}
    </div>
</body>
</html>

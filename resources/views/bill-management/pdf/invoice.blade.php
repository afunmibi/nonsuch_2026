<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Payment Voucher - {{ $bill->pa_code }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #333; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 15px; }
        .logo { font-size: 24px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; color: #1e3a8a; }
        .sub-header { font-size: 14px; font-weight: bold; margin-bottom: 5px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 6px 8px; border: 1px solid #ddd; text-align: left; vertical-align: top; }
        th { background-color: #f3f4f6; font-weight: bold; text-transform: uppercase; font-size: 9px; }
        
        .section-title { font-size: 12px; font-weight: bold; margin-bottom: 8px; margin-top: 15px; text-transform: uppercase; border-bottom: 1px solid #ccc; padding-bottom: 3px; }
        
        .total-row td { background-color: #f9fafb; font-weight: bold; border-top: 2px solid #333; }
        .amount { text-align: right; }
        
        .signatures { margin-top: 40px; page-break-inside: avoid; }
        .sig-box { width: 33%; float: left; text-align: center; }
        .sig-line { width: 80%; border-top: 1px solid #000; margin: 40px auto 5px; }
        .sig-title { font-weight: bold; font-size: 10px; text-transform: uppercase; }
        
        .bank-details { background: #f0fdf4; border: 1px solid #bbf7d0; padding: 10px; margin-bottom: 20px; border-radius: 4px; }
        .paid-stamp { 
            position: absolute; top: 150px; right: 50px; 
            border: 3px solid #059669; color: #059669; 
            font-size: 24px; font-weight: bold; 
            padding: 10px 20px; text-transform: uppercase; 
            transform: rotate(-15deg); opacity: 0.8; 
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Nonsuch Medicare Limited</div>
        <div class="sub-header">HCP Payment Voucher</div>
        <div>Generating Date: {{ now()->format('d M Y, h:i A') }}</div>
        <div>Voucher Reference: {{ $bill->pa_code }}</div>
    </div>

    @if($bill->status == 'paid')
    <div class="paid-stamp">PAID</div>
    @endif

    <!-- Beneficiary & Bank Details -->
    <div class="bank-details">
        <table style="border: none; margin: 0; background: transparent;">
            <tr style="background: transparent;">
                <td style="border: none; width: 60%;">
                    <strong style="display: block; font-size: 12px; margin-bottom: 4px;">Beneficiary Details (HCP)</strong>
                    <div style="font-size: 14px; font-weight: bold;">{{ $bill->sec_hcp ?? $bill->pry_hcp }}</div>
                    <div>Code: {{ $bill->sec_hcp_code ?? $bill->pry_hcp_code }}</div>
                </td>
                <td style="border: none; width: 40%;">
                    <strong style="display: block; font-size: 12px; margin-bottom: 4px;">Bank Settlement Info</strong>
                    <div style="font-size: 12px;"><strong>Bank:</strong> {{ $bill->sec_hcp_bank_name }}</div>
                    <div style="font-size: 12px;"><strong>Acc No:</strong> {{ $bill->sec_hcp_account_number }}</div>
                    <div style="font-size: 10px; color: #666;">Name: {{ $bill->sec_hcp_account_name }}</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Patient Info -->
    <table>
        <tr>
            <th width="20%">Patient Name</th>
            <td width="30%">{{ $bill->full_name }}</td>
            <th width="20%">Policy Number</th>
            <td width="30%">{{ $bill->policy_no }}</td>
        </tr>
        <tr>
            <th>Enrollee Company</th>
            <td>{{ $bill->enrollee_company ?? 'N/A' }}</td>
            <th>Admission Date</th>
            <td>{{ $bill->date_admitted ?? 'N/A' }} ({{ $bill->admission_days }} Days)</td>
        </tr>
        <tr>
            <th>Primary Diagnosis</th>
            <td colspan="3">{{ $bill->diagnosis }}</td>
        </tr>
    </table>

    <div class="section-title">Payment Breakdown</div>
    
    <!-- Services Table -->
    <table>
        <thead>
            <tr>
                <th width="50%">Service Description</th>
                <th width="15%" class="amount">Claimed</th>
                <th width="15%" class="amount">Vetted</th>
                <th width="20%">Reason</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr>
                <td>{{ $service->service_name }}</td>
                <td class="amount">&#8358;{{ number_format($service->hcp_amount_claimed_total_services, 2) }}</td>
                <td class="amount">&#8358;{{ number_format($service->hcp_amount_due_total_services, 2) }}</td>
                <td>{{ $service->remarks }}</td>
            </tr>
            @endforeach
            
            @if($drugs->isNotEmpty())
            <tr>
                <td colspan="4" style="background:#f9f9f9; font-weight:bold; font-size:10px; padding:4px;">DRUGS & CONSUMABLES</td>
            </tr>
            @foreach($drugs as $drug)
            <tr>
                <td>{{ $drug->drug_name }} ({{ $drug->qty }}x)</td>
                <td class="amount">&#8358;{{ number_format($drug->hcp_amount_claimed_total_drugs, 2) }}</td>
                <td class="amount">&#8358;{{ number_format($drug->hcp_amount_due_total_drugs, 2) }}</td>
                <td>{{ $drug->remarks }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td style="text-align: right; text-transform: uppercase;">Total Payment Authorized</td>
                <td class="amount" style="color: #999;">&#8358;{{ number_format($bill->hcp_amount_claimed_grandtotal, 2) }}</td>
                <td class="amount" style="font-size: 14px;">&#8358;{{ number_format($bill->hcp_amount_due_grandtotal, 2) }}</td>
                <td style="background: #f3f4f6;"></td>
            </tr>
        </tfoot>
    </table>

    <!-- Approval Chain -->
    <div class="signatures">
        <div class="sig-box">
            <div class="sig-title">Prepared By (CM)</div>
            <div class="sig-line"></div>
            <div>{{ $cm_staff }}</div>
            <div style="font-size: 9px; color: #666;">{{ $bill->cm_processed_at }}</div>
        </div>
        <div class="sig-box">
            <div class="sig-title">Approved By (MD)</div>
            <div class="sig-line"></div>
            <div>{{ $md_authorizer }}</div>
        </div>
        <div class="sig-box">
            <div class="sig-title">Paid By (Accounts)</div>
            <div class="sig-line"></div>
            <div>{{ $accountant ?? '_________________' }}</div>
            @if($bill->paid_at)
            <div style="font-size: 9px; color: #666;">{{ $bill->paid_at }}</div>
            @endif
        </div>
        <div style="clear: both;"></div>
    </div>

    <div style="margin-top: 30px; font-size: 9px; text-align: center; color: #888;">
        This document is system generated by Nonsuch AI. | Printed: {{ now() }}
    </div>
</body>
</html>

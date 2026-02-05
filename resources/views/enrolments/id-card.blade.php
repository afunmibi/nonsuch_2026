<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identity Card - {{ $enrolment->full_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; }
        }
        .id-card {
            width: 350px;
            height: 220px;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            position: relative;
        }
        .id-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -20%;
            width: 140%;
            height: 140%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            z-index: 1;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-8 flex flex-col items-center gap-8">

    <div class="no-print bg-white p-4 rounded-xl shadow-sm flex gap-4">
        <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">
            <i class="fas fa-print mr-2"></i> Print Card
        </button>
        <a href="{{ route('enrolments.show', $enrolment->id) }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-bold hover:bg-gray-300 transition">
            Back to Details
        </a>
    </div>

    <!-- Principal Card -->
    <div class="space-y-4">
        <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest text-center">Principal ID Card</h2>
        <div class="id-card p-4 text-white flex flex-col justify-between relative">
            <div class="z-10 flex justify-between items-start">
                <div class="flex items-center gap-2">
                    <i class="fas fa-hospital text-2xl"></i>
                    <span class="font-black text-xs tracking-tighter uppercase italic">NONSUCH HMO</span>
                </div>
                <div class="text-[8px] bg-white/20 px-2 py-0.5 rounded font-black uppercase italic">Member ID</div>
            </div>

            <div class="z-10 flex gap-4 mt-2">
                <div class="w-20 h-24 bg-white/10 rounded-lg overflow-hidden border-2 border-white/30 flex-shrink-0">
                    @if($enrolment->photograph)
                        <img src="{{ asset('storage/' . $enrolment->photograph) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-white/50">
                            <i class="fas fa-user text-3xl"></i>
                        </div>
                    @endif
                </div>
                <div class="flex flex-col justify-center">
                    <p class="text-[14px] font-black leading-tight uppercase mb-1">{{ $enrolment->full_name }}</p>
                    <p class="text-[12px] font-bold text-blue-100 flex items-center gap-1">
                        <i class="fas fa-fingerprint text-[10px]"></i>
                        {{ $enrolment->policy_no }}
                    </p>
                    <div class="grid grid-cols-2 gap-x-4 mt-2 border-t border-white/20 pt-2">
                        <div>
                            <p class="text-[6px] text-blue-200 uppercase font-black">Plan Type</p>
                            <p class="text-[8px] font-black uppercase">{{ $enrolment->package_code }}</p>
                        </div>
                        <div>
                            <p class="text-[6px] text-blue-200 uppercase font-black">Valid Thru</p>
                            <p class="text-[8px] font-black">12/2026</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="z-10 flex justify-between items-end mt-2 uppercase">
                <div class="text-[7px]">
                    <p class="text-blue-200 font-bold mb-0.5">Primary Provider:</p>
                    <p class="font-black leading-none">{{ $enrolment->pry_hcp }}</p>
                </div>
                <div class="text-[10px] bg-white text-blue-600 font-black px-3 py-1 rounded-sm shadow-lg">
                    PRINCIPAL
                </div>
            </div>
        </div>
    </div>

    <!-- Dependant Cards -->
    @for($i=1; $i<=4; $i++)
        @php 
            $name = "dependants_{$i}_name";
            $dob = "dependants_{$i}_dob";
            $status = "dependants_{$i}_status";
            $photo = "dependants_{$i}_photograph";
        @endphp

        @if($enrolment->$name)
        <div class="space-y-4">
            <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest text-center mt-4">Dependant ID Card</h2>
            <div class="id-card p-4 text-white flex flex-col justify-between relative" style="background: linear-gradient(135deg, #059669 0%, #fbbf24 140%);">
                <div class="z-10 flex justify-between items-start">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-hospital text-2xl"></i>
                        <span class="font-black text-xs tracking-tighter uppercase italic">NONSUCH HMO</span>
                    </div>
                    <div class="text-[8px] bg-white/20 px-2 py-0.5 rounded font-black uppercase italic tracking-widest">Dependent ID</div>
                </div>

                <div class="z-10 flex gap-4 mt-2">
                    <div class="w-20 h-24 bg-white/10 rounded-lg overflow-hidden border-2 border-white/30 flex-shrink-0">
                        @if($enrolment->$photo)
                            <img src="{{ asset('storage/' . $enrolment->$photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-white/50">
                                <i class="fas fa-user-friends text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-col justify-center">
                        <p class="text-[14px] font-black leading-tight uppercase mb-1">{{ $enrolment->$name }}</p>
                        <p class="text-[12px] font-bold text-emerald-100 flex items-center gap-1">
                            <i class="fas fa-link text-[10px]"></i>
                            {{ $enrolment->policy_no }}
                        </p>
                        <div class="grid grid-cols-2 gap-x-4 mt-2 border-t border-white/20 pt-2 text-emerald-50">
                            <div>
                                <p class="text-[6px] text-emerald-200 uppercase font-black">Relation</p>
                                <p class="text-[8px] font-black uppercase">{{ $enrolment->$status }}</p>
                            </div>
                            <div>
                                <p class="text-[6px] text-emerald-200 uppercase font-black">DOB</p>
                                <p class="text-[8px] font-black">{{ $enrolment->$dob }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="z-10 flex justify-between items-end mt-2 uppercase">
                    <div class="text-[7px]">
                        <p class="text-emerald-100 font-bold mb-0.5">Linked Parent/Guard:</p>
                        <p class="font-black leading-none italic">{{ $enrolment->full_name }}</p>
                    </div>
                    <div class="text-[10px] bg-white text-emerald-700 font-black px-3 py-1 rounded-sm shadow-lg">
                        DEPENDANT
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endfor

</body>
</html>

@extends('layouts.app')

@section('title', 'Boarding Pass - SkyConnect')

@section('content')
<div class="container py-5 px-lg-5">
    <div id="pass-root">
        <div class="row justify-content-center"><div class="col-lg-10"><div class="shimmer rounded-5" style="height: 400px;"></div></div></div>
    </div>
    
    <div class="text-center mt-5">
        <button onclick="window.print()" class="btn btn-outline-dark rounded-pill px-5 fw-bold"><i class="fas fa-print me-2"></i> PRINT PASS</button>
    </div>
</div>

<style>
    .shimmer { background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: loading 1.5s infinite; }
    @keyframes loading { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    
    .pass-card { background: white; border-radius: 30px; display: flex; overflow: hidden; box-shadow: 0 30px 60px rgba(0,0,0,0.1); border: 1px solid rgba(0,0,0,0.05); }
    .pass-main { flex: 3; padding: 40px; border-right: 2px dashed #e0e0e0; position: relative; }
    .pass-stub { flex: 1; padding: 40px; background: #f8f9fa; display: flex; flex-direction: column; justify-content: space-between; }
    
    .pass-main::before, .pass-main::after { content: ''; position: absolute; right: -15px; width: 30px; height: 30px; background: #f4f7f6; border-radius: 50%; }
    .pass-main::before { top: -15px; }
    .pass-main::after { bottom: -15px; }

    .barcode { height: 60px; background: repeating-linear-gradient(90deg, #333, #333 2px, transparent 2px, transparent 4px); width: 100%; opacity: 0.3; }
    
    @media print {
        nav, footer, .btn { display: none !important; }
        body { background: white !important; }
        .container { max-width: 100% !important; padding: 0 !important; }
        .pass-card { box-shadow: none !important; border: 1px solid #eee !important; margin-top: 50px; }
    }
</style>

@push('scripts')
<script>
const NODE_API = 'http://localhost:3000';
const bookingId = "{{ $id }}";

document.addEventListener('DOMContentLoaded', () => {
    loadPass();
});

async function loadPass() {
    const res = await fetch(`${NODE_API}/api/bookings/${bookingId}`, {
        headers: window.API_TOKEN ? { 'Authorization': 'Bearer ' + window.API_TOKEN } : {}
    });
    const data = await res.json();
    if (data.success) renderPass(data.booking, data.passengers[0]);
}

function renderPass(b, p) {
    const f = b.flight;
    const date = new Date(f.departure_time);
    
    document.getElementById('pass-root').innerHTML = `
        <div class="row justify-content-center reveal">
            <div class="col-lg-10">
                <div class="pass-card">
                    <div class="pass-main">
                        <div class="d-flex justify-content-between mb-5">
                            <div>
                                <h4 class="fw-800 text-primary mb-0">SkyConnect</h4>
                                <p class="small text-secondary fw-bold text-uppercase">Boutique Aviation</p>
                            </div>
                            <div class="text-end">
                                <h6 class="text-secondary small fw-bold mb-0">FLIGHT</h6>
                                <h4 class="fw-800 text-dark mb-0">${f.flight_number}</h4>
                            </div>
                        </div>
                        
                        <div class="row mb-5 text-center">
                            <div class="col-4">
                                <h1 class="display-4 fw-800 mb-0">${f.origin_airport_id.code}</h1>
                                <p class="small text-secondary text-uppercase fw-bold">${f.origin_airport_id.city}</p>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-center">
                                <i class="fas fa-plane text-primary opacity-25 fa-2x"></i>
                            </div>
                            <div class="col-4">
                                <h1 class="display-4 fw-800 mb-0">${f.destination_airport_id.code}</h1>
                                <p class="small text-secondary text-uppercase fw-bold">${f.destination_airport_id.city}</p>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-6">
                                <p class="x-small text-muted text-uppercase mb-1 fw-bold">Passenger</p>
                                <h5 class="fw-bold text-dark">${p.first_name} ${p.last_name}</h5>
                            </div>
                            <div class="col-3">
                                <p class="x-small text-muted text-uppercase mb-1 fw-bold">Date</p>
                                <h5 class="fw-bold text-dark">${date.toLocaleDateString('en-GB', {day:'2-digit', month:'short'})}</h5>
                            </div>
                            <div class="col-3">
                                <p class="x-small text-muted text-uppercase mb-1 fw-bold">Gate</p>
                                <h5 class="fw-bold text-dark">A${Math.floor(Math.random()*20)+1}</h5>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pass-stub">
                        <div class="text-center">
                            <p class="x-small text-muted text-uppercase mb-1 fw-bold">Boarding</p>
                            <h2 class="fw-800 text-primary mb-4">${new Date(date.getTime() - 40*60000).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}</h2>
                            
                            <p class="x-small text-muted text-uppercase mb-1 fw-bold">Seat</p>
                            <h3 class="fw-800 text-dark">${b.seat_number || '14A'}</h3>
                        </div>
                        
                        <div class="barcode-area">
                            <div class="barcode mb-2"></div>
                            <p class="x-small text-center text-muted mb-0">${b.booking_reference}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}
</script>
@endpush
@endsection

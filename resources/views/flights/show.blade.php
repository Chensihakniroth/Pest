@extends('layouts.app')

@section('title', 'Configure Your Trip - SkyConnect')

@section('content')
<div class="container py-5">
    <div class="row g-5">
        <!-- LEFT: FLIGHT INFO & SEAT MAP -->
        <div class="col-lg-8">
            <div class="reveal mb-5">
                <h6 class="text-primary fw-bold text-uppercase small mb-2" style="letter-spacing: 2px;">Step 1 of 2</h6>
                <h1 class="display-5 fw-800 text-dark mb-4">Configure Your Trip</h1>
                
                <!-- Summary Card -->
                <div class="card border-0 p-4 mb-4" style="border-radius: 25px;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-center">
                                <h2 class="fw-800 mb-0">{{ $flight->originAirport->code }}</h2>
                                <p class="small text-secondary mb-0">{{ $flight->originAirport->city }}</p>
                                <p class="x-small text-muted mb-0">{{ \Carbon\Carbon::parse($flight->departure_time)->format('H:i, d M') }}</p>
                            </div>
                            <div class="col-md-4 text-center px-4">
                                <i class="fas fa-plane text-primary fa-2x opacity-25"></i>
                                <hr class="my-2">
                                <span class="badge bg-light text-dark border rounded-pill">{{ $flight->flight_number }}</span>
                            </div>
                            <div class="col-md-4 text-center">
                                <h2 class="fw-800 mb-0">{{ $flight->destinationAirport->code }}</h2>
                                <p class="small text-secondary mb-0">{{ $flight->destinationAirport->city }}</p>
                                <p class="x-small text-muted mb-0">{{ \Carbon\Carbon::parse($flight->arrival_time)->format('H:i, d M') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seat Selection Card -->
            @auth
            <div class="card border-0 p-4 reveal" style="border-radius: 30px;">
                <div class="card-body">
                    <h4 class="fw-800 text-dark mb-4"><i class="fas fa-chair me-2 text-primary"></i> Select Your Seat</h4>
                    
                    <div class="seat-map-wrapper bg-light rounded-4 p-5 mb-4 shadow-inner">
                        <div class="d-flex flex-column align-items-center">
                            <!-- Aircraft Nose -->
                            <div class="bg-white border mb-5 rounded-top-pill" style="width: 150px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <small class="text-muted fw-bold">COCKPIT</small>
                            </div>

                            @for($row = 1; $row <= 8; $row++)
                                <div class="d-flex mb-2 align-items-center">
                                    <div class="me-3 small text-muted fw-bold" style="width: 20px;">{{ $row }}</div>
                                    @foreach(['A', 'B', 'C', '', 'D', 'E', 'F'] as $col)
                                        @if($col === '')
                                            <div style="width: 40px;"></div>
                                        @else
                                            @php $seat = $row . $col; @endphp
                                            <div class="seat-btn text-center m-1 d-flex align-items-center justify-content-center rounded-3" 
                                                 data-seat="{{ $seat }}"
                                                 onclick="selectSeat(this)">
                                                {{ $col }}
                                            </div>
                                        @endif
                                    @endforeach
                                    <div class="ms-3 small text-muted fw-bold" style="width: 20px;">{{ $row }}</div>
                                </div>
                                @if($row == 2 || $row == 5) <div class="my-3 w-100 border-top border-2 border-white opacity-50"></div> @endif
                            @endfor
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-4 small text-secondary fw-bold">
                        <span><span class="seat-legend available"></span> Available</span>
                        <span><span class="seat-legend selected"></span> Selected</span>
                        <span><span class="seat-legend occupied"></span> Occupied</span>
                    </div>
                </div>
            </div>
            @endauth
        </div>

        <!-- RIGHT: PRICE & CHECKOUT -->
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 110px;">
                <div class="card border-0 p-4 shadow-lg reveal" style="border-radius: 30px;">
                    <div class="card-body">
                        <h4 class="fw-800 text-dark mb-4">Fare Breakdown</h4>
                        
                        <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
                            @csrf
                            <input type="hidden" name="flight_id" value="{{ $flight->id }}">
                            <input type="hidden" name="seat_number" id="selectedSeatInput">

                            <div class="mb-4">
                                <label class="small fw-bold text-secondary text-uppercase mb-2 d-block">Fare Class</label>
                                <select class="form-select border-0 bg-light rounded-4 py-3" id="fare_class" name="fare_class" required>
                                    <option value="economy" data-multiplier="1">Economy Class</option>
                                    <option value="business" data-multiplier="2">Business Class (+100%)</option>
                                    <option value="first" data-multiplier="3">First Class (+200%)</option>
                                </select>
                            </div>

                            <div class="py-3 border-top border-bottom mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary">Base Fare</span>
                                    <span class="fw-bold">${{ number_format($flight->price, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2" id="classPremiumRow" style="display: none !important;">
                                    <span class="text-secondary">Class Premium</span>
                                    <span class="fw-bold" id="classPremiumText">+$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <h5 class="fw-800 mb-0">Total Amount</h5>
                                    <h3 class="fw-800 text-primary mb-0" id="totalDisplay">${{ number_format($flight->price, 2) }}</h3>
                                </div>
                            </div>

                            <div id="selectedSeatSummary" class="alert alert-info border-0 rounded-4 text-center mb-4 py-2" style="display: none !important;">
                                <small class="fw-bold">RESERVED SEAT: <span id="summarySeatCode">--</span></small>
                            </div>

                            @auth
                                <button type="submit" id="finalBookBtn" class="btn btn-primary w-100 py-3 rounded-pill fw-800 shadow-lg mb-3" disabled>
                                    Confirm Reservation
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-dark w-100 py-3 rounded-pill fw-800">Login to Book</a>
                            @endauth
                            <p class="x-small text-center text-secondary mb-0">Secure checkout powered by SkyConnect</p>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('flights.index') }}" class="text-decoration-none small fw-bold text-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Change Selected Flight
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.seat-btn {
    width: 45px;
    height: 45px;
    background: white;
    border: 1.5px solid #e9ecef;
    cursor: pointer;
    font-size: 0.8rem;
    font-weight: 700;
    color: #adb5bd;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.seat-btn:hover {
    border-color: var(--sc-primary);
    color: var(--sc-primary);
    transform: scale(1.1);
}
.seat-btn.selected {
    background: var(--sc-primary);
    border-color: var(--sc-primary);
    color: white;
    box-shadow: 0 4px 12px rgba(0, 122, 255, 0.3);
}
.seat-legend {
    display: inline-block;
    width: 12px;
    height: 12px;
    border-radius: 3px;
    margin-right: 5px;
}
.seat-legend.available { background: white; border: 1px solid #dee2e6; }
.seat-legend.selected { background: var(--sc-primary); }
.seat-legend.occupied { background: #e9ecef; }

.shadow-inner {
    box-shadow: inset 0 2px 10px rgba(0,0,0,0.05);
}
</style>

<script>
function selectSeat(el) {
    document.querySelectorAll('.seat-btn').forEach(s => s.classList.remove('selected'));
    el.classList.add('selected');
    const seat = el.dataset.seat;
    
    document.getElementById('selectedSeatInput').value = seat;
    document.getElementById('summarySeatCode').textContent = seat;
    document.getElementById('selectedSeatSummary').style.display = 'block';
    document.getElementById('finalBookBtn').disabled = false;
}

document.addEventListener('DOMContentLoaded', function() {
    const classSelect = document.getElementById('fare_class');
    const basePrice = {{ $flight->price }};
    
    classSelect.addEventListener('change', function() {
        const mult = parseInt(this.options[this.selectedIndex].dataset.multiplier);
        const total = basePrice * mult;
        const premium = total - basePrice;
        
        document.getElementById('totalDisplay').textContent = '$' + total.toLocaleString(undefined, {minimumFractionDigits: 2});
        
        if(premium > 0) {
            document.getElementById('classPremiumRow').style.setProperty('display', 'flex', 'important');
            document.getElementById('classPremiumText').textContent = '+$' + premium.toLocaleString(undefined, {minimumFractionDigits: 2});
        } else {
            document.getElementById('classPremiumRow').style.setProperty('display', 'none', 'important');
        }
    });
});
</script>
@endsection
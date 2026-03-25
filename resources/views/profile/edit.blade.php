@extends('layouts.app')

@section('title', 'Account Settings - SkyConnect')

@section('content')
<div class="container py-5 px-lg-5">
    <div class="row justify-content-center reveal">
        <div class="col-lg-6">
            <h6 class="text-primary fw-bold text-uppercase small mb-2" style="letter-spacing: 3px;">Member Profile</h6>
            <h1 class="display-4 fw-800 text-dark mb-5" style="letter-spacing: -1.5px;">Account Settings</h1>

            <div class="mirror-card p-4 p-lg-5 rounded-5 shadow-lg border-0 bg-white bg-opacity-50" style="backdrop-filter: blur(20px);">
                <div class="text-center mb-5">
                    <div id="user-avatar" class="avatar-circle mx-auto mb-3 shadow-sm" style="width: 100px; height: 100px; background: var(--sc-primary); color: white; display: flex; align-items:center; justify-content:center; border-radius: 50%; font-size: 2.5rem; font-weight: bold;">?</div>
                    <h4 id="display-name" class="fw-800 text-dark mb-0">Loading Profile...</h4>
                    <p id="display-role" class="text-primary small fw-bold text-uppercase mb-0">SkyConnect Member</p>
                </div>

                <form id="profile-form">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase ms-2">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-0 rounded-start-pill ps-4"><i class="fas fa-user text-primary"></i></span>
                            <input type="text" id="input-name" class="form-control border-0 rounded-end-pill py-3 shadow-none fw-bold" placeholder="Your Name">
                        </div>
                    </div>
                    <div class="mb-5">
                        <label class="form-label small fw-bold text-secondary text-uppercase ms-2">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-0 rounded-start-pill ps-4"><i class="fas fa-envelope text-primary"></i></span>
                            <input type="email" id="input-email" class="form-control border-0 rounded-end-pill py-3 shadow-none fw-bold" placeholder="Your Email">
                        </div>
                    </div>
                    <button type="submit" id="save-btn" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm">SAVE CHANGES</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const NODE_API = 'http://localhost:3000';
let currentUserId = '{{ auth()->user()->id }}'; 

document.addEventListener('DOMContentLoaded', async () => {
    console.clear();
    console.log('%c ⚡ PROFILE SYNC INITIALIZED ', 'background: #1c1c1e; color: #007aff; font-weight: bold; padding: 5px; border-radius: 5px;');
    
    // Pre-fill the form with the authenticated user's data from Blade
    const user = {
        _id: currentUserId,
        name: '{{ auth()->user()->name }}',
        email: '{{ auth()->user()->email }}'
    };
    
    populateForm(user);
});

function populateForm(user) {
    document.getElementById('display-name').innerText = user.name;
    document.getElementById('user-avatar').innerText = user.name.charAt(0).toUpperCase();
    document.getElementById('input-name').value = user.name;
    document.getElementById('input-email').value = user.email;
}

async function apiCall(endpoint, method = 'GET', body = null) {
    const url = NODE_API + endpoint;
    const colors = { 'GET': '#34c759', 'POST': '#ff9500', 'PUT': '#ff3b30' };
    
    console.log(`%c ${method} %c → %c ${url}`, `background: #1c1c1e; color: ${colors[method]}; padding: 2px 6px; border-radius: 3px; font-weight: bold;`, '', 'color: #007aff;');

    const options = { method, headers: { 'Accept': 'application/json' } };
    if (window.API_TOKEN) options.headers['Authorization'] = 'Bearer ' + window.API_TOKEN;
    if (body) {
        options.headers['Content-Type'] = 'application/json';
        options.body = JSON.stringify(body);
    }

    const response = await fetch(url, options);
    
    // Handle non-JSON errors (like 404 HTML)
    const contentType = response.headers.get("content-type");
    if (contentType && contentType.indexOf("application/json") !== -1) {
        const data = await response.json();
        console.log(`%c ${response.status} %c RESPONSE:`, `background: #1c1c1e; color: #34c759; padding: 2px 6px; border-radius: 3px;`, '', data);
        return data;
    } else {
        const text = await response.text();
        console.error(`%c ${response.status} %c NON-JSON ERROR:`, `background: #ff3b30; color: white; padding: 2px 6px; border-radius: 3px;`, '', text);
        throw new Error('Server returned non-JSON response');
    }
}

document.getElementById('profile-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    if (!currentUserId) return alert('No user selected!');
    
    const saveBtn = document.getElementById('save-btn');
    saveBtn.disabled = true;
    saveBtn.innerText = 'SAVING...';

    const payload = {
        name: document.getElementById('input-name').value,
        email: document.getElementById('input-email').value
    };

    try {
        const data = await apiCall(`/api/users/${currentUserId}`, 'PUT', payload);
        if (data.success) {
            populateForm(data.user);
            alert('Profile saved to MongoDB! (✧ω✧)');
        }
    } catch (err) {
        alert('Update failed. See console.');
    } finally {
        saveBtn.disabled = false;
        saveBtn.innerText = 'SAVE CHANGES';
    }
});
</script>
@endpush
@endsection

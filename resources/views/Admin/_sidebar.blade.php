@php
    $active = $active ?? '';
    $verifCount = $verifCount ?? null;
@endphp

<aside class="w-64 bg-white hidden md:flex flex-col border-r border-red-100 z-10 flex-shrink-0 text-base">
    <div class="p-6">
        <h1 class="text-2xl font-bold text-red-500">SiToko</h1>
    </div>

    <nav class="flex-1 px-4 space-y-2">
        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Main Menu</p>

        <a href="{{ url('/dashboard-admin') }}" class="{{ $active === 'dashboard' ? 'flex items-center px-4 py-3 text-white bg-red-400 rounded-xl shadow-md transition-colors' : 'flex items-center px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-500 rounded-xl transition-colors' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>

        <a href="{{ url('/dashboard-admin/reports') }}" class="{{ $active === 'reports' ? 'flex items-center px-4 py-3 text-white bg-red-400 rounded-xl shadow-md transition-colors' : 'flex items-center px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-500 rounded-xl transition-colors' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Laporan Platform
        </a>

        <a href="{{ url('/dashboard-admin/seller-data') }}" class="{{ $active === 'penjual' ? 'flex items-center px-4 py-3 text-white bg-red-400 rounded-xl shadow-md transition-colors' : 'flex items-center px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-500 rounded-xl transition-colors' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            Data Penjual
        </a>

        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Management</p>

        <a href="{{ url('/dashboard-admin/verifikasi') }}" class="{{ $active === 'verifikasi' ? 'flex items-center px-4 py-3 text-white bg-red-400 rounded-xl shadow-md transition-colors' : 'flex items-center px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-500 rounded-xl transition-colors' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Verifikasi Penjual
            @if(!is_null($verifCount) && $verifCount > 0)
                <span class="ml-auto bg-white text-red-500 py-0.5 px-2 rounded-full text-xs font-bold">{{ $verifCount }}</span>
            @endif
        </a>
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        
        <a href="#"
            id="logoutButton"
            class="flex items-center px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-500 rounded-xl transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Logout
        </a>
        
    </nav>
</aside>

<!-- Logout Confirmation Modal -->
<div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Apakah Anda yakin ingin keluar?</h3>
                    {{-- <p class="text-sm text-gray-500 mt-1">Apakah Anda yakin ingin keluar?</p> --}}
                </div>
            </div>
        </div>

        {{-- <!-- Modal Body -->
        <div class="p-6">
            <p class="text-gray-600 text-sm">
                Anda akan keluar dari sistem dan perlu login kembali untuk mengakses dashboard admin.
            </p>
        </div> --}}

        <!-- Modal Footer -->
        <div class="p-6 bg-gray-50 rounded-b-2xl flex gap-3">
            <button 
                id="cancelLogout"
                type="button" 
                class="flex-1 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-colors">
                Batal
            </button>
            <button 
                id="confirmLogout"
                type="button" 
                class="flex-1 px-4 py-2.5 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition-colors">
                Ya, Keluar
            </button>
        </div>
    </div>
</div>

<script>
    // Get elements
    const logoutButton = document.getElementById('logoutButton');
    const logoutModal = document.getElementById('logoutModal');
    const cancelLogout = document.getElementById('cancelLogout');
    const confirmLogout = document.getElementById('confirmLogout');
    const logoutForm = document.getElementById('logout-form');

    // Show modal when logout button clicked
    logoutButton.addEventListener('click', function(e) {
        e.preventDefault();
        logoutModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    });

    // Hide modal when cancel button clicked
    cancelLogout.addEventListener('click', function() {
        logoutModal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Enable scrolling
    });

    // Hide modal when clicking outside
    logoutModal.addEventListener('click', function(e) {
        if (e.target === logoutModal) {
            logoutModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    });

    // Submit form when confirm button clicked
    confirmLogout.addEventListener('click', function() {
        logoutForm.submit();
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !logoutModal.classList.contains('hidden')) {
            logoutModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    });
</script>
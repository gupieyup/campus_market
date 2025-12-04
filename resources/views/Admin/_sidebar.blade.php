@php
    $active = $active ?? '';
    $verifCount = $verifCount ?? null;
@endphp

<aside class="w-64 bg-white hidden md:flex flex-col border-r border-red-100 z-10 flex-shrink-0">
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
            @if(!is_null($verifCount))
                <span class="ml-auto bg-white text-red-500 py-0.5 px-2 rounded-full text-xs font-bold">{{ $verifCount }}</span>
            @endif
        </a>
        
        <a href="{{ route('logout') }}"
            class="flex items-center px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-500 rounded-xl transition-colors"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Logout
        </a>
        
    </nav>
</aside>
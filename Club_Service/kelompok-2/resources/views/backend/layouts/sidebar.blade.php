<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('dashboard/assets/images/logoporlempika.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Porlempika</h4>
        </div>
    </div>

    <!--navigation-->
    <ul class="metismenu" id="menu">

        {{-- DASHBOARD --}}
        <li>
            <a href="{{ route('backend.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        {{-- ANGGOTA --}}
        @auth
            @php $canAccess = in_array(Auth::user()->role, ['admin', 'anggota', 'klub']); @endphp
            <li>
                <a href="{{ $canAccess ? route('backend.anggota.index') : '#' }}"
                    @if (!$canAccess) onclick="return false;" style="pointer-events: none; opacity: 0.5;" @endif>
                    <div class="parent-icon"><i class='bx bx-user'></i></div>
                    <div class="menu-title">Anggota</div>
                </a>
            </li>
        @endauth

        {{-- ATLET --}}
        @auth
            @php $canAccess = in_array(Auth::user()->role, ['admin', 'atlet', 'klub']); @endphp
            <li>
                <a href="{{ $canAccess ? route('backend.atlet.index') : '#' }}"
                    @if (!$canAccess) onclick="return false;" style="pointer-events: none; opacity: 0.5;" @endif>
                    <div class="parent-icon"><i class='bx bx-run'></i></div>
                    <div class="menu-title">Atlet</div>
                </a>
            </li>
        @endauth

        {{-- CLUB --}}
        @auth
            @php $canAccess = in_array(Auth::user()->role, ['admin', 'klub']); @endphp
            <li>
                <a href="{{ $canAccess ? route('backend.club.index') : '#' }}"
                    @if (!$canAccess) onclick="return false;" style="pointer-events: none; opacity: 0.5;" @endif>
                    <div class="parent-icon"><i class='bx bx-group'></i></div>
                    <div class="menu-title">Klub</div>
                </a>
            </li>
        @endauth

        {{-- GALLERY --}}
        @auth
            @php $canAccess = in_array(Auth::user()->role, ['admin', 'penyelenggara']); @endphp
            <li>
                <a href="{{ $canAccess ? route('backend.galeri.index') : '#' }}"
                    @if (!$canAccess) onclick="return false;" style="pointer-events: none; opacity: 0.5;" @endif>
                    <div class="parent-icon"><i class='bx bx-image'></i></div>
                    <div class="menu-title">Galeri</div>
                </a>
            </li>
        @endauth

        {{-- JURI --}}
        @auth
            @php $canAccess = in_array(Auth::user()->role, ['admin', 'juri']); @endphp
            <li>
                <a href="{{ $canAccess ? route('backend.juri.index') : '#' }}"
                    @if (!$canAccess) onclick="return false;" style="pointer-events: none; opacity: 0.5;" @endif>
                    <div class="parent-icon"><i class='bx bx-user-voice'></i></div>
                    <div class="menu-title">Juri</div>
                </a>
            </li>
        @endauth

        {{-- PENGUMUMAN --}}
        @auth
            @php $canAccess = Auth::user()->role === 'admin'; @endphp
            <li>
                <a href="{{ $canAccess ? route('backend.pengumuman.index') : '#' }}"
                    @if (!$canAccess) onclick="return false;" style="pointer-events: none; opacity: 0.5;" @endif>
                    <div class="parent-icon"><i class='bx bx-bell'></i></div>
                    <div class="menu-title">Pengumuman</div>
                </a>
            </li>
        @endauth

        {{-- PERTANDINGAN --}}
        @auth
            @php $canAccess = in_array(Auth::user()->role, ['admin', 'penyelenggara']); @endphp
            <li>
                <a href="{{ $canAccess ? route('backend.pertandingan.index') : '#' }}"
                    @if (!$canAccess) onclick="return false;" style="pointer-events: none; opacity: 0.5;" @endif>
                    <div class="parent-icon"><i class='bx bx-trophy'></i></div>
                    <div class="menu-title">Pertandingan</div>
                </a>
            </li>
        @endauth

        {{-- PENYELENGGARA --}}
        @auth
            <li>
                @php
                    $allowedRoles = ['admin', 'penyelenggara'];
                    $canAccess = in_array(Auth::user()->role, $allowedRoles);
                @endphp

                <a href="{{ $canAccess ? route('backend.penyelenggara_event.index') : '#' }}"
                    title="{{ $canAccess ? '' : 'Anda tidak memiliki akses' }}"
                    @if (!$canAccess) onclick="return false;" style="pointer-events: none; opacity: 0.5; cursor: not-allowed;" @endif>
                    <div class="parent-icon"><i class='bx bx-briefcase'></i></div>
                    <div class="menu-title">Penyelenggara Event</div>
                </a>
            </li>
        @endauth

        {{-- JADWAL PERTANDINGAN --}}
        @auth
            <li>
                @php
                    $allowedRoles = ['admin', 'penyelenggara'];
                    $canAccess = in_array(Auth::user()->role, $allowedRoles);
                @endphp

                <a href="{{ $canAccess ? route('backend.jadwal_pertandingan.index') : '#' }}"
                    title="{{ $canAccess ? '' : 'Anda tidak memiliki akses' }}"
                    @if (!$canAccess) onclick="return false;" style="pointer-events: none; opacity: 0.5; cursor: not-allowed;" @endif>
                    <div class="parent-icon"><i class='bx bx-calendar'></i></div>
                    <div class="menu-title">Jadwal Pertandingan</div>
                </a>
            </li>
        @endauth

        {{-- HASIL PERTANDINGAN --}}
        @auth
            <li>
                @php
                    $allowedRoles = ['juri'];
                    $canAccess = in_array(Auth::user()->role, $allowedRoles);
                @endphp

                <a href="{{ $canAccess ? route('backend.hasil_pertandingan.index') : '#' }}"
                    title="{{ $canAccess ? '' : 'Anda tidak memiliki akses' }}"
                    @if (!$canAccess) onclick="return false;" style="pointer-events: none; opacity: 0.5; cursor: not-allowed;" @endif>
                    <div class="parent-icon"><i class='bx bx-medal'></i></div>
                    <div class="menu-title">Hasil Pertandingan</div>
                </a>
            </li>
        @endauth

        {{-- KATEGORI PERTANDINGAN --}}
         @auth
            <li>
                @php
                    $allowedRoles = ['admin', 'penyelenggara'];
                    $canAccess = in_array(Auth::user()->role, $allowedRoles);
                @endphp

                <a href="{{ $canAccess ? route('backend.kategori_pertandingan.index') : '#' }}"
                    title="{{ $canAccess ? '' : 'Anda tidak memiliki akses' }}"
                    @if (!$canAccess) onclick="return false;" style="pointer-events: none; opacity: 0.5; cursor: not-allowed;" @endif>
                    <div class="parent-icon"><i class='bx bx-category'></i></div>
                    <div class="menu-title">Kategori Pertandingan</div>
                </a>
            </li>
        @endauth


        {{-- USERS --}}
        @auth
            @php $canAccess = Auth::user()->role === 'admin'; @endphp
            <li>
                <a href="{{ $canAccess ? route('backend.users.index') : '#' }}"
                    @if (!$canAccess) style="pointer-events: none; opacity: 0.5;" @endif>
                    <div class="parent-icon"><i class='bx bx-user-pin'></i></div>
                    <div class="menu-title">User</div>
                </a>
            </li>
        @endauth

        {{-- OUTPUT (DROPDOWN) --}}
        @auth
            @php $canAccess = Auth::user()->role === 'admin'; @endphp
            @if ($canAccess)
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-printer'></i></div>
                        <div class="menu-title">Output</div>
                    </a>
                    <ul>
                        <li><a href="{{ route('backend.output.anggota') }}"><i class="bx bx-id-card"></i> Cetak Anggota</a>
                        </li>
                        <li><a href="{{ route('backend.output.atlet') }}"><i class="bx bx-run"></i> Cetak Atlet</a></li>
                        <li><a href="{{ route('backend.output.hasilpertandingan') }}"><i class="bx bx-bar-chart-alt"></i>
                                Cetak Hasil Pertandingan</a></li>
                        <li><a href="{{ route('backend.output.club') }}"><i class="bx bx-building-house"></i> Cetak
                                Klub</a></li>
                        <li><a href="{{ route('backend.output.juri') }}"><i class="bx bx-user-voice"></i> Cetak Juri</a>
                        </li>
                        <li><a href="{{ route('backend.output.penyelenggara') }}"><i class="bx bx-briefcase"></i> Cetak
                                Penyelenggara</a></li>
                    </ul>
                </li>
            @endif
        @endauth

    



    </ul>
    <!--end navigation-->
</div>

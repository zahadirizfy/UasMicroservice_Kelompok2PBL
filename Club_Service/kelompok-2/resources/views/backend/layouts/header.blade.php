<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand gap-3">
            {{-- Tombol Hamburger --}}
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>

            {{-- Judul berjalan --}}
            <div class="search-bar flex-grow-1">
                <h3 id="typing-text"></h3>
            </div>

            {{-- Notifikasi --}}
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center gap-1">
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link position-relative" href="{{ route('backend.konfirmasi.index') }}">
                                    <span class="alert-count">
                                        {{ \App\Models\User::where('is_approved', false)->count() }}
                                    </span>
                                    <i class='bx bx-bell'></i>
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>

            {{-- Info User & Dropdown --}}
            @php
                $role = Auth::user()->role;
                $roleImages = [
                    'admin' => 'admin.png',
                    'penyelenggara' => 'penyelenggara.png',
                    'juri' => 'juri.png',
                    'atlet' => 'atlet.png',
                    'klub' => 'klub.png',
                    'anggota' => 'anggota.png',
                ];
                $image = $roleImages[$role] ?? 'logokel2.jpg';
            @endphp

            <div class="user-box dropdown px-3">
                <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret"
                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('dashboard/assets/images/' . $image) }}" class="user-img" alt="user">
                    <div class="user-info">
                        <p class="user-name mb-0">{{ Auth::user()->email }}</p>
                        <p class="designattion mb-0">{{ ucfirst($role) }}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    @if ($role === 'admin')
                        <li>
                            <h6 class="dropdown-header">Page Settings</h6>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('backend.hero.index') }}"><i
                                    class="bx bx-photo-album"></i> Hero Section</a></li>
                        <li><a class="dropdown-item" href="{{ route('backend.about.index') }}"><i
                                    class="bx bx-info-circle"></i> About Section</a></li>
                        <li><a class="dropdown-item" href="{{ route('backend.rule.index') }}"><i
                                    class="bx bx-list-check"></i> Rules Section</a></li>
                        <li><a class="dropdown-item" href="{{ route('backend.clientlogos.index') }}"><i
                                    class="bx bx-images"></i> Client Logos</a></li>
                        <li><a class="dropdown-item" href="{{ route('backend.organization.index') }}"><i
                                    class="bx bx-sitemap"></i> Structure Organization</a></li>
                        <li><a class="dropdown-item" href="{{ route('backend.testimonials.index') }}"><i
                                    class="bx bx-comment-detail"></i> Testimonials</a></li>
                        <li><a class="dropdown-item" href="{{ route('backend.contact.index') }}"><i
                                    class="bx bx-envelope"></i> Contact</a></li>
                        <li><a class="dropdown-item" href="{{ route('backend.portfolio.index') }}">
                                <i class="bx bx-briefcase"></i> Portfolio</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    @endif
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bx bx-log-out-circle"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>

{{-- Toggle sidebar --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleBtn = document.querySelector(".mobile-toggle-menu");
        const wrapper = document.querySelector(".wrapper");
        toggleBtn.addEventListener("click", () => wrapper.classList.toggle("toggled"));
    });
</script>

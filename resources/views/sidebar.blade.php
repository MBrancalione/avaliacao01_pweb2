<style>
    /* CSS próprio: não depende de recompilar o Tailwind */
    .bibi-nav {
        position: sticky; top: 0; z-index: 50;
        background: linear-gradient(90deg, #2a1670 0%, #4c32a8 55%, #6d4fd1 100%);
        box-shadow: 0 4px 16px rgba(42, 22, 112, .35);
    }

    /* Marca */
    .bibi-brand { display: inline-flex; align-items: center; gap: 10px; text-decoration: none; color: #fff; }
    .bibi-brand-icon {
        width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;
        background: rgba(255,255,255,.18); border: 1px solid rgba(255,255,255,.3);
    }
    .bibi-brand-text { font-weight: 800; font-size: 20px; letter-spacing: .12em; }

    /* Links desktop */
    .bibi-link {
        display: inline-flex; align-items: center; height: 100%; padding: 0 4px;
        font-size: 14px; font-weight: 600; letter-spacing: .03em; text-decoration: none;
        color: rgba(255,255,255,.72); border-bottom: 3px solid transparent;
        transition: color .2s ease, border-color .2s ease;
    }
    .bibi-link:hover { color: #fff; border-bottom-color: rgba(196,181,253,.7); }
    .bibi-link.is-active { color: #fff; border-bottom-color: #c4b5fd; }

    /* Botão do usuário */
    .bibi-user-btn {
        display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px;
        font-size: 14px; font-weight: 600; color: #fff; cursor: pointer;
        background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.28); border-radius: 999px;
        transition: background .2s ease;
    }
    .bibi-user-btn:hover { background: rgba(255,255,255,.26); }
    .bibi-avatar {
        width: 24px; height: 24px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
        background: #fff; color: #4c32a8; font-size: 12px; font-weight: 800; text-transform: uppercase;
    }

    /* Botão hambúrguer (mobile) */
    .bibi-burger {
        display: inline-flex; align-items: center; justify-content: center; padding: 8px; border-radius: 8px;
        color: #fff; background: rgba(255,255,255,.12); border: 0; cursor: pointer;
    }
    .bibi-burger:hover { background: rgba(255,255,255,.24); }

    /* Menu mobile */
    .bibi-mobile { background: #35208a; border-top: 1px solid rgba(255,255,255,.15); }
    .bibi-mlink {
        display: block; width: 100%; padding: 10px 16px; font-size: 16px; font-weight: 600; text-decoration: none;
        color: rgba(255,255,255,.8); border-left: 4px solid transparent;
    }
    .bibi-mlink:hover { background: rgba(255,255,255,.1); color: #fff; }
    .bibi-mlink.is-active { background: rgba(255,255,255,.16); color: #fff; border-left-color: #c4b5fd; }
    .bibi-muser { padding: 14px 16px 6px; border-top: 1px solid rgba(255,255,255,.15); }
    .bibi-muser-name { color: #fff; font-weight: 700; }
    .bibi-muser-mail { color: rgba(255,255,255,.65); font-size: 14px; }
</style>

<nav x-data="{ open: false }" class="bibi-nav">
    <!-- Menu Principal Horizontal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('filmeuser') }}" class="bibi-brand">
                        <span class="bibi-brand-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#ffffff"><path d="M8 5v14l11-7z"/></svg>
                        </span>
                        <span class="bibi-brand-text">BIBI TV</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('filmeuser') }}" class="bibi-link {{ request()->routeIs('filmeuser') ? 'is-active' : '' }}">
                        {{ __('Catálogo') }}
                    </a>

                    <a href="{{ url('avaliacao') }}" class="bibi-link {{ request()->is('avaliacao') ? 'is-active' : '' }}">
                        {{ __('Avaliação') }}
                    </a>
                    <a href="{{ route('chamado.listchamado') }}" class="bibi-link {{ request()->routeIs('chamado.*') ? 'is-active' : '' }}">
    {{ __('Chamados') }}
</a>
{{-- CORREÇÃO: as telas de chamado usam este menu também para o admin, que precisa de um caminho de volta ao painel --}}
@if(Auth::user()->is_admin)
    <a href="{{ route('dashboard') }}" class="bibi-link">{{ __('Painel') }}</a>
@endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="bibi-user-btn">
                            <span class="bibi-avatar">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
                            <div>{{ Auth::user()->name }}</div>
                            <div>
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('usuario.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="bibi-burger">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bibi-mobile">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('filmeuser') }}" class="bibi-mlink {{ request()->routeIs('filmeuser') ? 'is-active' : '' }}">
                {{ __('Filmes') }}
            </a>
            <a href="{{ url('avaliacao') }}" class="bibi-mlink {{ request()->is('avaliacao*') ? 'is-active' : '' }}">
                {{ __('Avaliação') }}
            </a>
        </div>

        <div class="bibi-muser">
            <div class="bibi-muser-name">{{ Auth::user()->name }}</div>
            <div class="bibi-muser-mail">{{ Auth::user()->email }}</div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('usuario.edit')" style="color: #fff;">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" style="color: #fff;" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

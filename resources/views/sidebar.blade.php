<style>
    .bibi-nav {
        position: sticky;
        top: 0;
        z-index: 50;
        background-color: #24145c;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .bibi-brand {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: #ffffff;
    }

    .bibi-brand-icon {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.1);
    }

    .bibi-brand-text {
        font-weight: 700;
        font-size: 18px;
        letter-spacing: .05em;
    }

    .bibi-link {
        display: inline-flex;
        align-items: center;
        height: 100%;
        padding: 0 4px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        color: rgba(255, 255, 255, 0.7);
        border-bottom: 2px solid transparent;
        transition: color .15s ease, border-color .15s ease;
    }

    .bibi-link:hover {
        color: #ffffff;
    }

    .bibi-link.is-active {
        color: #ffffff;
        border-bottom-color: #a78bfa;
    }

    .bibi-user-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        font-size: 14px;
        font-weight: 500;
        color: #ffffff;
        cursor: pointer;
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 6px;
        transition: background-color .15s ease;
    }

    .bibi-user-btn:hover {
        background: rgba(255, 255, 255, 0.08);
    }

    .bibi-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #a78bfa;
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .bibi-burger {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px;
        border-radius: 6px;
        color: rgba(255, 255, 255, 0.8);
        background: transparent;
        border: 0;
        cursor: pointer;
        transition: background-color .15s ease, color .15s ease;
    }

    .bibi-burger:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff;
    }

    .bibi-mobile {
        background: #1e114d;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .bibi-mlink {
        display: block;
        width: 100%;
        padding: 10px 16px;
        font-size: 15px;
        font-weight: 500;
        text-decoration: none;
        color: rgba(255, 255, 255, 0.7);
        border-left: 3px solid transparent;
        transition: background-color .15s ease, color .15s ease;
    }

    .bibi-mlink:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #ffffff;
    }

    .bibi-mlink.is-active {
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff;
        border-left-color: #a78bfa;
    }

    .bibi-muser {
        padding: 12px 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .bibi-muser-name {
        color: #ffffff;
        font-weight: 600;
        font-size: 14px;
    }

    .bibi-muser-mail {
        color: rgba(255, 255, 255, 0.6);
        font-size: 13px;
    }
</style>

<nav x-data="{ open: false }" class="bibi-nav">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('filmeuser') }}" class="bibi-brand">
                        <span class="bibi-brand-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#ffffff">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </span>
                        <span class="bibi-brand-text">BIBI TV</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('filmeuser') }}"
                        class="bibi-link {{ request()->routeIs('filmeuser') ? 'is-active' : '' }}">
                        {{ __('Catálogo') }}
                    </a>

                    <a href="{{ url('avaliacao') }}"
                        class="bibi-link {{ request()->is('avaliacao') ? 'is-active' : '' }}">
                        {{ __('Avaliação') }}
                    </a>
                    <a href="{{ route('chamado.listchamado') }}"
                        class="bibi-link {{ request()->routeIs('chamado.*') ? 'is-active' : '' }}">
                        {{ __('Chamados') }}
                    </a>
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
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
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
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="bibi-burger">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bibi-mobile">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('filmeuser') }}"
                class="bibi-mlink {{ request()->routeIs('filmeuser') ? 'is-active' : '' }}">
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
                    <x-responsive-nav-link :href="route('logout')" style="color: #fff;"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
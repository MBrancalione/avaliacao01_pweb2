<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="shrink-0 flex items-center">
                <a href="{{ route('main') }}" class="font-bold text-xl" style="color: #4c32a8; letter-spacing: .05em; text-decoration: none;">
                    BIBI TV
                </a>
            </div>
            <h2 class="font-semibold text-xl leading-tight" style="color: #4c32a8;">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <style>
        /* CSS Simplificado e estático */
        .cat-wrap   { width: 100%; max-width: 1100px; margin: 0 auto; }
        .cat-pad    { padding-left: 16px; padding-right: 16px; }
        @media (min-width: 640px) { .cat-pad { padding-left: 24px; padding-right: 24px; } }

        /* Banner de boas-vindas */
        .dash-hero {
            position: relative; border-radius: 8px; padding: 24px;
            background: #24145c;
            border: 1px solid rgba(255,255,255,.1);
            display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px;
        }
        .dash-hero h3 { color: #fff; font-size: 22px; font-weight: 700; margin: 0 0 4px; }
        .dash-hero p  { color: rgba(255,255,255,.7); font-size: 14px; margin: 0; }
        .dash-badge {
            display: inline-flex; align-items: center; gap: 8px; padding: 4px 12px; border-radius: 6px;
            background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2);
            color: #fff; font-size: 12px; font-weight: 600;
        }
        .dash-dot { width: 8px; height: 8px; border-radius: 50%; background: #4ade80; }

        /* Títulos de seção */
        .dash-section { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #6b7280; margin: 0 0 12px 2px; }

        /* Cards de estatística */
        .dash-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; }
        .dash-stat {
            display: flex; align-items: center; justify-content: space-between; gap: 12px;
            background: #fff; border-radius: 8px; padding: 20px; border: 1px solid #e5e7eb; border-top: 3px solid var(--c);
        }
        .dash-label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; color: #6b7280; margin: 0; }
        .dash-number { font-size: 28px; font-weight: 700; line-height: 1.1; color: #1f2937; margin: 4px 0 0; }
        .dash-icon {
            width: 44px; height: 44px; border-radius: 8px; display: flex; align-items: center; justify-content: center;
            background: var(--bg); color: var(--c); flex-shrink: 0;
        }
        .dash-icon svg, .dash-link-icon svg { width: 22px; height: 22px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* Acesso rápido */
        .dash-links { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; }
        .dash-link {
            display: flex; align-items: center; gap: 14px; background: #fff; border-radius: 8px; padding: 16px 18px;
            text-decoration: none; border: 1px solid #e5e7eb;
        }
        .dash-link:hover { border-color: #4c32a8; }
        .dash-link-icon {
            width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center;
            background: #ede9f9; color: #4c32a8; flex-shrink: 0;
        }
        .dash-link-title { font-size: 15px; font-weight: 600; color: #4c32a8; margin: 0; }
        .dash-link-desc  { font-size: 12px; color: #6b7280; margin: 2px 0 0; }
        .dash-arrow { margin-left: auto; color: #9ca3af; }
        .dash-arrow svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    </style>

    <div class="py-12">
        <div class="cat-wrap cat-pad space-y-6">

            <!-- Banner de boas-vindas -->
            <div class="dash-hero">
                <div>
                    <h3>Olá, {{ Auth::user()->name }}! 👋</h3>
                    <p>Bem-vindo ao painel de administração da sua plataforma.</p>
                </div>
                <span class="dash-badge"><span class="dash-dot"></span>Painel Ativo</span>
            </div>

            <!-- Estatísticas -->
            <div>
                <p class="dash-section">Visão geral</p>
                <div class="dash-stats">

                    <div class="dash-stat" style="--c: #4c32a8; --bg: #ede9f9;">
                        <div>
                            <p class="dash-label">Total no Catálogo</p>
                            <p class="dash-number">10</p>
                        </div>
                        <div class="dash-icon">
                            <svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="18" rx="2"/><path d="M7 3v18"/><path d="M17 3v18"/><path d="M2 8h5"/><path d="M2 16h5"/><path d="M17 8h5"/><path d="M17 16h5"/></svg>
                        </div>
                    </div>

                    <div class="dash-stat" style="--c: #16a34a; --bg: #dcfce7;">
                        <div>
                            <p class="dash-label">Planos Ativos</p>
                            <p class="dash-number">3</p>
                        </div>
                        <div class="dash-icon">
                            <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                        </div>
                    </div>

                    <div class="dash-stat" style="--c: #4f46e5; --bg: #e0e7ff;">
                        <div>
                            <p class="dash-label">Usuários</p>
                            <p class="dash-number">5</p>
                        </div>
                        <div class="dash-icon">
                            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                    </div>

                    <div class="dash-stat" style="--c: #d97706; --bg: #fef3c7;">
                        <div>
                            <p class="dash-label">Avaliações</p>
                            <p class="dash-number">5</p>
                        </div>
                        <div class="dash-icon">
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01z"/></svg>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Acesso rápido -->
            <div>
                <p class="dash-section">Acesso rápido</p>
                <div class="dash-links">

                    <a href="{{ route('filmeadmin') }}" class="dash-link">
                        <span class="dash-link-icon">
                            <svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="18" rx="2"/><path d="M7 3v18"/><path d="M17 3v18"/></svg>
                        </span>
                        <span>
                            <p class="dash-link-title">Catálogo</p>
                            <p class="dash-link-desc">Gerenciar filmes</p>
                        </span>
                        <span class="dash-arrow"><svg viewBox="0 0 24 24"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg></span>
                    </a>

                    <a href="{{ route('planos') }}" class="dash-link">
                        <span class="dash-link-icon">
                            <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                        </span>
                        <span>
                            <p class="dash-link-title">Planos</p>
                            <p class="dash-link-desc">Preços e limites</p>
                        </span>
                        <span class="dash-arrow"><svg viewBox="0 0 24 24"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg></span>
                    </a>

                    <a href="{{ route('users.list') }}" class="dash-link">
                        <span class="dash-link-icon">
                            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        </span>
                        <span>
                            <p class="dash-link-title">Usuários</p>
                            <p class="dash-link-desc">Contas e assinaturas</p>
                        </span>
                        <span class="dash-arrow"><svg viewBox="0 0 24 24"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg></span>
                    </a>

                    <a href="{{ route('chamado.listchamado') }}" class="dash-link">
                        <span class="dash-link-icon">
                            <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        </span>
                        <span>
                            <p class="dash-link-title">Chamados</p>
                            <p class="dash-link-desc">Suporte aos usuários</p>
                        </span>
                        <span class="dash-arrow"><svg viewBox="0 0 24 24"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg></span>
                    </a>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
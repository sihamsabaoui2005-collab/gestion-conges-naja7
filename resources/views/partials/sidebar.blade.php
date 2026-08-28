<aside class="sidebar">
  <div class="side-logo">
    <img src="{{ asset('images/logo-naja7host.png') }}" alt="NAJA7HOST">
  </div>

  @if (auth()->user()->role === 'rh')
    <nav class="side-nav">
      <a href="{{ route('dashboard') }}" class="side-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i data-lucide="home" style="width:17px;height:17px;"></i><span class="tip">Tableau de bord</span>
      </a>
      <a href="{{ route('conges.apercu') }}" class="side-link {{ request()->routeIs('conges.apercu') ? 'active' : '' }}">
        <i data-lucide="calendar-heart" style="width:17px;height:17px;"></i><span class="tip">Congés & Absences</span>
      </a>
      <a href="{{ route('conges.index') }}" class="side-link {{ request()->routeIs('conges.index') || request()->routeIs('conges.show') ? 'active' : '' }}">
        <i data-lucide="file-text" style="width:17px;height:17px;"></i><span class="tip">Demandes @if(($demandesEnAttente ?? 0) > 0)({{ $demandesEnAttente }})@endif</span>
      </a>
      <a href="{{ route('employes.index') }}" class="side-link {{ request()->routeIs('employes.*') ? 'active' : '' }}">
        <i data-lucide="users" style="width:17px;height:17px;"></i><span class="tip">Employés</span>
      </a>
      <a href="{{ route('calendrier.index') }}" class="side-link {{ request()->routeIs('calendrier.index') ? 'active' : '' }}">
        <i data-lucide="calendar-days" style="width:17px;height:17px;"></i><span class="tip">Calendrier équipe</span>
      </a>
      <a href="{{ route('conges.index') }}" class="side-link">
        <i data-lucide="check-square" style="width:17px;height:17px;"></i><span class="tip">Validation @if(($demandesEnAttente ?? 0) > 0)({{ $demandesEnAttente }})@endif</span>
      </a>
      <a href="{{ route('rapports.index') }}" class="side-link {{ request()->routeIs('rapports.*') ? 'active' : '' }}">
        <i data-lucide="file-bar-chart" style="width:17px;height:17px;"></i><span class="tip">Rapports</span>
      </a>
      <a href="{{ route('statistiques.index') }}" class="side-link {{ request()->routeIs('statistiques.index') ? 'active' : '' }}">
        <i data-lucide="bar-chart-3" style="width:17px;height:17px;"></i><span class="tip">Statistiques</span>
      </a>
      <a href="{{ route('profile.edit') }}" class="side-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
        <i data-lucide="user" style="width:17px;height:17px;"></i><span class="tip">Mon profil</span>
      </a>
      <a href="{{ route('settings.index') }}" class="side-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
        <i data-lucide="settings" style="width:17px;height:17px;"></i><span class="tip">Paramètres & Support</span>
      </a>
    </nav>

    <div class="side-bottom">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="side-link"><i data-lucide="log-out" style="width:16px;height:16px;"></i><span class="tip">Déconnexion</span></button>
      </form>
    </div>
  @else
    <nav class="side-nav">
      <a href="{{ route('dashboard') }}" class="side-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i data-lucide="layout-dashboard" style="width:17px;height:17px;"></i><span class="tip">Tableau de bord</span>
      </a>
      <a href="{{ route('conges.create') }}" class="side-link {{ request()->routeIs('conges.create') ? 'active' : '' }}">
        <i data-lucide="plus-circle" style="width:17px;height:17px;"></i><span class="tip">Nouvelle demande</span>
      </a>
      <a href="{{ route('calendrier.index') }}" class="side-link {{ request()->routeIs('calendrier.index') ? 'active' : '' }}">
        <i data-lucide="calendar-days" style="width:17px;height:17px;"></i><span class="tip">Calendrier</span>
      </a>
      <a href="{{ route('conges.solde') }}" class="side-link {{ request()->routeIs('conges.solde') ? 'active' : '' }}">
        <i data-lucide="wallet" style="width:17px;height:17px;"></i><span class="tip">Mon solde</span>
      </a>
      <a href="{{ route('conges.mesDemandes') }}" class="side-link {{ request()->routeIs('conges.mesDemandes') ? 'active' : '' }}">
        <i data-lucide="file-text" style="width:17px;height:17px;"></i><span class="tip">Mes demandes</span>
      </a>
      <a href="{{ route('conges.historique') }}" class="side-link {{ request()->routeIs('conges.historique') ? 'active' : '' }}">
        <i data-lucide="history" style="width:17px;height:17px;"></i><span class="tip">Historique</span>
      </a>
      <a href="{{ route('profile.edit') }}" class="side-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
        <i data-lucide="user" style="width:17px;height:17px;"></i><span class="tip">Mon profil</span>
      </a>
      <a href="{{ route('settings.index') }}" class="side-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
        <i data-lucide="settings" style="width:17px;height:17px;"></i><span class="tip">Paramètres & Support</span>
      </a>
    </nav>

    <div class="side-bottom">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="side-link"><i data-lucide="log-out" style="width:16px;height:16px;"></i><span class="tip">Déconnexion</span></button>
      </form>
    </div>
  @endif
</aside>
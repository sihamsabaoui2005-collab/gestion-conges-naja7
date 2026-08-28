<button class="icon-btn" id="notifBtn">
  <i data-lucide="bell" style="width:16px;height:16px;"></i>
  @if (auth()->user()->unreadNotifications->count() > 0)
    <span class="dot">{{ auth()->user()->unreadNotifications->count() }}</span>
  @endif
</button>
<div class="notif-panel" id="notifPanel">
  <h4>Notifications</h4>
  @forelse (auth()->user()->unreadNotifications as $notification)
    @php
      $couleursNotif = ['green' => 'var(--green)', 'red' => 'var(--red)', 'blue' => 'var(--blue-2)'];
      $cNotif = $couleursNotif[$notification->data['couleur'] ?? 'blue'] ?? 'var(--blue-2)';
    @endphp
    <a href="{{ route('notifications.ouvrir', $notification->id) }}" class="notif-item" style="cursor:pointer;">
      <span class="n-ico" style="background:rgba(59,130,246,.15); color:{{ $cNotif }};">
        <i data-lucide="{{ $notification->data['icone'] ?? 'bell' }}" style="width:14px;height:14px;"></i>
      </span>
      <div>
        <b style="display:block;">{{ $notification->data['titre'] ?? '' }}</b>
        <span style="font-size:11px; color:var(--text-dim); display:block;">{{ $notification->data['message'] ?? '' }}</span>
      </div>
    </a>
  @empty
    <div class="notif-empty">Aucune notification récente.</div>
  @endforelse
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const notifBtn = document.getElementById('notifBtn');
  const notifPanel = document.getElementById('notifPanel');

  if (notifBtn && notifPanel) {
    notifBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      notifPanel.classList.toggle('active');
    });

    document.addEventListener('click', function (e) {
      if (!notifPanel.contains(e.target) && !notifBtn.contains(e.target)) {
        notifPanel.classList.remove('active');
      }
    });
  }

  if (typeof lucide !== 'undefined') {
    lucide.createIcons();
  }
});
</script>
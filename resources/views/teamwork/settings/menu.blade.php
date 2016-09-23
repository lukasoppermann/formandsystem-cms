<header class="o-section-header c-settings-header">
    <span class="c-settings-header__title-label">Settings</span>
    <h4 class="o-headline--second o-headline--light c-settings-header__title">{{auth()->user()->currentTeam->name}}</h4>
    <div class="c-settings-menu">
        {{ $settings_menu }}
    </div>
</header>

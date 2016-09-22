<button class="o-media o-media--reverse o-media--center o-menu__link c-menu__link--profile" {{$attr or ''}}>
    @include('users.image', ['class' => 'c-user-image--small c-user-image--space-left o-media__figure'])
    <span class="o-media__body c-user-name">
        {{$label or ''}}
    </span>
</button>

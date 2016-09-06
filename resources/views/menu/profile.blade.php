<button class="o-media o-media--reverse o-media--center o-menu__link c-menu__link--profile" {{$item->get('attr')}}>
    @include('users.image', ['class' => 'c-user-image--small c-user-image--space-left o-media__figure'])
    <span class="o-media__body">
        {{$item->get('label')}}
    </span>
</button>

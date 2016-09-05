<a class="o-media o-media--reverse o-media--center o-menu__link c-menu__link--profile" {{$item->get('attr')}} href="{{$item->get('prefix').$item->get('link')}}">
    @include('users.image', ['class' => 'c-user-image--small c-user-image--space-left o-media__figure'])
    <span class="o-media__body">
        {{$item->get('label')}}
    </span>
</a>

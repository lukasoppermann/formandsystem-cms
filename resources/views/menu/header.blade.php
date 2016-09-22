<header class="o-menu__header o-media o-media--center">
    <div class="o-media__figure o-menu__header-icon">
        @if(!isset($link) || $link === NULL)
            {{ svg_icon('formandsystem')->viewbox("0 0 512 512") }}
        @else
            <a href="{{$link}}" class="o-link">
                {{ svg_icon('arrow-back')->viewbox("0 0 512 512") }}
            </a>
        @endif
    </div>
    <div class="o-media__body">
        <div class="o-media o-media--reverse o-media--center">
            <div class="o-media__body">
                <h1 class="o-menu__title">{{$title}}</h1>
                <span class="o-menu__subtitle">/ {{$subtitle or ''}}</span>
            </div>
            @if(isset($link_right))
                <div class="o-media__figure o-menu__header-icon">
                    <a href="{{$link_right}}" class="o-link">
                        {{ svg_icon($icon_right)->viewbox("0 0 512 512") }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</header>

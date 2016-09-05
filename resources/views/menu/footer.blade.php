<div class="o-flexbar__item o-flexbar__item--bottom">
    <form action="/settings/developers/bust-cache" method="post" class="o-sidebar__footer o-flexbar o-flexbar--vertical">
        {{ csrf_field() }}
        {{ method_field('POST') }}
        <button type="submit" class="o-menu__item">
            <div class="o-menu__link">Refresh cache</div>
        </button>
    </form>
</div>

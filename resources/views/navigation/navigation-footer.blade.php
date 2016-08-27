<div class="c-navigation__footer">
    <form action="/settings/developers/bust-cache" method="post">
        {{ csrf_field() }}
        {{ method_field('POST') }}
        <button type="submit" class="c-navigation__item">
            <div class="c-navigation__link">Refresh cache</div>
        </button>
    </form>
</div>

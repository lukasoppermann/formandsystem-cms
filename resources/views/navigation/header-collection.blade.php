<header class="c-navigation__header">

    <div class="c-navigation__icon">
        <a href="/" class="o-link o-link--full">
            <svg viewBox="0 0 512 512" class="o-icon">
              <use xlink:href="#svg-icon--arrow-back"></use>
            </svg>
        </a>
    </div>

    <div class="c-navigation__icon c-navigation__icon--right c-navigation__icon--light" data-dialog-link="/dialog/editCollection?id={{$item['id']}}">
        <svg viewBox="0 0 512 512" class="o-icon">
          <use xlink:href="#svg-icon--edit"></use>
        </svg>
    </div>

    <h1 class="c-navigation__title">{{$item->get('name')}}</h1>
</header>

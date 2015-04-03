<section class="o-section editor-section js-editor-section" data-class="" data-link="">
  <div class="o-section__drag-handle editor-section-dragHandler js-editor-section-dragHandler">
    <svg viewBox="0 0 512 512" class="o-icon o-icon--centered o-icon--medium-light-gray">
      <use xlink:href="#icon-drag"></use>
    </svg>
  </div>
  <div class="grid editor-inner-section o-section__body">

    @unless( !isset($section['columns']) )

      @foreach ($section['columns'] as $column)

        @include('partials/column', ['column' => $column])

      @endforeach

    @endunless

  </div>

  <div class="o-settings">
    <div class="o-settings__toggle" data-toggle-target="section-settings-{{$pos}}">JSSSSSSSSSS</div>
    <div class="o-settings__content o-box--pad-h-md o-box--pad-v-sm" data-toggle="section-settings-{{$pos}}">
      <div class="o-button--confirm o-button o-button--outlined o-button--warning" data-toggle="section-delete-{{$pos}}">
        <div class="o-button--confirm__content" data-toggle-target="section-delete-{{$pos}}">Delete</div>
        <div class="o-button--confirm__confirmation o-button--bar">
          <div class="o-button--bar__item">
            <svg viewBox="0 0 512 512" class="o-icon o-icon--gray">
              <use xlink:href="#icon-arrow-left"></use>
            </svg>
          </div>
          <div class="o-button--bar__item">
            <svg viewBox="0 0 512 512" class="o-icon o-icon--gray">
              <use xlink:href="#icon-trash"></use>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>

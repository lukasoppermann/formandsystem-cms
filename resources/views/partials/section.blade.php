<section class="o-section editor-section js-editor-section" data-class="" data-link="">
  <div class="o-section__drag-handle editor-section-dragHandler js-editor-section-dragHandler">
    <svg viewBox="0 0 512 512" class="o-icon--centered o-icon--medium-light-gray">
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
    <div class="o-settings__content" data-toggle="section-settings-{{$pos}}">
      Settings
    </div>
  </div>

</section>

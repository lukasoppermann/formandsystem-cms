<section class="editor-section js-editor-section" data-class="demo-class" data-link="demo-link">
  <div class="editor-section-dragHandler js-editor-section-dragHandler">
    <svg viewBox="0 0 512 512" class="icon-drag">
      <use xlink:href="#icon-drag"></use>
    </svg>
  </div>
  <div class="grid editor-inner-section">

    @unless( !isset($section['columns']) )

      @foreach ($section['columns'] as $column)

        @include('partials/column', ['column' => $column])

      @endforeach

    @endunless

  </div>
</section>

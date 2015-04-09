<section class="o-section editor-section js-editor-section" data-pos="{{$pos}}">
  <div class="o-section__drag-handle editor-section-dragHandler js-editor-section-dragHandler">
    <svg viewBox="0 0 512 512" class="o-icon o-icon--centered o-icon--medium-light-gray">
      <use xlink:href="#icon-drag"></use>
    </svg>
  </div>
  <div class="grid editor-inner-section o-section__body">
    <!-- gulp-remove:start -->
    @unless( !isset($section['columns']) )

      @foreach ($section['columns'] as $column)

        @include('partials/column', ['column' => $column])

      @endforeach

    @endunless
    <!-- gulp-remove:end -->
  </div>

  <div class="o-settings">
    <div class="o-settings__toggle" data-click="toggle-settings">JSSSSSSSSSS</div>
    <div class="o-settings__content o-box--pad-h-md o-box--pad-v-sm o-grid o-togglable" data-js="settings-content">

      <div class="o-grid__column o-grid__column--md-3">
        <label class="o-input">
          <span class="o-input__label">additional classes</span>
          <input data-js="additional-classes" class="o-input__field" type="text" value="{{$section['class']}}" placeholder="class, second-class" />
        </label>
      </div>

      <div class="o-grid__column o-grid__column--md-3">
        <label class="o-input">
          <span class="o-input__label">section link</span>
          <input data-js="section-link" class="o-input__field" type="text" value="{{$section['link']}}" placeholder="link label" />
        </label>
      </div>
      <!-- Delete Button -->
      <div class="o-grid__column o-grid__column--md-1 o-grid__offset--md-5 o-grid__column--right">
        <div class="o-button--confirm o-button o-button--outlined o-button--warning o-button--right">
          <div class="o-button--confirm__content o-hideable is-toggled" data-click="button-confirm" data-js="confirm-first-state">Delete</div>
          <div class="o-button--confirm__confirmation o-button--bar o-hideable" data-js="confirm-second-state">
            <div class="o-button o-button--light-gray" data-click="button-confirm-cancel">
              <svg viewBox="0 0 512 512" class="o-icon o-icon--gray">
                <use xlink:href="#icon-arrow-left"></use>
              </svg>
            </div>
            <div class="o-button o-button--warning" data-click="button-confirm-confirm" data-event-variable='{"action":"delete-section", "pos":{{$pos}}}'>
              <svg viewBox="0 0 512 512" class="o-icon o-icon--white">
                <use xlink:href="#icon-trash"></use>
              </svg>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>

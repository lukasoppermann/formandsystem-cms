{!! Form::open( ) !!}
<div class="content-wrapper">
  <div class="page-settings">
    <svg viewBox="0 0 512 512" class="icon-settings">
      <use xlink:href="#icon-settings"></use>
    </svg>
  </div>
  <div class="options">
    {!! Form::button('Save', array('class'=>'button blue save'))!!}
  </div>
  <div class="page-content">

    <section class="block-content content-section grid" data-class="section-class">
      <div class="settings">
        <svg viewBox="0 0 512 512" class="icon-settings">
          <use xlink:href="#icon-settings"></use>
        </svg>
      </div>
      <div class="section-drag-handle"></div>


      <div class="block resizable column-6of12" data-column="6" data-type="block" data-class="class">
        <div class="settings">
          <svg viewBox="0 0 512 512" class="icon-settings">
            <use xlink:href="#icon-settings"></use>
          </svg>
        </div>
        <div class="drag-handle"></div>

        <textarea class="mark block-content" name="text">Copy Text</textarea>

        <div class="handle"></div>
      </div>

    </section>

    <section class="content-section" id="add_section">
      <div class="add-content">
        <span class="text add-block" data-type="text">+</span>
      </div>
    </section>
  </div>

</div>

{!! Form::close() !!}

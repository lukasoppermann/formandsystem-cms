
<div class="o-dialog o-dialog--absolute is-hidden" data-target="fragment-new-{{$fragment_id}}">
    <div class="o-dialog__box c-fragment-settings-dialog">
        <div class="o-dialog__body o-grid">

            @include('fragments.new-fragment', [
                'classes' => 'o-grid__column o-grid__column--md-6of12',
                'label' => 'Text',
                'related' => 'fragment',
                'related_id' => $fragment_id,
                'type' => 'text',
                'button_classes' => 'c-fragment-new__selection',
            ])

            @include('fragments.new-fragment', [
                'classes' => 'o-grid__column o-grid__column--md-6of12',
                'label' => 'Image',
                'related' => 'fragment',
                'related_id' => $fragment_id,
                'type' => 'image',
                'button_classes' => 'c-fragment-new__selection',
            ])

            @include('fragments.new-fragment', [
                'classes' => 'o-grid__column o-grid__column--md-6of12',
                'label' => 'Collection',
                'related' => 'fragment',
                'related_id' => $fragment_id,
                'type' => 'collection',
                'button_classes' => 'c-fragment-new__selection',
            ])

            @include('fragments.new-fragment', [
                'classes' => 'o-grid__column o-grid__column--md-6of12',
                'label' => 'Section',
                'related' => 'fragment',
                'related_id' => $fragment_id,
                'type' => 'section',
                'button_classes' => 'c-fragment-new__selection',
            ])

        </div>
    </div>
    <div class="o-dialog__bg" data-toggle-dialog="fragment-new-{{$fragment_id}}"></div>
</div>

<div class="o-fragment c-fragment-new c-fragment-new-section o-grid__column o-grid__column--md-{{config('user.grid-md')}}of{{config('user.grid-md')}}" data-toggle-dialog="fragment-new-{{$fragment_id}}">
    Create a new fragment
</div>

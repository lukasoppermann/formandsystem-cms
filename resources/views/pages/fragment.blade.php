<?php
    $md_col = config('user.grid-md');
    for($i = 1; $i <= $md_col; $i++){
        $grid_md_columns[$i] = $i.' of '.$md_col;
    }
    $sm_col = config('user.grid-sm');
    for($i = 1; $i <= $sm_col; $i++){
        $grid_sm_columns[$i] = $i.' of '.$sm_col;
    }
    $lg_col = config('user.grid-lg');
    for($i = 1; $i <= $lg_col; $i++){
        $grid_lg_columns[$i] = $i.' of '.$lg_col;
    }
    $dialog_is_hidden = "";
    if(!isset($errors) || $errors->{$fragment->id}->isEmpty()){
        $dialog_is_hidden = ' is-hidden';
    }
?>

<div class="o-dialog o-dialog--absolute {{$dialog_is_hidden}}" data-target="fragment-settings-{{$fragment->id}}">
    <div class="o-dialog__box c-fragment-settings-dialog">
        <div class="o-dialog__body">
            <h4 class="o-headline o-headline--second">Fragment Settings</h4>
            <form class="o-form" action="/fragments" method="POST" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                @include('forms.hidden',['name' => 'id', 'value' => $fragment->id])

                @include('forms.select',['name' => 'columns_medium', 'label' => 'Columns', 'values' => $grid_md_columns, 'selected' => $fragment->details->get('columns_medium'), 'error_bag' => $fragment->id])

                @include('forms.select',[
                    'name' => 'columns_small',
                    'label' => 'Columns for small screens',
                    'values' => $grid_sm_columns,
                    'selected' => $fragment->details->get('columns_small'),
                    'error_bag' => $fragment->id,
                ])

                @include('forms.select',['name' => 'columns_large', 'label' => 'Columns for large screens', 'values' => $grid_lg_columns, 'selected' => $fragment->details->get('columns_large'), 'error_bag' => $fragment->id])

                @include('forms.textarea',['name' =>'classes', 'label' => 'Classes', 'value' => $fragment->details->get('classes'), 'error_bag' => $fragment->id])

                <div class="o-flex">
                    @include('forms.submit',['label' => 'Save', 'classes' => 'o-flex__item--align-right'])
                </div>
            </form>
        </div>
    </div>
    <div class="o-dialog__bg" data-toggle-dialog="fragment-settings-{{$fragment->id}}"></div>
</div>

<div class="o-fragment o-fragment--{{$fragment->type}} o-grid__column o-grid__column--md-{{$fragment->details->get('columns_medium')}}of{{$md_col}}">
    <div class="c-settings-panel__toggle c-settings-panel__toggle--right c-settings-panel__toggle--small" data-toggle-dialog="fragment-settings-{{$fragment->id}}">
        <svg viewBox="0 0 512 512" class="o-icon">
          <use xlink:href="#svg-icon--settings"></use>
        </svg>
    </div>
    @each('pages.fragment', $fragment->fragments,'fragment')

    {{$fragment->data}}

</div>

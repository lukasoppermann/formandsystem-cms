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
?>

<h4 class="o-headline o-headline--second">Fragment Settings</h4>
<form class="o-form" action="/fragments/{{$item->get('id')}}" method="POST" autocomplete="off">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    @include('forms.select',[
        'name' => 'columns[md]',
        'label' => 'Columns',
        'values' => $grid_md_columns,
        'selected' => collect($item->get('meta')['columns'])->get('md',1),
        'error_bag' => $item->get('id')
    ])

    @include('forms.select',[
        'name' => 'columns[sm]',
        'label' => 'Columns for small screens',
        'values' => $grid_sm_columns,
        'selected' => collect($item->get('meta')['columns'])->get('sm',1),
        'error_bag' => $item->get('id'),
    ])

    @include('forms.select',['name' => 'columns[lg]', 'label' => 'Columns for large screens', 'values' => $grid_lg_columns, 'selected' => collect($item->get('meta')['columns'])->get('lg',1), 'error_bag' => $item->get('id')])

    @include('forms.textarea',[
        'name' =>'custom_classes',
        'label' => 'Classes',
        'value' => collect($item->get('meta'))->get('custom_classes',''),
        'error_bag' => $item->get('id')
    ])

    <div class="o-grid">
        @include('forms.submit',['label' => 'Save', 'classes' => 'o-button o-button--blue  o-grid__column o-flex__item--align-right o-flex__item--none'])
    </div>
</form>
<form class="o-form o-grid" action="/fragments/{{$item->get('id')}}" method="POST" autocomplete="off">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    @include('forms.submit',['label' => 'Delete', 'classes' => 'o-grid__column o-button o-button--link o-button--link--red o-flex__item--none o-flex__item--align-right'])
</form>

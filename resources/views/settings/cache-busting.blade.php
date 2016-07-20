<?php

 ?>
<section class="o-section">
    <h3 class="o-headline o-headline--second">Cache Busting Code</h3>
    <p class="o-copy o-content__paragraph">This code is used to verify that a request to delete your cache is valid and comes from Form&System. Please copy it into your API package config or use it to verify the request when writing your own implementation.</p>

    <form class="o-form" action="/settings/developers/cache-code" method="POST">
        {{ csrf_field() }}
        <div class="o-flex-bar">
            {{ method_field('POST') }}
            <p class="o-flex-bar__item o-flex-bar__item--fill"><span class="type--bold">Code: </span><span class="type--grey">{{config('app.user')->account()->details('name','code',true)->get('data','none')}}</span></p>
            @include('forms.submit',['label' => 'Generate Code', 'classes' => 'o-button o-flex-bar__item o-flex-bar__item--right o-button--blue'])
        </div>
    </form>
</section>

<div class="o-dialog o-dialog--absolute{{session('dialogIsVisible') !== true ? ' is-hidden' : ''}}" data-dialog>
    <div class="o-dialog__box">
        <div class="o-dialog__body">
            <div data-dialog-content>
                {{$content or ''}}
            </div>
            @include('notice.loading')
        </div>
    </div>
    <div class="o-dialog__bg" data-close-dialog></div>
</div>

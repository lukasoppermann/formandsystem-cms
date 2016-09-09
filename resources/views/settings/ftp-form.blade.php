<form class="o-form" action="/settings/developers/ftp" method="POST" autocomplete="off">
    {{ csrf_field() }}
    @if(!isset($ftp_settings))
        @include('forms.hidden',['name' => 'ftp_account_type', 'value' => $type])
        @include('forms.select',['name' => $type.'_type', 'label' => 'FTP type', 'values' => [
            'sftp' => 'Secure FTP (SFTP)',
            'ftp' => 'FTP'
        ], 'selected' => 'sftp'])
        @include('forms.input',['name' => $type.'_host', 'label' => 'FTP host e.g. ftp.domain.com'])
        @include('forms.input',['name' => $type.'_root', 'label' => 'Path to the image folder', 'value' => ''])
        @include('forms.input',['name' => $type.'_port', 'label' => 'Port defaults to 22', 'value' => ''])
        @include('forms.input',['name' => $type.'_username', 'label' => 'Username', 'attr' => 'autocomplete=off'])
        @include('forms.input',['name' => $type.'_password', 'label' => 'Password', 'type' => 'password', 'attr' => 'autocomplete=off'])
        @include('forms.toggle',['name' => $type.'_ssl', 'label' => 'Use SSL', 'selected' => 'true'])
        <div class="o-flex">
            @include('forms.submit',['label' => 'Save', 'classes' => 'o-button o-button--blue  o-flex__item--align-right'])
        </div>
    @else
        {{ method_field('DELETE') }}
        <div class="o-flex o-flex--row">
            <p class="o-flex__item o-flex__item--fill"></p>
            @include('forms.hidden',['name' => 'ftp_image_account_type', 'value' => $type])
            @include('forms.submit',['label' => 'Delete ftp connection', 'classes' => 'o-button o-flex__item o-button--red'])
        </div>
    @endif
</form>

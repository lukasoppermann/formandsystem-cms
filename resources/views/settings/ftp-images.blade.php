<section class="o-section">
    <h3 class="o-headline o-headline--second">FTP for images</h3>
    <p class="o-copy o-content__paragraph">This FTP account is used to transfer images to your server. For security reasons we recommend to create an FTP account that has only access to the folder where the images are supposed to be stored.<p>

    @include('settings.ftp-form', [
        'type' => 'ftp_image',
        'ftp_settings' => isset($ftp_image) ? $ftp_image : NULL,
    ])
</section>

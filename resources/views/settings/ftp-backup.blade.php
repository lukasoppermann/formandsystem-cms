<section class="o-section">
    <h3 class="o-headline o-headline--second">FTP for backups</h3>
    <p class="o-copy">These settings are used to connect to your database to add and receive all data. The information is stored in a secure, encrypted manner. To change the database you need to delete the settings and add new ones.</p>

    @include('settings.ftp-form', [
        'type' => 'ftp_backup',
        'ftp_settings' => isset($ftp_backup) ? $ftp_backup : NULL,
    ])
</section>

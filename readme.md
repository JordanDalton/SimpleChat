## Simple Chat

.env file
    APP_ENV=local
    APP_DEBUG=true
    APP_KEY=LHSADXYmb44W4sDC14BBXzVni36aM5QA

    DB_HOST=localhost
    DB_DATABASE=homestead
    DB_USERNAME=homestead
    DB_PASSWORD=secret

    CACHE_DRIVER=file
    SESSION_DRIVER=file
    QUEUE_DRIVER=sync

    MAIL_DRIVER=smtp
    MAIL_HOST=mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=null
    MAIL_PASSWORD=null

To install run the following:
    php artisan migrate --seed
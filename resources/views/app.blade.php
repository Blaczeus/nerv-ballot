<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="stylesheet" href="/tmp/fonts/fonts.css">
        <link rel="stylesheet" href="/tmp/fonts/font-icons.css">
        <link rel="stylesheet" href="/tmp/css/bootstrap.min.css">
        <link rel="stylesheet" href="/tmp/css/drift-basic.min.css">
        <link rel="stylesheet" href="/tmp/css/photoswipe.css">
        <link rel="stylesheet" href="/tmp/css/swiper-bundle.min.css">
        <link rel="stylesheet" href="/tmp/css/animate.css">
        <link rel="stylesheet" href="https://sibforms.com/forms/end-form/build/sib-styles.css">
        <link rel="stylesheet" href="/tmp/css/styles.css">

        @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia

        <script type="text/javascript" src="/tmp/js/jquery.min.js"></script>
        <script type="text/javascript" src="/tmp/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/tmp/js/swiper-bundle.min.js"></script>
        <script type="text/javascript" src="/tmp/js/bootstrap-select.min.js"></script>
        <script type="text/javascript" src="/tmp/js/lazysize.min.js"></script>
        <script type="text/javascript" src="/tmp/js/count-down.js"></script>
        <script type="text/javascript" src="/tmp/js/wow.min.js"></script>
        <script type="text/javascript" src="/tmp/js/drift.min.js"></script>
        <script type="text/javascript" src="/tmp/js/multiple-modal.js"></script>
        <script type="text/javascript" src="/tmp/js/carousel.js"></script>
        <script type="text/javascript" src="/tmp/js/main.js?v={{ filemtime(public_path('tmp/js/main.js')) }}"></script>

        <!-- <script src="/tmp/js/sibforms.js" defer></script> -->

        <script>
            window.REQUIRED_CODE_ERROR_MESSAGE = 'Please choose a country code';
            window.LOCALE = 'en';
            window.EMAIL_INVALID_MESSAGE = window.SMS_INVALID_MESSAGE =
                'The information provided is invalid. Please review the field format and try again.';
            window.REQUIRED_ERROR_MESSAGE = 'This field cannot be left blank. ';
            window.GENERIC_INVALID_MESSAGE =
                'The information provided is invalid. Please review the field format and try again.';

            window.translation = {
                common: {
                    selectedList: '{quantity} list selected',
                    selectedLists: '{quantity} lists selected',
                },
            };

            var AUTOHIDE = Boolean(0);
        </script>
        <script type="module" src="/tmp/js/model-viewer.min.js"></script>
        <script type="module" src="/tmp/js/zoom.js"></script>
    </body>
</html>

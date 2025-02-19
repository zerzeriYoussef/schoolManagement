<?php

return [
    'default' => 'toastr',

    'scripts' => [
        'cdn' => [
            'https://cdn.jsdelivr.net/npm/@flasher/flasher@1.1.1/dist/flasher.min.js',
        ],
    ],

    'toastr' => [
        'options' => [
            'closeButton' => true,
            'closeClass' => 'toast-close-button',
            'closeDuration' => 300,
            'closeEasing' => 'swing',
            'closeHtml' => '<button><i class="icon-off"></i></button>',
            'closeMethod' => 'fadeOut',
            'closeOnHover' => true,
            'containerId' => 'toast-container',
            'debug' => false,
            'escapeHtml' => false,
            'extendedTimeOut' => 10000,
            'hideDuration' => 1000,
            'hideEasing' => 'linear',
            'hideMethod' => 'fadeOut',
            'iconClass' => 'toast-info',
            'iconClasses' => [
                'error' => 'toast-error',
                'info' => 'toast-info',
                'success' => 'toast-success',
                'warning' => 'toast-warning',
            ],
            'messageClass' => 'toast-message',
            'newestOnTop' => false,
            'onHidden' => null,
            'onShown' => null,
            'positionClass' => 'toast-top-right',
            'preventDuplicates' => true,
            'progressBar' => true,
            'progressClass' => 'toast-progress',
            'rtl' => false,
            'showDuration' => 300,
            'showEasing' => 'swing',
            'showMethod' => 'fadeIn',
            'tapToDismiss' => true,
            'target' => 'body',
            'timeOut' => 5000,
            'titleClass' => 'toast-title',
            'toastClass' => 'toast',
        ],
    ],
];
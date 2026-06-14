<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $quotes = [
        'The only way to do great work is to love what you do. - Steve Jobs',
        'Life is what happens when you\'re busy making other plans. - John Lennon',
        'The future belongs to those who believe in the beauty of their dreams. - Eleanor Roosevelt',
        'It does not matter how slowly you go as long as you do not stop. - Confucius',
        'Believe you can and you\'re halfway there. - Theodore Roosevelt',
    ];
    $this->comment($quotes[array_rand($quotes)]);
})->purpose('Display an inspiring quote');

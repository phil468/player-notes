<?php

use App\Models\Player;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/players/{player}/notes', function (Player $player) {
    return view('player-notes', compact('player'));
})->middleware('auth')->name('player.notes');

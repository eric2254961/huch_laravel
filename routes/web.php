<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/register', [RegisteredUserController::class, 'store'])->name('register'); // Assurez-vous que RegisterController est correctement importé

Route::get('/registration-confirmation', function () {
    return view('auth.confirmation');
})->name('registration.confirmation');

require __DIR__.'/auth.php';

Route::get('/search-user/{email}', function ($email) {
    // Activer le journal des requêtes
    DB::enableQueryLog();

    // Enregistrer le temps de début
    $startTime = microtime(true);

    // Exécuter la requête de recherche
    $user = User::where('email', $email)->first();

    // Enregistrer le temps de fin
    $endTime = microtime(true);

    // Calculer le temps d'exécution
    $executionTime = $endTime - $startTime;

    // Obtenir le journal des requêtes
    $queries = DB::getQueryLog();

    return response()->json([
        'user' => $user,
        'execution_time' => $executionTime,
        'queries' => $queries
    ]);
});
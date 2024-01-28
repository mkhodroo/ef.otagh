<?php

use App\Http\Controllers\ProfileController;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Mkhodroo\Cities\Controllers\CityController;
use Spatie\SimpleExcel\SimpleExcelReader;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/import-user', function () {
    $rows = SimpleExcelReader::create(public_path('Book2.xlsx'))->getRows();
    echo "<pre>";
    $rows->each(function(array $rowProperties){
        if($rowProperties['mobile']){
            print_r($rowProperties);
            // $user= User::where('email', 'like', '%'.$rowProperties['mobile'])->first();
            // $user->enable = 0;
            // $user->save();
            // print($user->enable);
            $province = $rowProperties['province'];
            $city = $rowProperties['shahr'];
            $name = "اتاق اصناف شهرستان ". $city;
            $username = $rowProperties['mobile'];
            $password = $username;
            
            $city_id = CityController::create($province, $city)->id;

            $user = User::create([
                'name' => $name,
                'email' => "$username",
                'password' => Hash::make($password),
                'city_id' => $city_id
            ]);

            UserInfo::create([
                'user_id' => $user->id,
                'fname' => $rowProperties['name'],
                'lname' => $rowProperties['lname'],
                'mobile' => "$username",
            ]);
        }
    });
});

Route::get('/build-app', function () {
    Artisan::call('migrate');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/2', function () {
    return view('welcome2');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
require __DIR__.'/namayeshgah.php';
require __DIR__.'/download.php';

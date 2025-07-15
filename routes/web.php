<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\SemproController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PangkatController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TugasakhirController;
use App\Http\Controllers\BidangkeahlianController;
use App\Http\Controllers\SitaController;
use App\Http\Controllers\ClusteringController;




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

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout']);


//JURUSAN
// Route::get('/jurusan', [JurusanController::class, 'index']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    });


    //User
    Route::resource('user', UserController::class);


    //Jurusan
    Route::get('/jurusan', function () {
        return view('admin.jurusan');
    });
    Route::resource('/jurusan', JurusanController::class);


    //Prodi
    Route::get('/prodi', function () {
        return view('admin.prodi');
    });
    Route::resource('/prodi', ProdiController::class);


    //Ruangan
    Route::get('/ruangan', function () {
        return view('admin.ruangan');
    });
    Route::resource('/ruangan', RuanganController::class);


    //Mahasiswa
    Route::get('/mahasiswa', function () {
        return view('admin.mahasiswa');
    });
    Route::resource('/mahasiswa', MahasiswaController::class);

    Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'detail']);


    //Bidang Keahlian
    Route::resource('/bidangkeahlian', BidangkeahlianController::class);


    //Jabatan Fungsional
    Route::get('/jabatan', function () {
        return view('admin.jabatan');
    });
    Route::resource('/jabatan', JabatanController::class);


    //Pangkat
    Route::get('/pangkat', function () {
        return view('admin.pangkat');
    });
    Route::resource('/pangkat', PangkatController::class);


    //Dosen
    Route::resource('/dosen', DosenController::class);

    Route::get('/dosen/{id}', [DosenController::class, 'detail']);
    // Route::get('/dosen', function () {
    //     return view('admin.dosen.index');
    // });


    //Tugas Akhir
    Route::resource('/tugasakhir', TugasakhirController::class);
    Route::get('/tugasakhir/detail/{id}', [TugasakhirController::class, 'detail'])->name('tugasakhir.detail');
    Route::get('/tugasakhir/reviewta/{id}', [TugasakhirController::class, 'reviewview'])->name('tugasakhir.reviewta');
    Route::put('/tugasakhir/reviewta/{id}', [TugasakhirController::class, 'reviewpost'])->name('tugasakhir.reviewpost');
    Route::get('/downloadproposal/{id}', [TugasakhirController::class, 'download']);

    //Mahasiswa Bimbingan
    Route::resource('bimbingan', BimbinganController::class);
    Route::get('/detailmhsbimbingan/{id}', [BimbinganController::class, 'detail']);
    // Route::get('/detailmhsbimbingan/{id}', [BimbinganController::class, 'datadetail']);
    Route::get('/kartubimbingan/{id}', [BimbinganController::class, 'kartubimbingan']);
    Route::get('/bimbingan/{id}/edit', [BimbinganController::class, 'edit']);
    Route::put('/bimbingan/{id}', [BimbinganController::class, 'update']);
    Route::get('/downloadproposal/{id}', [BimbinganController::class, 'download']);
    Route::get('/verifikasikartubimbingan/{id}', [BimbinganController::class, 'verifikasibimbingan']);

    //Sempro
    Route::resource('/sempro', SemproController::class);
    Route::get('/detailsempro/{id}', [SemproController::class, 'detail']);
    Route::get('/accsemprop1/{id}', [SemproController::class, 'accsemprop1']);
    Route::get('/accsemprop2/{id}', [SemproController::class, 'accsemprop2']);
    Route::get('/semprojadwal/{id}', [SemproController::class, 'formsemprojadwal']);
    Route::get('/editsemprojadwal/{id}', [SemproController::class, 'formeditsemprojadwal']);
    Route::get('/nilaisempro/{id}', [SemproController::class, 'nilaisempro']);
    Route::post('/inputnilaisempro/{id}', [SemproController::class, 'storenilaisempro']);
    Route::post('/semprojadwal/{id}', [SemproController::class, 'storesemprojadwal']);
    Route::post('/editsemprojadwal/{id}', [SemproController::class, 'updatesemprojadwal']);
    // Route::get('/downloaddokumensempro/{id}', [SemproController::class, 'download']);


    //Sidang Tugas Akhir
    Route::resource('/sita', SitaController::class);
    Route::get('/sitajadwal/{id}', [SitaController::class, 'formsitajadwal']);
    Route::get('/detailsita/{id}', [SitaController::class, 'detail']);
    Route::get('/fulltadownload/{id}', [SitaController::class, 'download']);
    Route::get('/sita/accsidangta/{id}', [SitaController::class, 'accsidangta']);
    Route::get('/validasidokumen/{id}', [SitaController::class, 'validasidokumen']);
    Route::post('/sitajadwal/{id}', [SitaController::class, 'storesitajadwal']);
    Route::get('/nilaisita/{id}', [SitaController::class, 'nilaisita']);
    Route::get('/tolakvalidasidokumen/{id}', [SitaController::class, 'tolakvalidasidokumen']);
    Route::post('/inputnilaisita/{id}', [SitaController::class, 'storenilaisita']);


    //Clustering
    Route::get('/klaster', [ClusteringController::class, 'klaster']);
    Route::resource('/clustering', ClusteringController::class);
});

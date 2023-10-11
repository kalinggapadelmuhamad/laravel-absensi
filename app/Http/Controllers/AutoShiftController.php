<?php

namespace App\Http\Controllers;

use App\Models\AutoShift;
use App\Models\Jabatan;
use App\Models\MappingShift;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;

class AutoShiftController extends Controller
{
    public function index()
    {
        return view('autoshift.index', [
            'title' => 'Master Jadwal/Shift Otomatis',
            'data' => AutoShift::all()
        ]);
    }

    public function tambah()
    {
        return view('autoshift.tambah', [
            'title' => 'Tambah Data Auto Shift',
            'data_jabatan' => Jabatan::all(),
            'shift' => Shift::all()
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "jabatan_id" => 'required',
            "shift_id" => 'required',
        ]);

        // Cek banyak user dengan jabatan
        $users = User::where('jabatan_id', $request->jabatan_id)->get();

        // Tanggal mulai "auto shift"
        $startDate = now()->format('Y-m-d');

        // Tanggal berakhir "auto shift" (satu bulan ke depan)
        $endDate = now()->addMonth()->format('Y-m-d');

        // Loop melalui setiap pengguna
        foreach ($users as $user) {
            // Loop untuk setiap hari dalam satu bulan
            $currentDate = \Carbon\Carbon::parse($startDate); // Parse tanggal awal
            while ($currentDate->lte($endDate)) {
                // Input mapping shift berdasarkan pengguna, jabatan, shift, dan tanggal
                MappingShift::create([
                    'user_id' => $user->id,
                    'jabatan_id' => $request->jabatan_id,
                    'shift_id' => $request->shift_id,
                    'tanggal' => $currentDate->format('Y-m-d'),
                ]);

                // Tambahkan satu hari ke tanggal saat ini
                $currentDate->addDay();
            }
        }

        // Tambahkan data "auto shift" ke tabel AutoShift
        AutoShift::create($validatedData);

        return redirect('/auto-shift')->with('success', 'Data Berhasil Ditambahkan');
    }


    public function edit($id)
    {
        return view('autoshift.edit', [
            'title' => 'Edit Data Auto Shift',
            'auto_shift' => AutoShift::findOrFail($id),
            'data_jabatan' => Jabatan::all(),
            'shift' => Shift::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            "jabatan_id" => 'required',
            "shift_id" => 'required',
        ]);

        // Ambil data "auto shift" berdasarkan ID
        $autoShift = AutoShift::find($id);
        $jabatanId = $autoShift->jabatan_id;

        // Update data "auto shift"
        $autoShift->update($validatedData);

        $users = User::where('jabatan_id', $jabatanId)->get();
        foreach ($users as $user) {
            MappingShift::where('user_id', $user->id)->delete();
        }

        $users = User::where('jabatan_id', $request->jabatan_id)->get();

        // Tanggal mulai "auto shift"
        $startDate = now()->format('Y-m-d');

        // Tanggal berakhir "auto shift" (satu bulan ke depan)
        $endDate = now()->addMonth()->format('Y-m-d');

        // Loop melalui setiap pengguna
        foreach ($users as $user) {
            // Loop untuk setiap hari dalam satu bulan
            $currentDate = \Carbon\Carbon::parse($startDate); // Parse tanggal awal
            while ($currentDate->lte($endDate)) {
                // Input mapping shift berdasarkan pengguna, jabatan, shift, dan tanggal
                MappingShift::create([
                    'user_id' => $user->id,
                    'jabatan_id' => $request->jabatan_id,
                    'shift_id' => $request->shift_id,
                    'tanggal' => $currentDate->format('Y-m-d'),
                ]);

                // Tambahkan satu hari ke tanggal saat ini
                $currentDate->addDay();
            }
        }

        return redirect('/auto-shift')->with('success', 'Data Berhasil Diupdate');
    }

    public function delete($id)
    {
        $delete = AutoShift::find($id);
        $jabatanId = $delete->jabatan_id;

        $users = User::where('jabatan_id', $jabatanId)->get();
        foreach ($users as $user) {
            MappingShift::where('user_id', $user->id)->delete();
        }

        $delete = AutoShift::find($id);
        $delete->delete();
        return redirect('/auto-shift')->with('success', 'Data Berhasil di Delete');
    }
}

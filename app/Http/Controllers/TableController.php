<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    // Tampilkan semua meja
    public function index()
    {
        $tables = Table::all();
        return view('tables.index', compact('tables'));
    }

    // Tampilkan form tambah meja
    public function create()
    {
        return view('tables.create');
    }

    // Simpan data meja baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:kosong,terisi,dipesan',
        ]);

        Table::create($request->all());

        return redirect()->route('tables.index')->with('success', 'Meja berhasil ditambahkan.');
    }

    // Tampilkan form edit
    public function edit(Table $table)
    {
        return view('tables.edit', compact('table'));
    }

    // Update data meja
    public function update(Request $request, Table $table)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:kosong,terisi,dipesan',
        ]);

        $table->update($request->all());

        return redirect()->route('tables.index')->with('success', 'Meja berhasil diperbarui.');
    }

    // Hapus meja
    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()->route('tables.index')->with('success', 'Meja berhasil dihapus.');
    }

  public function changeStatus(Request $request, $id)
{
    $table = Table::findOrFail($id);

    $request->validate([
        'status' => 'required|in:kosong,terisi,dipesan'
    ]);

    $table->status = $request->status;
    $table->save();

    return back()->with('success', 'Status meja berhasil diperbarui.');
}
public function publicIndex()
{
    $tables = \App\Models\Table::all();
    return view('public.daftar_table', compact('tables'));
}

}

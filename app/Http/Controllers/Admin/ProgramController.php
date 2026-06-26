<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;

class ProgramController extends Controller
{
    /**
     * LIST PROGRAM
     */
    public function index()
    {
         $program = Program::oldest()->get();
        return view('admin.program.index', compact('program'));
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        return view('admin.program.create');
    }

    /**
     * SIMPAN DATA
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required'
        ]);

        Program::create([
            'nama_program' => $request->nama_program
        ]);

        return redirect('/admin/program')->with('success', 'Program berhasil ditambahkan');
    }

    /**
     * FORM EDIT
     */
    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return view('admin.program.edit', compact('program'));
    }

    /**
     * UPDATE
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_program' => 'required'
        ]);

        $program = Program::findOrFail($id);

        $program->update([
            'nama_program' => $request->nama_program
        ]);

        return redirect('/admin/program')->with('success', 'Program berhasil diupdate');
    }

    /**
     * DELETE
     */
    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        $program->delete();

        return redirect('/admin/program')->with('success', 'Program berhasil dihapus');
    }
}
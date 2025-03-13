<?php
namespace App\Http\Controllers;

use App\Models\Title;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    public function index()
    {
        $titles = Title::all();
        return view('titles.index', compact('titles'));
    }

    public function create()
    {
        return view('titles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|unique:titles',
            'title' => 'required',
        ]);

        Title::create($request->all());
        return redirect()->route('titles.index')->with('success', 'Title berhasil ditambahkan.');
    }

    public function edit(Title $title)
    {
        return view('titles.edit', compact('title'));
    }

    public function update(Request $request, Title $title)
    {
        $request->validate([
            'url' => 'required|unique:titles,url,' . $title->id,
            'title' => 'required',
        ]);

        $title->update($request->all());
        return redirect()->route('titles.index')->with('success', 'Title berhasil diperbarui.');
    }

    public function destroy(Title $title)
    {
        $title->delete();
        return redirect()->route('titles.index')->with('success', 'Title berhasil dihapus.');
    }
}

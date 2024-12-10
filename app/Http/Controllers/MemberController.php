<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    public function index()
    {
        // Return the view for the members index
        return view('members.index');
    }

    public function getMembersData()
    {

        $members = Member::get();

        return DataTables::of($members)
            ->addColumn('actions', function ($member) {
                return '
                    <a href="' . route('members.edit', $member) . '" class="btn btn-warning btn-sm">Edit</a>
                    <form action="' . route('members.destroy', $member) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                ';
            })
            ->editColumn('join_date', function ($member) {
                return $member->join_date->format('Y-m-d');
            })
            ->editColumn('status', function ($member) {
                return ucfirst($member->status);
            })
            ->rawColumns(['actions'])
            ->make(true);
    }


    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:members',
            'join_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        Member::create($request->all());
        return redirect()->route('members.index')->with('success', 'Member created successfully.');
    }

    public function show(Member $member)
    {
        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:members,email,' . $member->id,
            'join_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        $member->update($request->all());
        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;

class MemberController extends Controller
{
    public function index()
    {
        return view('members.index');
    }

    public function getMembersData()
    {
        try {
            $members = Member::get();

            return DataTables::of($members)
                ->addColumn('actions', function ($member) {
                    $encryptedId = Crypt::encrypt($member->id);
                    return '
                        <a href="' . route('members.edit', $encryptedId) . '" class="btn btn-warning btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-danger btn-sm delete-member" data-id="' . $encryptedId . '" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    ';
                })
                ->editColumn('join_date', function ($member) {
                    return \Carbon\Carbon::parse($member->join_date)->locale('id_ID')->translatedFormat('d F Y');
                })
                ->editColumn('status', function ($member) {
                    $icon = '';
                    switch ($member->status) {
                        case 'active':
                            $icon = '<i class="fas fa-check-circle text-success"></i> Active';
                            break;
                        case 'inactive':
                            $icon = '<i class="fas fa-times-circle text-danger"></i> Inactive';
                            break;
                        case 'pending':
                            $icon = '<i class="fas fa-clock text-warning"></i> Pending';
                            break;
                        default:
                            $icon = '<i class="fas fa-question-circle text-secondary"></i> Unknown';
                            break;
                    }
                    return $icon;
                })
                ->rawColumns(['actions', 'status'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('Error fetching members data: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch members data.'], 500);
        }
    }

    public function create()
    {
        return view('members.create');
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string',
                'phone' => 'required|string|max:15',
                'email' => 'required|string|email|max:255|unique:members',
                'join_date' => 'required|date',
                'status' => 'required|in:active,inactive',
            ]);

            $member = Member::create($request->all());

            // Log the activity with additional properties for successful creation
            activity()
                ->causedBy(auth()->user()) // The user performing the action
                ->performedOn($member) // Targeted member
                ->withProperties([
                    'name' => $member->name,
                    'email' => $member->email,
                    'status' => $member->status,
                ]) // Additional data you want to log
                ->log('Added a new member: ' . $member->name); // The message you want to log

            return redirect()->route('members.index')->with('success', 'Member created successfully.');
        } catch (\Exception $e) {
            // Log the error with Spatie Activity Log
            activity()
                ->causedBy(auth()->user()) // The user performing the action
                ->withProperties([
                    'error_message' => $e->getMessage(),
                    'input_data' => $request->all(),
                ]) // Log the error message and input data
                ->log('Failed to create member: ' . $e->getMessage()); // The message you want to log

            return redirect()->route('members.index')->with('error', 'Failed to create member.');
        }
    }

    public function show(Member $member)
    {
        return view('members.show', compact('member'));
    }

    public function edit($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $member = Member::findOrFail($id);
            return view('members.edit', compact('member'));
        } catch (\Exception $e) {
            Log::error('Error editing member: ' . $e->getMessage());
            return redirect()->route('members.index')->with('error', 'Failed to retrieve member for editing.');
        }
    }

    public function update(Request $request, Member $member)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string',
                'phone' => 'required|string|max:15',
                'email' => 'required|string|email|max:255|unique:members,email,' . $member->id,
                'join_date' => 'required|date',
                'status' => 'required|in:active,inactive',
            ]);

            $member->update($request->all());

            // Log the activity with additional properties
            activity()
                ->causedBy(auth()->user()) // The user performing the action
                ->performedOn($member) // Targeted member
                ->withProperties([
                    'name' => $member->name,
                    'email' => $member->email,
                    'status' => $member->status,
                ]) // Additional data you want to log
                ->log('Updated member: ' . $member->name); // The message you want to log

            Log::info('Member updated successfully: ' . $member->name);
            return redirect()->route('members.index')->with('success', 'Member updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating member: ' . $e->getMessage());
            return redirect()->route('members.index')->with('error', 'Failed to update member.');
        }
    }

    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $member = Member::findOrFail($id);
            $member->delete();

            // Log the activity with additional properties
            activity()
                ->causedBy(auth()->user()) // The user performing the action
                ->performedOn($member) // Targeted member
                ->withProperties([
                    'name' => $member->name,
                    'email' => $member->email,
                    'status' => $member->status,
                ]) // Additional data you want to log
                ->log('Deleted member: ' . $member->name); // The message you want to log

            Log::info('Member deleted successfully: ' . $member->name);
            return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting member: ' . $e->getMessage());
            return redirect()->route('members.index')->with('error', 'Failed to delete member.');
        }
    }
}

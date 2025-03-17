<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    // Get all skills
    public function index()
    {
        $skills = Skill::all();
        return response()->json($skills);
    }

    // Create a new skill
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'required|integer|min:0|max:100',
        ]);

        $skill = Skill::create($request->all());
        return response()->json($skill, 201);
    }

    // Update a skill
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'required|integer|min:0|max:100',
        ]);

        $skill = Skill::findOrFail($id);
        $skill->update($request->all());
        return response()->json($skill);
    }

    // Delete a skill
    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);
        $skill->delete();
        return response()->json(null, 204);
    }
}

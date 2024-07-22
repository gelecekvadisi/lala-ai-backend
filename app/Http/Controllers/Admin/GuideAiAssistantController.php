<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuideAiAssistant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuideAiAssistantController extends Controller
{

    public function index(Request $request)
    {
        $query = GuideAiAssistant::query();

        if ($request->has('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                  ->orWhere('assistant_id', 'like', $search)
                  ->orWhere('inputs', 'like', $search)
                  ->orWhere('instructions_generator', 'like', $search)
                  ->orWhere('spreadsheet_name', 'like', $search)
                  ->orWhere('spreadsheet_id', 'like', $search);
            });

            $guideAiAssistant = $query->latest()->get();
            return view('admin.guide-ai-assistant.search', compact('guideAiAssistant'));
        } else {
            $guideAiAssistant = $query->latest()->paginate(10);
            return view('admin.guide-ai-assistant.index', compact('guideAiAssistant'));
        }
    }

    public function create()
    {
        return view('admin.guide-ai-assistant.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_name' => 'nullable|string|max:255',
            'assistant_id' => 'required|string|max:255',
            'inputs' => 'required|string',
            'instructions_generator' => 'required|string',
            'spreadsheet_name' => 'required|string|max:255',
            'spreadsheet_id' => 'required|string|max:255',
            'status' => 'nullable|in:on',
        ]);

        GuideAiAssistant::create($request->except('status') + [
                'status' => $request->status ? 1 : 0,
            ]);

        return response()->json([
            'message'   => __('Guide AI Assistant created successfully'),
            'redirect'  => route('admin.guide-ai-assistant.index')
        ]);
    }

    public function edit(string $id)
    {
        $guideAiAssistant = GuideAiAssistant::findOrFail($id);
        return view('admin.guide-ai-assistant.edit', compact('guideAiAssistant'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_name' => 'nullable|string|max:255',
            'assistant_id' => 'required|string|max:255',
            'inputs' => 'required|string',
            'instructions_generator' => 'required|string',
            'spreadsheet_name' => 'required|string|max:255',
            'spreadsheet_id' => 'required|string|max:255',
            'status' => 'nullable|in:on',
        ]);

        $guideAiAssistant = GuideAiAssistant::findOrFail($id);
        $guideAiAssistant->update($request->except('status') + [
                'status' => $request->status ? 1 : 0,
            ]);

        return response()->json([
            'message'   => __('Guide AI Assistant updated successfully'),
            'redirect'  => route('admin.guide-ai-assistant.index')
        ]);
    }

    public function destroy(string $id)
    {
        $guideAiAssistant = GuideAiAssistant::findOrFail($id);
        $guideAiAssistant->delete();
        return response()->json([
            'message'   => __('Guide AI Assistant deleted successfully'),
            'redirect'  => route('admin.guide-ai-assistant.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $guideAiAssistant = GuideAiAssistant::findOrFail($id);
        $guideAiAssistant->update(['status' => $request->status]);
        return response()->json(['message' => 'Guide AI Assistant status updated successfully']);
    }

    public function deleteAll(Request $request)
    {
        $idsToDelete = $request->input('ids');
        DB::beginTransaction();
        try {
            GuideAiAssistant::whereIn('id', $idsToDelete)->delete();
            DB::commit();

            return response()->json([
                'message' => __('Guide AI Assistant deleted successfully'),
                'redirect' => route('admin.guide-ai-assistant.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(__('Something was wrong.'), 400);
        }
    }
}

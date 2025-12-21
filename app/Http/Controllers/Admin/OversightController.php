<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OversightService;
use App\Models\Task;
use App\Traits\FormatTaskAttributes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

/**
 * Controller for Admin-level system oversight.
 * Enforces read-only monitoring as a Senior Lead standard.
 */
class OversightController extends Controller
{
    use FormatTaskAttributes;

    public function __construct(
        protected readonly OversightService $oversightService
    ) {}


    /**
     * Provide a global, read-only list of all tasks for auditing purposes.
     */
    public function tasks(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = Task::with(['camp', 'manager', 'assignedTo'])
                ->select('tasks.*');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('status', fn(Task $task) => $this->getStatusBadge($task->status))
                ->editColumn('priority', fn(Task $task) => $this->getPriorityBadge($task->priority))
                ->addColumn('camp_name', fn(Task $task) => $task->camp->name)
                ->addColumn('manager_name', fn(Task $task) => $task->manager->name)
                ->addColumn('assigned_name', fn(Task $task) => $task->assignedTo?->name ?? '<span class="text-muted">Unassigned</span>')
                ->addColumn('actions', function (Task $task) {
                    return '
                        <button class="btn btn-sm btn-outline-info" onclick="viewTaskDetails(' . $task->id . ')">
                            <i class="bi bi-eye"></i> View Detail
                        </button>';
                })
                ->rawColumns(['status', 'priority', 'assigned_name', 'actions'])
                ->make(true);
        }

        return view('admin.oversight.tasks');
    }

    /**
     * Fetch specific task details for the oversight modal.
     */
    public function show(int $task): JsonResponse
    {
        $task = $this->oversightService->getTaskDetails($task);

        return response()->json([
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'status' => $this->getStatusBadge($task->status),
            'priority' => $this->getPriorityBadge($task->priority),
            'camp' => $task->camp->name,
            'manager' => $task->manager->name,
            'assigned_to' => $task->assignedTo?->name ?? 'Unassigned',
            'due_date' => $task->due_date?->format('M d, Y') ?? 'N/A',
            'required_skills' => $task->required_skills ?? 'No specific skills required',
        ]);
    }
}

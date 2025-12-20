<?php

namespace App\Http\Controllers\Supporter;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Actions\Supporter\Task\AcceptTaskAction;
use App\Actions\Supporter\Task\CompleteTaskAction;
use App\Traits\FormatTaskAttributes;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaskController extends Controller
{
    use FormatTaskAttributes;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Task::with(['camp', 'manager'])
                ->whereNull('assigned_to')
                ->where('status', 'pending');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('status', fn($task) => $this->getStatusBadge($task->status))
                ->editColumn('priority', fn($task) => $this->getPriorityBadge($task->priority))
                ->addColumn('camp_name', fn($task) => $task->camp->name)
                ->addColumn('manager_name', fn($task) => $task->manager->name)
                ->addColumn('actions', function ($task) {
                    return '<button onclick="acceptTask(' . $task->id . ')" class="btn btn-sm btn-primary">Accept Task</button>';
                })
                ->rawColumns(['status', 'priority', 'actions'])
                ->make(true);
        }

        return view('supporter.tasks.index');
    }

    public function myTasks(Request $request)
    {
        if ($request->ajax()) {
            $query = Task::with(['camp', 'manager'])
                ->where('assigned_to', auth()->id());

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('status', fn($task) => $this->getStatusBadge($task->status))
                ->addColumn('camp_name', fn($task) => $task->camp->name)
                ->addColumn('actions', function ($task) {
                    if ($task->status !== 'completed') {
                        return '<button onclick="completeTask(' . $task->id . ')" class="btn btn-sm btn-success">Mark Completed</button>';
                    }
                    return '<span class="text-muted small">Completed</span>';
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }

        return view('supporter.tasks.my_tasks');
    }

    public function accept(Task $task, AcceptTaskAction $action)
    {
        try {
            $action->execute($task, auth()->user());
            return response()->json(['success' => true, 'message' => 'Task accepted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function complete(Task $task, CompleteTaskAction $action)
    {
        try {
            $action->execute($task, auth()->user());
            return response()->json(['success' => true, 'message' => 'Task marked as completed!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}

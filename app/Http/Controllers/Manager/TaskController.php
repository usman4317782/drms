<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Camp;
use App\Models\User;
use App\DTOs\TaskData;
use App\Actions\Manager\Task\CreateTaskAction;
use App\Actions\Manager\Task\UpdateTaskAction;
use App\Http\Requests\Manager\StoreTaskRequest;
use App\Http\Requests\Manager\UpdateTaskRequest;
use App\Traits\FormatTaskAttributes;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaskController extends Controller
{
    use FormatTaskAttributes;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Task::with(['camp', 'assignedTo'])
                ->where('manager_id', auth()->id())
                ->select('tasks.*');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('status', fn($task) => $this->getStatusBadge($task->status))
                ->editColumn('priority', fn($task) => $this->getPriorityBadge($task->priority))
                ->addColumn('camp_name', fn($task) => $task->camp->name)
                ->addColumn('assigned_name', fn($task) => $task->assignedTo->name ?? 'Unassigned')
                ->addColumn('actions', function ($task) {
                    return '
                        <div class="btn-group">
                            <a href="' . route('manager.tasks.edit', $task) . '" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>';
                })
                ->rawColumns(['status', 'priority', 'actions'])
                ->make(true);
        }

        return view('manager.tasks.index');
    }

    public function create()
    {
        $camps = Camp::where('manager_id', auth()->id())->get();

        $volunteers = User::whereHas('roles', function ($q) {
            $q->whereIn('slug', ['supporter', 'volunteer', 'donor']);
        })->get();

        return view('manager.tasks.create', compact('camps', 'volunteers'));
    }

    public function store(StoreTaskRequest $request, CreateTaskAction $action)
    {
        $data = TaskData::fromArray($request->validated());
        $action->execute($data);

        return redirect()->route('manager.tasks.index')
            ->with('success', 'Task created and assigned successfully.');
    }

    public function edit(Task $task)
    {
        if ($task->manager_id !== auth()->id()) {
            abort(403);
        }

        $camps = Camp::where('manager_id', auth()->id())->get();
        $volunteers = User::whereHas('roles', function ($q) {
            $q->whereIn('slug', ['supporter', 'volunteer', 'donor']);
        })->get();

        return view('manager.tasks.edit', compact('task', 'camps', 'volunteers'));
    }

    public function update(UpdateTaskRequest $request, Task $task, UpdateTaskAction $action)
    {
        if ($task->manager_id !== auth()->id()) {
            abort(403);
        }

        $data = TaskData::fromArray($request->validated());
        $action->execute($task, $data);

        return redirect()->route('manager.tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        if ($task->manager_id !== auth()->id()) {
            abort(403);
        }

        $task->delete();

        return response()->json(['success' => true]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Models\User;
use App\Services\TimeService;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Log;

class TimesheetController extends Controller
{

    protected $timeService;

    public function __construct(TimeService $timeService)
    {
        $this->timeService = $timeService;
    }

    // Display a listing of the timesheets.
    public function index(Request $request)
    {

        $authUser = auth()->user();

        // Start the query
        $query = Timesheet::with([
            'user' => function ($query) {
                $query->select('id', 'name');
            },
            'job' => function ($query) {
                $query->select('id', 'name', 'detail');
            }
        ])->orderBy('date', 'desc');

        // Member can see their timesheets only
        if ($authUser->group != 6) {
            $query->where('user_id', $authUser->id);
        }

        // Check if a type was provided
        if ($request->filled('type')) {
            if ($request->type === 'unpaid') {
                $query->whereIn('status', [1, 2]);
            }
            if ($request->type === 'approved') {
                $query->whereIn('status', [2]);
            }
            if ($request->type === 'report') {
                $query->whereIn('status', [1, 2, 3]);
            }
        }

        // Check if a job was provided
        if ($request->filled('job')) {
            $query->where('job_id', $request->job);
        }

        // Check if a user was provided
        if ($request->filled('user')) {
            $query->where('user_id', $request->user);
        }

        // Check if a status was provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Validate and set the limit parameter, converting it to an integer
        $limit = intval($request->input('limit', 10)); // Default to 10 if limit is not valid or provided

        // Validate and set the page parameter, converting it to an integer
        $page = intval($request->input('page', 1)); // Default to page 1 if page is not valid or provided
        if ($page <= 0) {
            $page = 1; // Ensure that page is positive
        }

        // Handle 'show all' case when limit is set to -1
        if ($limit == -1) {
            $timesheets = $query->get(); // Fetch all timesheets matching the criteria
            $total = $timesheets->count(); // Count the timesheets

            // Prepare the response for 'all' data
            $response = [
                'data' => $timesheets,
                'total' => $total,
                'limit' => -1,
                'currentPage' => 1,
                'lastPage' => 1,
            ];
        } else {
            // Ensure that limit is positive for regular pagination
            if ($limit <= 0) {
                $limit = 10;
            }

            // Apply pagination if limit is not -1
            $timesheets = $query->paginate($limit, ['*'], 'page', $page);
            $total = $timesheets->total(); // This ensures total counts all matches, not just the paginated subset

            // Prepare the response with pagination
            $response = [
                'data' => $timesheets->items(),
                'total' => $total,
                'limit' => $limit,
                'currentPage' => $timesheets->currentPage(),
                'lastPage' => $timesheets->lastPage(),
            ];
        }

        return response()->json($response);
    }

    // Calculate amount
    public function calculateAmount(Request $request)
    {

        // Query for all statuses to calculate the total amount
        $totalQuery = Timesheet::query();

        if ($request->filled('user')) {
            $totalQuery->where('user_id', intval($request->user));
        }

        if ($request->filled('job')) {
            $totalQuery->where('job_id', intval($request->job));
        }

        $totalAmount = (float) $totalQuery->sum('amount');

        // Query for unpaid statuses (1 and 2)
        $unpaidQuery = Timesheet::whereIn('status', [1, 2]);

        if ($request->filled('user')) {
            $unpaidQuery->where('user_id', intval($request->user));
        }

        if ($request->filled('job')) {
            $unpaidQuery->where('job_id', intval($request->job));
        }

        $unpaidAmount = (float) $unpaidQuery->sum('amount');

        // Query for paid statuses (3)
        $paidQuery = Timesheet::whereIn('status', [3]);

        if ($request->filled('user')) {
            $paidQuery->where('user_id', intval($request->user));
        }

        if ($request->filled('job')) {
            $paidQuery->where('job_id', intval($request->job));
        }

        $paidAmount = (float) $paidQuery->sum('amount');

        return response()->json([
            'totalAmount' => $totalAmount,
            'unpaidAmount' => $unpaidAmount,
            'paidAmount' => $paidAmount,
        ]);
    }


    /**
     * Store a newly created timesheet in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $authUser = auth()->user();

        // Validate incoming request data

        $rules = [
            'job_id' => 'required|integer',
            'date' => 'required|date',
            'start_time' => 'required|string|max:8',
            'end_time' => 'required|string|max:8',
            'break' => 'nullable|boolean',
            'note' => 'nullable|string',
        ];

        if ($authUser->group == 6) {
            $rules['user_id'] = 'required|integer';
            $rules['status'] = 'required|integer';
        }

        $validatedData = $request->validate($rules);

        if ($authUser->group != 6) {
            $validatedData['status'] = 1;
            $validatedData['user_id'] = $authUser->id;
        }

        // Prepare the data for the new item
        $data = [
            'job_id' => $validatedData['job_id'],
            'date' => isset($validatedData['date']) ? date('Y-m-d', strtotime($validatedData['date'])) : null,
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'break' => $validatedData['break'] ?? false,
            'note' => $validatedData['note'] ?? null,
        ];

        if ($authUser->group == 6) {
            $data['user_id'] = $validatedData['user_id'];
            $data['status'] = $validatedData['status'];
        } else {
            $data['user_id'] = $authUser->id;
            $data['status'] = 1;
        }

        $user = User::find($data['user_id']);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $data['hourly_rate'] = $user->hourly_rate;
        $data['time_worked'] = $this->timeService->calculateTimeWorked($data['start_time'], $data['end_time'], $data['break']);
        $data['amount'] = $data['time_worked'] * $data['hourly_rate'];

        // Create and save the new timesheet
        $timesheet = Timesheet::create($data);

        return response()->json(['message' => 'Timesheet created successfully', 'timesheet' => $timesheet], 201);
    }


    /**
     * Update the specified timesheet in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $authUser = auth()->user();

        $timesheet = Timesheet::find($id);
        if (!$timesheet) {
            return response()->json(['message' => 'Timesheet not found'], 404);
        }

        $rules = [
            'job_id' => 'required|integer',
            'date' => 'required|date',
            'start_time' => 'required|string|max:8',
            'end_time' => 'required|string|max:8',
            'break' => 'nullable|boolean',
            'note' => 'nullable|string',
        ];

        if ($authUser->group == 6) {
            $rules['user_id'] = 'required|integer';
            $rules['status'] = 'required|integer';
        }

        $validatedData = $request->validate($rules);

        if ($request->has('date')) {
            $validatedData['date'] = date('Y-m-d', strtotime($validatedData['date']));
        }

        $data = array_filter([
            'job_id' => $validatedData['job_id'] ?? null,
            'date' => isset($validatedData['date']) ? date('Y-m-d', strtotime($validatedData['date'])) : null,
            'start_time' => $validatedData['start_time'] ?? null,
            'end_time' => $validatedData['end_time'] ?? null,
            'break' => $validatedData['break'] ?? false,
            'note' => $validatedData['note'] ?? null,
        ]);

        if ($request->has('break')) {
            $data['break'] = $validatedData['break'];
        }

        if ($authUser->group == 6) {
            $data['user_id'] = $validatedData['user_id'];
            $data['status'] = $validatedData['status'];
        }

        $userId = $authUser->group == 6 ? $validatedData['user_id'] : $authUser->id;

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $data['hourly_rate'] = $user->hourly_rate;
        $data['time_worked'] = $this->timeService->calculateTimeWorked($data['start_time'], $data['end_time'], $data['break']);
        $data['amount'] = $data['time_worked'] * $data['hourly_rate'];

        $timesheet->update($data);

        return response()->json(['message' => 'Timesheet updated successfully', 'timesheet' => $timesheet, 'data' => $data]);
    }


    /**
     * Activate the specified timesheet in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $timesheet = Timesheet::find($id);

        if (!$timesheet) {
            return response()->json(['message' => 'Timesheet not found'], 404);
        }

        $timesheet->update(['status' => 2]);

        return response()->json(['message' => 'Timesheet approved successfully'], 200);
    }


    /**
     * Deactivate the specified timesheet in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function unapprove($id)
    {
        $timesheet = Timesheet::find($id);

        if (!$timesheet) {
            return response()->json(['message' => 'Timesheet not found'], 404);
        }

        $timesheet->update(['status' => 1]);

        return response()->json(['message' => 'Timesheet unapproved successfully'], 200);
    }


    /**
     * Remove the specified timesheet from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $timesheet = Timesheet::find($id);

        if (!$timesheet) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        $timesheet->delete();

        return response()->json(['message' => 'Job deleted successfully'], 200);
    }
}

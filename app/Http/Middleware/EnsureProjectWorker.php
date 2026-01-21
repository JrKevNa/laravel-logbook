<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureProjectWorker
{
    public function handle(Request $request, Closure $next): Response
    {
        $projectId = $request->route('id'); // get {id} from route
        $userId = Auth::id();
        
        $project = Project::where('id', $projectId)
            ->whereHas('workers', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            })
            ->first();

        if (!$project) {
            abort(403, 'You are not assigned to this project.');
        }

        return $next($request);
    }
}
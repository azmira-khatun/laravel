<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class HasManyThroughController extends Controller
{
    public function index()
    {
        $applications = Application::with('environments.deployments')->get();

        return view('deployments.index', compact('applications'));
    }

    public function showDeployments($applicationId)
    {
        $application = Application::findOrFail($applicationId);

        $deployments = $application->deployments()->get();

        return view('deployments.list', [
            'applicationName' => $application->name,
            'deployments' => $deployments,
        ]);
    }

    public function listAllApplicationsWithDeployments()
    {
        $applications = Application::with('deployments')->get();

        return view('applications.list_all', [
            'applications' => $applications,
        ]);
    }
}

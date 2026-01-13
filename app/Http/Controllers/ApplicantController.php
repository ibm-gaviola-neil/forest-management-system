<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function index()
    {
        return view('Pages.Applicant.index');
    }

    public function chainsaw()
    {
        return view('Pages.Applicant.chainsaw-registration.create');
    }

    public function cutting()
    {
        return view('Pages.Applicant.cutting-permit.index');
    }

    public function permit()
    {
        return view('Pages.Applicant.permit-status.index');
    }

    public function requirements()
    {
        return view('Pages.Applicant.requirements.index');
    }

    public function treeRegistration()
    {
        return view('Pages.Applicant.tree-registration.create');
    }

    public function settings()
    {
        return view('Pages.Applicant.settings.index');
    }
}

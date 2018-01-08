<?php

namespace App\Http\Controllers;

use App\Interfaces\EmployeesInterface;
use Illuminate\Http\Request;
use App\Models\Employee;

class HomeController extends Controller {

    /**
     * Show home screen.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EmployeesInterface $employeesService) {

        $employees = Employee::paginate(5);
        return view('index', compact('employees'));
    }

}

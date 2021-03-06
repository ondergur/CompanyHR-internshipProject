<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;
use App\Exports\EmployeesExport;
use App\Http\Requests\EmployeeFormRequest;
use function foo\func;
use Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $company_names = DB::table('companies')->pluck('name', 'id');
        $employees = $this->filterData($request)
            ->paginate(12);

        return view('employee.index',
            compact('employees', 'company_names'));
    }

    public function datatable()
    {
        return view('employee.datatable', [
            'company_names' => DB::table('companies')->pluck('name', 'id'),
        ]);
    }

    public function getdata(Request $request)
    {
        $employees = $this->filterData($request);
        return DataTables::of($employees)
            ->addColumn('action', function ($user) {
                return '<a href="'.route('employees.edit', $user).'" class="btn btn-xs btn-primary"> Edit</a>'.
                    Form::open([ 'method' => 'delete', 'route' => ['employees.destroy', $user]]).
                    Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-xs btn-danger']).
                    Form::close();
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function filterData(Request $request)
    {
        return Employee::with('company')
            ->when($request->filled('namefilter'), function ($query) use ($request) {
                $query->where('name', 'LIKE', "%{$request->input('namefilter')}%");
            })
            ->when($request->filled('lastnamefilter'), function ($query) use ($request) {
                $query->where('lastname', 'LIKE', "%{$request->input('lastnamefilter')}%");
            })
            ->when($request->filled('emailfilter'), function ($query) use ($request) {
                $query->where('email', 'LIKE', "%{$request->input('emailfilter')}%");
            })
            ->when($request->filled('phonefilter'), function ($query) use ($request) {
                $query->where('phone', 'LIKE', "%{$request->input('phonefilter')}%");
            })
            ->when($request->filled('companyfilter'), function ($query) use ($request) {
                $query->where('companyid', "{$request->input('companyfilter')}");
            });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->form(new Employee);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeFormRequest $request)
    {
        $this->saveEmployee($request, new Employee);
        return redirect('/employees/');
    }

    /**
     * Display the specified resource.
     *
     * @param Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return view('employee.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return $this->form($employee);
    }

    private function form(Employee $employee)
    {
        if ($employee->exists) {
            $route = ['employees.update', $employee->id];
            $method = 'put';

        } else {
            $route = ['employees.store'];
            $method = 'post';
        }

        $companies = Company::all();
        $company_names = [];
        foreach ($companies as $company) {
            $company_names[$company->id] = $company->name;
        }

        return view('employee.form', compact('employee', 'route', 'method', 'company_names'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmployeeFormRequest $request
     * @param Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeFormRequest $request, Employee $employee)
    {
        $this->saveEmployee($request, $employee);

        return redirect()->route('employees.index');
    }

    private function saveEmployee(Request $request, Employee $employee)
    {
        $attributes = $request->all();
        $employee->fill($attributes);
        $employee->save();

        return $employee;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Employee $employee
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index');
    }

    public function export(Request $request)
    {
        return \Excel::download(new EmployeesExport, 'employeesexcel.xlsx');
    }

}


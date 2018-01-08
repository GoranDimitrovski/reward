<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Company;
use App\Interfaces\EmployeesInterface;
use GuzzleHttp;
use Validator;
use DB;
use StringHelper;

class EmployeesService implements EmployeesInterface {

    private $employeeInsertRules = [
        'uuid' => 'required',
        'bio' => 'required',
        'name' => 'required',
        'company' => 'required',
        'title' => 'required',
        'avatar' => 'required|image_or_url'
    ];

    public function fetchEmployeeData() {
        try {

            $client = new GuzzleHttp\Client();
            $response = $client->get('http://hiring.rewardgateway.net/list', ['auth' => ['hard', 'hard']]);

            $employees = json_decode($response->getBody());
            $this->saveEmployees($employees);
        } catch (\Exception $e) {
            \Log::error($e);
        }
    }

    private function saveEmployees($employees) {
        foreach ($employees as $employee) {

            $validator = Validator::make((array) $employee, $this->employeeInsertRules);

            if (!$validator->fails()) {

                try {

                    DB::beginTransaction();

                    $e = Employee::where('uuid', $employee->uuid)->first();

                    $companyId = $this->getCompanyId(StringHelper::stripXSS($employee->company));

                    if (is_null($e)) {
                        Employee::create([
                            'uuid' => StringHelper::stripXSS($employee->uuid),
                            'bio' => StringHelper::stripXSS($employee->bio),
                            'name' => StringHelper::stripXSS($employee->name),
                            'company_id' => $companyId,
                            'title' => StringHelper::stripXSS($employee->title),
                            'avatar' => $employee->avatar == '0' ? '' : StringHelper::stripXSS($employee->avatar),
                        ]);
                    } else {
                        $e->bio = StringHelper::stripXSS($employee->bio);
                        $e->name = StringHelper::stripXSS($employee->name);
                        $e->company_id = $companyId;
                        $e->title = StringHelper::stripXSS($employee->title);
                        $e->avatar = $employee->avatar == '0' ? '' : StringHelper::stripXSS($employee->avatar);
                        $e->save();
                    }

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    \Log::error($e);
                }
            }
        }
    }

    private function getCompanyId($name) {
        $company = Company::where('name', $name)->first();

        if (is_null($company)) {
            $company = Company::create(['name' => $name]);
        }

        return $company->id;
    }

}

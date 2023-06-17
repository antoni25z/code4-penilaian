<?php

namespace App\Controllers;

use App\Models\AspectModel;
use App\Models\AttendanceModel;
use App\Models\CriteriaModel;
use App\Models\DeptModel;
use App\Models\EmployeeModel;
use App\Models\ResultRatingModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Config\Database;

class MyApi extends BaseController
{
    use ResponseTrait;

    public function login()
    {
        $username = $this->request->getPost('username');
        $current_password = $this->request->getPost('password');

        $user_model = new UserModel();
        $checkUsername = $user_model->where('username', $username)->first();

        $password = $checkUsername['password'];

        if (!$checkUsername) {
            $response = [
                'error' => true,
                'message' => 'Karyawan Belum Terdaftar'
            ];
        } else {
            if ($current_password == $password) {
                $response = [
                    'error' => false,
                    'message' => 'Login Berhasil',
                    'user' => $checkUsername
                ];
            } else {
                $response = [
                    'error' => true,
                    'message' => 'Kata Sandi Salah'
                ];
            }
        }

        return $this->respond($response);
    }

    public function getEmployees($employee_name = null)
    {
        $employee_model = new EmployeeModel();
        $dept_model = new DeptModel();

        if (empty($employee_name)) {
            $employee = $employee_model->findAll();
        } else {
            $db = Database::connect();
            $employee = $db->table("employee")
                ->like('fname', $employee_name)
                ->orLike('lname', $employee_name)
                ->get()
                ->getResult();
        }

        $results = [];

        foreach ($employee as $item) {
            $dept = $dept_model->find($item['id']);

            $results = [
                'id' => 0,
                'fname' => $item['fname'],
                'lname' => $item['lname'],
                'email' => $item['email'],
                'sex' => $item['sex'],
                'birth_place' => $item['birth_place'],
                'birth_date' => $item['birth_date'],
                'join_date' => $item['join_date'],
                'dept' => [
                    'id' => $dept['id'],
                    'dept_name' => $dept['dept_name'],
                ],
                'address' => $item['address'],
                'promoted' => intval($item['promoted'])
            ];
        }

        $response = [
            'error' => false,
            'message' => 'get all employee success',
            'employee' => $results
        ];

        return $this->respond($response);
    }

    public function getDept()
    {
        $dept_model = new DeptModel();

        $dept = $dept_model->findAll();

        $response = [
            'error' => false,
            'message' => 'Berhasil mengambil semua departemen',
            'dept' => $dept
        ];

        return $this->respond($response);
    }

    public function deleteEmployee($id = null)
    {
        $employee_model = new EmployeeModel();
        $delete = $employee_model->delete($id);

        if ($delete) {
            $response = [
                'error' => false,
                'message' => 'Karyawan berhasil di hapus'
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'Karyawan gagal di hapus'
            ];
        }
        return $this->respond($response);
    }

    public function updateEmployee($id = null)
    {
        $employee_model = new EmployeeModel();
        $user_model = new UserModel();

        $fname = $this->request->getPost('fname');
        $lname = $this->request->getPost('lname');
        $email = $this->request->getPost('email');
        $sex = $this->request->getPost('sex');
        $birth_place = $this->request->getPost('birth_place');
        $birth_date = $this->request->getPost('birth_date');
        $join_date = $this->request->getPost('join_date');
        $dept_id = $this->request->getPost('dept_id');
        $address = $this->request->getPost('address');
        $promoted = $this->request->getPost('promoted');
        $password = $this->request->getPost('password');
        $username = $this->request->getPost('username');

        $data = [
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'sex' => $sex,
            'birth_place' => $birth_place,
            'birth_date' => $birth_date,
            'join_date' => $join_date,
            'dept_id' => $dept_id,
            'address' => $address,
            'promoted' => $promoted
        ];

        $user_data = [
            'username' => $username,
            'password' => $password,
            'type' => 1,
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'sex' => $sex,
            'birth_place' => $birth_place,
            'birth_date' => $birth_date,
            'dept_id' => $dept_id,
            'address' => $address,
        ];

        $update_user = $user_model->update($id, $user_data);

        if ($update_user) {
            $update_employee = $employee_model->update($id, $data);
            if ($update_employee) {
                $response = [
                    'error' => false,
                    'message' => 'Update Karyawan Berhasil'
                ];
            } else {
                $response = [
                    'error' => true,
                    'message' => 'Update Karyawan Gagal'
                ];
            }
        } else {
            $response = [
                'error' => true,
                'message' => 'Update User Gagal'
            ];
        }

        return $this->respond($response);
    }

    public function addEmployee()
    {
        $id = $this->request->getPost('id');
        $fname = $this->request->getPost('fname');
        $lname = $this->request->getPost('lname');
        $email = $this->request->getPost('email');
        $sex = $this->request->getPost('sex');
        $birth_place = $this->request->getPost('birth_place');
        $birth_date = $this->request->getPost('birth_date');
        $join_date = $this->request->getPost('join_date');
        $dept_id = $this->request->getPost('dept_id');
        $address = $this->request->getPost('address');
        $promoted = $this->request->getPost('promoted');
        $password = $this->request->getPost('password');
        $username = $this->request->getPost('username');

        $data = [
            'id' => $id,
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'sex' => $sex,
            'birth_place' => $birth_place,
            'birth_date' => $birth_date,
            'join_date' => $join_date,
            'dept_id' => $dept_id,
            'address' => $address,
            'promoted' => $promoted
        ];

        $user_data = [
            'id' => $id,
            'username' => $username,
            'password' => $password,
            'type' => 1,
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'sex' => $sex,
            'birth_place' => $birth_place,
            'birth_date' => $birth_date,
            'dept_id' => $dept_id,
            'address' => $address,
        ];

        $user_model = new UserModel();
        $checkUsername = $user_model->where('username', $username)->first();

        $employee_model = new EmployeeModel();

        $add_user = $user_model->insert($user_data);

        if ($checkUsername) {
            $response = [
                'error' => true,
                'message' => 'Karyawan Sudah Terdaftar'
            ];
        } else {
            if ($add_user) {
                $add = $employee_model->insert($data);
                if ($add) {
                    $response = [
                        'error' => false,
                        'message' => 'Karyawan berhasil ditambahkan'
                    ];
                } else {
                    $response = [
                        'error' => true,
                        'message' => 'Karyawan gagal ditambahkan'
                    ];
                }
            } else {
                $response = [
                    'error' => true,
                    'message' => 'User gagal ditambahkan'
                ];
            }
        }

        return $this->respond($response);
    }

    public function getAspects() {
        $aspect_model = new AspectModel();
        $criteria_model = new CriteriaModel();

        $aspect = $aspect_model->findAll();

        $results = [];
        foreach ($aspect as $item) {
            $criteria = $criteria_model->where("aspect_id", $item['id'])->findAll();
            $results = [
                'id' => $item['id'],
                'name' => $item['name'],
                'core_weight' => $item['core_weight'],
                'secondary_weight' => $item['secondary_weight'],
                'weight' => $item['weight'],
                'criteria' => $criteria
            ];
        }

        $response = [
            'error' => true,
            'message' => 'Pengambilan aspek dan kriteria',
            'results' => $results
        ];

        return $this->respond($response);
    }

    public function addResultRating() {
        $result_model = new ResultRatingModel();

        $employee_id = $this->request->getPost('employee_id');
        $month = $this->request->getPost('month');
        $year = $this->request->getPost('year');
        $result = $this->request->getPost('result');

        $data = [
          "employee_id" => $employee_id,
          "month" => $month,
          "year" => $year,
          "result" => $result
        ];

        $add = $result_model->insert($data);

        if ($add) {
            $response = [
                'error' => false,
                'message' => 'Penilaian Berhasil'
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'Penilaian Gagal'
            ];
        }
        return $this->respond($response);
    }

    public function addAttendance() {
        $attendance_model = new AttendanceModel();

        $employee_id = $this->request->getPost("employee_id");
        $alpha = $this->request->getPost("alpha");
        $permit = $this->request->getPost("permit");
        $sick = $this->request->getPost("sick");
        $month = $this->request->getPost("month");
        $year = $this->request->getPost("year");

        $data = [
            "employee_id" => $employee_id,
            "alpha" => $alpha,
            "permit" => $permit,
            "sick" => $sick,
            "month" => $month,
            "year" => $year
        ];

        $add = $attendance_model->insert($data);
        if ($add) {
            $response = [
                'error' => false,
                'message' => 'Absen Berhasil'
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'Absen Gagal'
            ];
        }
        return $this->respond($response);
    }

    public function getAttendances() {
        $employee_model = new EmployeeModel();
        $attendance_model = new AttendanceModel();

        $attendance = $attendance_model->findAll();

        $attendances = [];
        $permit = 0;
        $sick = 0;
        $alpha = 0;

        foreach ($attendance as $item) {
            $employee = $employee_model->find($item['employee_id']);

            $permit += $item['permit'];
            $sick += $item['sick'];
            $alpha += $item['alpha'];

            $attendances = [
                'id'=> $item['id'],
                'employee'=> [
                    'id' => $employee['id'],
                    'employee_name' => $employee['fname'] ." ". $employee['lname']
                ],
                'permit'=> $permit,
                'alpha'=> $sick,
                'sick'=> $alpha,
            ];
        }

        $response = [
            'error' => false,
            'message' => 'Berhasil mengambil semua aspek',
            'attendance' => $attendances
        ];

        return $this->respond($response);
    }

    public function addAspect() {
        $aspect_model = new AspectModel();

        $name = $this->request->getPost("name");
        $core_weight = $this->request->getPost("core_weight");
        $secondary_weight = $this->request->getPost("secondary_weight");
        $weight = $this->request->getPost("weight");

        $data = [
            "name" => $name,
            "core_weight" => $core_weight,
            "secondary_weight" => $secondary_weight,
            "weight" => $weight
        ];

        $add = $aspect_model->insert($data);
        if ($add) {
            $response = [
                'error' => false,
                'message' => 'Penambahan Aspek Berhasil'
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'Penambahan Aspek Gagal'
            ];
        }
        return $this->respond($response);
    }

    public function updateAspect($id = null) {
        $aspect_model = new AspectModel();

        $name = $this->request->getPost("name");
        $core_weight = $this->request->getPost("core_weight");
        $secondary_weight = $this->request->getPost("secondary_weight");
        $weight = $this->request->getPost("weight");

        $data = [
            "name" => $name,
            "core_weight" => $core_weight,
            "secondary_weight" => $secondary_weight,
            "weight" => $weight
        ];

        $add = $aspect_model->update($id, $data);
        if ($add) {
            $response = [
                'error' => false,
                'message' => 'Perubahan Aspek Berhasil'
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'Perubahan Aspek Gagal'
            ];
        }
        return $this->respond($response);
    }

    public function deleteAspect($id = null) {
        $aspect_model = new AspectModel();

        $add = $aspect_model->delete($id);
        if ($add) {
            $response = [
                'error' => false,
                'message' => 'Perubahan Aspek Berhasil'
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'Perubahan Aspek Gagal'
            ];
        }
        return $this->respond($response);
    }

    public function getAllAspects() {
        $aspect_model = new AspectModel();

        $aspect = $aspect_model->findAll();

        $response = [
            'error' => false,
            'message' => 'Berhasil mengambil semua aspek',
            'aspects' => $aspect
        ];

        return $this->respond($response);
    }

    public function addCriteria() {
        $criteria_model = new CriteriaModel();

        $name = $this->request->getPost("name");
        $type = $this->request->getPost("type");
        $target = $this->request->getPost("target");
        $aspect_id = $this->request->getPost("aspect_id");
        $dept_id = $this->request->getPost("dept_id");

        $data = [
            "name" => $name,
            "type" => $type,
            "target" => $target,
            "aspect_id" => $aspect_id,
            "dept_id" => $dept_id
        ];

        $add = $criteria_model->insert($data);
        if ($add) {
            $response = [
                'error' => false,
                'message' => 'Penambahan Kriteria Berhasil'
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'Penambahan Kriteria Gagal'
            ];
        }
        return $this->respond($response);
    }

    public function updateCriteria($id = null) {
        $criteria_model = new CriteriaModel();

        $name = $this->request->getPost("name");
        $type = $this->request->getPost("type");
        $target = $this->request->getPost("target");
        $aspect_id = $this->request->getPost("aspect_id");
        $dept_id = $this->request->getPost("dept_id");

        $data = [
            "name" => $name,
            "type" => $type,
            "target" => $target,
            "aspect_id" => $aspect_id,
            "dept_id" => $dept_id
        ];

        $add = $criteria_model->update($id, $data);
        if ($add) {
            $response = [
                'error' => false,
                'message' => 'Perubahan Kriteria Berhasil'
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'Perubahan Kriteria Gagal'
            ];
        }
        return $this->respond($response);
    }

    public function deleteCriteria($id = null) {
        $criteria_model = new CriteriaModel();

        $add = $criteria_model->delete($id);
        if ($add) {
            $response = [
                'error' => false,
                'message' => 'Perubahan Kriteria Berhasil'
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'Perubahan Kriteria Gagal'
            ];
        }
        return $this->respond($response);
    }

    public function getAllCriterias() {
        $criteria_model = new CriteriaModel();
        $aspect_model = new AspectModel();

        $criteria = $criteria_model->findAll();

        $result = [];
        foreach ($criteria as $item) {
            $aspect = $aspect_model->find($item['aspect_id']);

            $result = [
                'id' => $item['id'],
                'name' => $item['name'],
                'type' => $item['type'],
                'target' => $item['target'],
                'aspect_detail' => [
                    "id" => $aspect['id'],
                    "name" => $aspect['name']
                ],
            ];
        }

        $response = [
            'error' => false,
            'message' => 'Berhasil mengambil semua kriteria',
            'aspects' => $result
        ];

        return $this->respond($response);
    }

    public function getResultRating() {
        $db = Database::connect();

        $start_month = $this->request->getGet('start_month'); //2
        $start_year = $this->request->getGet('start_year'); //2023
        $end_month = $this->request->getGet('end_month'); // 6
        $end_year = $this->request->getGet('end_year'); // 2024

        $employee_model = new EmployeeModel();

        $permit = 0;
        $alpha = 0;
        $sick = 0;

        $data = [];

        if ($start_year == $end_year) {

            $sameYearResult = $db->table("result_rating")
                ->where('year', $start_year)
                ->where('month >= ', $start_month)
                ->where('month <= ', $end_month)
                ->get()
                ->getResult();

            if (!empty($sameYearResult)) {
                foreach ($sameYearResult as $item) {
                    $employee = $employee_model->find($item['employee_id']);

                    $sameYearAtt = $db->table("attendance")
                        ->where('employee_id', $item['employee_id'])
                        ->where('year', $start_year)
                        ->where('month >= ', $start_month)
                        ->where('month <= ', $end_month)
                        ->get()
                        ->getResult();
                    if (!empty($sameYearAtt)) {
                        foreach ($sameYearAtt as $items) {
                            $permit += $items['permit'];
                            $alpha += $items['alpha'];
                            $sick += $items['sick'];
                        }
                    }

                    $data = [
                        "id" => $item['id'],
                        "employee_detail" => [
                            "id" => $employee['id'],
                            "employee_name" => $employee['fname'] ." ". $employee['lname']
                        ],
                        "result" => $item['result'],
                        "permit" => $permit,
                        "alpha" => $alpha,
                        "sick" => $sick
                    ];
                }
            }
        } else {
            $startYearResult = $db->table("result_rating")
                ->where('year', $start_year)
                ->where('month >= ', $start_month)
                ->get()
                ->getResult();

            $endYearResult = $db->table("result_rating")
                ->where('year', $end_year)
                ->where('month <= ', $end_month)
                ->get()
                ->getResult();



            $results = array_merge($startYearResult, $endYearResult);

            if (!empty($results)) {
                foreach ($results as $item) {
                    $employee = $employee_model->find($item['employee_id']);

                    $startYearAtt = $db->table("attendance")
                        ->where('employee_id', $item['employee_id'])
                        ->where('year', $start_year)
                        ->where('month >= ', $start_month)
                        ->where('month <= ', $end_month)
                        ->get()
                        ->getResult();

                    $endYearAtt = $db->table("attendance")
                        ->where('employee_id', $item['employee_id'])
                        ->where('month >= ', $start_month)
                        ->where('month <= ', $end_month)
                        ->get()
                        ->getResult();
                    $att = array_merge($startYearAtt, $endYearAtt);

                    if (!empty($att)) {
                        foreach ($att as $items) {
                            $permit += $items['permit'];
                            $alpha += $items['alpha'];
                            $sick += $items['sick'];
                        }
                    }

                    $data = [
                        "id" => $item['id'],
                        "employee_detail" => [
                            "id" => $employee['id'],
                            "employee_name" => $employee['fname'] ." ". $employee['lname']
                        ],
                        "result" => $item['result'],
                        "permit" => $permit,
                        "alpha" => $alpha,
                        "sick" => $sick
                    ];
                }
            }
        }
        $response = [
            'error' => false,
            'message' => 'Berhasil mengambil semua result',
            'data' => $data
        ];
        return $this->respond($response);
    }
}
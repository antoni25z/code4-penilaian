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
        $dept_model = new DeptModel();
        $checkUsername = $user_model->where('username', $username)->first();

        if (!$checkUsername) {
            $response = [
                'error' => true,
                'message' => 'Karyawan Belum Terdaftar',
                'user' => [
                    "id" => -0,
                    "username" => "",
                    "type" => -0,
                    "dept" => ""
                ]
            ];
        } else {
            $password = $checkUsername['password'];
            if ($current_password == $password) {

                $dept = $dept_model->find($checkUsername['dept_id']);

                $results = [
                    'id' => (int)$checkUsername['id'],
                    'username' => $checkUsername['username'],
                    'type' => (int)$checkUsername['type'],
                    'dept' => $dept['dept_name'],
                ];

                $response = [
                    'error' => false,
                    'message' => 'Login Berhasil',
                    'user' => $results
                ];
            } else {
                $response = [
                    'error' => true,
                    'message' => 'Kata Sandi Salah',
                    'user' => [
                        "id" => -0,
                        "username" => "",
                        "type" => -0,
                        "dept" => ""
                    ]
                ];
            }
        }

        return $this->respond($response);
    }

    public function resetPassword()
    {

        $username = $this->request->getPost('username');
        $old_pass = $this->request->getPost('old_password');
        $new_pass = $this->request->getPost('new_password');

        $user_model = new UserModel();

        $old = $user_model->where("username", $username)->where("password", $old_pass)->findAll();

        if ($old) {
            $data = [
                "password" => $new_pass
            ];
            $getId = $user_model->where("username", $username)->first();
            $new = $user_model->update($getId['id'],$data);

            if ($new) {
                $response = [
                    'error' => true,
                    'message' => 'Perubahan Kata Sandi Berhasil'
                ];
            } else {
                $response = [
                    'error' => true,
                    'message' => 'Perubahan Kata Sandi Gagal'
                ];
            }
        } else {
            $response = [
                'error' => true,
                'message' => 'Kata sandi lama salah'
            ];
        }
        return $this->respond($response);
    }

    public function getEmployees()
    {
        $employee_model = new EmployeeModel();
        $dept_model = new DeptModel();
        $user_model = new UserModel();

        $employee_name = $this->request->getGet('name');

        if (empty($employee_name)) {
            $employee = $employee_model->orderBy('id', 'DESC')->findAll();
        } else {
            $db = Database::connect();
            $employee = $db->table("employee")
                ->like('fname', $employee_name)
                ->orLike('lname', $employee_name)
                ->orderBy('id', 'DESC')
                ->get()->getResultArray();
        }

        $results = [];

        foreach ($employee as $item) {
            $dept = $dept_model->find($item['dept_id']);
            $user = $user_model->find($item['id']);

            $results[] = [
                'id' => (int)$item['id'],
                'fname' => $item['fname'],
                'lname' => $item['lname'],
                'email' => $item['email'],
                'sex' => $item['sex'],
                'birth_place' => $item['birth_place'],
                'birth_date' => $item['birth_date'],
                'join_date' => $item['join_date'],
                'dept' => [
                    'id' => (int)$dept['id'],
                    'dept_name' => $dept['dept_name'],
                ],
                'address' => $item['address'],
                'promoted' => intval($item['promoted']),
                'username' => $user['username'],
                'password' => $user['password']
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

        $result = [];

        foreach ($dept as $item) {
            $result[] = [
                "id" => (int)$item['id'],
                "dept_name" => $item['dept_name']
            ];
        }

        $response = [
            'error' => false,
            'message' => 'Berhasil mengambil semua departemen',
            'dept' => $result
        ];

        return $this->respond($response);
    }

    public function deleteEmployee($id = null)
    {
        $employee_model = new EmployeeModel();
        $user_model = new UserModel();
        $delete = $employee_model->delete($id);
        if ($delete) {
            $user_model->delete($id);
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
        $dept_id = (int)$this->request->getPost('dept_id');
        $address = $this->request->getPost('address');
        $promoted = (int)$this->request->getPost('promoted');
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
            'type' => 0,
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
        $id = (int)$this->request->getPost('id');
        $fname = $this->request->getPost('fname');
        $lname = $this->request->getPost('lname');
        $email = $this->request->getPost('email');
        $sex = $this->request->getPost('sex');
        $birth_place = $this->request->getPost('birth_place');
        $birth_date = $this->request->getPost('birth_date');
        $join_date = $this->request->getPost('join_date');
        $dept_id = (int)$this->request->getPost('dept_id');
        $address = $this->request->getPost('address');
        $promoted = (int)$this->request->getPost('promoted');
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
            'type' => 0,
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


        if ($checkUsername) {
            $response = [
                'error' => true,
                'message' => 'Karyawan Sudah Terdaftar'
            ];
        } else {
            $add_user = $user_model->insert($user_data);
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

    public function getAspects()
    {
        $aspect_model = new AspectModel();
        $criteria_model = new CriteriaModel();

        $aspect = $aspect_model->findAll();

        $results = [];

        foreach ($aspect as $item) {
            $criteria = $criteria_model->where("aspect_id", $item['id'])->findAll();
            $criterias = [];
            foreach ($criteria as $t) {
                $criterias[] = [
                    "id" => (int)$t['id'],
                    "name" => $t['name'],
                    "type" => (int)$t['type'],
                    "target" => (int)$t['target'],
                    "aspect_id" => (int)$t['aspect_id'],
                    "dept_id" => (int)$t['dept_id']
                ];
            }

            $results[] = [
                'id' => (int)$item['id'],
                'name' => $item['name'],
                'core_weight' => (int)$item['core_weight'],
                'secondary_weight' => (int)$item['secondary_weight'],
                'weight' => (int)$item['weight'],
                'criteria' => $criterias
            ];
        }

        $response = [
            'error' => true,
            'message' => 'Pengambilan aspek dan kriteria',
            'results' => $results
        ];

        return $this->respond($response);
    }

    public function addResultRating()
    {
        $result_model = new ResultRatingModel();

        $employee_id = (int)$this->request->getPost('employee_id');
        $month = (int)$this->request->getPost('month');
        $year = (int)$this->request->getPost('year');
        $result = (double)$this->request->getPost('result');

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

    public function addAttendance()
    {
        $attendance_model = new AttendanceModel();

        $employee_id = (int)$this->request->getPost("employee_id");
        $alpha = (int)$this->request->getPost("alpha");
        $permit = (int)$this->request->getPost("permit");
        $sick = (int)$this->request->getPost("sick");
        $month = (int)$this->request->getPost("month");
        $year = (int)$this->request->getPost("year");

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

    public function getAttendances()
    {
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

            $attendances[] = [
                'id' => $item['id'],
                'employee' => [
                    'id' => $employee['id'],
                    'employee_name' => $employee['fname'] . " " . $employee['lname']
                ],
                'permit' => $permit,
                'alpha' => $sick,
                'sick' => $alpha,
            ];
        }

        $response = [
            'error' => false,
            'message' => 'Berhasil mengambil semua aspek',
            'attendance' => $attendances
        ];

        return $this->respond($response);
    }

    public function addAspect()
    {
        $aspect_model = new AspectModel();

        $name = $this->request->getPost("name");
        $core_weight = (int)$this->request->getPost("core_weight");
        $secondary_weight = (int)$this->request->getPost("secondary_weight");
        $weight = (int)$this->request->getPost("weight");

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

    public function updateAspect($id = null)
    {
        $aspect_model = new AspectModel();

        $name = $this->request->getPost("name");
        $core_weight = (int)$this->request->getPost("core_weight");
        $secondary_weight = (int)$this->request->getPost("secondary_weight");
        $weight = (int)$this->request->getPost("weight");

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

    public function deleteAspect($id = null)
    {
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

    public function getAllAspects()
    {
        $aspect_model = new AspectModel();

        $aspect = $aspect_model->orderBy('id', 'DESC')->findAll();

        $aspects = [];

        foreach ($aspect as $item) {
            $aspects[] = [
                "id" => (int) $item['id'],
                "name" => $item['name'],
                "core_weight" => (int) $item['core_weight'],
                "secondary_weight" => (int) $item['secondary_weight'],
                "weight" => (int) $item['weight'],
            ];
        }

        $response = [
            'error' => false,
            'message' => 'Berhasil mengambil semua aspek',
            'aspects' => $aspects
        ];

        return $this->respond($response);
    }

    public function addCriteria()
    {
        $criteria_model = new CriteriaModel();

        $name = $this->request->getPost("name");
        $type = (int)$this->request->getPost("type");
        $target = (int)$this->request->getPost("target");
        $aspect_id = (int) $this->request->getPost("aspect_id");
        $dept_id = (int)$this->request->getPost("dept_id");

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

    public function updateCriteria($id = null)
    {
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

    public function deleteCriteria($id = null)
    {
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

    public function getAllCriterias()
    {
        $criteria_model = new CriteriaModel();
        $aspect_model = new AspectModel();

        $criteria = $criteria_model->orderBy('id', 'DESC')->findAll();

        $result = [];
        foreach ($criteria as $item) {
            $aspect = $aspect_model->find($item['aspect_id']);

            $result[] = [
                'id' => (int) $item['id'],
                'name' => $item['name'],
                'type' => (int)$item['type'],
                'target' => (int)$item['target'],
                'aspect_detail' => [
                    "id" => (int)$aspect['id'],
                    "name" => $aspect['name']
                ],
            ];
        }

        $response = [
            'error' => false,
            'message' => 'Berhasil mengambil semua kriteria',
            'criteria' => $result
        ];

        return $this->respond($response);
    }

    public function getResultRating()
    {

        $month = $this->request->getGet('month'); //2
        $year = $this->request->getGet('year'); //2023

        $employee_model = new EmployeeModel();
        $result_model = new ResultRatingModel();
        $att_model = new AttendanceModel();

        $permit = 0;
        $alpha = 0;
        $sick = 0;

        $data = [];

        if (empty($year)) {
            $yearResult = $result_model->orderBy('result', 'DESC')->findAll();
        } else {
            $yearResult = $result_model->where('year', $year)->where('month', $month)->orderBy('result', 'DESC')->findAll();
        }

        if (!empty($yearResult)) {
            foreach ($yearResult as $item) {
                $employee = $employee_model->find($item['employee_id']);

                $att = $att_model->where('employee_id', $item['employee_id'])->where('year', $year)->where('month', $month)->findAll();
                if (!empty($att)) {
                    foreach ($att as $items) {
                        $permit = (int)$items['permit'];
                        $alpha = (int)$items['alpha'];
                        $sick = (int)$items['sick'];
                    }
                } else {
                    $permit = 0;
                    $alpha = 0;
                    $sick = 0;
                }

                $data[] = [
                    "id" => (int)$item['id'],
                    "employee_detail" => [
                        "id" => (int)$employee['id'],
                        "employee_name" => $employee['fname'] . " " . $employee['lname']
                    ],
                    "result" => (double)$item['result'],
                    "permit" => $permit,
                    "alpha" => $alpha,
                    "sick" => $sick
                ];
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
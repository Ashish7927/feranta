<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\AdminModel;
use CodeIgniter\Files\File;

class ApiController extends ResourceController
{

    public function __construct()
    {
        $db = db_connect();
        $this->db = db_connect();

        $this->AdminModel = new AdminModel($db);
        $this->session = session();
        helper(['form', 'url', 'validation']);
    }

    public function index()
    {
        $response = [
            'status'   => 200,
            'error'    => null,
            'response' => [
                'message' => 'CodeIgniter-4, Rest-API working fine.'
            ],
        ];
        return $this->respondCreated($response);
    }


    public function masterData()
    {
        $department = $this->AdminModel->Department();
        $designation = $this->AdminModel->Designation();
        $City = $this->AdminModel->City();
        $Company = $this->AdminModel->Company();
        $Union = $this->AdminModel->Union();
        $Unionposition = $this->AdminModel->Unionposition();


        $response = [
            'status'   => 200,
            'error'    => null,
            'response' => [
                'message' => 'Here is the all master data',
                'department' => $department,
                'designation' => $designation,
                'city' => $City,
                'company' => $Company,
                'union' => $Union,
                'unionposition' => $Unionposition,

            ],
        ];

        return $this->respondCreated($response);
    }

    public function sendOtpForLogin()
    {
        $rules = [
            'phone' => 'required|numeric|exact_length[10]'
        ];

        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $phone = $this->request->getVar('phone');
            $data = $this->AdminModel->checkUserPahone($phone);
            if (empty($data) || $data == null) {
                $data_array = [
                    'full_name' => '',
                    'email' => '',
                    'contact_no' => $phone,
                    'status' => 1,
                    'user_type' => 5,
                ];

                $result = $this->AdminModel->adduser($data_array);
                $data = $this->AdminModel->checkUserPahone($phone);
            }

            if ($data[0]->status == 1) {
                //Send otp
                $otp = rand(100000, 999999);
                $updateotp = [
                    'otp' => $otp
                ];

                $data = $this->AdminModel->UpdateProfile($updateotp, $data[0]->id);


                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'response' => [
                        'message' => 'Otp send successfully!',
                        'otp' => $otp,
                    ],
                ];
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Your account is not Active, Please contact to Admin!'
                    ]
                ];
            }
        }

        return $this->respondCreated($response);
    }

    public function verifyOtpForLogin()
    {
        $rules = [
            'phone' => 'required|numeric|exact_length[10]',
            'entered_otp' => 'required|numeric|exact_length[6]',
        ];

        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $phone = $this->request->getVar('phone');
            $otp = $this->request->getVar('entered_otp');
            $data = $this->AdminModel->checkUserPahone($phone);
            if (!empty($data) && $data != null) {

                //verify otp
                $actuallOtp = $data[0]->otp;
                if ($otp == $actuallOtp) {

                    $profileStatus = 0;
                    if ($data[0]->password != NULL || $data[0]->password != '') {
                        $profileStatus = 1;
                    }

                    if ($data[0]->adhar_no != NULL || $data[0]->adhar_no != '') {
                        $profileStatus = 2;
                    }
                    $response = [
                        'status'   => 201,
                        'error'    => null,
                        'response' => [
                            'success' => 'OTP matched',
                            'userDetails' => $data,
                            'profile_status' => $profileStatus
                        ],
                    ];
                } else {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'Invalid OTP'
                        ]
                    ];
                }
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Enter Phone number is not registered'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function getServicePrice()
    {

        $rules = [
            'origin_lat' => 'required',
            'origin_lng' => 'required',
            'destination_lat' => 'required',
            'destination_lng' => 'required',
            'type' => 'required'
        ];

        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $origin_lat = $this->request->getVar('origin_lat');
            $origin_lng = $this->request->getVar('origin_lng');
            $destination_lat = $this->request->getVar('destination_lat');
            $destination_lng = $this->request->getVar('destination_lng');
            $type = $this->request->getVar('type');

            // $checkServicRate = $this->AdminModel->checkServicRate($origin->state_id, $vehicleDetails->type_id);
            // if (!empty($checkServicRate)) {
            // Set up API key and other parameters
            $apiKey = 'AIzaSyAX9w0uT7e_Ohjm_FHv7dHNOjvoFdeDe04';

            // Make API request
            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins={$origin_lat},{$origin_lng}&destinations={$destination_lat},{$destination_lng}&key={$apiKey}";

            $response = file_get_contents($url);

            // Parse API response
            $data = json_decode($response, true);

            // Check if response is successful
            if ($data['status'] == 'OK') {
                $distance = $data['rows'][0]['elements'][0]['distance']['value'];
                $km = round($distance / 1000);

                $state_id = 1;
                $serviceRateStatewise = $this->AdminModel->getRateStatewise($state_id);
                $result = array();
                foreach ($serviceRateStatewise as $rate) {
                    $type_name = $rate->type_name;

                    if ($type == 1) {
                        $rate = $rate->full_fare;
                        $price = $rate * $km;
                    } else {
                        $rate = $rate->fare_per_share;
                        $price = $rate * $km;
                    }

                    $result[] = array('type_name' => $type_name, 'fare_price' => $price, 'rate' => $rate);
                }

                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'response' => [
                        'message' => 'price fetch Successfully',
                        'data' => $result,
                        'distance' => $km . 'km'
                    ],
                ];
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => $data['error_message']
                    ]
                ];
            }
        }

        return $this->respondCreated($response);
    }

    public function sceduleService()
    {

        $rules = [
            'origin_lat' => 'required',
            'origin_lng' => 'required',
            'destination_lat' => 'required',
            'destination_lng' => 'required',
            'driver_id' => 'required',
            'boarding_datetime' => 'required',
        ];

        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $origin_lat = $this->request->getVar('origin_lat');
            $origin_lng = $this->request->getVar('origin_lng');
            $destination_lat = $this->request->getVar('destination_lat');
            $destination_lng = $this->request->getVar('destination_lng');
            $driver_id = $this->request->getVar('driver_id');
            $boarding_datetime = $this->request->getVar('boarding_datetime');
            $getVehicleId = $this->AdminModel->getVehicleDriverData($driver_id);

            if (empty($getVehicleId) || $getVehicleId ==  null) {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Not a valid driver'
                    ]
                ];
            } else {
                $checkServicRate = $this->AdminModel->checkServicRate(1, $getVehicleId->type_id);
                if (!empty($checkServicRate)) {
                    // Set up API key and other parameters
                    $apiKey = 'AIzaSyAX9w0uT7e_Ohjm_FHv7dHNOjvoFdeDe04';

                    // Make API request
                    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins={$origin_lat},{$origin_lng}&destinations={$destination_lat},{$destination_lng}&key={$apiKey}";

                    $response = file_get_contents($url);

                    // Parse API response
                    $data = json_decode($response, true);

                    // Check if response is successful
                    if ($data['status'] == 'OK') {
                        $distance = $data['rows'][0]['elements'][0]['distance']['value'];
                        $km = round($distance / 1000);

                        $full_fare = $km * $checkServicRate->full_fare;
                        $fare_per_sit = $km * $checkServicRate->fare_per_share;
                        $serviceRate = $checkServicRate->id;

                        $newTime = date("Y-m-d H:i:s", strtotime($boarding_datetime . " +30 minutes"));

                        $data = [
                            'vehicle_id' => $getVehicleId->vehicle_id,
                            'boarding_date' => $boarding_datetime,
                            'start_datetime' => $newTime,
                            'origin_lat' => $origin_lat,
                            'origin_lng' => $origin_lng,
                            'destination_lat' => $destination_lat,
                            'destination_lng' => $destination_lng,
                            'service_rate' => $serviceRate,
                            'full_fare' => $full_fare,
                            'fare_per_sit' => $fare_per_sit,
                            'driver_id' => $driver_id,
                            'status' => 1
                        ];

                        $id = $this->AdminModel->InsertServiceDetails($data);
                        $serviceDetails = $this->AdminModel->getSingleData('service_details', $id);
                        $response = [
                            'status'   => 201,
                            'error'    => null,
                            'response' => [
                                'message' => 'Service added successfully!',
                                'data' => $serviceDetails
                            ],
                        ];
                    } else {
                        $response = [
                            'status'   => 200,
                            'error'    => 1,
                            'response' => [
                                'message' => $data['error_message']
                            ]
                        ];
                    }
                } else {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'Service Not Availble'
                        ]
                    ];
                }
            }
        }

        return $this->respondCreated($response);
    }

    public function startService()
    {
        $rules = [
            'service_id' => 'required'
        ];

        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {

            $service_id = $this->request->getVar('service_id');
            $data = [
                'status' => 2
            ];

            $this->AdminModel->UpdateRecordById('service_details', $service_id, $data);
            $response = [
                'status'   => 200,
                'error'    => null,
                'response' => [
                    'success' => 'Service updated Successfully'
                ],
            ];
        }
        return $this->respondCreated($response);
    }

    public function sendLiveLocation()
    {
        $rules = [
            'driver_id' => 'required|numeric',
            'service_id' => 'required|numeric',
            'vehicle_id' => 'required|numeric',
            'lat' => 'required',
            'lng' => 'required',
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {

            $driver_id = $this->request->getVar('driver_id');
            $service_id = $this->request->getVar('service_id');
            $vehicle_id = $this->request->getVar('vehicle_id');
            $lat = $this->request->getVar('lat');
            $lng = $this->request->getVar('lng');
            $data = [
                'vehicle_id' => $vehicle_id,
                'driver_id' => $driver_id,
                'service_id' => $service_id,
                'lat' => $lat,
                'lng' => $lng,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->AdminModel->InsertRecord('vehicle_location_status', $data);

            $response = [
                'status'   => 200,
                'error'    => null,
                'response' => [
                    'success' => 'Live Status Updated Successfully'
                ],
            ];
        }

        return $this->respondCreated($response);
    }

    public function register()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'wp_no' => 'required|numeric|exact_length[10]|is_unique[user.contact_no]',
            'email' => 'required|is_unique[user.email]',
            'eis_no' => 'required|numeric|exact_length[8]|is_unique[user.eis_no]',
            'department_id' => 'required|numeric',
            'designation_id' => 'required|numeric',
            'area' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {

            $email = $this->request->getVar('email');
            $name = $this->request->getVar('name');
            $eis_no = $this->request->getVar('eis_no');
            $department_id = $this->request->getVar('department_id');
            $area = $this->request->getVar('area');
            $wp_no = $this->request->getVar('wp_no');
            $designation_id = $this->request->getVar('designation_id');

            $img = $this->request->getPost('profile_image');
            $filename = '';
            if ($img) {
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace('data:image/jpeg;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $file_data = base64_decode($img);
                $image_name = md5(uniqid(rand(), true));
                $filename = $image_name . '.' . 'png';
                $path = 'uploads/';
                file_put_contents($path . $filename, $file_data);
            }
            $data_array = [
                'full_name' => $name,
                'email' => $email,
                'contact_no' => $wp_no,
                'eis_no' => $eis_no,
                'member_desgn_id' => $designation_id,
                'member_dept_id' => $department_id,
                'joining_date' => date('Y-m-d'),
                'user_name' => strtolower(str_replace(' ', '_', $name)),
                'city_id' => $area,
                'status' => 0,
                'profile_image' => $filename,
                'user_type' => 2,
            ];

            $result = $this->AdminModel->adduser($data_array);
            if ($result) {
                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'response' => [
                        'success' => 'User registered Successfully'
                    ],
                ];
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Registration failed!, Something went wrong.'
                    ]
                ];
            }
        }

        return $this->respondCreated($response);
    }

    public function updatePassword()
    {
        $rules = [
            'esi_no' => 'required|numeric|exact_length[8]',
            'password' => 'required'
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $esi_no = $this->request->getVar('esi_no');
            $data = $this->AdminModel->checkUserEsino($esi_no);
            if (!empty($data) && $data != null) {

                $password = $this->request->getVar('password');
                $updatepassword = [
                    'password' => base64_encode(base64_encode($password))
                ];
                $result = $this->AdminModel->UpdateProfile($updatepassword, $data[0]->id);
                if ($result) {
                    $response = [
                        'status'   => 200,
                        'error'    => null,
                        'response' => [
                            'success' => 'Password updated Successfully'
                        ],
                    ];
                } else {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'Password updated failed!, Something went wrong.'
                        ]
                    ];
                }
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Invalid ESI No'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function updateProfile()
    {

        $rules = [
            'adhar_no' => 'required|numeric',
            'user_id' => 'required|numeric'
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {

            $user_id = $this->request->getVar('user_id');
            $userDtls = $this->AdminModel->userdata($user_id);
            if (!empty($userDtls) && $userDtls != null) {
                $dob = $this->request->getVar('dob');
                $blood_group = $this->request->getVar('blood_group');
                $adhar_no = $this->request->getVar('adhar_no');
                $joining_date = $this->request->getVar('joining_date');
                $marital_status = $this->request->getVar('marital_status');
                $spouse_name = $this->request->getVar('spouse_name');
                $no_of_children = $this->request->getVar('no_of_children');
                $address1 = $this->request->getVar('address');
                $gender = $this->request->getVar('gender');
                $alter_number = $this->request->getVar('alter_number');
                $office_name = $this->request->getVar('office_name');
                $office_location = $this->request->getVar('office_location');
                $office_union = $this->request->getVar('office_union');
                $position_in_union = $this->request->getVar('position_in_union');



                $img = $this->request->getPost('profile_image');
                if ($img) {
                    $img = str_replace('data:image/png;base64,', '', $img);
                    $img = str_replace('data:image/jpeg;base64,', '', $img);
                    $img = str_replace(' ', '+', $img);
                    $file_data = base64_decode($img);
                    $image_name = md5(uniqid(rand(), true));
                    $filename = $image_name . '.' . 'png';
                    $path = 'uploads/';
                    file_put_contents($path . $filename, $file_data);
                    $updateImage = [
                        'profile_image' => $filename
                    ];

                    $data = $this->AdminModel->UpdateProfile($updateImage, $user_id);
                }

                $data_array = [
                    'dob' => $dob,
                    'blood_group' => $blood_group,
                    'adhar_no' => $adhar_no,
                    'joining_dateinbranchoffice' => $joining_date,
                    'marital_status' => $marital_status,
                    'spouse_name' => $spouse_name,
                    'no_of_children' => $no_of_children,
                    'address1' => $address1,
                    'gender' => $gender,
                    'alter_cnum' => $alter_number,
                    'office_name' => $office_name,
                    'office_location' => $office_location,
                    'office_union' => $office_union,
                    'position_in_union' => $position_in_union,
                ];

                $result = $this->AdminModel->UpdateProfile($data_array, $user_id);
                if ($result) {
                    $response = [
                        'status'   => 201,
                        'error'    => null,
                        'response' => [
                            'success' => 'User profile updated Successfully'
                        ],
                    ];
                } else {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'update failed!, Something went wrong.'
                        ]
                    ];
                }
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'User not found!'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function createPost()
    {
        $rules = [
            'user_id' => 'required|numeric',
            // 'content' => 'required',
            'post_type' => 'required|numeric'
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $user_id = $this->request->getVar('user_id');
            $userDtls = $this->AdminModel->userdata($user_id);
            if (!empty($userDtls) && $userDtls != null) {

                $content = $this->request->getVar('content');
                $post_type = $this->request->getVar('post_type');
                $data_array = [
                    'post_content' => $content,
                    'user_id' => $user_id,
                    'post_type' => $post_type,
                    'status' => 1
                ];
                $insert_id = $this->AdminModel->createPost($data_array);

                if ($imagefile = $this->request->getFiles()) {
                    foreach ($imagefile['post_images'] as $img) {

                        if ($img->isValid() && !$img->hasMoved()) {
                            $image_name = md5(uniqid(rand(), true));
                            $ext = $img->guessExtension();
                            $newName = $image_name . '.' . $ext;
                            $img->move('uploads/post/', $newName);
                            $imageData = [
                                'post_id' => $insert_id,
                                'image_name' => $newName,
                                'image_path' => 'uploads/post/'
                            ];
                            $result = $this->AdminModel->inserPostImage($imageData);
                        }
                    }
                }

                if ($videosfile = $this->request->getFiles()) {

                    foreach ($videosfile['post_videos'] as $vdo) {
                        if ($vdo->isValid() && !$vdo->hasMoved()) {
                            $video_name = md5(uniqid(rand(), true));
                            $ext = $vdo->guessExtension();
                            $newFileName = $video_name . '.' . $ext;
                            $vdo->move('uploads/post/', $newFileName);
                            $videoData = [
                                'post_id' => $insert_id,
                                'video_file' => $newFileName,
                                'video_path' => 'uploads/post/'
                            ];
                            $result = $this->AdminModel->inserPostVideo($videoData);
                        }
                    }
                }
                // $images = $this->request->getPost('post_images');
                // if (is_array($images)) {

                //     if (count($images) > 3) {
                //         $response = [
                //             'status'   => 200,
                //             'error'    => 1,
                //             'response' => [
                //                 'message' => 'number of image upload limit exceed'
                //             ]
                //         ];
                //         return $this->respondCreated($response);
                //     }
                //     foreach ($images as $img) {
                //         $filename = '';
                //         if ($img) {
                //             $img = str_replace('data:image/png;base64,', '', $img);
                //             $img = str_replace('data:image/jpeg;base64,', '', $img);
                //             $img = str_replace(' ', '+', $img);
                //             $file_data = base64_decode($img);
                //             $image_name = md5(uniqid(rand(), true));
                //             $filename = $image_name . '.' . 'png';
                //             $path = 'uploads/post/';
                //             file_put_contents($path . $filename, $file_data);

                //             $imageData = [
                //                 'post_id' => $insert_id,
                //                 'image_name' => $filename,
                //                 'image_path' => 'uploads/post/'
                //             ];
                //             $result = $this->AdminModel->inserPostImage($imageData);
                //         }
                //     }
                // }

                // $videos = $this->request->getPost('post_videos');
                // if (is_array($videos)) {
                //     if (count($videos) > 3) {
                //         $response = [
                //             'status'   => 200,
                //             'error'    => 1,
                //             'response' => [
                //                 'message' => 'number of Video upload limit exceed'
                //             ]
                //         ];
                //         return $this->respondCreated($response);
                //     }
                //     foreach ($videos as $vdo) {
                //         $filename = '';
                //         if ($vdo) {
                //             $vdo = str_replace('data:image/png;base64,', '', $vdo);
                //             $vdo = str_replace('data:image/jpeg;base64,', '', $vdo);
                //             $vdo = str_replace(' ', '+', $vdo);
                //             $file_data = base64_decode($vdo);
                //             $image_name = md5(uniqid(rand(), true));
                //             $filename = $image_name . '.' . 'mp4';
                //             $path = 'uploads/post/';
                //             file_put_contents($path . $filename, $file_data);

                //             $videoData = [
                //                 'post_id' => $insert_id,
                //                 'video_file' => $filename,
                //                 'video_path' => 'uploads/post/'
                //             ];
                //             $result = $this->AdminModel->inserPostVideo($videoData);
                //         }
                //     }
                // }

                if ($insert_id) {
                    $response = [
                        'status'   => 201,
                        'error'    => null,
                        'response' => [
                            'success' => 'Post created Successfully'
                        ],
                    ];
                } else {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'Post creation failed!, Something went wrong.'
                        ]
                    ];
                }
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'User not found!'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function getGeneralPost()
    {
        $Posts = $this->AdminModel->getPost(1);
        $resultArray = [];
        foreach ($Posts as $Post) {
            $Post['images'] = $this->AdminModel->getAllLikeComment('post_image', $Post['id']);
            $Post['videos'] = $this->AdminModel->getAllLikeComment('post_video', $Post['id']);
            $Post['likes'] = $this->AdminModel->getAllLikeComment('post_like', $Post['id']);
            $Post['comments'] = $this->AdminModel->getAllLikeComment('post_comment', $Post['id']);
            $resultArray[] = $Post;
        }
        $response = [
            'status'   => 200,
            'error'    => null,
            'response' => [
                'message' => 'Here is the all general post data',
                'Posts' => $resultArray,

            ],
        ];
        return $this->respondCreated($response);
    }

    public function getPresidentPost()
    {
        $Posts = $this->AdminModel->getPost(2);
        $resultArray = [];
        foreach ($Posts as $Post) {
            $Post['images'] = $this->AdminModel->getAllLikeComment('post_image', $Post['id']);
            $Post['videos'] = $this->AdminModel->getAllLikeComment('post_video', $Post['id']);
            $Post['likes'] = $this->AdminModel->getAllLikeComment('post_like', $Post['id']);
            $Post['comments'] = $this->AdminModel->getAllLikeComment('post_comment', $Post['id']);
            $resultArray[] = $Post;
        }
        $response = [
            'status'   => 200,
            'error'    => null,
            'response' => [
                'message' => 'Here is the all president post data',
                'Posts' => $resultArray,

            ],
        ];
        return $this->respondCreated($response);
    }

    public function addLike()
    {
        $rules = [
            'user_id' => 'required|numeric',
            'post_id' => 'required|numeric'
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $user_id = $this->request->getVar('user_id');
            $post_id = $this->request->getVar('post_id');
            $userDtls = $this->AdminModel->userdata($user_id);
            $postDtls = $this->AdminModel->postDate($post_id);
            if (!empty($userDtls) && $userDtls != null && !empty($postDtls) && $postDtls != null) {

                $data_array = [
                    'user_id' => $user_id,
                    'post_id' => $post_id
                ];
                $insert_id = $this->AdminModel->addLike($data_array);

                if ($insert_id) {
                    $response = [
                        'status'   => 201,
                        'error'    => null,
                        'response' => [
                            'success' => 'Like added Successfully'
                        ],
                    ];
                } else {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'Something went wrong!.'
                        ]
                    ];
                }
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'User or Post not found!'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function addComment()
    {
        $rules = [
            'user_id' => 'required|numeric',
            'post_id' => 'required|numeric',
            'comment' => 'required',
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $user_id = $this->request->getVar('user_id');
            $post_id = $this->request->getVar('post_id');
            $userDtls = $this->AdminModel->userdata($user_id);
            $postDtls = $this->AdminModel->postDate($post_id);
            if (!empty($userDtls) && $userDtls != null && !empty($postDtls) && $postDtls != null) {
                $comment = $this->request->getVar('comment');

                $data_array = [
                    'user_id' => $user_id,
                    'post_id' => $post_id,
                    'comment' => $comment
                ];
                $insert_id = $this->AdminModel->addComment($data_array);

                if ($insert_id) {
                    $response = [
                        'status'   => 201,
                        'error'    => null,
                        'response' => [
                            'success' => 'Comment added Successfully'
                        ],
                    ];
                } else {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'Something went wrong!.'
                        ]
                    ];
                }
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'User or Post not found!'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function deleteLikeOrComment()
    {
        $rules = [
            'user_id' => 'required|numeric',
            'post_id' => 'required|numeric',
            'type' => 'required',
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $user_id = $this->request->getVar('user_id');
            $post_id = $this->request->getVar('post_id');
            $comment_id = $this->request->getVar('comment_id');
            $userDtls = $this->AdminModel->userdata($user_id);
            $postDtls = $this->AdminModel->postDate($post_id);
            if (!empty($userDtls) && $userDtls != null && !empty($postDtls) && $postDtls != null) {
                $type = $this->request->getVar('type');
                if ($type == 'like') {
                    $insert_id = $this->AdminModel->deleteRecord('post_like', ['post_id' => $post_id, 'user_id' => $user_id]);
                } else {
                    $insert_id = $this->AdminModel->deleteRecord('post_comment', ['id' => $comment_id]);
                }

                if ($insert_id) {
                    $response = [
                        'status'   => 201,
                        'error'    => null,
                        'response' => [
                            'success' => 'Deleted Successfully'
                        ],
                    ];
                } else {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'Something went wrong!.'
                        ]
                    ];
                }
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'User or Post not found!'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function getAllLikeCommentPostwise()
    {
        $rules = [
            'post_id' => 'required|numeric'
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $post_id = $this->request->getVar('post_id');
            $postDtls = $this->AdminModel->postDate($post_id);
            if (!empty($postDtls) && $postDtls != null) {


                $allLike = $this->AdminModel->getAllLikeComment('post_like', $post_id);
                $allComment = $this->AdminModel->getAllLikeComment('post_comment', $post_id);


                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'response' => [
                        'success' => 'Like added Successfully',
                        'like' => $allLike,
                        'comment' => $allComment,
                    ],
                ];
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Post not found!'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function memeberListForApproval()
    {
        $memeberList = $this->AdminModel->GetAllUserList(2);

        $response = [
            'status'   => 200,
            'error'    => null,
            'response' => [
                'message' => 'Here is the all memeber data for approveal',
                'memeberList' => $memeberList
            ],
        ];

        return $this->respondCreated($response);
    }

    public function approveMemebr()
    {
        $rules = [
            'memeber_id' => 'required|numeric',
            'user_id' => 'required|numeric'
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $user_id = $this->request->getVar('user_id');
            $userDtls = $this->AdminModel->userdata($user_id);
            if (!empty($userDtls) && $userDtls != null && $userDtls[0]->user_type != 1) {

                $memeber_id = $this->request->getVar('memeber_id');
                $updateStatus = [
                    'status' => 1
                ];
                $result = $this->AdminModel->UpdateProfile($updateStatus, $memeber_id);
                if ($result) {
                    $response = [
                        'status'   => 200,
                        'error'    => null,
                        'response' => [
                            'success' => 'Member approved Successfully'
                        ],
                    ];
                } else {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'Member approved failed!, Something went wrong.'
                        ]
                    ];
                }
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Invalid user_id'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function globalMemberList()
    {
        $memeberList = $this->AdminModel->GetAllActiveUserList(2);

        $response = [
            'status'   => 200,
            'error'    => null,
            'response' => [
                'message' => 'Here is the all member data',
                'memeberList' => $memeberList
            ],
        ];

        return $this->respondCreated($response);
    }

    public function localMemberList()
    {
        $rules = [
            'user_id' => 'required|numeric'
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $user_id = $this->request->getVar('user_id');
            $userDtls = $this->AdminModel->userdata($user_id);
            if (!empty($userDtls) && $userDtls != null && $userDtls[0]->city_id != '') {

                $memeberList = $this->AdminModel->getLocalMember($userDtls[0]->city_id);

                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'response' => [
                        'success' => 'Here is the all local member',
                        'memeberList' => $memeberList
                    ],
                ];
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Invalid user_id'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function getProfileDetails()
    {
        $rules = [
            'user_id' => 'required|numeric'
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $user_id = $this->request->getVar('user_id');
            $userDtls = $this->AdminModel->userdata($user_id);
            if (!empty($userDtls) && $userDtls != null) {

                $profileDetails = $this->AdminModel->getProfileDetails($user_id);

                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'response' => [
                        'success' => 'Profile Details',
                        'profileDetails' => $profileDetails
                    ],
                ];
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'User not found'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function getLeaveDetails()
    {
        $rules = [
            'user_id' => 'required|numeric'
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $user_id = $this->request->getVar('user_id');
            $userDtls = $this->AdminModel->userdata($user_id);
            if (!empty($userDtls) && $userDtls != null && $userDtls[0]->city_id != '') {

                $annualLeaveDetails = $this->AdminModel->annualLeaveData();
                $appliedLeave = $this->AdminModel->getAppliedLeave($user_id);
                $totalCltaken = $this->AdminModel->getTotalLeavyCategorywise($user_id, 'cl');
                $totalEltaken = $this->AdminModel->getTotalLeavyCategorywise($user_id, 'el');
                $totalHpltaken = $this->AdminModel->getTotalLeavyCategorywise($user_id, 'hpl');
                $holiday = $this->AdminModel->Holiday();

                $EL = $annualLeaveDetails[0]->no_of_el - $totalEltaken[0]->no_of_day;
                $CL = $annualLeaveDetails[0]->no_of_cl - $totalCltaken[0]->no_of_day;
                $HPL = $annualLeaveDetails[0]->no_of_hpl - $totalHpltaken[0]->no_of_day;
                $LL = $this->AdminModel->getTotalLl($user_id);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'response' => [
                        'success' => 'Here is the all leave details',
                        'total_appoved_leave' => $annualLeaveDetails,
                        'remining_el' => $EL,
                        'remining_cl' => $CL,
                        'remining_hpl' => $HPL,
                        'total_ll' => count($LL),
                        'holiday' => $holiday,
                        'appliedLeave' => $appliedLeave
                    ],
                ];
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'User not found'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function addLeaveDetails()
    {
        $rules = [
            'user_id' => 'required|numeric',
            'leava_type' => 'required',
            'start_date' => 'required',
            'reason' => 'required',
            'end_date' => 'required'

        ];
        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $user_id = $this->request->getVar('user_id');
            $userDtls = $this->AdminModel->userdata($user_id);
            if (!empty($userDtls) && $userDtls != null) {

                $leava_type = $this->request->getVar('leava_type');
                $start_date = $this->request->getVar('start_date');
                $end_date = $this->request->getVar('end_date');
                $reason = $this->request->getVar('reason');

                $startDate = strtotime($start_date);
                $endDate = strtotime($end_date);
                $datediff = $endDate - $startDate;
                $totalDay = round($datediff / (60 * 60 * 24));
                $data_array = [
                    'user_id' => $user_id,
                    'leave_type' => $leava_type,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'reason' => $reason,
                    'no_of_day' => $totalDay,
                    'status' => 1
                ];
                $result = $this->AdminModel->insertLeaveDetails($data_array);

                if ($result) {
                    $response = [
                        'status'   => 201,
                        'error'    => null,
                        'response' => [
                            'success' => 'Leave added Successfully'
                        ],
                    ];
                } else {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'Leave insertion failed!, Something went wrong.'
                        ]
                    ];
                }
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'User not found!'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function addLl()
    {
        $rules = [
            'user_id' => 'required|numeric',
            'date' => 'required',
            'remark' => 'required'
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $user_id = $this->request->getVar('user_id');
            $userDtls = $this->AdminModel->userdata($user_id);
            if (!empty($userDtls) && $userDtls != null) {

                $date = $this->request->getVar('date');

                $remark = $this->request->getVar('remark');

                $data_array = [
                    'user_id' => $user_id,
                    'date' => $date,
                    'remark' => $remark,
                    'status' => 1
                ];
                $result = $this->AdminModel->insertLlDetails($data_array);

                if ($result) {
                    $response = [
                        'status'   => 201,
                        'error'    => null,
                        'response' => [
                            'success' => 'LL added Successfully'
                        ],
                    ];
                } else {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'LL insertion failed!, Something went wrong.'
                        ]
                    ];
                }
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'User not found!'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }


    public function applayTraining()
    {
        $rules = [
            'user_id' => 'required|numeric',
            'training_id' => 'required|numeric',
            'training_date' => 'required',
            'training_time' => 'required'
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $user_id = $this->request->getVar('user_id');
            $userDtls = $this->AdminModel->userdata($user_id);
            if (!empty($userDtls) && $userDtls != null) {

                $training_id = $this->request->getVar('training_id');
                $checkTraing = $this->AdminModel->checkTraining($user_id, $training_id);
                if (!empty($checkTraing) && !$checkTraing == null) {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'You have already applied for this Training!'
                        ]
                    ];
                    return $this->respondCreated($response);
                }
                $training_date = $this->request->getVar('training_date');
                $training_time = $this->request->getVar('training_time');
                $remark = $this->request->getVar('remark');

                $data_array = [
                    'emp_id' => $user_id,
                    'training_date' => $training_date,
                    'training_time' => $training_time,
                    'training_topic' => $training_id,
                    'remark' => $remark,
                    'training_status' => 0
                ];
                $result = $this->AdminModel->insertTraingRequest($data_array);

                if ($result) {
                    $response = [
                        'status'   => 201,
                        'error'    => null,
                        'response' => [
                            'success' => 'Training added Successfully'
                        ],
                    ];
                } else {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'Training insertion failed!, Something went wrong.'
                        ]
                    ];
                }
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'User not found!'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function getUserTrainingHistory()
    {
        $rules = [
            'user_id' => 'required|numeric'
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $user_id = $this->request->getVar('user_id');
            $userDtls = $this->AdminModel->userdata($user_id);
            if (!empty($userDtls) && $userDtls != null) {

                $trainingHistory = $this->AdminModel->getUserTraingHistory($user_id);

                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'response' => [
                        'success' => 'Here is the all local member',
                        'trainingHistory' => $trainingHistory
                    ],
                ];
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'User not found'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function getAllTrainingHistory()
    {
        $trainingHistory = $this->AdminModel->Training();

        $response = [
            'status'   => 200,
            'error'    => null,
            'response' => [
                'success' => 'Here is the all local member',
                'trainingHistory' => $trainingHistory
            ],
        ];

        return $this->respondCreated($response);
    }

    public function approveMemebrTraining()
    {
        $rules = [
            'request_id' => 'required|numeric',
            'user_id' => 'required|numeric'
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $user_id = $this->request->getVar('user_id');
            $userDtls = $this->AdminModel->userdata($user_id);
            if (!empty($userDtls) && $userDtls != null && $userDtls[0]->user_type == 1) {

                $training_id = $this->request->getVar('request_id');
                $updateStatus = [
                    'training_status' => 1
                ];
                $result = $this->AdminModel->UpdateTrainingDetails($updateStatus, $training_id);
                if ($result) {
                    $response = [
                        'status'   => 200,
                        'error'    => null,
                        'response' => [
                            'success' => 'Traing approved Successfully'
                        ],
                    ];
                } else {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'Traing approved failed!, Something went wrong.'
                        ]
                    ];
                }
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Invalid user_id'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }

    public function getCompanyServiceDetails()
    {
        $rules = [
            'user_id' => 'required|numeric'
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status'   => 200,
                'error'    => 1,
                'response' => [
                    'message' => $this->validator->getErrors()
                ]
            ];
        } else {
            $user_id = $this->request->getVar('user_id');
            $userDtls = $this->AdminModel->userdata($user_id);

            if (!empty($userDtls) && $userDtls != null && $userDtls[0]->office_name != '') {

                $ambulanceDetails = $this->AdminModel->getambulanceDetails($userDtls[0]->office_name);
                $bloodBankDetails = $this->AdminModel->getbloodBankDetails($userDtls[0]->office_name);
                $medicalDetails = $this->AdminModel->getmedicalDetails($userDtls[0]->office_name);

                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'response' => [
                        'success' => 'Here is the all comapny services member',
                        'ambulanceDetails' => $ambulanceDetails,
                        'bloodBankDetails' => $bloodBankDetails,
                        'medicalDetails' => $medicalDetails,

                    ],
                ];
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'User or office not found'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }

    private function imageToBase64($path)
    {
        $path = $path;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
}

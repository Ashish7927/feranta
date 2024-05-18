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

    public function sendOtpForLoginDriver()
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
            $data = $this->AdminModel->checkUserPahoneDriver($phone);
            if (!empty($data) && $data != null) {


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
            } else {

                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Phone no not registreted'
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
                            'vehicle_type' => $getVehicleId->type_id,
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
                            'status' => 0,
                            'booking_status'=> 0
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
                'status' => 1
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
            $checkUpdate = $this->AdminModel->checkDriverStatus($service_id);
            if(!empty($checkUpdate) && count($checkUpdate) > 0)
            {
                $this->AdminModel->UpdateRecordById('vehicle_location_status',$checkUpdate[0]->id , $data);
            }else{
                $this->AdminModel->InsertRecord('vehicle_location_status', $data);
            }
            
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

    public function bookService()
    {
        $rules = [
            'origin_lat' => 'required',
            'origin_lng' => 'required',
            'destination_lat' => 'required',
            'destination_lng' => 'required',
            'booking_type' => 'required',
            'vehicle_type' => 'required',
            'cutomer_id' => 'required'
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
            $booking_type = $this->request->getVar('booking_type');
            $vehicle_type = $this->request->getVar('vehicle_type');
            $cutomer_id = $this->request->getVar('cutomer_id');

            $success = 0;
            $radius = 5; // Radius in kilometers

            if ($booking_type == 'cab') {
                $getAvailableServiceId = $this->db->query("SELECT id, ( 6371 * acos( cos( radians($destination_lat) ) * cos( radians( destination_lat ) ) * cos( radians( destination_lng ) - radians($destination_lng) ) + sin( radians($destination_lat) ) * sin( radians( destination_lat ) ) ) ) AS distance FROM service_details WHERE status != 1 AND vehicle_type = $vehicle_type HAVING distance < $radius ORDER BY distance")->getResultArray();

                $checkAvailbility = $this->db->query("SELECT id, ( 6371 * acos( cos( radians($origin_lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($origin_lng) ) + sin( radians($origin_lat) ) * sin( radians( lat ) ) ) ) AS distance FROM vehicle_location_status WHERE service_id IN($getAvailableServiceId) HAVING distance < $radius ORDER BY distance")->getResult();

                if (empty($checkAvailbility) || count($checkAvailbility) == 0) {
                    $checkAvailbility = $this->db->query("SELECT id, ( 6371 * acos( cos( radians($origin_lat) ) * cos( radians( origin_lat ) ) * cos( radians( origin_lng ) - radians($origin_lng) ) + sin( radians($origin_lat) ) * sin( radians( origin_lat ) ) ) ) AS distance FROM service_details WHERE boarding_date BETWEEN DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s') AND DATE_FORMAT(NOW() + INTERVAL 30 MINUTE, '%Y-%m-%d %H:%i:%s') HAVING distance < $radius ORDER BY distance")->getResult();
                }

                if (!empty($checkAvailbility) && count($checkAvailbility) > 0) {

                    $success = 1;
                    $service_rate = $checkAvailbility[0]->service_rate;
                    $totalfare = $checkAvailbility[0]->full_fare;
                } else {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'Sorry! No service availble on this root'
                        ]
                    ];
                }
            } elseif ($booking_type == 'sharing') {
                $checkAvailbility = $this->AdminModel->checkServiceAvailbility($vehicle_type, $from_location, $to_location);
                if (!empty($checkAvailbility) && count($checkAvailbility) > 0) {
                    $success = 1;
                    $service_rate = $checkAvailbility[0]->service_rate;
                    $totalfare = $checkAvailbility[0]->fare_per_sit;
                } else {
                    return redirect()->to('service-booking')->with('message', 'Sorry! No service availble on this root');
                }
            } elseif ($booking_type == 'future_cab') {
                $success = 0;
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Booking type not found'
                    ]
                ];
            }

            if ($success == 1) {
                $data = [
                    'user_id' => $cutomer_id,
                    'booking_type' => $booking_type,
                    'vehicle_type' => $vehicle_type,
                    'origin_lat' => $origin_lat,
                    'origin_lng' => $origin_lng,
                    'destination_lat' => $destination_lat,
                    'destination_lng' => $destination_lng,
                    'boarding_date' => date('Y-m-d H:i:s'),
                    'service_rate' => $service_rate,
                    'fare' => $totalfare,
                    'vehicle_id' => '',
                    'driver_id' => '',
                    'status' => 0,
                    'created_by' => 0,
                    'updated_by' => 0,
                    'updated_at' => date('Y-m-d H:i:s')

                ];

                $booking_id = $this->AdminModel->InsertService($data);

                foreach ($checkAvailbility as $service) {

                    $data = [
                        'booking_id' => $booking_id,
                        'service_id' => $service->id,
                        'driver_id' => $service->driver_id,
                        'status' => 0
                    ];
                    $this->AdminModel->InsertRecord('service_request', $data);
                }

                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'response' => [
                        'success' => 'Booking register successfully!'
                    ],
                ];
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Something went wrong!'
                    ]
                ];
            }
        }

        return $this->respondCreated($response);
    }

    public function getAllRequest()
    {
        $rules = [
            'driver_id' => 'required'
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
            $allRequest = $this->AdminModel->getDriverwiseBookingRequest($driver_id);

            $response = [
                'status'   => 200,
                'error'    => null,
                'response' => [
                    'success' => 'Here is all request',
                    'data' => $allRequest
                ],
            ];

        }

        return $this->respondCreated($response);
    }

    public function acceptBooking()
    {
        $rules = [
            'request_id' => 'required'
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

            $request_id  = $this->request->getPost('request_id');
            $requestDetails = $this->AdminModel->getSingleData('service_request', $request_id);
            if($requestDetails->status != 0){

                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Booking alredy assigned!'
                    ]
                ];

            }else{
            $serviceDetails = $this->AdminModel->getSingleData('service_details', $requestDetails->service_id);

                $data = [
                    'status'  => 1,
                ];
                $this->AdminModel->UpdateRecordById('service_request', $request_id, $data);
                $data = [
                    'vehicle_id'  => $serviceDetails->vehicle_id,
                    'driver_id'  => $requestDetails->driver_id,
                    'status'  => 1
                ];
                $this->AdminModel->UpdateRecordById('service_bookings', $serviceDetails->booking_id, $data);
                $data = [
                    'status'  => 2,
                ];
                $this->db->query("UPDATE service_request SET status = 2 WHERE booking_id = $serviceDetails->booking_id AND status = 0 ");

                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'response' => [
                        'success' => 'Booking accepted successfully!'
                    ],
                ];
            }
        }

        return $this->respondCreated($response);
    }

    public function rejectBooking()
    {
        $rules = [
            'request_id' => 'required'
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
            $request_id  = $this->request->getPost('request_id');
            $requestDetails = $this->AdminModel->getSingleData('service_request', $id);
            $data = [
                'status'  => 3,
            ];
            $this->AdminModel->UpdateRecordById('service_request', $request_id, $data);

            $resuestall = $this->AdminModel->getAllrequestStatuswise($requestDetails->booking_id, 0);
            if (empty($resuestall) || count($resuestall) == 0) {
                $data = [
                    'status'  => 3
                ];
                $this->AdminModel->UpdateRecordById('service_bookings', $requestDetails->booking_id, $data);
            }

            $response = [
                'status'   => 200,
                'error'    => null,
                'response' => [
                    'success' => 'Booking rejected successfully!'
                ],
            ];

        }

        return $this->respondCreated($response);
    }

    public function endBooking()
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
            $serviceDetails = $this->AdminModel->getSingleData('service_details', $service_id);
            if($serviceDetails->booking_status == 1){

                $this->db->query("UPDATE service_bookings SET status = 3 WHERE service_id = $service_id ");
            }
            $data = [
                'status' => 3
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

// customer cancel
//driver cancel (cancel service or cancel booking only)
    public function cancelBooking()
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
        }

        return $this->respondCreated($response);
    }

    
    public function verifyBookingOtp()
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
        }

        return $this->respondCreated($response);
    }
}

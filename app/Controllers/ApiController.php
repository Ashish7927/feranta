<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\AdminModel;
use CodeIgniter\Files\File;
use Google\Client;

class ApiController extends ResourceController
{

    function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

    function getAddressFromLatLng($lat, $lng)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$lng}&key=AIzaSyAX9w0uT7e_Ohjm_FHv7dHNOjvoFdeDe04";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if ($data['status'] == 'OK') {
            $address = $data['results'][0]['formatted_address'];
            return $address;
        } else {
            return "N/A";
        }
    }

    public function __construct()
    {
        $db = db_connect();
        $this->db = db_connect();

        $this->AdminModel = new AdminModel($db);
        $this->session = session();
        helper(['form', 'url', 'validation']);
    }


    public function authenticate()
    {
        // Path to your JSON key file
        $jsonKeyFilePath = ROOTPATH . 'assets/google/fernata-48950-bfeed489576a.json';

        // Load Google Client Library
        require_once ROOTPATH . 'vendor/autoload.php';

        // Create a new Google Client instance
        $client = new Client();
        $client->setAuthConfig($jsonKeyFilePath);

        // Set the scopes
        $client->setScopes(['https://www.googleapis.com/auth/firebase.messaging']);

        // Get access token
        $accessToken = $client->fetchAccessTokenWithAssertion();

        // Access token
        return $token = $accessToken['access_token'];

        // Use this $token in your HTTP requests to authenticate
    }

    public function sendPushNotification($title, $message, $sender_id)
    {
        $projectId = 'fernata-48950';
        $messageData = [
            'message' => [
                'token' =>$sender_id,
                'notification' => [
                    'title' => $title,
                    'body' => $message
                ]
            ]
        ];
        $jsonMessage = json_encode($messageData);

        // Set the URL for the FCM API endpoint
        $url = 'https://fcm.googleapis.com/v1/projects/' . $projectId . '/messages:send';

        // get OAuth 2.0 access token
        $serverKey = $this->authenticate();


        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $serverKey,
            'Content-Type: application/json'
        ]);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonMessage);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);


        if ($response === false) {
            $echo = 'cURL error: ' . curl_error($ch);
        } else {
            $responseData = json_decode($response, true);

            if (isset($responseData['error'])) {
                $echo = 'FCM error: ' . $responseData['error']['message'];
            } else {
                $echo = 'Message sent successfully!';
            }
        }
        curl_close($ch);
    }

    public function vehcileTypeMaster()
    {
        $alltytpes = $this->AdminModel->GetAllRecord('vehicle_types');
        $response = [
            'status'   => 200,
            'error'    => null,
            'response' => [
                'message' => 'All Vehcile date!',
                'data' => $alltytpes,
            ],
        ];
        return $this->respondCreated($response);
    }


    public function sendOtpForLogin()
    {
        $rules = [
            'phone' => 'required|numeric|exact_length[10]',
            'device_token' => 'required'
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
            $device_token = $this->request->getVar('device_token');
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
                    'otp' => $otp,
                    'device_token' => $device_token
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
            'phone' => 'required|numeric|exact_length[10]',
            'device_token' => 'required'
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
            $device_token = $this->request->getVar('device_token');
            $data = $this->AdminModel->checkUserPahoneDriver($phone);
            if (!empty($data) && $data != null) {


                if ($data[0]->status == 1) {
                    //Send otp
                    $otp = rand(100000, 999999);
                    $updateotp = [
                        'otp' => $otp,
                        'device_token' => $device_token
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

                        $from_add = $this->getAddressFromLatLng($origin_lat,$origin_lng);
                        $to_add = $this->getAddressFromLatLng($destination_lat,$destination_lng);

                        $data = [
                            'vehicle_id' => $getVehicleId->vehicle_id,
                            'vehicle_type' => $getVehicleId->type_id,
                            'boarding_date' => $boarding_datetime,
                            'start_datetime' => $newTime,
                            'from_city' => $from_add,
                            'to_city' => $to_add,
                            'origin_lat' => $origin_lat,
                            'origin_lng' => $origin_lng,
                            'destination_lat' => $destination_lat,
                            'destination_lng' => $destination_lng,
                            'service_rate' => $serviceRate,
                            'full_fare' => $full_fare,
                            'fare_per_sit' => $fare_per_sit,
                            'driver_id' => $driver_id,
                            'status' => 0,
                            'booking_status' => 0
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
            'service_id' => 'required',
            'lat' => 'required',
            'lng' => 'required'
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
            $lat = $this->request->getVar('lat');
            $lng = $this->request->getVar('lng');
            $serviceDetails = $this->AdminModel->getSingleData('service_details', $service_id);
            $distance = $this->haversineGreatCircleDistance($serviceDetails->origin_lat, $serviceDetails->origin_lng, $lat, $lng);
            if ($distance <= 500) {

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
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => "You can only start within 500 meter distance to pickup location."
                    ]
                ];
            }
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
            if (!empty($checkUpdate) && count($checkUpdate) > 0) {
                $this->AdminModel->UpdateRecordById('vehicle_location_status', $checkUpdate[0]->id, $data);
            } else {
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

                $arr = array_map(function ($value) {
                    return $value['id'];
                }, $getAvailableServiceId);
                $getAvailableServiceId = implode(',', $arr);
                $checkAvailbility = $this->db->query("SELECT *, ( 6371 * acos( cos( radians($origin_lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($origin_lng) ) + sin( radians($origin_lat) ) * sin( radians( lat ) ) ) ) AS distance FROM vehicle_location_status WHERE service_id IN($getAvailableServiceId) HAVING distance < $radius ORDER BY distance")->getResult();

                if (empty($checkAvailbility) || count($checkAvailbility) == 0) {
                    $checkAvailbility = $this->db->query("SELECT *, ( 6371 * acos( cos( radians($origin_lat) ) * cos( radians( origin_lat ) ) * cos( radians( origin_lng ) - radians($origin_lng) ) + sin( radians($origin_lat) ) * sin( radians( origin_lat ) ) ) ) AS distance FROM service_details WHERE start_datetime BETWEEN DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s') AND DATE_FORMAT(NOW() + INTERVAL 30 MINUTE, '%Y-%m-%d %H:%i:%s') HAVING distance < $radius ORDER BY distance")->getResult();
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
                $from_add = $this->getAddressFromLatLng($origin_lat,$origin_lng);
                $to_add = $this->getAddressFromLatLng($destination_lat,$destination_lng);
                $data = [
                    'user_id' => $cutomer_id,
                    'booking_type' => $booking_type,
                    'vehicle_type' => $vehicle_type,
                    'from_location' => $from_add,
                    'to_location' => $to_add,
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

                $BookingData = $this->AdminModel->getBookingData($booking_id);

                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'response' => [
                        'success' => 'Booking register successfully!',
                        'data' => $BookingData
                    ],
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
            if ($requestDetails->status != 0) {

                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Booking alredy closed!'
                    ]
                ];
            } else {
                $serviceDetails = $this->AdminModel->getSingleData('service_details', $requestDetails->service_id);

                $data = [
                    'status'  => 1,
                ];
                $this->AdminModel->UpdateRecordById('service_request', $request_id, $data);
                $otp = rand(100000, 999999);
                $data = [
                    'vehicle_id'  => $serviceDetails->vehicle_id,
                    'driver_id'  => $requestDetails->driver_id,
                    'service_id'  => $serviceDetails->id,
                    'otp' => $otp,
                    'status'  => 1
                ];
                $this->AdminModel->UpdateRecordById('service_bookings', $requestDetails->booking_id, $data);
                $data = [
                    'status'  => 2,
                ];
                $this->db->query("UPDATE service_request SET status = 2 WHERE booking_id = $requestDetails->booking_id AND status = 0 ");
                $this->db->query("UPDATE service_details SET status = 1 WHERE id = $serviceDetails->id");
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
            $requestDetails = $this->AdminModel->getSingleData('service_request', $request_id);
            if ($requestDetails->status != 2) {

                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Booking alredy closed!'
                    ]
                ];
            } else {
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
        }

        return $this->respondCreated($response);
    }

    public function endBooking()
    {
        $rules = [
            'service_id' => 'required',
            'lat' => 'required',
            'lng' => 'required'
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

            $lat = $this->request->getVar('lat');
            $lng = $this->request->getVar('lng');
            $distance = $this->haversineGreatCircleDistance($serviceDetails->destination_lat, $serviceDetails->destination_lng, $lat, $lng);
            if ($distance <= 500) {

                if ($serviceDetails->booking_status == 1) {

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
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => "You can only end Booking within 500 meter distance to drop location."
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }

    // cancel Booking
    public function cancelBooking()
    {
        $rules = [
            'booking_id' => 'required',
            'user_id' => 'required'
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
            $booking_id = $this->request->getVar('booking_id');
            $bookingDetails = $this->AdminModel->getSingleData('service_bookings', $booking_id);
            $data = [
                'status'  => 2,
                'updated_by' => $user_id
            ];
            $this->AdminModel->UpdateRecordById('service_bookings', $booking_id, $data);


            $this->db->query("UPDATE service_request SET status = 2 WHERE booking_id = $booking_id");


            if ($bookingDetails->service_id != '') {
                $this->db->query("UPDATE service_details SET status = 0 WHERE id = $bookingDetails->service_id");
            }

            $response = [
                'status'   => 200,
                'error'    => null,
                'response' => [
                    'success' => 'Booking canceled successfully!'
                ],
            ];
        }

        return $this->respondCreated($response);
    }



    public function checkBookingService()
    {
        $rules = [
            'booking_id' => 'required'
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
            $booking_id = $this->request->getVar('booking_id');
            $BookingData = $this->AdminModel->getBookingData($booking_id);

            $response = [
                'status'   => 200,
                'error'    => null,
                'response' => [
                    'success' => 'Booking status data',
                    'BookingData' => $BookingData
                ],
            ];
        }

        return $this->respondCreated($response);
    }


    public function verifyBookingOtp()
    {
        $rules = [
            'booking_id' => 'required|numeric',
            'otp' => 'required|numeric|exact_length[6]',
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

            $booking_id = $this->request->getVar('booking_id');
            $otp = $this->request->getVar('otp');
            $data = $this->AdminModel->getBookingData($booking_id);
            if (!empty($data) && $data != null) {

                //verify otp
                $actuallOtp = $data[0]->otp;
                if ($otp == $actuallOtp) {

                    $response = [
                        'status'   => 201,
                        'error'    => null,
                        'response' => [
                            'success' => 'OTP matched',
                            'userDetails' => $data
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
                        'message' => 'Invalid Booking Id!'
                    ]
                ];
            }
        }
        return $this->respondCreated($response);
    }


    public function updateProfile()
    {
        $rules = [
            'customer_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'contact_no' => 'required'

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

            $customer_id = $this->request->getVar('customer_id');
            $name = $this->request->getVar('name');
            $email = $this->request->getVar('email');
            $contact_no = $this->request->getVar('contact_no');


            $CountEmail = $this->db->query("SELECT * FROM user  where email= '" . $email . "' and id!= $customer_id ")->getResult();
            $CountContact = $this->db->query("SELECT * FROM user  where contact_no=" . $contact_no . " and id!=$customer_id ")->getResult();
            if ($CountEmail >= 0) {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Email id already exist!'
                    ]
                ];
                return $this->respondCreated($response);
            }
            if ($CountContact >= 0) {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Contact no is already exist!'
                    ]
                ];
                return $this->respondCreated($response);
            }

            $data = [
                'full_name' => $name,
                'email' => $email,
                'contact_no' => $contact_no
            ];

            $file = $this->request->getFile('image');

            if ($file->isValid() && !$file->hasMoved()) {
                $imagename = $file->getRandomName();
                $file->move('uploads/', $imagename);
                $data['profile_image'] = $imagename;
            } else {
                $imagename = "";
            }
            $this->AdminModel->updateUser($data, $customer_id);

            $serviceDetails = $this->AdminModel->getSingleData('user', $customer_id);
            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'message' => 'Profile updated successfully!',
                    'data' => $serviceDetails
                ],
            ];
        }

        return $this->respondCreated($response);
    }

    public function profileDetails()
    {
        $rules = [
            'user_id' => 'required'
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
            $userDetails = $this->AdminModel->getSingleData('user', $user_id);
            if (!empty($userDetails)) {

                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'response' => [
                        'success' => 'User Profile Details',
                        'userDetails' => $userDetails
                    ],
                ];
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Invalid user Id!'
                    ]
                ];
            }
        }

        return $this->respondCreated($response);
    }

    public function sceduleList()
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
            $allService = $this->AdminModel->getAllDriverService($driver_id);
            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => 'Scedule Service List',
                    'userDetails' => $allService
                ],
            ];
        }

        return $this->respondCreated($response);
    }

    public function bookingHistoryCustomer()
    {
        $rules = [
            'customer_id' => 'required'
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

            $customer_id = $this->request->getVar('customer_id');
            $allService = $this->AdminModel->getAllCustomerBookingData($customer_id);
            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => 'Booking Service List',
                    'userDetails' => $allService
                ],
            ];
        }

        return $this->respondCreated($response);
    }

    public function driverRegister()
    {
        $rules = [
            'full_name' => 'required',
            'email' => 'required',
            'contact_no' => 'required',
            'city' => 'required',
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

            $data = [
                'full_name' => $this->request->getVar('name'),
                'email'  => $this->request->getVar('email'),
                'user_name'  => $this->request->getVar('name'),
                'contact_no'  => $this->request->getVar('contact'),
                'state_id'  => $this->request->getVar('state'),
                'city_id'  => $this->request->getVar('city'),
                'pin'  => $this->request->getVar('pincode'),
                'address1'  => $this->request->getVar('address1'),
                'address2'  => $this->request->getVar('address2'),
                'adhar_no'  => $this->request->getVar('adharno'),

                'password'  => base64_encode(base64_encode($this->request->getVar('password'))),
                'profile_image'  => $imagename,

                'adhar_font'  => $imagename1,
                'adhar_back'  => $imagename2,

                'user_type'  => $this->request->getVar('role'),
                'license_no'  => $this->request->getVar('license_no'),
                'license_img'  => $license_img1,
                'status' => 1,
                'ac_name'  => $this->request->getVar('ac_name'),
                'bank_name'  => $this->request->getVar('bank_name'),
                'acc_no'  => $this->request->getVar('acc_no'),
                'ifsc'  => $this->request->getVar('ifsc'),
                'exp_year'  => $this->request->getVar('exp_year')

            ];

            if ($this->request->getVar('is_driver') == 1) {
                $data['is_driver']  = $this->request->getVar('is_driver');
            }
            //print_r($data);exit;

            $this->AdminModel->adduser($data);

            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => 'Booking Service List',
                    'userDetails' => $allService
                ],
            ];
        }

        return $this->respondCreated($response);
    }

    public function driverUpdateProfile()
    {
        $rules = [
            'customer_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'contact_no' => 'required'

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

            $customer_id = $this->request->getVar('customer_id');
            $name = $this->request->getVar('name');
            $email = $this->request->getVar('email');
            $contact_no = $this->request->getVar('contact_no');


            $CountEmail = $this->db->query("SELECT * FROM user  where email= '" . $email . "' and id!= $customer_id ")->getResult();
            $CountContact = $this->db->query("SELECT * FROM user  where contact_no=" . $contact_no . " and id!=$customer_id ")->getResult();
            if ($CountEmail >= 0) {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Email id already exist!'
                    ]
                ];
                return $this->respondCreated($response);
            }
            if ($CountContact >= 0) {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Contact no is already exist!'
                    ]
                ];
                return $this->respondCreated($response);
            }

            $data = [
                'full_name' => $name,
                'email' => $email,
                'contact_no' => $contact_no
            ];

            $file = $this->request->getFile('image');

            if ($file->isValid() && !$file->hasMoved()) {
                $imagename = $file->getRandomName();
                $file->move('uploads/', $imagename);
                $data['profile_image'] = $imagename;
            } else {
                $imagename = "";
            }
            $this->AdminModel->updateUser($data, $customer_id);

            $serviceDetails = $this->AdminModel->getSingleData('user', $customer_id);
            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'message' => 'Profile updated successfully!',
                    'data' => $serviceDetails
                ],
            ];
        }

        return $this->respondCreated($response);
    }
}

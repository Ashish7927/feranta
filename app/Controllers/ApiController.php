<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\AdminModel;
use CodeIgniter\Files\File;
use Google\Client;

date_default_timezone_set('Asia/Kolkata');

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

    public function sendPushNotification($user_id, $title, $message)
    {

        $userDetails = $this->AdminModel->getSingleData('user', $user_id);

        $data_array = [
            'user_id' => $user_id,
            'title' => $title,
            'message' => $message,
            'details' => ''
        ];
        $this->AdminModel->InsertRecord('notifications', $data_array);

        $projectId = 'fernata-48950';
        $messageData = [
            'message' => [
                'token' => $userDetails->device_token,
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
        return $echo;
    }

    public function getMasterData()
    {
        $alltytpes = $this->AdminModel->GetAllRecord('vehicle_types');
        $state = $this->AdminModel->GetAllRecord('state');
        $city = $this->AdminModel->GetAllRecord('city');
        $pincode = $this->AdminModel->GetAllRecord('pincode');
        $blood_group = $this->AdminModel->GetAllRecord('blood_group');
        $districts = $this->AdminModel->GetAllRecord('districts');
        $blocks = $this->AdminModel->GetAllRecord('blocks');
        $response = [
            'status'   => 200,
            'error'    => null,
            'response' => [
                'message' => 'Here all master data!',
                'vehicle_type' => $alltytpes,
                'state' => $state,
                'city' => $city,
                'pincode' => $pincode,
                'blood_group' => $blood_group,
                'districts' => $districts,
                'blocks' => $blocks

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
                foreach ($serviceRateStatewise as $ratee) {
                    $type_name = $ratee->type_name;

                    if ($type == 1) {
                        $rate = $ratee->full_fare;
                        $price = $rate * $km;
                    } else {
                        $rate = $ratee->fare_per_share;
                        $price = $rate * $km;
                    }

                    $result[] = array('type_id' => $ratee->type_id, 'type_name' => $type_name, 'fare_price' => $price, 'rate' => $rate);
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
            $getVehicleId = $this->AdminModel->getVehicleDetailsbyDriverId($driver_id);

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

                        $from_add = $this->getAddressFromLatLng($origin_lat, $origin_lng);
                        $to_add = $this->getAddressFromLatLng($destination_lat, $destination_lng);

                        $data = [
                            'vehicle_id' => $getVehicleId->id,
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
                $getAvailableServiceId = $this->db->query("SELECT id, ( 6371 * acos( cos( radians($destination_lat) ) * cos( radians( destination_lat ) ) * cos( radians( destination_lng ) - radians($destination_lng) ) + sin( radians($destination_lat) ) * sin( radians( destination_lat ) ) ) ) AS distance FROM service_details WHERE booking_status != 1 AND  share_status = 0 AND vehicle_type = $vehicle_type HAVING distance < $radius ORDER BY distance")->getResultArray();
                if (empty($getAvailableServiceId)) {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'Sorry! No service availble on this root'
                        ]
                    ];
                } else {
                    $arr = array_map(function ($value) {
                        return $value['id'];
                    }, $getAvailableServiceId);
                    $getAvailableServiceId = implode(',', $arr);
                    $checkAvailbility = $this->db->query("SELECT *, ( 6371 * acos( cos( radians($origin_lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($origin_lng) ) + sin( radians($origin_lat) ) * sin( radians( lat ) ) ) ) AS distance FROM vehicle_location_status WHERE service_id IN($getAvailableServiceId) HAVING distance < $radius ORDER BY distance")->getResult();

                    if (empty($checkAvailbility) || count($checkAvailbility) == 0) {
                        $checkAvailbility = $this->db->query("SELECT *, ( 6371 * acos( cos( radians($origin_lat) ) * cos( radians( origin_lat ) ) * cos( radians( origin_lng ) - radians($origin_lng) ) + sin( radians($origin_lat) ) * sin( radians( origin_lat ) ) ) ) AS distance FROM service_details WHERE id IN($getAvailableServiceId) AND start_datetime BETWEEN DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s') AND DATE_FORMAT(NOW() + INTERVAL 30 MINUTE, '%Y-%m-%d %H:%i:%s') HAVING distance < $radius ORDER BY distance")->getResult();
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
                }
            } elseif ($booking_type == 'sharing') {

                $getAvailableServiceId = $this->db->query("SELECT id, ( 6371 * acos( cos( radians($destination_lat) ) * cos( radians( destination_lat ) ) * cos( radians( destination_lng ) - radians($destination_lng) ) + sin( radians($destination_lat) ) * sin( radians( destination_lat ) ) ) ) AS distance FROM service_details WHERE booking_status != 1 AND vehicle_type = $vehicle_type HAVING distance < $radius ORDER BY distance")->getResultArray();

                $arr = array_map(function ($value) {
                    return $value['id'];
                }, $getAvailableServiceId);
                $getAvailableServiceId = implode(',', $arr);
                $checkAvailbility = $this->db->query("SELECT *, ( 6371 * acos( cos( radians($origin_lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($origin_lng) ) + sin( radians($origin_lat) ) * sin( radians( lat ) ) ) ) AS distance FROM vehicle_location_status WHERE service_id IN($getAvailableServiceId) HAVING distance < $radius ORDER BY distance")->getResult();

                if (empty($checkAvailbility) || count($checkAvailbility) == 0) {
                    $checkAvailbility = $this->db->query("SELECT *, ( 6371 * acos( cos( radians($origin_lat) ) * cos( radians( origin_lat ) ) * cos( radians( origin_lng ) - radians($origin_lng) ) + sin( radians($origin_lat) ) * sin( radians( origin_lat ) ) ) ) AS distance FROM service_details WHERE id IN($getAvailableServiceId) AND start_datetime BETWEEN DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s') AND DATE_FORMAT(NOW() + INTERVAL 30 MINUTE, '%Y-%m-%d %H:%i:%s') HAVING distance < $radius ORDER BY distance")->getResult();
                }

                if (!empty($checkAvailbility) && count($checkAvailbility) > 0) {

                    $success = 1;
                    $service_rate = $checkAvailbility[0]->service_rate;
                    $totalfare = $checkAvailbility[0]->fare_per_sit;
                } else {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'Sorry! No service availble on this root'
                        ]
                    ];
                }
            } elseif ($booking_type == 'future_cab') {
                $success = 0;
            } elseif ($booking_type == 'lift') {
                $success = 0;
                $checkAvailbility = $this->db->query("SELECT *, ( 6371 * acos( cos( radians($origin_lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($origin_lng) ) + sin( radians($origin_lat) ) * sin( radians( lat ) ) ) ) AS distance FROM lift_driver_status WHERE status =1 AND vehicle_type = $vehicle_type HAVING distance < $radius ORDER BY distance")->getResult();
                if (empty($checkAvailbility) || count($checkAvailbility) == 0) {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'Sorry! No active vehicle nearby you!'
                        ]
                    ];
                } else {
                    $from_add = $this->getAddressFromLatLng($origin_lat, $origin_lng);
                    $to_add = $this->getAddressFromLatLng($destination_lat, $destination_lng);
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
                        'vehicle_id' => '',
                        'driver_id' => '',
                        'status' => 0,
                        'created_by' => 0,
                        'updated_by' => 0,
                        'updated_at' => date('Y-m-d H:i:s')

                    ];

                    $booking_id = $this->AdminModel->InsertService($data);

                    foreach ($checkAvailbility as $service) {

                        $driverSubscriptionStatus = $this->AdminModel->getDriverSubscriptionStatus($service->driver_id);

                       if(isset($driverSubscriptionStatus) && count($driverSubscriptionStatus) == 0){
                        continue;
                       } 

                        $this->sendPushNotification($service->driver_id, 'A new booking request', 'Here is a booking request from ' . $from_add . 'to ' . $to_add);
                        $getVehicleId = $this->AdminModel->getSingleData('vehicle_details', $service->driver_id, 'driver_id');
                        $data = [
                            'booking_id' => $booking_id,
                            'vehicle_id' => $getVehicleId->id,
                            'driver_id' => $service->driver_id,
                            'status' => 0
                        ];
                        $this->AdminModel->InsertRecord('lift_request', $data);
                    }

                    $BookingData = $this->AdminModel->getBookingData($booking_id);
                    $vehicleList = $this->AdminModel->getBookingwiseLiftRequest($booking_id);
                    $response = [
                        'status'   => 200,
                        'error'    => null,
                        'response' => [
                            'success' => 'Booking register successfully!',
                            'bookingDetails' => $BookingData,
                            'availbleVehicleList' => $vehicleList
                        ],
                    ];
                }
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
                $from_add = $this->getAddressFromLatLng($origin_lat, $origin_lng);
                $to_add = $this->getAddressFromLatLng($destination_lat, $destination_lng);
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

                    $this->sendPushNotification($service->driver_id, 'A new booking request', 'Here is a booking request from ' . $from_add . 'to ' . $to_add);

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
                $bookingDetails = $this->AdminModel->getSingleData('service_bookings', $requestDetails->booking_id);
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

                if ($bookingDetails->booking_type == 'cab' || $bookingDetails->booking_type == 'cab') {
                    $this->db->query("UPDATE service_details SET booking_status = 1 WHERE id = $serviceDetails->id");
                } else {

                    if ($serviceDetails->share_booking_ids != '') {
                        $allBookingids = explode(',', $serviceDetails->share_booking_ids);
                        array_push($allBookingids, $requestDetails->booking_id);
                        $booking_ids = implode(',', $allBookingids);
                        $totelBooking = count($allBookingids);
                        $serviceRate = $this->AdminModel->getSingleData('service_rate', $requestDetails->service_rate);
                        if ($totelBooking >= $serviceRate->max_no_share) {
                            $this->db->query("UPDATE service_details SET status =1, share_status = 1,share_booking_ids = $booking_ids WHERE id = $serviceDetails->id");
                        } else {
                            $this->db->query("UPDATE service_details SET share_status = 1,share_booking_ids = $booking_ids WHERE id = $serviceDetails->id");
                        }
                    } else {
                        $this->db->query("UPDATE service_details SET share_status = 1,share_booking_ids = $requestDetails->booking_id WHERE id = $serviceDetails->id");
                    }
                }

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
            if ($requestDetails->status == 2) {

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
            // if ($distance <= 500) {

            if ($serviceDetails->booking_status == 1) {

                $this->db->query("UPDATE service_bookings SET status = 3 WHERE service_id = $service_id ");
            }
            $data = [
                'status' => 3
            ];
            $this->AdminModel->UpdateRecordById('service_details', $service_id, $data);
            if ($serviceDetails->status == 1) {
                $bookingDetails = $this->AdminModel->getSingleData('service_bookings', $service_id, 'service_id');
                if ($bookingDetails) {
                    $this->sendPushNotification($bookingDetails->user_id, 'Booking Complete', 'Your booking from ' . $bookingDetails->from_location . 'to ' . $bookingDetails->to_location . ' has been completed');
                }
            }

            $response = [
                'status'   => 200,
                'error'    => null,
                'response' => [
                    'success' => 'Service updated Successfully'
                ],
            ];
            // } else {
            //     $response = [
            //         'status'   => 200,
            //         'error'    => 1,
            //         'response' => [
            //             'message' => "You can only end Booking within 500 meter distance to drop location."
            //         ]
            //     ];
            // }
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

                    $dataU = [
                        'otp_verify_status' => 1
                    ];
                    $this->AdminModel->UpdateRecordById('service_bookings', $booking_id, $dataU);

                    $bookingDetails = $this->AdminModel->getSingleData('service_bookings', $booking_id);
                    if ($bookingDetails) {
                        $this->sendPushNotification($bookingDetails->user_id, 'Booking Start', 'Your booking from ' . $bookingDetails->from_location . 'to ' . $bookingDetails->to_location . ' has been Start!');
                    }

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
            if (count($CountEmail) > 0) {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Email id already exist!'
                    ]
                ];
                return $this->respondCreated($response);
            }
            if (count($CountContact) > 0) {
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

            if ($file != null && $file->isValid() && !$file->hasMoved()) {
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
            'contact_no' => 'required|numeric|exact_length[10]|is_unique[user.contact_no]',
            'email' => 'required|is_unique[user.email]',
            'city' => 'required'
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
            $created_by = $this->request->getVar('member_id');
            $file = $this->request->getFile('img');

            if ($file != null && $file->isValid() && !$file->hasMoved()) {
                $imagename = $file->getRandomName();
                $file->move('uploads/', $imagename);
            } else {
                $imagename = "";
            }

            $file1 = $this->request->getFile('frontimg');

            if ($file1 != null && $file1->isValid() && !$file1->hasMoved()) {
                $imagename1 = $file1->getRandomName();
                $file1->move('uploads/', $imagename1);
            } else {
                $imagename1 = "";
            }
            $file2 = $this->request->getFile('backimg');

            if ($file2 != null && $file2->isValid() && !$file2->hasMoved()) {
                $imagename2 = $file2->getRandomName();
                $file2->move('uploads/', $imagename2);
            } else {
                $imagename2 = "";
            }

            $license_img = $this->request->getFile('license_img');

            if ($license_img != null && $license_img->isValid() && !$license_img->hasMoved()) {
                $license_img1 = $license_img->getRandomName();
                $license_img->move('uploads/', $license_img1);
            } else {
                $license_img1 = "";
            }

            $cheque = $this->request->getFile('cheque');

            if ($cheque != null &&  $cheque->isValid() && !$cheque->hasMoved()) {
                $cheque_name = $cheque->getRandomName();
                $cheque->move('uploads/', $cheque_name);
            } else {
                $cheque_name = "";
            }

            $data = [
                'full_name' => $this->request->getVar('full_name'),
                'email'  => $this->request->getVar('email'),
                'contact_no'  => $this->request->getVar('contact_no'),
                'alter_cnum'  => $this->request->getVar('altcontact'),
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
                'block'  => $this->request->getVar('block'),
                'ditrict'  => $this->request->getVar('ditrict'),
                'father_name'  => $this->request->getVar('father_name'),
                'blood_group'  => $this->request->getVar('blood_group'),
                'spouse_name'  => $this->request->getVar('spouse_name'),
                'cheque'  => $cheque_name,
                'branch_name'  => $this->request->getVar('branch_name'),
                'user_type'  => 4,
                'license_no'  => $this->request->getVar('license_no'),
                'license_type'  => $this->request->getVar('license_type'),
                'license_expire_date'  => $this->request->getVar('license_expire_date'),
                'dob'  => $this->request->getVar('dob'),

                'mother_name'  => $this->request->getVar('mother_name'),
                'nominee_name'  => $this->request->getVar('nominee_name'),
                'nominee_rltn'  => $this->request->getVar('nominee_rltn'),
                'nominee_add'  => $this->request->getVar('nominee_add'),
                'nominee_dob'  => $this->request->getVar('nominee_dob'),

                'license_img'  => $license_img1,
                'status' => 1,
                'ac_name'  => $this->request->getVar('ac_name'),
                'bank_name'  => $this->request->getVar('bank_name'),
                'acc_no'  => $this->request->getVar('acc_no'),
                'ifsc'  => $this->request->getVar('ifsc'),
                'exp_year'  => $this->request->getVar('exp_year'),
                'created_by' => $created_by

            ];


            $this->AdminModel->adduser($data);

            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => 'Driver added successfully!',
                    'userDetails' => $data
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

            if ($file != null && $file->isValid() && !$file->hasMoved()) {
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

    public function getAllNotification()
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
            $allNotification = $this->AdminModel->getAllDriverNotification($user_id);
            $this->db->query("UPDATE notifications SET status = 1 WHERE 'user_id' = $user_id");
            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => 'Scedule Service List',
                    'allNotification' => $allNotification
                ],
            ];
        }

        return $this->respondCreated($response);
    }


    public function addRatingReviews()
    {
        $rules = [
            'user_id' => 'required',
            'driver_id' => 'required',
            'booking_id' => 'required',
            'rating' => 'required'

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
            $driver_id = $this->request->getVar('driver_id');
            $booking_id = $this->request->getVar('booking_id');
            $rating = $this->request->getVar('rating');
            $review = $this->request->getVar('review');

            $data = [
                'user_id' => $user_id,
                'driver_id' => $driver_id,
                'booking_id' => $booking_id,
                'ratting' => $rating,
                'review' => $review,
                'status' => 1
            ];

            $this->AdminModel->InsertRecord('ratting_review', $data);
            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => 'rating added successfully!'
                ],
            ];
        }

        return $this->respondCreated($response);
    }

    public function editRattingReview()
    {
        $rules = [
            'ratting_id' => 'required',
            'rating' => 'required'
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
            $ratting_id = $this->request->getVar('ratting_id');
            $rating = $this->request->getVar('rating');
            $review = $this->request->getVar('review');

            $data = [
                'ratting' => $rating,
                'review' => $review
            ];

            $this->AdminModel->UpdateRecordById('ratting_review', $ratting_id, $data);

            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => 'rating updated successfully!'
                ],
            ];
        }

        return $this->respondCreated($response);
    }

    public function getBookingRatting()
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
            $ratting = $this->AdminModel->getSingleData('ratting_review', $booking_id, 'booking_id');
            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => 'here is the booking ratting review details',
                    'ratting' => $ratting
                ],
            ];
        }

        return $this->respondCreated($response);
    }

    function editSceduleService()
    {
        $rules = [
            'service_id' => 'required',
            'origin_lat' => 'required',
            'origin_lng' => 'required',
            'destination_lat' => 'required',
            'destination_lng' => 'required',
            'boarding_datetime' => 'required'
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
            if (!empty($serviceDetails) && $serviceDetails->booking_status == 0 && $serviceDetails->status == 0) {


                $checkServicRate = $this->AdminModel->getSingleData('service_rate', $serviceDetails->service_rate);
                $origin_lat = $this->request->getVar('origin_lat');
                $origin_lng = $this->request->getVar('origin_lng');
                $destination_lat = $this->request->getVar('destination_lat');
                $destination_lng = $this->request->getVar('destination_lng');
                $boarding_datetime = $this->request->getVar('boarding_datetime');

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

                    $from_add = $this->getAddressFromLatLng($origin_lat, $origin_lng);
                    $to_add = $this->getAddressFromLatLng($destination_lat, $destination_lng);

                    $data = [
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
                        'fare_per_sit' => $fare_per_sit
                    ];
                    $this->AdminModel->UpdateRecordById('service_details', $service_id, $data);
                    $serviceDetails = $this->AdminModel->getSingleData('service_details', $service_id);
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
                        'message' => "you can't edit service at this time"
                    ]
                ];
            }
        }

        return $this->respondCreated($response);
    }

    public function onGoingRide()
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
            $allService = $this->AdminModel->getOngoingDriverService($driver_id);
            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => 'ongoing service',
                    'userDetails' => $allService
                ],
            ];
        }

        return $this->respondCreated($response);
    }

    public function sendPushNotificationTemp()
    {
        $token = $this->request->getVar('token');
        $title = $this->request->getVar('title');
        $message = $this->request->getVar('message');



        $projectId = 'fernata-48950';
        $messageData = [
            'message' => [
                'token' => $token,
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
        return $this->respondCreated($echo);
    }


    public function memberLogin()
    {
        $rules = [
            'phone' =>  'required|numeric|exact_length[10]',
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
            $phone = $this->request->getVar('phone');
            $password = $this->request->getVar('password');
            $data = $this->AdminModel->checkUserPahone($phone);
            if (!empty($data) && $data != null) {
                $password = base64_encode(base64_encode($password));
                if ($data[0]->password == $password) {

                    if (($data[0]->franchise_id != null || $data[0]->franchise_id != '') && $data[0]->user_type == 2) {
                        $response = [
                            'status'   => 200,
                            'error'    => null,
                            'response' => [
                                'message' => 'Login success!',
                                'profileDetails' => $data[0]
                            ],
                        ];
                    } else {
                        $response = [
                            'status'   => 200,
                            'error'    => 1,
                            'response' => [
                                'message' => 'Invalid Request!'
                            ]
                        ];
                    }
                } else {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'Invalid password!'
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

    public function addCustomer()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'phone' => 'required|numeric|exact_length[10]|is_unique[user.contact_no]',
            'email' => 'required|is_unique[user.email]',
            'member_id' => 'required|numeric'
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
            $member_id = $this->request->getVar('member_id');
            $phone = $this->request->getVar('phone');

            // $img = $this->request->getPost('profile_image');
            $filename = '';
            // if ($img) {
            //     $img = str_replace('data:image/png;base64,', '', $img);
            //     $img = str_replace('data:image/jpeg;base64,', '', $img);
            //     $img = str_replace(' ', '+', $img);
            //     $file_data = base64_decode($img);
            //     $image_name = md5(uniqid(rand(), true));
            //     $filename = $image_name . '.' . 'png';
            //     $path = 'uploads/';
            //     file_put_contents($path . $filename, $file_data);
            // }

            $data_array = [
                'full_name' => $name,
                'email' => $email,
                'contact_no' => $phone,
                'alter_cnum' => $this->request->getVar('wp_contact'),
                'status' => 1,
                'profile_image' => $filename,
                'user_type' => 5,
                'created_by' => $member_id
            ];

            $result = $this->AdminModel->adduser($data_array);
            if ($result) {
                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'response' => [
                        'success' => 'Customer registered Successfully'
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

    public function getList()
    {
        $rules = [
            'member_id' => 'required'
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
            $member_id = $this->request->getVar('member_id');
            $memberList = $this->AdminModel->getAllUserList($member_id);
            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => ' list',
                    'userList' => $memberList
                ],
            ];
        }

        return $this->respondCreated($response);
    }


    public function addOwner()
    {
        $rules = [
            'full_name' => 'required',
            'contact_no' => 'required|numeric|exact_length[10]|is_unique[user.contact_no]',
            'email' => 'required|is_unique[user.email]',
            'city' => 'required'
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
            $created_by = $this->request->getVar('member_id');
            if ($created_by == '' || !$this->request->getVar('member_id')) {
                $created_by = 0;
            }
            $file = $this->request->getFile('img');

            if ($file != null && $file->isValid() && !$file->hasMoved()) {
                $imagename = $file->getRandomName();
                $file->move('uploads/', $imagename);
            } else {
                $imagename = "";
            }

            $file1 = $this->request->getFile('frontimg');

            if ($file1 != null && $file1->isValid() && !$file1->hasMoved()) {
                $imagename1 = $file1->getRandomName();
                $file1->move('uploads/', $imagename1);
            } else {
                $imagename1 = "";
            }
            $file2 = $this->request->getFile('backimg');

            if ($file2 != null &&  $file2->isValid() && !$file2->hasMoved()) {
                $imagename2 = $file2->getRandomName();
                $file2->move('uploads/', $imagename2);
            } else {
                $imagename2 = "";
            }

            $license_img = $this->request->getFile('license_img');

            if ($license_img != null && $license_img->isValid() && !$license_img->hasMoved()) {
                $license_img1 = $license_img->getRandomName();
                $license_img->move('uploads/', $license_img1);
            } else {
                $license_img1 = "";
            }

            $cheque = $this->request->getFile('cheque');

            if ($cheque != null && $cheque->isValid() && !$cheque->hasMoved()) {
                $cheque_name = $cheque->getRandomName();
                $cheque->move('uploads/', $cheque_name);
            } else {
                $cheque_name = "";
            }

            $data = [
                'full_name' => $this->request->getVar('full_name'),
                'email'  => $this->request->getVar('email'),
                'contact_no'  => $this->request->getVar('contact_no'),
                'alter_cnum'  => $this->request->getVar('altcontact'),
                'state_id'  => $this->request->getVar('state'),
                'city_id'  => $this->request->getVar('city'),
                'pin'  => $this->request->getVar('pincode'),
                'address1'  => $this->request->getVar('address1'),
                'address2'  => $this->request->getVar('address2'),
                'adhar_no'  => $this->request->getVar('adharno'),
                'block'  => $this->request->getVar('block'),
                'ditrict'  => $this->request->getVar('ditrict'),
                'father_name'  => $this->request->getVar('father_name'),
                'blood_group'  => $this->request->getVar('blood_group'),
                'spouse_name'  => $this->request->getVar('spouse_name'),
                'cheque'  => $cheque_name,
                'branch_name'  => $this->request->getVar('branch_name'),
                'password'  => base64_encode(base64_encode($this->request->getVar('password'))),
                'profile_image'  => $imagename,

                'adhar_font'  => $imagename1,
                'adhar_back'  => $imagename2,

                'user_type'  => 3,
                'license_no'  => $this->request->getVar('license_no'),
                'license_type'  => $this->request->getVar('license_type'),
                'license_expire_date'  => $this->request->getVar('license_expire_date'),
                'dob'  => $this->request->getVar('dob'),

                'mother_name'  => $this->request->getVar('mother_name'),
                'nominee_name'  => $this->request->getVar('nominee_name'),
                'nominee_rltn'  => $this->request->getVar('nominee_rltn'),
                'nominee_add'  => $this->request->getVar('nominee_add'),
                'nominee_dob'  => $this->request->getVar('nominee_dob'),


                'license_img'  => $license_img1,
                'status' => 1,
                'ac_name'  => $this->request->getVar('ac_name'),
                'bank_name'  => $this->request->getVar('bank_name'),
                'acc_no'  => $this->request->getVar('acc_no'),
                'ifsc'  => $this->request->getVar('ifsc'),
                'created_by' => $created_by,
                'is_driver'  => $this->request->getVar('is_driver')


            ];


            $this->AdminModel->adduser($data);

            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => 'Owner added successfully!',
                    'userDetails' => $data
                ],
            ];
        }

        return $this->respondCreated($response);
    }


    public function changeDriverStatus()
    {
        $rules = [
            'driver_id' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'status' => 'required'
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
            $driverDetails = $this->AdminModel->getSingleData('user', $driver_id);
            $vehcileDetails = $this->AdminModel->getSingleData('vehicle_details', $driver_id, 'driver_id');
            if (isset($vehcileDetails->booking_type) && $vehcileDetails->booking_type == 2) {

                $checkStatus = $this->AdminModel->getSingleData('lift_driver_status', $driver_id, 'driver_id');

                $data = [
                    'driver_id' => $driver_id,
                    'lat'  => $this->request->getVar('lat'),
                    'lng'  => $this->request->getVar('lng'),
                    'status'  => $this->request->getVar('status'),
                    'vehicle_type' => $vehcileDetails->lift_vehicle_type,
                    'updated_at'  => date('Y-m-d H:i:s')
                ];
                if (!empty($checkStatus) && isset($checkStatus->id)) {

                    $this->AdminModel->UpdateRecordById('lift_driver_status', $checkStatus->id, $data);
                } else {
                    $this->AdminModel->InsertRecord('lift_driver_status', $data);
                }

                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'response' => [
                        'success' => 'Status updated successfully!'
                    ],
                ];
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Not a valid driver!'
                    ]
                ];
            }
        }

        return $this->respondCreated($response);
    }

    public function startLiftBooking()
    {
        $rules = [
            'booking_id' => 'required',
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

            $booking_id = $this->request->getVar('booking_id');
            $lat = $this->request->getVar('lat');
            $lng = $this->request->getVar('lng');
            $bookingDetails = $this->AdminModel->getSingleData('service_bookings', $booking_id);
            $distance = $this->haversineGreatCircleDistance($bookingDetails->origin_lat, $bookingDetails->origin_lng, $lat, $lng);
            if ($distance <= 500) {

                $data = [
                    'status' => 1
                ];

                $this->AdminModel->UpdateRecordById('service_bookings', $booking_id, $data);
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'response' => [
                        'success' => 'Booking updated Successfully'
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

    public function endLiftBooking()
    {
        $rules = [
            'booking_id' => 'required',
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

            $booking_id = $this->request->getVar('booking_id');
            $bookingDetails = $this->AdminModel->getSingleData('service_bookings', $booking_id);

            $lat = $this->request->getVar('lat');
            $lng = $this->request->getVar('lng');
            $distance = $this->haversineGreatCircleDistance($bookingDetails->destination_lat, $bookingDetails->destination_lng, $lat, $lng);
            // if ($distance <= 500) {

            $data = [
                'status' => 3
            ];
            $this->AdminModel->UpdateRecordById('service_bookings', $booking_id, $data);
            $this->sendPushNotification($bookingDetails->user_id, 'Booking Complete', 'Your booking from ' . $bookingDetails->from_location . 'to ' . $bookingDetails->to_location . ' has been completed');
            $response = [
                'status'   => 200,
                'error'    => null,
                'response' => [
                    'success' => 'Booking updated Successfully'
                ],
            ];
            // } else {
            //     $response = [
            //         'status'   => 200,
            //         'error'    => 1,
            //         'response' => [
            //             'message' => "You can only end Booking within 500 meter distance to drop location."
            //         ]
            //     ];
            // }
        }
        return $this->respondCreated($response);
    }

    public function cancelLiftBooking()
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
            $data = [
                'status'  => 2,
                'updated_by' => $user_id
            ];
            $this->AdminModel->UpdateRecordById('service_bookings', $booking_id, $data);

            $this->db->query("UPDATE lift_request SET status = 2 WHERE booking_id = $booking_id ");

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

    public function accecptLiftBooking()
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
            $requestDetails = $this->AdminModel->getSingleData('lift_request', $request_id);
            if ($requestDetails->status != 0) {

                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Booking alredy closed!'
                    ]
                ];
            } else {
                $data = [
                    'status'  => 1,
                ];
                $this->AdminModel->UpdateRecordById('lift_request', $request_id, $data);
                $otp = rand(100000, 999999);
                $data = [
                    'vehicle_id'  => $requestDetails->vehicle_id,
                    'driver_id'  => $requestDetails->driver_id,
                    'otp' => $otp,
                    'status'  => 1
                ];
                $this->AdminModel->UpdateRecordById('service_bookings', $requestDetails->booking_id, $data);

                $this->db->query("UPDATE lift_request SET status = 2 WHERE booking_id = $requestDetails->booking_id AND status = 0 ");

                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'response' => [
                        'success' => 'Booking placed successfully!'
                    ],
                ];
            }
        }

        return $this->respondCreated($response);
    }

    public function getLiftBookingRequest()
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
            $allRequest = $this->AdminModel->getDriverwiseLiftRequest($driver_id);

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

    // Owner APIs Start

    public function ownerLogin()
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
            $data = $this->AdminModel->checkUserPahoneOwner($phone);
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
                        'message' => 'Phone no not registreted as Owner!'
                    ]
                ];
            }
        }

        return $this->respondCreated($response);
    }

    public function addVehicle()
    {
        $rules = [
            'owner_id' => 'required',
            'redg_no' => 'required',
            'model_name' => 'required',
            'vehicle_type' => 'required',
            'booking_type' => 'required',
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
            $vendor_id = $this->request->getPost('owner_id');
            $member_id = $this->request->getPost('member_id');
            $driver_id = $this->request->getPost('driver_id');
            $no_of_sit = $this->request->getPost('no_of_sit');
            $redg_no = $this->request->getPost('redg_no');
            $model_name = $this->request->getPost('model_name');
            $vehicle_type = $this->request->getPost('vehicle_type');


            $file = $this->request->getFile('insurance_img');
            if ($file != null && $file->isValid() && !$file->hasMoved()) {
                $insurance_img = $file->getRandomName();
                $file->move('uploads/', $insurance_img);
            } else {
                $insurance_img = "";
            }

            $file1 = $this->request->getFile('fit_doc');
            if ($file1 != null && $file1->isValid() && !$file1->hasMoved()) {
                $fit_doc = $file1->getRandomName();
                $file1->move('uploads/', $fit_doc);
            } else {
                $fit_doc = "";
            }

            $pollurion_doc = $this->request->getFile('pollurion_doc');
            if ($pollurion_doc != null && $pollurion_doc->isValid() && !$pollurion_doc->hasMoved()) {
                $pollurion_doc1 = $pollurion_doc->getRandomName();
                $pollurion_doc->move('uploads/', $pollurion_doc1);
            } else {
                $pollurion_doc1 = "";
            }

            $file3 = $this->request->getFile('permit_doc');
            if ($file3 != null && $file3->isValid() && !$file3->hasMoved()) {
                $permit_doc = $file3->getRandomName();
                $file3->move('uploads/', $permit_doc);
            } else {
                $permit_doc = "";
            }

            $rc_copy = $this->request->getFile('rc_copy');
            if ($rc_copy != null && $rc_copy->isValid() && !$rc_copy->hasMoved()) {
                $rc_copy_doc = $rc_copy->getRandomName();
                $rc_copy->move('uploads/', $rc_copy_doc);
            } else {
                $rc_copy_doc = "";
            }


            $data = [
                'type_id' => $vehicle_type,
                'model_name' => $model_name,
                'regd_no' => $redg_no,
                'no_of_sit' => $no_of_sit,
                'vendor_id' => $vendor_id,
                'vehicle_make' => $this->request->getPost('vehicle_make'),
                'vehicle_body' => $this->request->getPost('vehicle_body'),
                'engine_no' => $this->request->getPost('engine_no'),
                'chassis_no' => $this->request->getPost('chassis_no'),
                'manufacture_yr' => $this->request->getPost('manufacture_yr'),
                'vehicle_cc' => $this->request->getPost('vehicle_cc'),
                'insurance_date_from' => $this->request->getPost('insurance_date_from'),
                'insurance_date_to' => $this->request->getPost('insurance_date_to'),
                'insurance_img' => $insurance_img,
                'fit_expr' => $this->request->getPost('fit_expr'),
                'fit_doc' => $fit_doc,
                'polution_exp_date' => $this->request->getPost('polution_exp_date'),
                'pollurion_doc' => $pollurion_doc1,
                'permit_expr_date' => $this->request->getPost('permit_expr_date'),
                'permit_doc' => $permit_doc,
                'booking_type' => $this->request->getPost('booking_type'),
                'added_by' => $this->request->getPost('member_id'),
                'status' => 0,
                'rc_no' => $this->request->getPost('rc_no'),
                'rc_copy' => $rc_copy_doc,
            ];

            if($this->request->getPost('booking_type') == 2){
                $data['lift_vehicle_type']=$vehicle_type;
            }

            $vehicle_id = $this->AdminModel->InsertVehicle($data);

            if ($vehicle_id) {
                if (isset($driver_id) && $driver_id != '') {
                    $this->sendOtpForAssignDriver($driver_id, $vehicle_id, $vendor_id);
                }
                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'response' => [
                        'success' => 'Vehicle added successfully!',
                        'userDetails' => $data
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

    public function editVehicle()
    {
        $rules = [
            'vehicle_id' => 'required',
            'redg_no' => 'required',
            'model_name' => 'required',
            'vehicle_type' => 'required',
            'booking_type' => 'required',
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
            $vehicle_id = $this->request->getPost('vehicle_id');
            $no_of_sit = $this->request->getPost('no_of_sit');
            $redg_no = $this->request->getPost('redg_no');
            $model_name = $this->request->getPost('model_name');
            $vehicle_type = $this->request->getPost('vehicle_type');
            $vendor_id = $this->request->getPost('owner_id');
            $driver_id = $this->request->getPost('driver_id');

            if (isset($driver_id) && $driver_id != '') {
                $this->sendOtpForAssignDriver($driver_id, $vehicle_id, $vendor_id);
            }

            $data = [
                'type_id' => $vehicle_type,
                'model_name' => $model_name,
                'regd_no' => $redg_no,
                'no_of_sit' => $no_of_sit,
                'vehicle_make' => $this->request->getPost('vehicle_make'),
                'vehicle_body' => $this->request->getPost('vehicle_body'),
                'engine_no' => $this->request->getPost('engine_no'),
                'chassis_no' => $this->request->getPost('chassis_no'),
                'manufacture_yr' => $this->request->getPost('manufacture_yr'),
                'vehicle_cc' => $this->request->getPost('vehicle_cc'),
                'insurance_date_from' => $this->request->getPost('insurance_date_from'),
                'insurance_date_to' => $this->request->getPost('insurance_date_to'),
                'fit_expr' => $this->request->getPost('fit_expr'),
                'polution_exp_date' => $this->request->getPost('polution_exp_date'),
                'permit_expr_date' => $this->request->getPost('permit_expr_date'),
                'booking_type' => $this->request->getPost('booking_type'),
                'rc_no' => $this->request->getPost('rc_no')
            ];

            if($this->request->getPost('booking_type') == 2){
                $data['lift_vehicle_type']=$vehicle_type;
            }

            if (isset($vendor_id) && $vendor_id != '') {
                $data['vendor_id'] = $vendor_id;
            }

            $file = $this->request->getFile('insurance_img');
            if ($file != null && $file->isValid() && !$file->hasMoved()) {
                $insurance_img = $file->getRandomName();
                $file->move('uploads/', $insurance_img);
                $data['insurance_img'] = $insurance_img;
            }

            $file1 = $this->request->getFile('fit_doc');
            if ($file1 != null && $file1->isValid() && !$file1->hasMoved()) {
                $fit_doc = $file1->getRandomName();
                $file1->move('uploads/', $fit_doc);
                $data['fit_doc'] = $fit_doc;
            }

            $pollurion_doc = $this->request->getFile('pollurion_doc');
            if ($pollurion_doc != null && $pollurion_doc->isValid() && !$pollurion_doc->hasMoved()) {
                $pollurion_doc1 = $pollurion_doc->getRandomName();
                $pollurion_doc->move('uploads/', $pollurion_doc1);
                $data['pollurion_doc'] = $pollurion_doc1;
            }

            $file3 = $this->request->getFile('permit_doc');
            if ($file3 != null &&  $file3->isValid() && !$file3->hasMoved()) {
                $permit_doc = $file3->getRandomName();
                $file3->move('uploads/', $permit_doc);
                $data['permit_doc'] = $permit_doc;
            }

            $rc_copy = $this->request->getFile('rc_copy');
            if ($rc_copy != null &&  $rc_copy->isValid() && !$rc_copy->hasMoved()) {
                $rc_copy_doc = $rc_copy->getRandomName();
                $rc_copy->move('uploads/', $rc_copy_doc);
                $data['rc_copy'] = $rc_copy_doc;
            }

            $this->AdminModel->UpdateRecordById('vehicle_details', $vehicle_id, $data);

            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => 'Vehicle updated successfully!'
                ],
            ];
        }

        return $this->respondCreated($response);
    }

    public function sendOtpForAssignDriver($driver_id, $vehicle_id, $owner_id)
    {
        $vehicleDetails = $this->AdminModel->getSingleData('vehicle_details', $vehicle_id);
        $driverDetails = $this->AdminModel->getSingleData('user', $driver_id);

            if ($driverDetails->license_type == 'mcwg' && ($vehicleDetails->lift_vehicle_type == 1  || $vehicleDetails->booking_type != 2)) {
                return true;
            }
        if ($vehicleDetails->driver_id != '' && $vehicleDetails->driver_id != $driver_id) {
            if ($vehicleDetails->driver_id  == $driver_id) {
                return true;
            }
            $data = [
                'status'  => 3,
                'updated_by' => $owner_id
            ];
            $this->AdminModel->updateDriverRemoved($vehicleDetails->driver_id, $vehicle_id, $data);
        }

        $this->db->query("UPDATE driver_vehicle_mapping SET status = 2, updated_by = $owner_id WHERE vehicle_id = $vehicle_id AND status = 0; ");

        $otp = rand(100000, 999999);
        $data = [
            'driver_id' => $driver_id,
            'vehicle_id' => $vehicle_id,
            'owner_id' => $owner_id,
            'updated_by' => $owner_id,
            'status' => 0,
            'otp' => $otp
        ];

        $this->AdminModel->InsertRecord('driver_vehicle_mapping', $data);
    }

    function getDriverList()
    {
        $driverList = $this->AdminModel->getMemberDriverList();
        $response = [
            'status'   => 201,
            'error'    => null,
            'response' => [
                'success' => 'Driver list',
                'driverList' => $driverList
            ],
        ];

        return $this->respondCreated($response);
    }

    function sendOtpToAssignDriver()
    {
        $rules = [
            'driver_id' => 'required',
            'vehicle_id' => 'required',
            'owner_id' => 'required'
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
            $vehicle_id = $this->request->getVar('vehicle_id');
            $owner_id = $this->request->getVar('owner_id');
            $vehicleDetails = $this->AdminModel->getSingleData('vehicle_details', $vehicle_id);

            $driverDetails = $this->AdminModel->getSingleData('user', $driver_id);

            if ($driverDetails->license_type == 'mcwg' && ($vehicleDetails->lift_vehicle_type == 1  || $vehicleDetails->booking_type != 2)) {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Driver have not a valid license for assign such vehicle'
                    ]
                ];
            } else {



                if ($vehicleDetails->driver_id != '' && $vehicleDetails->driver_id != $driver_id) {
                    $data = [
                        'status'  => 3,
                        'updated_by' => $owner_id
                    ];
                    $this->AdminModel->updateDriverRemoved($vehicleDetails->driver_id, $vehicle_id, $data);
                }

                $this->db->query("UPDATE driver_vehicle_mapping SET status = 2, updated_by = $owner_id WHERE vehicle_id = $vehicle_id AND status = 0; ");

                $otp = rand(100000, 999999);
                $data = [
                    'driver_id' => $driver_id,
                    'vehicle_id' => $vehicle_id,
                    'owner_id' => $owner_id,
                    'updated_by' => $owner_id,
                    'status' => 0,
                    'otp' => $otp
                ];

                $this->AdminModel->InsertRecord('driver_vehicle_mapping', $data);

                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'response' => [
                        'success' => 'Otp send to driver!',
                        'otp' => $otp
                    ],
                ];
            }
        }

        return $this->respondCreated($response);
    }

    function verifyDriverAssignOtp()
    {
        $rules = [
            'driver_id' => 'required',
            'vehicle_id' => 'required',
            'owner_id' => 'required',
            'otp' => 'required'
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
            $vehicle_id = $this->request->getVar('vehicle_id');
            $owner_id = $this->request->getVar('owner_id');
            $otp = $this->request->getVar('otp');
            $getRequestId = $this->db->query("SELECT * FROM driver_vehicle_mapping WHERE driver_id = $driver_id AND vehicle_id = $vehicle_id AND status = 0;")->getRow();

            if (!empty($getRequestId)) {

                if ($getRequestId->otp == $otp) {
                    $data = [
                        'status' => 1,
                        'updated_by' => $owner_id
                    ];
                    $this->AdminModel->UpdateRecordById('driver_vehicle_mapping', $vehicle_id, $data);

                    $data = [
                        'status' => 1,
                        'driver_id' => $driver_id
                    ];
                    $this->AdminModel->UpdateRecordById('vehicle_details', $vehicle_id, $data);
                    $response = [
                        'status'   => 201,
                        'error'    => null,
                        'response' => [
                            'success' => 'Otp matched & vehicle assign to driver successfully!'
                        ],
                    ];
                } else {
                    $response = [
                        'status'   => 200,
                        'error'    => 1,
                        'response' => [
                            'message' => 'Invalid OTP!!'
                        ]
                    ];
                }
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Invalid Request!'
                    ]
                ];
            }
        }

        return $this->respondCreated($response);
    }

    function getOwnerwiseVehicleList()
    {
        $rules = [
            'owner_id' => 'required'
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
            $owner_id = $this->request->getVar('owner_id');
            $vehicleList = $this->AdminModel->getOwnerwiseVehicleList($owner_id);
            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => 'Vehicle list',
                    'vehicleList' => $vehicleList
                ],
            ];
        }

        return $this->respondCreated($response);
    }

    function employeeCheckInCheckOut()
    {
        $rules = [
            'member_id' => 'required',
            'lat' => 'required',
            'lng' => 'required',
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
            $member_id = $this->request->getVar('member_id');
            $type = $this->request->getVar('type');
            $imgfile = $this->request->getVar('image');

            $lat = $this->request->getVar('lat');
            $lng = $this->request->getVar('lng');
            $location = $this->getAddressFromLatLng($lat, $lng);
            $file = $this->request->getFile('image');
            if ($file != null && $file->isValid() && !$file->hasMoved()) {
                $imgfile = $file->getRandomName();
                $file->move('uploads/', $imgfile);
            } else {
                $imgfile = "";
            }

            $data = [
                'member_id' => $member_id,
                'type' => $type,
                'image' => $imgfile,
                'date' => date('Y-m-d'),
                'time' => date('H:i'),
                'location' => $location
            ];

            $this->AdminModel->InsertRecord('members_checkin', $data);
            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => $type.' added successfully!'
                ],
            ];
        }

        return $this->respondCreated($response);
    }

    public function liftBookingHistoryCustomer()
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
            $allService = $this->AdminModel->getAllCustomerLiftBookingData($customer_id);
            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => 'Lift Booking List',
                    'userDetails' => $allService
                ],
            ];
        }

        return $this->respondCreated($response);
    }

    public function getCheckinList()
    {
        $rules = [
            'member_id' => 'required'
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
            $member_id = $this->request->getVar('member_id');
            $Listdata = $this->AdminModel->getMemebrCheckinCheckoutList($member_id);
            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => 'All Checkin Checkout list',
                    'checklist' => $Listdata
                ],
            ];
        }

        return $this->respondCreated($response);
    }

    public function memberwiseOwenrList()
    {
        $rules = [
            'member_id' => 'required'
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
            $member_id = $this->request->getVar('member_id');
            $memberList = $this->AdminModel->getAllOwnerList($member_id);
            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => ' list',
                    'ownerlist' => $memberList
                ],
            ];
        }

        return $this->respondCreated($response);
    }

    public function getMemberwiseVehicleList()
    {
        $rules = [
            'member_id' => 'required'
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
            $member_id = $this->request->getVar('member_id');
            $vehicleList = $this->AdminModel->getMemberwiseVehicleList($member_id);
            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => ' list',
                    'vehicleList' => $vehicleList
                ],
            ];
        }

        return $this->respondCreated($response);
    }

    public function updateUser()
    {
        $rules = [
            'user_id' => 'required|numeric',
            'full_name' => 'required',
            'contact_no' => 'required|numeric|exact_length[10]',
            'email' => 'required',
            'city' => 'required'
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
            $id = $this->request->getVar('user_id');
            $file = $this->request->getFile('img');

            if ($file != null && $file->isValid() && !$file->hasMoved()) {
                $imagename = $file->getRandomName();
                $file->move('uploads/', $imagename);
            } else {
                $imagename = "";
            }

            $file1 = $this->request->getFile('frontimg');

            if ($file1 != null && $file1->isValid() && !$file1->hasMoved()) {
                $imagename1 = $file1->getRandomName();
                $file1->move('uploads/', $imagename1);
            } else {
                $imagename1 = "";
            }
            $file2 = $this->request->getFile('backimg');

            if ($file2 != null &&  $file2->isValid() && !$file2->hasMoved()) {
                $imagename2 = $file2->getRandomName();
                $file2->move('uploads/', $imagename2);
            } else {
                $imagename2 = "";
            }

            $license_img = $this->request->getFile('license_img');

            if ($license_img != null && $license_img->isValid() && !$license_img->hasMoved()) {
                $license_img1 = $license_img->getRandomName();
                $license_img->move('uploads/', $license_img1);
            } else {
                $license_img1 = "";
            }

            $cheque = $this->request->getFile('cheque');

            if ($cheque != null && $cheque->isValid() && !$cheque->hasMoved()) {
                $cheque_name = $cheque->getRandomName();
                $cheque->move('uploads/', $cheque_name);
            } else {
                $cheque_name = "";
            }

            $data = [
                'full_name' => $this->request->getVar('full_name'),
                'email'  => $this->request->getVar('email'),
                'contact_no'  => $this->request->getVar('contact_no'),
                'alter_cnum'  => $this->request->getVar('altcontact'),
                'state_id'  => $this->request->getVar('state'),
                'city_id'  => $this->request->getVar('city'),
                'pin'  => $this->request->getVar('pincode'),
                'address1'  => $this->request->getVar('address1'),
                'address2'  => $this->request->getVar('address2'),
                'adhar_no'  => $this->request->getVar('adharno'),
                'block'  => $this->request->getVar('block'),
                'ditrict'  => $this->request->getVar('ditrict'),
                'father_name'  => $this->request->getVar('father_name'),
                'blood_group'  => $this->request->getVar('blood_group'),
                'spouse_name'  => $this->request->getVar('spouse_name'),
                'spouse_name'  => $this->request->getVar('spouse_name'),
                'branch_name'  => $this->request->getVar('branch_name'),
                'password'  => base64_encode(base64_encode($this->request->getVar('password'))),
                'license_no'  => $this->request->getVar('license_no'),
                'license_type'  => $this->request->getVar('license_type'),
                'license_expire_date'  => $this->request->getVar('license_expire_date'),
                'dob'  => $this->request->getVar('dob'),

                'mother_name'  => $this->request->getVar('mother_name'),
                'nominee_name'  => $this->request->getVar('nominee_name'),
                'nominee_rltn'  => $this->request->getVar('nominee_rltn'),
                'nominee_add'  => $this->request->getVar('nominee_add'),
                'nominee_dob'  => $this->request->getVar('nominee_dob'),
                'ac_name'  => $this->request->getVar('ac_name'),
                'bank_name'  => $this->request->getVar('bank_name'),
                'acc_no'  => $this->request->getVar('acc_no'),
                'ifsc'  => $this->request->getVar('ifsc'),
                'is_driver'  => $this->request->getVar('is_driver')


            ];

            if ($imagename != "") {
                $data['profile_image']  = $imagename;
            }
            if ($imagename1 != "") {

                $data['adhar_font']  = $imagename1;
            }
            if ($imagename2 != "") {

                $data['adhar_back']  = $imagename1;
            }

            if ($license_img1 != "") {

                $data['license_img']  = $license_img1;
            }

            if ($cheque_name != "") {

                $data['cheque']  = $cheque_name;
            }


            $this->AdminModel->updateUser($data, $id);

            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => 'User details updated successfully!',
                    'userDetails' => $data
                ],
            ];
        }

        return $this->respondCreated($response);
    }

    public function memberwiseDriverList()
    {
        $rules = [
            'member_id' => 'required'
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
            $member_id = $this->request->getVar('member_id');
            $memberList = $this->AdminModel->getMemberDriverList();
            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => ' list',
                    'driverlist' => $memberList
                ],
            ];
        }

        return $this->respondCreated($response);
    }

    public function driverVehicleDetails()
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
            $vehicleDetails = $serviceDetails = $this->AdminModel->getSingleData('vehicle_details', $driver_id, 'driver_id');
            if (!empty($vehicleDetails)) {
                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'response' => [
                        'success' => 'vehicle details',
                        'driverlist' => $vehicleDetails
                    ],
                ];
            } else {
                $response = [
                    'status'   => 200,
                    'error'    => 1,
                    'response' => [
                        'message' => 'Vehicle not assign to this driver!'
                    ]
                ];
            }
        }

        return $this->respondCreated($response);
    }

    public function addDriverRatingReviews()
    {
        $rules = [
            'user_id' => 'required',
            'customer_id' => 'required',
            'booking_id' => 'required',
            'rating' => 'required'

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
            $customer_id = $this->request->getVar('customer_id');
            $booking_id = $this->request->getVar('booking_id');
            $rating = $this->request->getVar('rating');
            $review = $this->request->getVar('review');

            $data = [
                'user_id' => $user_id,
                'customer_id' => $customer_id,
                'booking_id' => $booking_id,
                'ratting' => $rating,
                'review' => $review,
                'status' => 1
            ];

            $this->AdminModel->InsertRecord('ratting_review', $data);
            $response = [
                'status'   => 201,
                'error'    => null,
                'response' => [
                    'success' => 'rating added successfully!'
                ],
            ];
        }

        return $this->respondCreated($response);
    }
}

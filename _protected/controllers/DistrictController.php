<?php

namespace app\controllers;

use app\models\District;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class DistrictController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['refresh'],
                'rules' => [
                    [
                        'actions' => ['refresh'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],

                ],
            ],
        ];
    }


    public function actionRefresh()
    {
        $districts = District::find()->where(['lat' => null])->limit(500)->all();

        $succeeed = 0;
        $failed = 0;
        foreach ($districts as $district) {
            $address = str_replace(' ', '+', $district->name) . ',+' . str_replace(' ', '+', $district->regency->name) . ',+' . str_replace(' ', '+', $district->regency->province->name);
//            echo $address;
            $location = $this->geocode($address);
            if ($location) {
                $district->lat = $location['0'];
                $district->lng = $location['1'];
                $district->save();
                $succeeed++;
            } else {
                $failed++;
            }
//            print_r($location);
//            echo $location['1'];

        }

        echo "Success: " . $succeeed . '; Failed: ' . $failed;

    }

// function to geocode address, it will return false if unable to geocode address
    function geocode($address)
    {

        // url encode the address
        $address = urlencode($address);

        // google map geocode api url
//        $url = "https://maps.google.com/maps/api/geocode/json?region=indonesia&key=AIzaSyD33FVZpbDxKFso_bnFNL_HBy0ZrPTTLgs&address={$address}";
        $url = "https://maps.google.com/maps/api/geocode/json?address={$address}";

//        echo $url . '<br/>';
        // get the json response
//        $resp_json = file_get_contents($url);

        // alternative method to get json response
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $resp_json = curl_exec($ch);
        curl_close($ch);


        // decode the json
        $resp = json_decode($resp_json, true);

        // response status will be 'OK', if able to geocode given address
        if ($resp['status'] == 'OK') {

            // get the important data
            $lati = $resp['results'][0]['geometry']['location']['lat'];
            $longi = $resp['results'][0]['geometry']['location']['lng'];
//            $formatted_address = $resp['results'][0]['formatted_address'];

            // verify if data is complete
            if ($lati && $longi) {

                // put the data in the array
                $data_arr = array();

                array_push(
                    $data_arr,
                    $lati,
                    $longi
//                    $formatted_address
                );
                return $data_arr;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

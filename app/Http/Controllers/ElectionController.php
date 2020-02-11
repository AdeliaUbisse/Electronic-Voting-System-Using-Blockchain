<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

class ElectionController extends Controller
{
    public function create()
    {
        return view('election.CanList');
    }

    public function store()
    {
       if  (isset($_POST['1'])){
        $result = $this->PostDataToChain('Joe','1');
        //$result = $this->getChain();
        return $result;
        //session()->flash('success','Your ballot is added into blockchain.');
        //return redirect()->route('home');
       }
       else{
           return "hellpo";
       }

    }

    public function PostDataToChain($uname,$ca)
    {
        $url = $this->getURL();
        $Ballot = array(
            'sender' => "$uname",
            'recipient' => "$url",
            'ballot' => "$ca"
        );
        $AddBallotUrl = "$url/transactions/new";
        $ch = curl_init($AddBallotUrl);
        $jsonDataEncoded = json_encode($Ballot);
        curl_setopt($ch , CURLOPT_POST , 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        //echo "<h1>Thanks for your participation!</h1>";
        //echo $jsonDataEncoded . "</br>";
        $result = curl_exec($ch);
        return $jsonDataEncoded;
    }

    public function getChain()
    {
        //$nodeAddress = "http://localhost:5001";
        $client = new \GuzzleHttp\Client();
        $url = $this->getURL();
        $response = $client->request('GET', "$url/chain");
        $result = $response->getBody();
        return $result;
    }

    public function getURL()
    {
        return $url = 'http://192.168.31.173:8080';
    }
}
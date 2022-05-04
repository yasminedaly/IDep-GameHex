<?php

namespace App\Service;

use LoLApi\ApiClient;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/riot")
 */
class riotApi
{

    public function getApiClient(): ApiClient
    {
        return new ApiClient(ApiClient::REGION_EUW, 'RGAPI-dc71ec01-75b2-4746-8f92-83a99c9c4d58');
    }

    public function getSummoner($summonerName){
        $apiClient = $this->getApiClient();
        $apiResultObject = $apiClient->getSummonerApi()->getSummonerBySummonerName($summonerName);
        return $apiResultObject->getResult();
    }

    /**
     * @Route("/summonerMatches", name="summoner_matches", methods={"GET"})
     */
    public function getMatchesBySummoner(){

    }
}
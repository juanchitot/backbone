<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Dto\ZipCodeDto;
use App\Models\City;
use App\Models\Municipality;
use App\Models\Settlement;
use App\Models\SettlementType;
use App\Models\State;
use App\Models\ZoneType;
use App\Repositories\ZipCodesRepository;
use Illuminate\Support\Facades\Cache;

class ZipCodesController extends Controller
{
    /**
     * @var ZipCodesRepository
     */
    private $zipCodesRepository;

    public function __construct(ZipCodesRepository $zipCodesRepository)
    {
        $this->zipCodesRepository = $zipCodesRepository;
    }

    public function index($code)
    {
        $result = [];
        if (Cache::has($code)) {
            return Cache::get($code);
        }
        $municipality = $this->zipCodesRepository->municipalityByZipCode($code);
        if ($municipality) {
            $result = ZipCodeDto::createFromMunicipality($code, $municipality);
            Cache::put($code, $result);
        } else {
            $result = ['error' => "Zip Code $code  Not Found"];
        }
        return $result;
    }

    public function load($number)
    {
        $csvFile = file(base_path() . "/import/CPdescarga$number.csv");
        $data = [];
        $first_line = true;
        foreach ($csvFile as $line) {
            if ($first_line) {
                $first_line = false;
                continue;
            }
            $data = str_getcsv($line);
            try {
                $settlementType = $this->insertSettlementType($data);
                $zoneType = $this->inserZoneType($data);
                $state = $this->insertState($data);
                $city = $this->insertCity($data, $state);
                $municipality = $this->insertMunicipality($data, $state);
                $settlement = $this->insertSettlement($data, $settlementType, $zoneType, $municipality, $city);


            } catch (\Throwable $e) {
                echo "Fallo con la linea " . print_r($data, true);
                echo $e;
            }
        }
    }

    private function insertSettlementType(array $data): SettlementType
    {
        $settlementTypeStr = $data[2];
        return SettlementType::query()->firstOrCreate(['name' => $settlementTypeStr]);
    }

    private function inserZoneType(array $data): ZoneType
    {
        $zoneTypeStr = $data[13];
        return ZoneType::query()->firstOrCreate(['name' => $zoneTypeStr]);
    }

    private function insertState(array $data)
    {
        $stateStr = $data[4];
        $state = State::query()->where(['state_uid' => (int)$data[7]])->first();
        if (!$state) {
            $state = new State(['name' => $stateStr, 'state_uid' => (int)$data[7]]);
            $state->saveOrFail();

        }
        return $state;
    }

    private function insertCity(array $data, State $state)
    {
        $cityName = $data[5];
        $city_uid = (int )$data[14];
        if (empty($city_uid))
            return null;
        $city = City::query()
            ->where(['city_uid' => $city_uid,
                'state_id' => $state->id
            ])->first();
        if (!$city) {
            $city = new City(['name' => $cityName, 'city_uid' => $city_uid]);
            $city->state()->associate($state);
            $city->saveOrFail();
        }
        return $city;
    }

    private function insertMunicipality($data, State $state)
    {
        $municipalityName = $data[3];
        $municipality = Municipality::query()
            ->where([
                'municipality_uid' => (int)$data[11],
                'state_id' => $state->id
            ])->first();
        if (!$municipality) {
            $municipality = new Municipality(['name' => $municipalityName, 'municipality_uid' => (int)$data[11]]);
            $municipality->state()->associate($state);
            $municipality->saveOrFail();
        }
        return $municipality;

    }

    private function insertSettlement(array $data, SettlementType $settlementType, ZoneType $zoneType, Municipality $municipality, City $city = null)
    {
        /* @var $settlement Settlement */
        $settlementName = $data[1];
        $zip_code = (int)$data[0];
        $settlement = Settlement::query()
            ->where(['zip_code' => $zip_code,
                'municipality_id' => $municipality->id,
                'settlement_uid' => (int)$data[12]
            ])->first();
        if (!$settlement) {

            $settlement = new Settlement(['name' => $settlementName, 'zip_code' => $zip_code, 'settlement_uid' => (int)$data[12]]);
            $settlement->zoneType()->associate($zoneType);
            $settlement->municipality()->associate($municipality);
            $settlement->settlementType()->associate($settlementType);
            if ($city)
                $settlement->city()->associate($city);

            $settlement->saveOrFail();
            echo $settlement->zip_code .'-'. $settlement->name . "\n";

        }
        return $settlement;

    }


}
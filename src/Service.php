<?php

namespace Deirdrelear\Seat\Infrastructure;

use DateInterval;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Service
{
    const FUEL_TYPES_ID_LIST = [16273, 4247, 4312, 4051, 4246, 81143, 81144];
    const DOCKING_STRUCTURES_TYPES_ID_LIST = [35835, 35836, 35825, 35826, 35827, 35832, 35833, 35834, 47512, 47513, 47514, 47515, 47516];
    const NAVIGATION_STRUCTURES_TYPES_ID_LIST = [35841, 35840, 37534];
    const METENOX_STRUCTURES_TYPES_ID_LIST = [81826];

    // Возвращает все корпорации, в которых состоят альты пользователя
    static public function getUserCorporationsIds() {
        // Сначала получаем идентификаторы персонажей, связанных с текущим пользователем.
        $userCharactersIds = auth()->user()->associatedCharacterIds();

        // Теперь запрашиваем в базе данных связанную с этими персонажами информацию
        $corporationIds = DB::table('character_affiliations')
            ->whereIn('character_id', $userCharactersIds)
            ->pluck('corporation_id');

        // делаем из коллекции объектов обычный массив
        $res = [];
        foreach ($corporationIds as $corporationId) {
            $res[] = $corporationId;
        }

        return $res;
    }

    // Возвращает все альянсы, в которых состоят альты пользователя
    static public function getAllianceCorporationsIds($userCorporationsIds) {
        $allianceIds = DB::table('corporation_infos')
            ->whereIn('corporation_id', $userCorporationsIds)
            ->whereNotNull('alliance_id')
            ->pluck('alliance_id')
            ->unique();
    
        return DB::table('corporation_infos')
            ->whereIn('alliance_id', $allianceIds)
            ->pluck('corporation_id')
            ->toArray();
    }

    // Возвращает все iHub в космосе в сыром виде
    static private function getRowIHubsInSpace($CorporationsIds = []) {
        // Если заданы идентификаторы корпораций, то делаем запрос только по ним
        if (count($CorporationsIds) > 0) {
            return DB::table('corporation_assets')
                ->where('location_type', '=', 'solar_system')
                ->where('type_id', '=', 32458)
                ->whereIn('corporation_id', $CorporationsIds)
                ->get();

        } else {
            return DB::table('corporation_assets')
                ->where('location_type', '=', 'solar_system')
                ->where('type_id', '=', 32458)
                ->get();
        }
    }

    // Возвращает полный список всех апгрейдов в iBub'ах
    static private function getIHubUpgrades() {
        return DB::table('corporation_assets')
            ->where('location_flag', '=', 'StructureActive')
            ->get();
    }

    // Ищет апгрейды, которое установлены в конкретной iHub
    static private function findUpgradesForIHub($iHubId, $iHubUpgrades) {
        $upgrades = [];
        // перебираем весь список топлива и находим по идентификатору нужное
        foreach ($iHubUpgrades as $iHubUpgrade) {
            if ($iHubUpgrade->location_id == $iHubId) {
                $upgrades[] = $iHubUpgrade;
            }
        }

        return $upgrades;
    }

    // Функция преобразует коллекцию объектов в массив объектов
    static private function convertCollectionToArray($items) {
        $newItems = [];
        foreach ($items as $item) {
            $newItems[] = $item;
        }

        return $newItems;
    }

    // возвращает все iHub в космосе, вместе с апгрейдами и именами
    static public function getIHubsInSpace($CorporationsIds = []) {
        // Получаем информацию о хабах в сыром виде
        $rowIHubs = self::getRowIHubsInSpace($CorporationsIds);

        // Теперь получаем полный список всех апгрейдов для IHub
        $iHubsUpgrades = self::getIHubUpgrades();

        // Теперь получаем все имена: солнечных систем, апгрейдов, корпораций
        // Теперь находим имена корпораций и типов структур
        $solarSystemIds = [];
        $iHubUpgradeIds = [];
        $corporationIds = [];

        // Сначала перебираем IHub
        foreach ($rowIHubs as $rowIHub) {
            $corporationIds[] = $rowIHub->corporation_id;
            $solarSystemIds[] = $rowIHub->location_id;
        }

        // Теперь перебиаем апгрейды к iHub
        foreach ($iHubsUpgrades as $iHubsUpgrade) {
            $iHubUpgradeIds[] = $iHubsUpgrade->type_id;
        }

        // Оставляем только уникальные идентификаторы
        $corporationIds = array_unique($corporationIds);
        $solarSystemIds = array_unique($solarSystemIds);
        $iHubUpgradeIds = array_unique($iHubUpgradeIds);

        // Получаем корпорации по списку идентификаторов
        $corporations = self::getCorporationsByIds($corporationIds);

        // Запрашиваем типы апгрейдов.
        $iHubsUpgradeTypes = self::getTypesByIds($iHubUpgradeIds);

        // Получаем названия солнечных систем
        $solarSystems = self::getSolarSystems($solarSystemIds);

        // Разносим апгрейды по принадежности в каждый iHub
        foreach ($rowIHubs as &$rowIHub) {
            $rowIHub->upgrades = self::findUpgradesForIHub($rowIHub->item_id, $iHubsUpgrades);
        }

        // Перебираем список IHub'ов и заносим в него имена корпораций,
        // названия солнечных систем и апгрейдов.
        foreach ($rowIHubs as &$rowIHub) {
            $rowIHub->corporation = self::findCorporationById($rowIHub->corporation_id, $corporations);
            $rowIHub->solarSystem =  self::findSolarSystemById($rowIHub->location_id, $solarSystems);

            foreach ($rowIHub->upgrades as &$upgrade) {
                $upgrade->upgrade_type = self::findTypeById($upgrade->type_id, $iHubsUpgradeTypes);
            }

            // сортируем список апргрейдов по алфавиту
            usort($rowIHub->upgrades, function($upgrade1, $upgrade2) {
                return strcmp($upgrade1->upgrade_type->typeName, $upgrade2->upgrade_type->typeName);
            });
        }

        // Теперь преобразуем в массив и возвращаем результат
        return self::convertCollectionToArray( $rowIHubs);
    }

    // Возвращает все находящиеся в космосе навигационные структуры,
    static private function getRowNavigationStructuresInSpace($CorporationsIds = []) {
        if (count($CorporationsIds) > 0) {
            return DB::table('corporation_assets')
                ->where('location_type', '=', 'solar_system')
                ->whereIn('type_id', self::NAVIGATION_STRUCTURES_TYPES_ID_LIST)
                ->whereIn('corporation_id', $CorporationsIds)
                ->get();
        } else {
            return DB::table('corporation_assets')
                ->where('location_type', '=', 'solar_system')
                ->whereIn('type_id', self::NAVIGATION_STRUCTURES_TYPES_ID_LIST)
                ->get();
        }
    }

    // Возвращает все находящиеся в космосе структуры с доком,
    static private function getRowDockingStructuresInSpace($CorporationsIds = []) {
        if (count($CorporationsIds) > 0) {
            return DB::table('corporation_assets')
                ->where('location_type', '=', 'solar_system')
                ->whereIn('type_id', self::DOCKING_STRUCTURES_TYPES_ID_LIST)
                ->whereIn('corporation_id', $CorporationsIds)
                ->get();
        } else {
            return DB::table('corporation_assets')
                ->where('location_type', '=', 'solar_system')
                ->whereIn('type_id', self::DOCKING_STRUCTURES_TYPES_ID_LIST)
                ->get();
        }

    }

    static private function getRowMetenoxStructuresInSpace($CorporationsIds = []) {
        if (count($CorporationsIds) > 0) {
            return DB::table('corporation_assets')
                ->where('location_type', '=', 'solar_system')
                ->whereIn('type_id', self::METENOX_STRUCTURES_TYPES_ID_LIST)
                ->whereIn('corporation_id', $CorporationsIds)
                ->get();
        } else {
            return DB::table('corporation_assets')
                ->where('location_type', '=', 'solar_system')
                ->whereIn('type_id', self::METENOX_STRUCTURES_TYPES_ID_LIST)
                ->get();
        }

    }

    // Возвращает топливо, которое лежит в структурах
    static private function getFuels() {
        return DB::table('corporation_assets')
            //->where('location_type', '=', 'solar_system')
            ->whereIn('type_id', self::FUEL_TYPES_ID_LIST)
            ->get();
    }

    // Ищет топливо, которое лежит в конкретной структуре
    static private function findFuelsForStructure($structureId, $fuelList) {
        $fuels = [];
        // перебираем весь список топлива и находим по идентификатору нужное
        foreach ($fuelList as $fuel) {
            if ($fuel->location_id == $structureId) {
                $fuels[] = $fuel;
            }
        }

        return $fuels;
    }

    // Добавляет в данные о структуре данные о ее типе, корпорации, названии топлива в ней
    static private function getNamesForStructures($fueledStructures) {
        // Находим имена корпораций и типов структур
        $corporationIds = [];
        $solarSystemIds = [];
        $typeIds = [];

        // перебираем список структур и выбираем идентификаторы
        foreach ($fueledStructures as $fueledStructure) {
            $corporationIds[] = $fueledStructure->corporation_id;
            $solarSystemIds[] = $fueledStructure->location_id;
            $typeIds[] = $fueledStructure->type_id;
        }

        // Добавляем в список идентификаторов типов идентификаторы топлива.
        $typeIds = array_merge($typeIds, self::FUEL_TYPES_ID_LIST);

        // Оставляем только уникальные идентификаторы
        $corporationIds = array_unique($corporationIds);
        $solarSystemIds = array_unique($solarSystemIds);
        $typeIds = array_unique($typeIds);

        // Получаем корпорации по списку идентификаторов
        $corporations = self::getCorporationsByIds($corporationIds);

        // Получаем названия солнечных систем
        $solarSystems = self::getSolarSystems($solarSystemIds);

        // Запрашиваем типы структур.
        $types = self::getTypesByIds($typeIds);

        // Перебираем список структур и заносим в него имена копрораций, типы
        // структур и топлива
        foreach ($fueledStructures as &$fueledStructure) {
            $fueledStructure->structure_type = self::findTypeById($fueledStructure->type_id, $types);
            $fueledStructure->corporation = self::findCorporationById($fueledStructure->corporation_id, $corporations);
            $fueledStructure->solarSystem =  self::findSolarSystemById($fueledStructure->location_id, $solarSystems);
            foreach ($fueledStructure->fuels as &$fuel) {
                $fuel->fuel_type = self::findTypeById($fuel->type_id, $types);
            }
        }

        return $fueledStructures;
    }

    // Возвращает список навигационных структур
    // Со всеми именами и количествами топлива
    static public function getNavigationStructuresInSpace($CorporationsIds = []) {
        // Сначала получаем все навигационные структуры в космосе
        $NavigationStructures = self::getRowNavigationStructuresInSpace($CorporationsIds);

        // Получаем полный список всего топлива
        $fuels = self::getFuels();

        // Добавляем каждое топливо в свою структуру
        foreach ($NavigationStructures as &$NavigationStructure) {
            $NavigationStructure->fuels = self::findFuelsForStructure($NavigationStructure->item_id, $fuels);
        }

        // Получаем имена и типы для структур и возвращаем результат, заодно пребразуем в массив
        return self::convertCollectionToArray(self::getNamesForStructures($NavigationStructures));
    }

    // Возвращает список всех структур с доком
    // Со всеми именами и количествами топлива
    static public function getDockingStructuresInSpace($CorporationsIds = []) {
        // Сначала получаем все навигационные структуры в космосе
        $dockingStructures = self::getRowDockingStructuresInSpace($CorporationsIds);

        // Получаем полный список всего топлива
        $fuels = self::getFuels();

        // Добавляем каждое топливо в свою структуру
        foreach ($dockingStructures as &$dockingStructure) {
            $dockingStructure->fuels = self::findFuelsForStructure($dockingStructure->item_id, $fuels);
        }

        // Получаем имена и типы для структур и возвращаем результат, заодно преобразуем в массив
        return self::convertCollectionToArray(self::getNamesForStructures($dockingStructures));
    }

    // Возвращает список всех метеноксов
    // Со всеми именами и количествами топлива
    static public function getMetenoxStructuresInSpace($CorporationsIds = [])
    {
        // Сначала получаем все метеноксы в космосе
        $metenoxStructures = self::getRowMetenoxStructuresInSpace($CorporationsIds);
    
        // Получаем полный список всего топлива
        $fuels = self::getFuels();
    
        // Добавляем каждое топливо в свою структуру и находим ближайшую луну
        foreach ($metenoxStructures as &$metenoxStructure) {
            $metenoxStructure->fuels = self::findFuelsForStructure($metenoxStructure->item_id, $fuels);
            $nearest_moon = self::getNearestMoon($metenoxStructure->item_id);
            $metenoxStructure->nearest_moon = $nearest_moon ? $nearest_moon->name : null;
            $metenoxStructure->state = DB::table('corporation_structures')->where('structure_id', $metenoxStructure->item_id)->value('state');
            $metenoxStructure->profit = self::calculateProfit($nearest_moon->moon_id);
        }
    
        // Получаем имена и типы для структур и возвращаем результат, заодно преобразуем в массив
        return self::convertCollectionToArray(self::getNamesForStructures($metenoxStructures));
    }


    // Ищет и возвращает элемент массива типов по идентификатору
    static public function findTypeById($id, $types) {
        foreach ($types as $type) {
            if ($type->typeID == $id) {
                return $type;
            }
        }

        return null;
    }

    // Ищет и возвращает элемент массива корпорации по идентификатору
    static public function findCorporationById($id, $corporations) {
        foreach ($corporations as $corporation) {
            if ($corporation->corporation_id == $id) {
                return $corporation;
            }
        }

        return null;
    }

    // Ищет и возвращает элемент массива альянса по идентификатору
    static public function findAllianceById($id, $alliances) {
        foreach ($alliances as $alliance) {
            if ($alliance->alliance_id == $id) {
                return $alliance;
            }
        }

        return null;
    }

    // Ищет и возвращает элемент массива солнечных систем по идентификатору
    static public function findSolarSystemById($id, $solarSystems) {
        foreach ($solarSystems as $solarSystem) {
            if ($solarSystem->system_id == $id) {
                return $solarSystem;
            }
        }

        return null;
    }

    // Возвращает список типов по идентификаторам
    static public function getTypesByIds(array $ids) {
        return DB::table('invTypes')
            ->whereIn('typeID', $ids)
            ->get();
    }

    // Возвращает список корпораций по идентификаторам
    private static function getCorporationsByIds($ids) {
        return DB::table('corporation_infos')
            ->whereIn('corporation_id', $ids)
            ->get();
    }

    // Возвращает список альянсов по идентификаторам
    private static function getAlliancesByIds($ids) {
        return DB::table('alliances')
            ->whereIn('alliance_id', $ids)
            ->get();
    }

    // Возвращает список пар значений id => name для структур в космосе
    static public function getStructuresNamesByIds($ids) {
        $structureNames = [];
        $items = DB::table('universe_structures')
            ->select('structure_id as id', 'name')
            ->whereIn('structure_id', $ids)
            ->get();

        foreach ($items as $item) {
            $structureNames[$item->id] = $item->name;
        }

        return $structureNames;
    }

    // Возвращает список пар значений id => name для имен персонажей и корпораций
    static public function getNamesByIds($ids) {
        $names = [];
        $items = DB::table('universe_names')
            ->select('entity_id as id', 'name')
            ->whereIn('entity_id', $ids)
            ->get();

        foreach ($items as $item) {
            $names[$item->id] = $item->name;
        }

        return $names;
    }

    // Возвращает имена солнечных систем по идентификаторам
    static private function getSolarSystems($ids) {
        return DB::table('solar_systems')
            ->whereIn('system_id', $ids)
            ->get();
    }

    // Возвращает список всех известных SEAT копающих структур
    static private function getRowMiningStructures() {
        return DB::table('corporation_structures')
            ->whereIn('type_id', ['35835', '35836'])
            ->get();
    }

    // Возвращает список копающих структур со всеми именами и типами
    static public function getMiningStructures() {
        // Получаем список копающих структур
        $miningStructures = self::getRowMiningStructures();

        // Получаем список идентификаторов структур, типов и корпораций
        $corporationIds = [];
        $structureIds = [];
        $structureTypeIds = [];
        foreach ($miningStructures as $miningStructure) {
            $corporationIds[] = $miningStructure->corporation_id;
            $structureIds[] = $miningStructure->structure_id;
            $structureTypeIds[] = $miningStructure->type_id;
        }

        // Оставляем только уникальные значения идентификаторов корпораций
        $corporationIds = array_unique($corporationIds);

        // Запрашиваем имена для структур.
        $structureNames = self::getStructuresNamesByIds($structureIds);

        // Получаем корпорации по списку идентификаторов
        $corporations = self::getCorporationsByIds($corporationIds);

        // Пробегаемся по корпорациям и вытаскиваем из них список идентификаторов альянсов
        $allianceIds = [];
        foreach ($corporations as $corporation) {
            $allianceIds[] = $corporation->alliance_id;
        }

        // Оставляем только уникальные значения идентификаторов альянсов
        $allianceIds = array_unique($allianceIds);

        // Получаем список альянсов по идентификаторам
        $alliances = self::getAlliancesByIds($allianceIds);

        // Получаем имена типов по списку идентификаторов
        $types = self::getTypesByIds($structureTypeIds);

        // Перебираем список структур и заносим в него имена
        foreach ($miningStructures as &$miningStructure) {
            $miningStructure->name = $structureNames[$miningStructure->structure_id];
            $miningStructure->corporation = self::findCorporationById($miningStructure->corporation_id, $corporations);
            $miningStructure->alliance = self::findAllianceById($miningStructure->corporation->alliance_id, $alliances);
            $miningStructure->type = self::findTypeById($miningStructure->type_id, $types);
        }

        return $miningStructures;
    }

    // Возвращает все экстракции руды в сыром виде
    static private function getRowExtractions($days) {
        //date_sub(DateTime $object, DateInterval $interval): DateTime

        // Вычитаем из текущей даты и времени полученное значение
        $date = new DateTime('NOW');
        $date->sub(DateInterval::createFromDateString($days . 'days'));

        return DB::table('corporation_industry_mining_extractions')
            ->where('chunk_arrival_time', '<', $date)
            ->get();
    }

    // Возвращает все экстракции руды с развернутыми именами корпораций и структур
    static public function getExtractions($days) {
        // Сначала получаем список сырых экстракций
        $rowExtractions = self::getRowExtractions($days);

        // Пробегаемся по списку экстракций и получаем имена структур и корпораций
        $corporationIds = [];
        $structureIds = [];
        foreach ($rowExtractions as $rowExtraction) {
            $corporationIds[] = $rowExtraction->corporation_id;
            $structureIds[] = $rowExtraction->structure_id;
        }

        // Оставляем только уникальные идентификаторы
        $corporationIds = array_unique($corporationIds);
        $structureIds = array_unique($structureIds);

        // Запрашиваем имена для структур.
        $structureNames = self::getStructuresNamesByIds($structureIds);

        // Получаем корпорации по списку идентификаторов
        $corporations = self::getCorporationsByIds($corporationIds);

        // Перебираем список экстракций и заносим в него имена
        foreach ($rowExtractions as &$rowExtraction) {
            $rowExtraction->structure_name = $structureNames[$rowExtraction->structure_id];
            $rowExtraction->corporation = self::findCorporationById($rowExtraction->corporation_id, $corporations);
        }

        return $rowExtractions;
    }
 
    static public function getNearestMoon($structure_id)
    {
        // Получаем координаты структуры
        $structure = DB::table('corporation_assets')
            ->select('x', 'y', 'z', 'location_id as system_id')
            ->where('item_id', $structure_id)
            ->first();

        if (!$structure) {
            return null;
        }

        // Получаем все луны в той же солнечной системе
        $moons = DB::table('moons')
            ->select('moon_id', 'name', 'x', 'y', 'z')
            ->where('system_id', $structure->system_id)
            ->get();

        if ($moons->isEmpty()) {
            return null;
        }

        // Находим ближайшую луну
        $nearest_moon = null;
        $min_distance = PHP_FLOAT_MAX;

        foreach ($moons as $moon) {
            $distance = sqrt(
                pow($moon->x - $structure->x, 2) +
                pow($moon->y - $structure->y, 2) +
                pow($moon->z - $structure->z, 2)
            );

            if ($distance < $min_distance) {
                $min_distance = $distance;
                $nearest_moon = $moon;
            }
        }
        return $nearest_moon;
    }
    
    static public function calculateProfit($moon_id)
    {
        $mining_volume = 30000; // 30000 m3 в час
        $reprocessing_yield = 40; // 40% эффективность переработки
        $hours_per_month = date('t') * 24; // Количество часов в текущем месяце
    
        $refined_value = DB::select(
            "SELECT 
                itm.materialTypeID,
                it.typeName AS material_name,
                SUM(FLOOR(umc.rate * ? * ? / umc_type.volume / 100) * itm.quantity * ?) AS total_quantity,
                AVG(mp.average_price) AS avg_price,
                SUM(FLOOR(umc.rate * ? * ? / umc_type.volume / 100) * itm.quantity * ?) * AVG(mp.average_price) AS total_value
            FROM 
                universe_moon_contents umc
            JOIN 
                invTypes umc_type ON umc_type.typeID = umc.type_id
            JOIN 
                invTypeMaterials itm ON itm.typeID = umc.type_id
            JOIN 
                invTypes it ON it.typeID = itm.materialTypeID
            LEFT JOIN
                market_prices mp ON mp.type_id = itm.materialTypeID
            WHERE 
                umc.moon_id = ?
                AND itm.materialTypeID > 10000
            GROUP BY 
                itm.materialTypeID, it.typeName
            ORDER BY 
                total_value DESC",
            [$mining_volume, $hours_per_month, $reprocessing_yield / 100, $mining_volume, $hours_per_month, $reprocessing_yield / 100, $moon_id]
        );
    
        $total_profit = 0;
        foreach ($refined_value as $material) {
            $total_profit += $material->total_value;
        }
    
        return $total_profit;
    }

    public static function calculateShutdownDate($miningStructure)
    {
        $fuelBlocks = collect($miningStructure->fuels)->whereIn('fuel_type.typeID', [4051, 4246, 4247, 4312])->sum('quantity');
        $magmaticGas = collect($miningStructure->fuels)->where('fuel_type.typeID', 81143)->first()->quantity ?? 0;
        $fuelBlockHours = floor($fuelBlocks / 5);
        $magmaticGasHours = floor($magmaticGas / 88);
        
        $fuelBlockShutdownDate = now()->addHours($fuelBlockHours)->startOfHour();
        $magmaticGasShutdownDate = now()->addHours($magmaticGasHours)->startOfHour();
        
        return [
            'fuelBlock' => $fuelBlockShutdownDate,
            'magmaticGas' => $magmaticGasShutdownDate
        ];
    }

    public static function calculateRequiredFuel($miningStructure, $targetDate)
    {
        $currentDate = now();
        $hoursUntilTarget = $currentDate->diffInHours($targetDate);

        $fuelBlocks = collect($miningStructure->fuels)->whereIn('fuel_type.typeID', [4051, 4246, 4247, 4312])->sum('quantity');
        $magmaticGas = collect($miningStructure->fuels)->where('fuel_type.typeID', 81143)->first()->quantity ?? 0;

        $requiredFuelBlocks = max(0, ($hoursUntilTarget * 5) - $fuelBlocks);
        $requiredMagmaticGas = max(0, ($hoursUntilTarget * 88) - $magmaticGas);

        return [
            'fuelBlocks' => $requiredFuelBlocks,
            'magmaticGas' => $requiredMagmaticGas
        ];
    }
}

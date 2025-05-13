<?php 
require __DIR__ . '../../../../ext/SourceQuery/bootstrap.php';
use xPaw\SourceQuery\SourceQuery;

$Query = new SourceQuery();
$result = [
    'online_server' => 0,
    'online_site' => isset($_POST['site']['COUNT(*)']) ? (int)$_POST['site']['COUNT(*)'] : 0
];

$servers = $_POST['servers'] ?? [];
$servers_count = count($servers);

foreach ($servers as $server) {
    $serverList = explode(':', $server['ip']);

    try {
        $Query->Connect($serverList[0], $serverList[1], 1, SourceQuery::SOURCE);
        $info = $Query->GetInfo();
        $result['online_server'] += $info['Players'];
    } catch (Exception $e) {
    } finally {
        $Query->Disconnect();
    }
}

echo json_encode($result);
exit;
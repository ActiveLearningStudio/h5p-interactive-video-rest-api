<?php
require_once('kaltura-core/KalturaClient.php');

$config = new KalturaConfiguration();
$config->setServiceUrl('https://www.kaltura.com');
$client = new KalturaClient($config);

$loginId = "EMAIL";
$password = "PASSWORD";
$partnerId = "";
$expiry = 86400;
$privileges = "*";
$otp = "";
$page_size = $_GET['pageSize'];
$page_index = $_GET['pageIndex'];
$search_text = $_GET['searchText'];

try {
  $ks = $client->user->loginByLoginId($loginId, $password, $partnerId, $expiry, $privileges, $otp);
  // var_dump($ks);
  $client->setKS($ks);

  $filter = new KalturaMediaEntryFilter();
  $filter->searchTextMatchOr = $search_text;
  $pager = new KalturaFilterPager();
  $pager->pageSize = $page_size;
  $pager->pageIndex = $page_index;


  try {
    $result = $client->media->listAction($filter, $pager);
    header('Content-Type: application/json');
    echo json_encode(array("results" => $result));
  } catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(array("error" => $e->getMessage()));
  }
} catch (Exception $e) {
  header('Content-Type: application/json');
  echo json_encode(array("error" => $e->getMessage()));
}
?>
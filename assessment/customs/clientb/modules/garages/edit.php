<?php
require_once __DIR__ . '/../../../../src/utils.php';
$id = $_GET['id'] ?? null;
$garageFound = null;
$garages = DataManager::getGarages('clientb');
if ($id !== null) {
    foreach ($garages as $g) {
        if (isset($g['id']) && (string)$g['id'] === (string)$id) {
            $garageFound = $g;
            break;
        }
    }
}
?>
<?php if (!$garageFound): ?>
    <div>Garage non trouvé.</div>
<?php else: ?>
    <h1>Détails: <?php echo htmlspecialchars($garageFound['title'] ?? '-'); ?></h1>
    <ul>
        <li>Adresse: <?php echo htmlspecialchars($garageFound['address'] ?? '-'); ?></li>
        <li>ID: <?php echo htmlspecialchars((string)($garageFound['id'] ?? '-')); ?></li>
    </ul>
    <?php
    $cars = DataManager::getCars('clientb');
    $carsInGarage = array_filter($cars, fn($c) => isset($c['garageId']) && (string)$c['garageId'] === (string)$garageFound['id']);
    if (!empty($carsInGarage)): ?>
        <h2>Voitures dans ce garage</h2>
        <ul>
            <?php foreach ($carsInGarage as $c): ?>
                <li><?php echo htmlspecialchars($c['modelName'] ?? '-'); ?> - <?php echo htmlspecialchars($c['brand'] ?? '-'); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
<?php endif; ?>

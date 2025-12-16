<?php
require_once __DIR__ . '/../../../../src/utils.php';
$id = $_GET['id'] ?? null;
$carFound = null;
$cars = DataManager::getCars('clientb');
if ($id !== null) {
	foreach ($cars as $c) {
		if (isset($c['id']) && (string)$c['id'] === (string)$id) {
			$carFound = $c;
			break;
		}
	}
}
?>
<?php if (!$carFound): ?>
	<div>Voiture non trouvée.</div>
<?php else: ?>
	<h1>Détails: <?php echo htmlspecialchars($carFound['modelName'] ?? '-'); ?></h1>
	<ul>
		<li>Marque: <?php echo htmlspecialchars($carFound['brand'] ?? '-'); ?></li>
		<li>Année: <?php echo htmlspecialchars($carFound['year'] ?? '-'); ?></li>
		<li>Puissance: <?php echo htmlspecialchars((string)($carFound['power'] ?? '-')); ?> ch</li>
		<?php if (isset($carFound['garageId'])):
			$garage = DataManager::getGarageById($carFound['garageId']); ?>
			<li>Garage: <?php echo htmlspecialchars($garage['title'] ?? '-'); ?></li>
		<?php endif; ?>
		<?php if (!empty($carFound['colorHex'])): ?>
			<li>Couleur: <span class="garage-color" style="background-color:<?php echo htmlspecialchars($carFound['colorHex']); ?>;"></span></li>
		<?php endif; ?>
	</ul>
<?php endif; ?>

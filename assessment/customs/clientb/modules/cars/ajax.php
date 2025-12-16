<?php
require_once __DIR__ . '/../../../../src/utils.php';
$cars = DataManager::getCars('clientb');
?>
<h1>Voitures Client B</h1>
<?php if (empty($cars)): ?>
	<p>Aucune voiture trouvée.</p>
<?php else: ?>
	<ul>
		<?php foreach ($cars as $car): ?>
			<?php
				$model = isset($car['modelName']) ? strtolower($car['modelName']) : '-';
				$brand = $car['brand'] ?? '-';
				$garage = DataManager::getGarageById($car['garageId'] ?? null);
				$garageTitle = $garage['title'] ?? '-';
			?>
			<li class="car-item" data-car-id="<?php echo htmlspecialchars($car['id'] ?? ''); ?>">
				<strong><?php echo htmlspecialchars($model); ?></strong>
				- <?php echo htmlspecialchars($brand); ?>
				- Garage: <?php echo htmlspecialchars($garageTitle); ?>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

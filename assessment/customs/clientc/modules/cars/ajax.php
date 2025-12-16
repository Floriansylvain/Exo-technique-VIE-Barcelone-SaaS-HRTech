<?php
require_once __DIR__ . '/../../../../src/utils.php';
$cars = DataManager::getCars('clientc');
?>
<h1>Voitures Client C</h1>
<?php if (empty($cars)): ?>
	<p>Aucune voiture trouvée.</p>
<?php else: ?>
	<ul>
		<?php foreach ($cars as $car): ?>
			<?php $color = isset($car['colorHex']) ? $car['colorHex'] : '#ccc'; ?>
			<li class="garage-bullet car-item" data-car-id="<?php echo htmlspecialchars($car['id'] ?? ''); ?>">
				<span class="garage-color" style="background-color:<?php echo htmlspecialchars($color); ?>"></span>
				<span>
					<strong><?php echo htmlspecialchars($car['modelName'] ?? '-'); ?></strong>
					- <?php echo htmlspecialchars($car['brand'] ?? '-'); ?>
				</span>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

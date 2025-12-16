<?php
require_once __DIR__ . '/../../../../src/utils.php';
$cars = DataManager::getCars('clienta');
?>
<h1>Voitures Client A</h1>
<?php if (empty($cars)): ?>
	<p>Aucune voiture trouvée.</p>
<?php else: ?>
	<ul>
		<?php foreach ($cars as $car): ?>
			<?php
				$yearRaw = $car['year'] ?? null;
				$date = '-';
				if ($yearRaw !== null && $yearRaw !== '') {
					$yr = (int)$yearRaw;
					$currentYear = (int)date('Y');
					if ($yr >= 1900 && $yr <= $currentYear + 1) {
						$date = (string)$yr;
					} else {
						$ts = (int)$yearRaw;
						if ($ts > 0) $date = date('d/m/Y', $ts);
						else $date = (string)$yearRaw;
					}
				}
			?>

			<li class="car-item" data-car-id="<?php echo htmlspecialchars($car['id'] ?? ''); ?>">
				<strong><?php echo htmlspecialchars($car['modelName'] ?? '-'); ?></strong>
				- <?php echo htmlspecialchars($car['brand'] ?? '-'); ?>
				(<?php echo $date; ?>)
				- <?php echo htmlspecialchars((string)($car['power'] ?? '-')); ?> ch
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

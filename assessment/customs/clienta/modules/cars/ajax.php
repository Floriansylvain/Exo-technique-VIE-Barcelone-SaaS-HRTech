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
				$yearInt = null;
				$currentYear = (int)date('Y');
				if ($yearRaw !== null && $yearRaw !== '') {
					$yr = (int)$yearRaw;
					if ($yr >= 1900 && $yr <= $currentYear + 1) {
						$date = (string)$yr;
						$yearInt = $yr;
					} else {
						$ts = (int)$yearRaw;
						if ($ts > 0) {
							$date = date('d/m/Y', $ts);
							$yearInt = (int)date('Y', $ts);
						} else {
							$date = (string)$yearRaw;
						}
					}
				}
				$ageClass = '';
				if ($yearInt !== null) {
					$age = $currentYear - $yearInt;
					if ($age > 10) $ageClass = 'car-old';
					elseif ($age < 2) $ageClass = 'car-new';
                    // aucune voiture dans le jeu de test n'a moins de 2 ans ou plus de 10 ans ^^"
				}
			?>

			<li class="car-item <?php echo $ageClass; ?>" data-car-id="<?php echo htmlspecialchars($car['id'] ?? ''); ?>">
				<strong><?php echo htmlspecialchars($car['modelName'] ?? '-'); ?></strong>
				- <?php echo htmlspecialchars($car['brand'] ?? '-'); ?>
				(<?php echo $date; ?>)
				- <?php echo htmlspecialchars((string)($car['power'] ?? '-')); ?> ch
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

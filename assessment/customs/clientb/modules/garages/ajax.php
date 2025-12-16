<?php
require_once __DIR__ . '/../../../../src/utils.php';
$garages = DataManager::getGarages('clientb');
?>
<h1>Garages Client B</h1>
<?php if (empty($garages)): ?>
    <p>Aucun garage trouvé.</p>
<?php else: ?>
    <ul>
        <?php foreach ($garages as $g): ?>
            <li class="garage-item" data-garage-id="<?php echo htmlspecialchars($g['id'] ?? ''); ?>">
                <strong><?php echo htmlspecialchars($g['title'] ?? '-'); ?></strong>
                - <?php echo htmlspecialchars($g['address'] ?? '-'); ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

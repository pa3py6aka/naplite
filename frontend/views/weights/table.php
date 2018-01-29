<?php
/* @var $weights \core\entities\Weight[] */

?>
<div class="adaptive_table_measures">
    <?php foreach ($weights as $weight): ?>
    <div class="adaptive_table_measures_name"><?= $weight->name ?></div>
    <table class="adaptive_table_measures_quantity">
        <tr class="dark">
            <td class="adaptive_table_measures_quantity_left">Стакан 250г:</td>
            <td><?= $weight->glass250 ?>г</td>
        </tr>
        <tr>
            <td class="adaptive_table_measures_quantity_left">Стакан 200г:</td>
            <td><?= $weight->glass200 ?>г</td>
        </tr>
        <tr class="dark">
            <td class="adaptive_table_measures_quantity_left">Ст.ложка:</td>
            <td><?= $weight->spoon_big ?>г</td>
        </tr>
        <tr>
            <td class="adaptive_table_measures_quantity_left">Ч.ложка:</td>
            <td><?= $weight->spoon_tea ?>г</td>
        </tr>
        <tr class="dark">
            <td class="adaptive_table_measures_quantity_left">1 шт:</td>
            <td><?= $weight->piece ?></td>
        </tr>
    </table>
    <?php endforeach; ?>
    <?php reset($weights); ?>
</div>
<table class="table_base hidden740">
    <tr>
        <th>Название</th>
        <th>Стакан<br />250г</th>
        <th>Стакан<br />200г</th>
        <th>Столовая<br />ложка</th>
        <th>Чайная<br />ложка</th>
        <th>1 шт</th>
    </tr>
    <?php foreach ($weights as $weight): ?>
        <tr>
            <td><?= $weight->name ?></td>
            <td><?= $weight->glass250 ?></td>
            <td><?= $weight->glass200 ?></td>
            <td><?= $weight->spoon_big ?></td>
            <td><?= $weight->spoon_tea ?></td>
            <td><?= $weight->piece ?></td>
            <td></td>
        </tr>
    <?php endforeach; ?>
</table>

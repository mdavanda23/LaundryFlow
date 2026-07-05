<?= $this->extend('staff/layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert-success">✓ <?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php
$colors = [
    'Received' => '#06B6D4', 'Washing' => '#7C3AED',
    'Drying'   => '#0369A1', 'Ironing'  => '#DB2777',
    'Ready'    => '#059669', 'Completed'=> '#16A34A',
];
$labelId = [
    'Received' => 'Diterima', 'Washing' => 'Dicuci',
    'Drying'   => 'Dikeringkan', 'Ironing' => 'Disetrika',
    'Ready'    => 'Siap Ambil', 'Completed' => 'Selesai',
];
?>

<div class="kanban-board">
    <?php foreach ($board as $stage => $cards): ?>
    <div class="kanban-col">
        <div class="kanban-col-header">
            <div class="kanban-col-title">
                <span class="kanban-dot" style="background:<?= $colors[$stage] ?>"></span>
                <?= $labelId[$stage] ?? $stage ?>
            </div>
            <span class="kanban-count"><?= count($cards) ?></span>
        </div>

        <?php if (!empty($cards)): ?>
            <?php foreach ($cards as $card): ?>
            <div class="kanban-card">
                <div class="kanban-invoice"><?= esc($card['invoice']) ?></div>
                <div class="kanban-customer"><?= esc($card['customer_name']) ?></div>
                <div class="kanban-detail"><?= esc($card['service_name']) ?> · <?= esc($card['weight']) ?> kg</div>
                <div class="kanban-time">🕐 <?= date('H:i', strtotime($card['created_at'])) ?></div>

                <!-- Update Status -->
                <form action="<?= site_url('staff/orders/update-status') ?>" method="POST" style="margin-top:8px">
                    <?= csrf_field() ?>
                    <input type="hidden" name="order_id" value="<?= $card['id'] ?>">
                    <div style="display:flex;gap:4px">
                        <select name="status" class="form-input" style="font-size:11px;padding:4px 6px;flex:1">
                            <?php foreach(array_keys($board) as $s): ?>
                            <option value="<?= $s ?>" <?= $card['status']===$s?'selected':'' ?>><?= $labelId[$s]??$s ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary" style="font-size:11px;padding:4px 8px">OK</button>
                    </div>
                </form>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align:center;padding:20px 0;color:#94A3B8;font-size:12px">Tidak ada</div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
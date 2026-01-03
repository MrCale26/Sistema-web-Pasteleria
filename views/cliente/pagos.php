<h2>💳 Resumen de Pagos</h2>

<?php if ($pagos->num_rows > 0): ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID Pago</th>
                <th>Pedido</th>
                <th>Método</th>
                <th>Monto</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($pago = $pagos->fetch_object()): ?>
                <tr>
                    <td>#<?= $pago->pago_id ?></td>
                    <td>#<?= $pago->pedido_id ?></td>
                    <td><?= ucfirst($pago->metodo) ?></td>
                    <td>S/ <?= number_format($pago->monto, 2) ?></td>
                    <td><?= ucfirst($pago->estado) ?></td>
                    <td><?= $pago->fecha_pago ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No se han registrado pagos aún.</p>
<?php endif; ?>

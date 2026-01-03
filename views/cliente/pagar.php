<h2 class="text-center mb-4">💳 Confirmar Pago</h2>

<div class="card w-50 mx-auto shadow p-4">
    <form method="post" action="index.php?controller=Carrito&action=pagar">
        <div class="mb-3">
            <label class="form-label">Selecciona el método de pago:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="metodo" value="efectivo" id="efectivo" required>
                <label class="form-check-label" for="efectivo">💵 Efectivo</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="metodo" value="tarjeta" id="tarjeta" required>
                <label class="form-check-label" for="tarjeta">💳 Tarjeta</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="metodo" value="yape" id="yape" required>
                <label class="form-check-label" for="yape">📱 Yape</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="metodo" value="plin" id="plin" required>
                <label class="form-check-label" for="plin">📲 Plin</label>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="index.php?controller=Carrito&action=ver" class="btn btn-secondary">⬅ Volver</a>
            <button type="submit" class="btn btn-primary">Pagar y Confirmar ✅</button>
        </div>
    </form>
</div>

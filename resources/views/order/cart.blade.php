<form id="order-form" method="POST" action="{{ url('order') }}">
@csrf
<div class="mb-2">
  <label for="member_id" class="form-label">Pelanggan</label>
  <select name="member_id" id="member_id" class="form-select form-select-sm">
    @foreach($members as $c)
    <option value="{{ $c->id }}">{{ $c->name }}</option>
    @endforeach
  </select>
</div>

<table class="table table-sm align-middle" id="tbl-cart">
  <thead class="table-light">
    <tr>
      <th>Produk</th>
      <th>Qty</th>
      <th>Price</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
  <tfoot>
    <tr>
      <td colspan="2" class="text-end"><strong>Total</strong></td>
      <td id="total-cell">0</td>
    </tr>
  </tfoot>
</table>

<input type="hidden" name="order_payload" id="order_payload" value="">
<button type="button" id="submit-order" class="btn btn-success">Submit Order</button>
</form>
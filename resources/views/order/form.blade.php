<div class="container-fluid">
  <h3 class="mb-4 fw-bold text-primary">Kalcer Store!</h3>

  @foreach ($categories as $category)
  <div class="mb-5">
    <h4 class="mt-4 border-bottom pb-2">{{ $category->name }}</h4>
    <div class="row mt-3">
      @foreach ($category->product as $product)
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card shadow-sm h-100 border-0 rounded-3 position-relative">
          <div class="card-body">
            <input type="hidden" name="id_product" class="id_product" value="{{ $product->id }}" data-price="{{ $product->price }}">
            <div class="d-flex flex-column justify-content-center h-100">
              <h6 class="card-title fw-semibold mb-1">{{ $product->name }}</h6>
              <p class="fw-bold text-success mb-0"> Rp {{ number_format((float)$product->price, 0, ',', '.') }} </p>
            </div>
            <button class="btn btn-primary btn-sm px-3 position-absolute top-50 end-0 translate-middle-y me-3 btn-add">Add</button>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endforeach
</div>

<!-- ======================= -->
<!-- Modal Konfirmasi Pesanan -->
<!-- ======================= -->
<div class="modal fade" id="confirmSubmitModal" tabindex="-1" aria-labelledby="confirmSubmitModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmSubmitModalLabel">Konfirmasi Pesanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Total pesanan kamu: <strong id="confirm-total">Rp 0</strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" id="confirm-submit-btn" class="btn btn-primary">Kirim</button>
      </div>
    </div>
  </div>
</div>

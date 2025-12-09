@extends('templates.layout')

@section('content')
<div class="container mt-4">
  <div class="card">
    <div class="card-body">
      <div id="invoice-content">

        <h4>Invoice: {{ $order->invoice }}</h4>
        <p><strong>Pelanggan:</strong> {{ $order->member_id }}</p>
        <p><strong>Tanggal:</strong> {{ $order->created_at }}</p>

        <table class="table table-sm">
          <thead>
            <tr>
              <th>Produk</th>
              <th>Qty</th>
              <th>Price</th>
            </tr>
          </thead>
          <tbody>
            @foreach($details as $d)
            <tr>
              <td>{{ $products[$d->product_id]->name ?? $d->product_id }}</td>
              <td>{{ $d->quantity }}</td>
              <td>{{ number_format($d->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="2" class="text-end"><strong>Total</strong></td>
              <td>{{ number_format($order->total, 0, ',', '.') }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="mt-4">
        <a href="{{ url('order') }}" class="btn btn-secondary btn-sm">Kembali</a>
        <button id="print-now" class="btn btn-primary btn-sm">Download PDF</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<!-- Masukin library html2pdf.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // tombol download PDF
    document.getElementById('print-now').addEventListener('click', function() {
      console.log("Memulai proses download PDF...");
      var element = document.getElementById('invoice-content');
      html2pdf().from(element).set({
        margin: 10,
        filename: 'invoice-{{ $order->invoice }}.pdf',
        html2canvas: {
          scale: 2
        },
        jsPDF: {
          orientation: 'portrait',
          unit: 'mm',
          format: 'a4'
        }
      }).save();
    });

    // Opsional: auto download saat halaman dibuka
    // setTimeout(function() {
    //   document.getElementById('print-now').click();
    // }, 500);
  });
</script>
@endpush
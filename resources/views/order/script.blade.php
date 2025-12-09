<script>
  $(function() {
    // array untuk menyimpan daftar pesanan sementara 
    const orderedList = [];
    // variabel untuk total 
    let total = 0;

    const $submitBtn = $('#submit-order');

    // helper: format angka jadi Rupiah
    const fmtRp = (n) => {
      try {
        return 'Rp ' + Number(n).toLocaleString('id-ID');
      } catch (e) {
        return n;
      }
    };

    function refreshCartState() {
      const totalSum = orderedList.reduce((s, it) => s + Number(it.price), 0);
      $('#total-cell').text(fmtRp(totalSum));
      $('#order_payload').val(JSON.stringify({
        items: orderedList,
        total: totalSum
      }));
      $submitBtn.prop('disabled', orderedList.length === 0);
    }

    // disable tombol submit di awal
    $submitBtn.prop('disabled', true);

    // klik tombol tambah produk
    $('.btn-add').on('click', function(e) {
      e.preventDefault();
      const $card = $(this).closest('.card-body');
      const name = $card.find('.card-title').text().trim();
      const price = Number($card.find('.id_product').data('price'));
      const id = Number($card.find('.id_product').val());

      if (orderedList.every(list => list.id !== id)) {
        // jika item belum ada di keranjang, tambahkan baru
        let dataN = {
          id: id,
          name: name,
          qty: 1,
          unitPrice: price,
          price: price
        };
        orderedList.push(dataN);
        // [Hapus baris ini setelah debugging selesai]
        if ($('#tbl-cart tbody').length === 0) {
          console.error("DEBUG: Elemen tbody tabel keranjang (#tbl-cart tbody) TIDAK ditemukan di halaman.");
        } else {
          console.log("DEBUG: Elemen tbody ditemukan. Mencoba menambahkan:", name);
        } 

        // buat baris tabel untuk item baru
        let order = `
          <tr data-id="${id}">
            <td>${name}</td>
            <td class="qty">1</td>
            <td class="price">${fmtRp(price)}</td>
          </tr>`;
        $('#tbl-cart tbody').append(order);


      } else {
        // jika item sudah ada, update qty dan total price
        const index = orderedList.findIndex(list => list.id === id);
        orderedList[index].qty += 1;
        orderedList[index].price = orderedList[index].qty * orderedList[index].unitPrice;

        // update tampilan di tabel
        const $row = $(`#tbl-cart tbody tr[data-id="${id}"]`);
        if ($row.length) {
          $row.find('.qty').text(orderedList[index].qty);
          $row.find('.price').text(fmtRp(orderedList[index].price));
        }
      }

      refreshCartState();
      console.log(orderedList);
    });

    // ketika tombol submit diklik, tampilkan modal konfirmasi
    $('#submit-order').on('click', function(e) {
      if (orderedList.length === 0) {
        alert('Keranjang kosong. Tambahkan produk terlebih dahulu.');
        return;
      }

      $('#confirm-total').text(fmtRp(
        orderedList.reduce((s, it) => s + Number(it.price), 0)
      ));

      const confirmModal = new bootstrap.Modal(document.getElementById('confirmSubmitModal'));
      confirmModal.show();
    });

    // ketika user konfirmasi kirim pesanan
    $('#confirm-submit-btn').on('click', function() {
      const $btn = $(this);
      $btn.prop('disabled', true).text('Mengirim...');

      const form = document.getElementById('order-form');
      const fd = new FormData(form);

      fetch(form.action, {
          method: 'POST',
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: fd,
          credentials: 'same-origin'
        })
        .then(async res => {
          const contentType = res.headers.get('content-type') || '';
          let data = null;

          if (contentType.includes('application/json')) {
            data = await res.json();
          } else {
            data = {
              success: res.ok
            };
          }

          if (!res.ok || (data && data.success === false)) {
            const msg = (data && data.message) ? data.message : 'Gagal menyimpan pesanan';
            alert(msg);
            $btn.prop('disabled', false).text('Kirim');
            return;
          }

          if (data && data.print_url) {
            window.location.href = data.print_url;
          } else {
            window.location.reload();
          }
        })
        .catch(err => {
          console.error(err);
          alert('Terjadi kesalahan saat mengirim pesanan. ' + (err.message || ''));
          $btn.prop('disabled', false).text('Kirim');
        });
    });
  });
</script>
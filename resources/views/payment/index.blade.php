@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow-lg mt-10" x-data="voucherPicker()" x-init="init()">
      <!-- Back Button -->
  <a href="/cart" class="inline-flex items-center gap-2 text-sm text-green-600 hover:text-green-800 font-semibold mb-6 transition duration-200">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
    Back to Cart
  </a>


    <!-- Header -->
    <div class="flex items-center space-x-3 border-b pb-4 mb-6">
        <img src="{{ asset('images/logocoffee2.png') }}" alt="Handai Coffee" class="h-8">
        <h1 class="text-2xl font-extrabold text-green-700">Pembayaran Handai Coffee</h1>
    </div>

    <!-- Daftar Produk -->
    <div class="mb-6 border p-4 rounded-xl bg-gray-50">
        <h2 class="text-lg font-semibold text-green-700 mb-4">🧾 Produk Dipesan</h2>
        @foreach ($order->details as $detail)
        <div class="flex items-center mb-4 last:mb-0">
            <img src="{{ asset('storage/' . $detail->product->image) }}" alt="{{ $detail->product->name_product }}" class="w-16 h-16 rounded border object-cover mr-4">
            <div class="flex-1">
                <p class="font-semibold text-gray-800">{{ $detail->product->name_product }}</p>
                <p class="text-sm text-gray-600">Jumlah: {{ $detail->quantity }}</p>
            </div>
            <div class="text-right font-semibold text-gray-700">
                Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
            </div>
        </div>
        @endforeach
    </div>

    <!-- FORM PEMBAYARAN -->
    <form id="paymentForm" @submit.prevent="submitPayment">
        @csrf

        <!-- Alamat Pengiriman -->
        <div class="mb-6 border p-4 rounded-xl">
            <label for="address" class="block font-semibold mb-1 text-green-700">📍 Alamat Pengiriman</label>
            <textarea name="address" id="address" class="w-full border rounded-lg p-3 text-gray-700" rows="3" required x-model="address"></textarea>
        </div>

        <!-- Opsi Pengiriman & Catatan -->
        <div class="mb-6 border p-4 rounded-xl">
            <h2 class="text-lg font-semibold text-green-700 mb-4">🚚 Opsi Pengiriman</h2>
            <div class="flex items-center space-x-6 mb-4">
              <label class="inline-flex items-center">
                  <input type="radio" name="delivery_option" value="pickup" @change="updateShipping('pickup')" x-model="delivery_option">
                  <span class="ml-2">Ambil Sendiri</span>
              </label>
              <label class="inline-flex items-center">
                  <input type="radio" name="delivery_option" value="delivery" @change="updateShipping('delivery')" x-model="delivery_option">
                  <span class="ml-2">Diantar</span>
              </label>
            </div>
            <div>
                <label for="note" class="block font-semibold mb-1 text-green-700">📝 Catatan (opsional):</label>
                <textarea name="note" id="note" class="w-full border rounded-lg p-3 text-gray-700" rows="3" x-model="note"></textarea>
            </div>
        </div>

        <!-- Voucher -->
        <div class="mb-6 border p-4 rounded-xl">
            <h2 class="text-lg font-semibold text-green-700 mb-4 flex items-center justify-between">
                🎁 Voucher
                <button type="button" @click="openModal()" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">Pilih Voucher</button>
            </h2>
            <input type="text" placeholder="Belum ada voucher dipilih" class="w-full border rounded p-2 cursor-pointer text-gray-700" readonly x-model="selectedVoucher.code" @click="openModal()">
            <p class="mt-1 text-sm text-gray-600" x-text="selectedVoucher.description || 'Pilih voucher untuk mendapatkan diskon'"></p>
            <input type="hidden" name="voucher_code" :value="selectedVoucher.code">
        </div>

        <!-- Ringkasan Pembayaran -->
        @php
        $subtotal = $order->details->sum('subtotal');
        $shipping = ($order->delivery_option == 'delivery') ? 2000 : 0;
        @endphp
        <div class="mb-6 border p-4 rounded-xl bg-gray-50">
            <h2 class="text-lg font-semibold text-green-700 mb-4">💰 Ringkasan Pembayaran</h2>
            <div class="flex justify-between mb-2 text-sm">
                <span>Subtotal Produk</span>
                <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between mb-2 text-sm">
                <span>Ongkos Kirim:</span>
                <span>Rp<span x-text="shipping.toLocaleString('id-ID')"></span></span>
            </div>
            <div class="flex justify-between mb-2 text-sm">
                <span>Diskon Voucher</span>
                <span class="text-red-600">Rp<span x-text="voucherDiscount.toLocaleString('id-ID')"></span></span>
            </div>
            <div class="flex justify-between font-bold text-lg border-t pt-3">
                <span>Total:</span>
                <span>Rp<span x-text="total.toLocaleString('id-ID')"></span></span>
            </div>
        </div>

        <!-- Tombol Bayar Sekarang -->
        <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-3 px-4 rounded-lg transition">💳 Bayar Sekarang</button>
    </form>

    <!-- Modal Daftar Voucher -->
    <div x-show="modalOpen" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" x-cloak>
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative" @click.away="closeModal()">
            <h3 class="text-xl font-bold mb-4 text-green-700">🎟️ Pilih Voucher</h3>
            <template x-for="voucher in vouchers" :key="voucher.code">
                <label class="block border p-3 rounded mb-3 cursor-pointer flex items-center"
                       :class="{'bg-green-100': selectedVoucher.code === voucher.code, 'opacity-50 cursor-not-allowed': !voucher.active}">
                    <input type="radio" name="voucher" class="mr-3"
                           :disabled="!voucher.active"
                           :value="voucher.code"
                           x-model="selectedVoucher.code"
                           @change="selectVoucher(voucher)">
                    <div>
                        <p class="font-semibold text-gray-800" x-text="voucher.code + ' - ' + voucher.description"></p>
                        <p class="text-sm text-gray-600" x-text="voucher.type === 'percentage' ? voucher.value + '%' : 'Rp' + voucher.value.toLocaleString('id-ID')"></p>
                        <p class="text-xs text-gray-400" x-text="'Masa berlaku: ' + voucher.start_date + ' s/d ' + voucher.expiry_date"></p>
                    </div>
                </label>
            </template>
            <div class="flex justify-end space-x-3 mt-4">
                <button @click="closeModal()" class="px-4 py-2 rounded border hover:bg-gray-100">Batal</button>
                <button @click="confirmVoucher()" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">OK</button>
            </div>
        </div>
    </div>

</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
function voucherPicker() {
    return {
        modalOpen: false,
        selectedVoucher: {
            code: '', description: '', discount: 0, type: '', value: 0,
            start_date: '', expiry_date: '', active: true
        },
        subtotal: {{ $subtotal }},
        shipping: {{ $shipping }},
        voucherDiscount: 0,
        total: {{ $subtotal + $shipping }},
        address: @json(old('address', $order->address)),
        delivery_option: @json(old('delivery_option', $order->delivery_option)),
        note: @json(old('note', $order->note)),
        vouchers: @json($availableVouchers),

        init() {
            this.updateShipping(this.delivery_option);
        },
        openModal() {
            this.modalOpen = true;
        },
        closeModal() {
            this.modalOpen = false;
        },
        selectVoucher(voucher) {
            this.selectedVoucher = { ...voucher };
        },
        confirmVoucher() {
            this.voucherDiscount = this.calculateDiscount();
            this.calculateTotal();
            this.closeModal();
        },
        calculateDiscount() {
            if (!this.selectedVoucher.code) return 0;
            return this.selectedVoucher.type === 'percentage'
                ? Math.floor(this.subtotal * (this.selectedVoucher.value / 100))
                : this.selectedVoucher.value;
        },
        calculateTotal() {
            this.total = this.subtotal + this.shipping - this.voucherDiscount;
        },
        updateShipping(option) {
            this.delivery_option = option;
            this.shipping = option === 'delivery' ? 2000 : 0;
            this.calculateTotal();
        },
        submitPayment() {
            this.calculateTotal();
            const formData = new FormData(document.getElementById('paymentForm'));
            fetch("{{ route('payment.pay', $order->id) }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                snap.pay(data.snapToken, {
                    onSuccess: function(result) {
                        var orderId = result.order_id.split('-')[0];
                        window.location.href = `/invoice?order_id=${orderId}`;
                    },
                    onError: function() {
                        alert('Pembayaran gagal');
                    },
                    onClose: function() {
                        alert('Pembayaran dibatalkan');
                    }
                });
            })
            .catch(async (error) => {
                const err = await error.json();
                alert(err.error || 'Terjadi kesalahan saat memproses pembayaran');
            });
        },
    }
}
</script>
@endsection
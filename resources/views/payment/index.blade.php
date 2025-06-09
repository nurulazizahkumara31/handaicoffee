@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow mt-8" x-data="voucherPicker()" x-init="init()">

    <!-- Header -->
    <div class="flex items-center space-x-3 border-b pb-4 mb-6">
        <img src="{{ asset('images/logocoffee2.png') }}" alt="Handai Coffee" class="h-8">
        <h1 class="text-2xl font-bold text-green-700">Pembayaran Handai Coffee</h1>
    </div>

    <!-- Daftar Produk -->
    <div class="mb-6 border p-4 rounded">
        <h2 class="text-lg font-semibold mb-4">Produk Dipesan</h2>
        @foreach ($order->details as $detail)
        <div class="flex items-center mb-4 last:mb-0">
            <img src="{{ asset('storage/' . $detail->product->image) }}" alt="{{ $detail->product->name_product }}" class="w-16 h-16 rounded border object-cover mr-4">
            <div class="flex-1">
                <p class="font-semibold">{{ $detail->product->name_product }}</p>
                <p class="text-sm text-gray-600">Jumlah: {{ $detail->quantity }}</p>
            </div>
            <div class="text-right font-semibold">
                Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
            </div>
        </div>
        @endforeach
    </div>

    <!-- FORM PEMBAYARAN -->
    <form id="paymentForm" @submit.prevent="submitPayment">
        @csrf

        <!-- Alamat Pengiriman -->
        <div class="mb-6 border p-4 rounded">
            <label for="address" class="block font-semibold mb-1 text-green-700">Alamat Pengiriman</label>
            <textarea name="address" id="address" class="w-full border rounded p-2" rows="3" required x-model="address">{{ old('address', $order->address) }}</textarea>
        </div>

        <!-- Opsi Pengiriman & Catatan -->
        <div class="mb-6 border p-4 rounded">
            <h2 class="text-lg font-semibold mb-4">Opsi Pengiriman</h2>
            <label class="inline-flex items-center mr-6">
                <input type="radio" name="delivery_option" value="pickup" @change="updateShipping('pickup')" x-model="delivery_option">
                <span class="ml-2">Ambil Sendiri</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="delivery_option" value="delivery" @change="updateShipping('delivery')" x-model="delivery_option">
                <span class="ml-2">Diantar</span>
            </label>
            <div class="mt-4">
                <label for="note" class="block font-semibold mb-1">Catatan (opsional):</label>
                <textarea name="note" id="note" class="w-full border rounded p-2" rows="3" x-model="note">{{ old('note', $order->note) }}</textarea>
            </div>
        </div>

        <!-- Voucher -->
        <div class="mb-6 border p-4 rounded">
            <h2 class="text-lg font-semibold mb-4 flex items-center justify-between">
                Voucher
                <button type="button" @click="openModal()" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">Pilih Voucher</button>
            </h2>
            <input type="text" placeholder="Belum ada voucher dipilih" class="w-full border rounded p-2 cursor-pointer" readonly x-model="selectedVoucher.code" @click="openModal()">
            <p class="mt-1 text-sm text-gray-600" x-text="selectedVoucher.description || 'Pilih voucher untuk mendapatkan diskon'"></p>
            <input type="hidden" name="voucher_code" :value="selectedVoucher.code">
        </div>

        <!-- Ringkasan Pembayaran -->
        @php
        $subtotal = $order->details->sum('subtotal');
        $shipping = ($order->delivery_option == 'delivery') ? 2000 : 0;
        @endphp
        <div class="mb-6 border p-4 rounded">
            <h2 class="text-lg font-semibold mb-4">Ringkasan Pembayaran</h2>
            <div class="flex justify-between mb-2">
                <span>Subtotal Produk</span>
                <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span>Ongkos Kirim:</span>
                <span>Rp<span x-text="shipping.toLocaleString('id-ID')"></span></span>
            </div>
            <div class="flex justify-between mb-2">
                <span>Diskon Voucher</span>
                <span class="text-red-600" x-text="voucherDiscountFormatted"></span>
            </div>
            <div class="flex justify-between mb-2 font-semibold text-lg">
                <span>Total:</span>
                <span>Rp<span x-text="total.toLocaleString('id-ID')"></span></span>
            </div>
        </div>

        <!-- Tombol Bayar Sekarang -->
        <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white font-semibold py-2 px-4 rounded">
            Bayar Sekarang
        </button>
    </form>

    <!-- Modal Daftar Voucher -->
    <div x-show="modalOpen" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" x-cloak>
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative" @click.away="closeModal()">
            <h3 class="text-xl font-semibold mb-4">Pilih Voucher</h3>
            <template x-for="voucher in vouchers" :key="voucher.code">
                <label class="block border p-3 rounded mb-3 cursor-pointer flex items-center"
                       :class="{'bg-green-100': selectedVoucher.code === voucher.code, 'opacity-50 cursor-not-allowed': !voucher.active}">
                    <input type="radio" name="voucher" class="mr-3"
                           :disabled="!voucher.active"
                           :value="voucher.code"
                           x-model="selectedVoucher.code"
                           @change="selectVoucher(voucher)">
                    <div>
                        <p class="font-semibold" x-text="voucher.code + ' - ' + voucher.description"></p>
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
            code: '',
            description: '',
            discount: 0,
            discountFormatted: '',
            type: '',
            value: 0,
            start_date: '',
            expiry_date: '',
            active: true
        },
        tempVoucher: null,
        subtotal: {{ $subtotal }},
        shipping: {{ $shipping }},
        voucherDiscount: 0,
        total: {{ $subtotal + $shipping }},
        address: '{{ old('address', $order->address) }}',
        delivery_option: '{{ old('delivery_option', $order->delivery_option) }}',
        note: '{{ old('note', $order->note) }}',
        vouchers: @json($availableVouchers),

        init() {
            const checkedDelivery = document.querySelector('input[name="delivery_option"]:checked');
            if (checkedDelivery) {
                this.shipping = checkedDelivery.value === 'delivery' ? 2000 : 0;
            } else {
                this.shipping = 0;
            }
            this.calculateTotal();
        },

        openModal() {
            this.tempVoucher = { ...this.selectedVoucher };
            this.modalOpen = true;
        },

        closeModal() {
            this.modalOpen = false;
            this.calculateTotal();
        },

        selectVoucher(voucher) {
            this.selectedVoucher = { ...voucher };
            this.calculateTotal();
        },

        confirmVoucher() {
            this.voucherDiscount = this.calculateDiscount();
            this.selectedVoucher.discountFormatted = this.voucherDiscount.toLocaleString('id-ID');
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
            this.voucherDiscount = this.calculateDiscount();
            this.total = this.subtotal + this.shipping - this.voucherDiscount;
        },

        updateShipping(option) {
            this.shipping = option === 'delivery' ? 2000 : 0;
            this.calculateTotal();
        },

        submitPayment() {
            this.calculateTotal();

            const formData = new FormData(document.getElementById('paymentForm'));

            fetch("{{ route('payment.pay', $order->id) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) throw response;
                return response.json();
            })
            .then(data => {
                snap.pay(data.snapToken, {
                    onSuccess: function(result) {
                        // Ekstrak order_id dari result.order_id dan hapus timestamp
                        var orderId = result.order_id.split('-')[0]; // Ambil ID sebelum tanda '-'

                        // Redirect ke halaman success dengan order_id tanpa timestamp
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
                if (error.json) {
                    const err = await error.json();
                    alert(err.error || 'Terjadi kesalahan');
                } else {
                    alert('Gagal memproses pembayaran');
                }
            });
        },

        get voucherDiscountFormatted() {
            return this.voucherDiscount.toLocaleString('id-ID');
        },

        get totalFormatted() {
            return this.total.toLocaleString('id-ID');
        }
    }
}
</script>
@endsection

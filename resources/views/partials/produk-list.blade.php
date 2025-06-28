<div class="wrapper pb-4" id="product-list">
    @forelse ($data as $row)
        <div class="box">
            <img src="{{ asset('/gambar_barang/' . $row->image) }}" class="image" alt="">
            <div>
                <center>
                    <span style="font-size: 18px; font-weight: bold">
                        {{ $row->nama_barang }}
                    </span>
                </center>
                <br>
                <p style="font-size: 14px" class="custom-p"><i class="fas fa-tags"></i> Rp.
                    {{ number_format($row->harga_barang, 0, ',', '.') }}</p>

                <div class="container pb-3">
                    <form action="{{ route('keranjang.pesanan.store', $row->id) }}" method="POST"
                        class="purchase-form">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-block custom-btn"
                            style="border-radius: 50px">Beli</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p>Data masih kosong</p>
    @endforelse
</div>

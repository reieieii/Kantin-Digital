<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produks = [
            // Stand Nasi Padang (ID: 1)
            ['stand_id' => 1, 'nama_produk' => 'Nasi Rendang', 'deskripsi' => 'Nasi dengan rendang padang yang lezat', 'harga' => 35000, 'stock' => 10, 'gambar' => 'https://picsum.photos/seed/rendang/300/200.jpg', 'kategori' => 'Makanan Berat', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 1, 'nama_produk' => 'Ayam Pop', 'deskripsi' => 'Ayam pop dengan sambal lado', 'harga' => 28000, 'stock' => 15, 'gambar' => 'https://picsum.photos/seed/ayampop/300/200.jpg', 'kategori' => 'Makanan Berat', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 1, 'nama_produk' => 'Telur Balado', 'deskripsi' => 'Telur dengan bumbu balado', 'harga' => 15000, 'stock' => 20, 'gambar' => 'https://picsum.photos/seed/telur/300/200.jpg', 'kategori' => 'Makanan Ringan', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 1, 'nama_produk' => 'Sayur Lodeh', 'deskripsi' => 'Sayur lodeh khas padang', 'harga' => 12000, 'stock' => 12, 'gambar' => 'https://picsum.photos/seed/sayur/300/200.jpg', 'kategori' => 'Makanan Ringan', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 1, 'nama_produk' => 'Es Teh Manis', 'deskripsi' => 'Es teh manis dengan susu', 'harga' => 8000, 'stock' => 25, 'gambar' => 'https://picsum.photos/seed/esteh/300/200.jpg', 'kategori' => 'Minuman', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 1, 'nama_produk' => 'Gorengan', 'deskripsi' => 'Aneka gorengan padang', 'harga' => 18000, 'stock' => 18, 'gambar' => 'https://picsum.photos/seed/gorengan/300/200.jpg', 'kategori' => 'Makanan Ringan', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            
            // Stand Ayam Bakar (ID: 2)
            ['stand_id' => 2, 'nama_produk' => 'Ayam Bakar', 'deskripsi' => 'Ayam bakar dengan sambal dan lalapan', 'harga' => 25000, 'stock' => 20, 'gambar' => 'https://picsum.photos/seed/ayambakar/300/200.jpg', 'kategori' => 'Makanan Berat', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 2, 'nama_produk' => 'Pepes Ayam', 'deskripsi' => 'Pepes ayam dengan daun kemangi', 'harga' => 22000, 'stock' => 12, 'gambar' => 'https://picsum.photos/seed/pepes/300/200.jpg', 'kategori' => 'Makanan Berat', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 2, 'nama_produk' => 'Ikan Bakar', 'deskripsi' => 'Ikan bakar dengan sambal', 'harga' => 30000, 'stock' => 8, 'gambar' => 'https://picsum.photos/seed/ikanbakar/300/200.jpg', 'kategori' => 'Makanan Berat', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 2, 'nama_produk' => 'Tempe Goreng', 'deskripsi' => 'Tempe goreng dengan sambal', 'harga' => 10000, 'stock' => 25, 'gambar' => 'https://picsum.photos/seed/tempe/300/200.jpg', 'kategori' => 'Makanan Ringan', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 2, 'nama_produk' => 'Tahu Goreng', 'deskripsi' => 'Tahu goreng dengan bumbu', 'harga' => 8000, 'stock' => 30, 'gambar' => 'https://picsum.photos/seed/tahu/300/200.jpg', 'kategori' => 'Makanan Ringan', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 2, 'nama_produk' => 'Es Jeruk', 'deskripsi' => 'Es jeruk segar', 'harga' => 6000, 'stock' => 20, 'gambar' => 'https://picsum.photos/seed/esjeruk/300/200.jpg', 'kategori' => 'Minuman', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            
            // Stand Mie Ayam (ID: 3)
            ['stand_id' => 3, 'nama_produk' => 'Mie Ayam', 'deskripsi' => 'Mie ayam dengan pangsit dan bakso', 'harga' => 18000, 'stock' => 25, 'gambar' => 'https://picsum.photos/seed/mieayam/300/200.jpg', 'kategori' => 'Makanan Berat', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 3, 'nama_produk' => 'Bakso Urat', 'deskripsi' => 'Bakso urat dengan mie dan sayuran', 'harga' => 15000, 'stock' => 30, 'gambar' => 'https://picsum.photos/seed/bakso/300/200.jpg', 'kategori' => 'Makanan Berat', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 3, 'nama_produk' => 'Mie Goreng', 'deskripsi' => 'Mie goreng dengan telur dan sayuran', 'harga' => 16000, 'stock' => 20, 'gambar' => 'https://picsum.photos/seed/miegoreng/300/200.jpg', 'kategori' => 'Makanan Berat', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 3, 'nama_produk' => 'Kwetiau Goreng', 'deskripsi' => 'Kwetiau goreng dengan ayam', 'harga' => 20000, 'stock' => 15, 'gambar' => 'https://picsum.photos/seed/kwetiau/300/200.jpg', 'kategori' => 'Makanan Berat', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 3, 'nama_produk' => 'Pangsit Goreng', 'deskripsi' => 'Pangsit goreng renyah', 'harga' => 12000, 'stock' => 18, 'gambar' => 'https://picsum.photos/seed/pangsit/300/200.jpg', 'kategori' => 'Makanan Ringan', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 3, 'nama_produk' => 'Es Teh', 'deskripsi' => 'Es teh manis', 'harga' => 5000, 'stock' => 35, 'gambar' => 'https://picsum.photos/seed/esteh2/300/200.jpg', 'kategori' => 'Minuman', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            
            // Stand Soto (ID: 4)
            ['stand_id' => 4, 'nama_produk' => 'Soto Ayam', 'deskripsi' => 'Soto ayam dengan telur dan kerupuk', 'harga' => 20000, 'stock' => 18, 'gambar' => 'https://picsum.photos/seed/sotoayam/300/200.jpg', 'kategori' => 'Makanan Berat', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 4, 'nama_produk' => 'Soto Daging', 'deskripsi' => 'Soto daging dengan jeroan', 'harga' => 25000, 'stock' => 10, 'gambar' => 'https://picsum.photos/seed/sotodaging/300/200.jpg', 'kategori' => 'Makanan Berat', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 4, 'nama_produk' => 'Soto Mie', 'deskripsi' => 'Soto dengan mie', 'harga' => 18000, 'stock' => 22, 'gambar' => 'https://picsum.photos/seed/sotomie/300/200.jpg', 'kategori' => 'Makanan Berat', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 4, 'nama_produk' => 'Empal Gentong', 'deskripsi' => 'Empal gentong dengan sambal', 'harga' => 15000, 'stock' => 12, 'gambar' => 'https://picsum.photos/seed/empal/300/200.jpg', 'kategori' => 'Makanan Ringan', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 4, 'nama_produk' => 'Perkedel', 'deskripsi' => 'Perkedel khas solo', 'harga' => 10000, 'stock' => 20, 'gambar' => 'https://picsum.photos/seed/perkedel/300/200.jpg', 'kategori' => 'Makanan Ringan', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 4, 'nama_produk' => 'Es Campur', 'deskripsi' => 'Es campur dengan buah', 'harga' => 12000, 'stock' => 25, 'gambar' => 'https://picsum.photos/seed/escampur/300/200.jpg', 'kategori' => 'Minuman', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            
            // Stand Bakso (ID: 5)
            ['stand_id' => 5, 'nama_produk' => 'Bakso Jumbo', 'deskripsi' => 'Bakso jumbo dengan mie dan sayuran', 'harga' => 22000, 'stock' => 15, 'gambar' => 'https://picsum.photos/seed/baksojumbo/300/200.jpg', 'kategori' => 'Makanan Berat', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 5, 'nama_produk' => 'Mie Ayam Bakso', 'deskripsi' => 'Kombinasi mie ayam dan bakso', 'harga' => 20000, 'stock' => 20, 'gambar' => 'https://picsum.photos/seed/mieayambakso/300/200.jpg', 'kategori' => 'Makanan Berat', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 5, 'nama_produk' => 'Bakso Kuah', 'deskripsi' => 'Bakso dengan kuah kental', 'harga' => 18000, 'stock' => 25, 'gambar' => 'https://picsum.photos/seed/baksokuah/300/200.jpg', 'kategori' => 'Makanan Berat', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 5, 'nama_produk' => 'Siomay', 'deskripsi' => 'Siomay dengan saus', 'harga' => 15000, 'stock' => 18, 'gambar' => 'https://picsum.photos/seed/siomay/300/200.jpg', 'kategori' => 'Makanan Ringan', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 5, 'nama_produk' => 'Batagor', 'deskripsi' => 'Batagor goreng', 'harga' => 12000, 'stock' => 22, 'gambar' => 'https://picsum.photos/seed/batagor/300/200.jpg', 'kategori' => 'Makanan Ringan', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 5, 'nama_produk' => 'Es Teh Tawar', 'deskripsi' => 'Es teh tawar', 'harga' => 4000, 'stock' => 30, 'gambar' => 'https://picsum.photos/seed/esteh3/300/200.jpg', 'kategori' => 'Minuman', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            
            // Stand Gado-Gado (ID: 6)
            ['stand_id' => 6, 'nama_produk' => 'Gado-Gado', 'deskripsi' => 'Gado-gado dengan lontong dan kerupuk', 'harga' => 15000, 'stock' => 25, 'gambar' => 'https://picsum.photos/seed/gadogado/300/200.jpg', 'kategori' => 'Makanan Berat', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 6, 'nama_produk' => 'Karedok', 'deskripsi' => 'Karedok dengan bumbu kacang', 'harga' => 12000, 'stock' => 20, 'gambar' => 'https://picsum.photos/seed/karedok/300/200.jpg', 'kategori' => 'Makanan Ringan', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 6, 'nama_produk' => 'Asinan Sayur', 'deskripsi' => 'Asinan segar', 'harga' => 10000, 'stock' => 15, 'gambar' => 'https://picsum.photos/seed/asinan/300/200.jpg', 'kategori' => 'Makanan Ringan', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 6, 'nama_produk' => 'Lontong Sayur', 'deskripsi' => 'Lontong dengan sayur lodeh', 'harga' => 13000, 'stock' => 18, 'gambar' => 'https://picsum.photos/seed/lontong/300/200.jpg', 'kategori' => 'Makanan Berat', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 6, 'nama_produk' => 'Pecel', 'deskripsi' => 'Pecel lezat', 'harga' => 8000, 'stock' => 20, 'gambar' => 'https://picsum.photos/seed/pecel/300/200.jpg', 'kategori' => 'Makanan Ringan', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 6, 'nama_produk' => 'Es Kelapa Muda', 'deskripsi' => 'Es kelapa muda', 'harga' => 10000, 'stock' => 25, 'gambar' => 'https://picsum.photos/seed/eskelapa/300/200.jpg', 'kategori' => 'Minuman', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            
            // Stand Es Buah (ID: 7)
            ['stand_id' => 7, 'nama_produk' => 'Es Buah', 'deskripsi' => 'Es buah segar dengan susu dan jelly', 'harga' => 12000, 'stock' => 30, 'gambar' => 'https://picsum.photos/seed/esbuah/300/200.jpg', 'kategori' => 'Minuman', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 7, 'nama_produk' => 'Es Campur', 'deskripsi' => 'Es campur dengan berbagai topping', 'harga' => 15000, 'stock' => 25, 'gambar' => 'https://picsum.photos/seed/escampur2/300/200.jpg', 'kategori' => 'Minuman', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 7, 'nama_produk' => 'Es Kopyor', 'deskripsi' => 'Es kopyor dengan susu', 'harga' => 10000, 'stock' => 20, 'gambar' => 'https://picsum.photos/seed/eskopyor/300/200.jpg', 'kategori' => 'Minuman', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 7, 'nama_produk' => 'Es Cendol', 'deskripsi' => 'Es cendol dengan pacar coklat', 'harga' => 8000, 'stock' => 35, 'gambar' => 'https://picsum.photos/seed/escendol/300/200.jpg', 'kategori' => 'Minuman', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 7, 'nama_produk' => 'Es Doger', 'deskripsi' => 'Es doger dengan kacang', 'harga' => 9000, 'stock' => 28, 'gambar' => 'https://picsum.photos/seed/esdoger/300/200.jpg', 'kategori' => 'Minuman', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 7, 'nama_produk' => 'Es Teler', 'deskripsi' => 'Es teler dengan buah segar', 'harga' => 11000, 'stock' => 22, 'gambar' => 'https://picsum.photos/seed/esteler/300/200.jpg', 'kategori' => 'Minuman', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            
            // Stand Jus & Kopi (ID: 8)
            ['stand_id' => 8, 'nama_produk' => 'Jus Alpukat', 'deskripsi' => 'Jus alpukat segar dengan susu', 'harga' => 12000, 'stock' => 20, 'gambar' => 'https://picsum.photos/seed/jusalpukat/300/200.jpg', 'kategori' => 'Minuman', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 8, 'nama_produk' => 'Jus Mangga', 'deskripsi' => 'Jus mangga manis', 'harga' => 10000, 'stock' => 25, 'gambar' => 'https://picsum.photos/seed/jusmangga/300/200.jpg', 'kategori' => 'Minuman', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 8, 'nama_produk' => 'Jus Jeruk', 'deskripsi' => 'Jus jeruk segar', 'harga' => 10000, 'stock' => 30, 'gambar' => 'https://picsum.photos/seed/jusjeruk2/300/200.jpg', 'kategori' => 'Minuman', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 8, 'nama_produk' => 'Jus Strawberi', 'deskripsi' => 'Jus strawberi creamy', 'harga' => 15000, 'stock' => 18, 'gambar' => 'https://picsum.photos/seed/jusstrawberi/300/200.jpg', 'kategori' => 'Minuman', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 8, 'nama_produk' => 'Kopi Susu', 'deskripsi' => 'Kopi susu dengan foam', 'harga' => 10000, 'stock' => 35, 'gambar' => 'https://picsum.photos/seed/kopisusu/300/200.jpg', 'kategori' => 'Minuman', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
            ['stand_id' => 8, 'nama_produk' => 'Cappuccino', 'deskripsi' => 'Cappuccino dengan bubuk coklat', 'harga' => 18000, 'stock' => 22, 'gambar' => 'https://picsum.photos/seed/cappuccino/300/200.jpg', 'kategori' => 'Minuman', 'tersedia' => true, 'created_at' => now(), 'updated_at' => now()],
        ];

        Produk::insert($produks);
    }
}

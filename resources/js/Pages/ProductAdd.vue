<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
</script>

<template>
    <AdminLayout :show-filter="false">
        <section class="w-full h-full flex items-center justify-center p-4">
            <div
                class="bg-white w-[35%] p-7 rounded-lg shadow-md overflow-y-auto flex flex-col gap-4"
            >
                <div class="text-xl font-medium">Tambah Produk</div>
                <div
                    class="border-2 border-dashed border-gray-300 p-5 rounded-md flex flex-col items-center justify-center gap-2"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-10 w-10 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                        />
                    </svg>
                    <div class="text-gray-500 text-sm">
                        Seret & Letakkan atau
                        <span class="text-blue-400">Pilih File</span> untuk
                        diunggah
                    </div>
                    <div class="text-gray-500 text-xs">
                        Format yang didukung: Jpg, Png
                    </div>
                </div>
                <div>
                    <label class="text-sm">Produk</label>
                    <input
                        type="text"
                        class="w-full bg-gray-100 border-2 border-gray-400 rounded-md p-2 mt-1 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Produk"
                    />
                </div>
                <div>
                    <label class="text-sm">Harga</label>
                    <input
                        type="text"
                        class="w-full bg-gray-100 border-2 border-gray-400 rounded-md p-2 mt-1 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Harga"
                    />
                </div>
                <div class="pb-2">
                    <label class="text-sm">Pilih kategori</label>
                    <select
                        class="w-full bg-gray-100 border-2 border-gray-400 rounded-md p-2 mt-1 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Pilih kategori"
                    >
                        <option value="" disabled selected>
                            Pilih kategori
                        </option>
                        <option value="makanan">Makanan</option>
                        <option value="minuman">Minuman</option>
                        <option value="cemilan">Cemilan</option>
                    </select>
                </div>

                <div class="flex jusitfy-between gap-3 border-t pt-4">
                    <button
                        class="w-full bg-gray-300 text-black py-2 rounded-md hover:bg-gray-400 transition duration-300"
                    >
                        Batal
                    </button>
                    <button
                        class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300"
                    >
                        Tambah
                    </button>
                </div>
            </div>
        </section>
    </AdminLayout>
</template>

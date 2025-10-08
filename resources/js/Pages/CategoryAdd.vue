<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";

import Notif from "@/Components/Notif.vue";
</script>

<template>
    <AdminLayout :show-filter="false">
        <Notif />
        <section class="w-full h-full flex items-center justify-center p-4">
            <div
                class="bg-white w-[28%] p-7 rounded-lg shadow-md overflow-y-auto flex flex-col gap-6"
            >
                <div class="text-xl font-medium">Tambah Kategori</div>
                <div class="pt-3">
                    <label class="text-sm">Kategori</label>
                    <input
                        type="text"
                        class="w-full bg-gray-100 border-2 border-gray-400 rounded-md p-2 mt-1 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Kategori"
                    />
                </div>

                <div class="flex jusitfy-between gap-3 border-t pt-6">
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

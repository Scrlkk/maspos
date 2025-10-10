<script setup>
import { Head, Link } from "@inertiajs/vue3";
import IconPaymentSuccess from "@/Components/IconPaymentSuccess.vue";
import IconArrow from "@/Components/IconArrow.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

defineOptions({
    layout: (h, page) => h(AdminLayout, { showFilter: false }, () => page),
});
</script>

<template>
    <Head title="Pembayaran" />
    <section class="w-full h-full flex items-center justify-center p-4">
        <div
            class="bg-white w-[28%] p-7 rounded-lg shadow-md overflow-y-auto flex flex-col items-center gap-3"
        >
            <div class="flex flex-col items-center">
                <IconPaymentSuccess />
                <div class="text-2xl font-bold text-green-600 mb-2">
                    Pembayaran Sukses
                </div>
            </div>
            <div class="text-center">
                <div class="text-gray-600">
                    <div>Total</div>
                    <div class="text-xl font-bold text-gray-800 py-1">
                        Rp 150.000
                    </div>
                    <div>12 Desember 2023</div>
                </div>
            </div>
            <Link
                :href="route('dashboard')"
                class="w-full bg-blue-600 text-white px-4 py-2 rounded-md cursor-pointer hover:bg-blue-700 transition flex gap-2 items-center justify-center"
            >
                <IconArrow class="mt-1" />
                <p>Kembali</p>
            </Link>
        </div>
    </section>
</template>

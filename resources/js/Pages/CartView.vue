<script setup>
import { ref, computed } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import CartBody from "@/Components/CartBody.vue";
import burger from "@/Assets/Misc/burger.png";
import coke from "@/Assets/Misc/coke.png";
import pizza from "@/Assets/Misc/pizza2.png";
import tea from "@/Assets/Misc/tea.png";

const source = ref([
    {
        id: 1,
        name: "Burger Spesial",
        price: 50.0,
        image: burger,
        subtotal: 50.0,
    },
    {
        id: 2,
        name: "Coca Cola",
        price: 15.0,
        image: coke,
        subtotal: 15.0,
    },
    {
        id: 3,
        name: "Pizza Spesial",
        price: 80.0,
        image: pizza,
        subtotal: 80.0,
    },
    {
        id: 4,
        name: "Ice Tea",
        price: 10.0,
        image: tea,
        subtotal: 10.0,
    },
    {
        id: 5,
        name: "Ice Tea",
        price: 10.0,
        image: tea,
        subtotal: 10.0,
    },
    {
        id: 6,
        name: "Ice Tea",
        price: 10.0,
        image: tea,
        subtotal: 10.0,
    },
]);

const hasItems = computed(() => source.value.length > 0);
</script>

<template>
    <AdminLayout :show-filter="false">
        <section class="flex flex-col h-full">
            <!-- Conditional rendering based on cart items -->
            <div v-if="hasItems" class="flex flex-col h-full">
                <!-- TABLE -->
                <div
                    class="flex-1 bg-white rounded-t-lg shadow-sm overflow-auto scrollbar-hide"
                >
                    <table class="w-full text-gray-600">
                        <thead
                            class="font-medium border-b border-gray-300 bg-white sticky top-0 z-20"
                        >
                            <tr class="bg-white">
                                <th
                                    class="font-medium rounded-tl-lg text-left px-6 py-3 w-[31%]"
                                >
                                    Product
                                </th>
                                <th class="font-medium px-6 py-3 w-[17%]">
                                    Harga
                                </th>
                                <th class="font-medium px-6 py-3 w-[17%]">
                                    Jumlah
                                </th>
                                <th class="font-medium px-6 py-3 w-[25%]">
                                    Subtotal
                                </th>
                                <th
                                    class="font-medium rounded-tr-lg px-6 py-3 w-[10%]"
                                ></th>
                            </tr>
                        </thead>
                        <tbody>
                            <CartBody
                                v-for="cart in source"
                                :key="cart.id"
                                :Cart="cart"
                            />
                        </tbody>
                    </table>
                </div>

                <!-- Footer with total and buttons -->
                <div
                    class="w-full bg-white px-5 py-4 rounded-b-lg flex gap-6 justify-end items-center shadow-[0_0_20px_rgba(0,0,0,0.1)]"
                >
                    <div class="flex gap-4">
                        <button
                            class="text-blue-500 border border-blue-500 px-7 py-2 rounded-md hover:bg-blue-50 transition-colors"
                        >
                            Kembali
                        </button>
                        <button
                            class="bg-blue-500 text-white px-9 py-2 rounded-md hover:bg-blue-600 transition-colors"
                        >
                            Bayar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Empty state -->
            <div
                v-else
                class="flex-1 bg-white rounded-lg shadow-sm flex flex-col items-center justify-center"
            >
                <div class="text-center py-16">
                    <div class="mb-4">
                        <svg
                            class="mx-auto h-24 w-24 text-gray-300"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6 0a1 1 0 100 2 1 1 0 000-2zm-6 0a1 1 0 100 2 1 1 0 000-2z"
                            />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        Keranjang Kosong
                    </h3>
                    <p class="text-gray-500 mb-6">
                        Belum ada produk yang ditambahkan ke keranjang
                    </p>
                    <button
                        class="text-blue-500 border border-blue-500 px-7 py-2 rounded-md hover:bg-blue-50 transition-colors"
                    >
                        Kembali ke Menu
                    </button>
                </div>
            </div>
        </section>
    </AdminLayout>
</template>

<style scoped>
.scrollbar-hide {
    /* Hide scrollbar for Chrome, Safari and Opera */
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
}

.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
</style>

<script setup>
import { computed, ref } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import CartBody from "@/Components/CartBody.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import DeleteCartItem from "@/Components/DeleteCartItem.vue";

const props = defineProps({
    carts: {
        type: Array,
        default: () => [],
    },
    total: {
        type: Number,
        default: 0,
    },
});

const hasItems = computed(() => props.carts.length > 0);
const showDeleteModal = ref(false);
const cartToDelete = ref(null);

const back = () => {
    router.visit(route("dashboard"));
};

const openDeleteModal = (cart) => {
    cartToDelete.value = cart;
    showDeleteModal.value = true;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    cartToDelete.value = null;
};

const handleDeleted = () => {
    closeDeleteModal();
};

defineOptions({
    layout: (h, page) => h(AdminLayout, { showFilter: false }, () => page),
});
</script>

<template>
    <Head title="Keranjang" />
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
                            <th class="font-medium px-6 py-3 w-[17%]">Harga</th>
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
                            v-for="cart in carts"
                            :key="cart.id"
                            :cart="cart"
                            @delete="openDeleteModal"
                        />
                    </tbody>
                </table>
            </div>

            <!-- Footer with total and buttons -->
            <div
                class="w-full bg-white px-5 py-4 rounded-b-lg flex gap-6 justify-between items-center shadow-[0_0_20px_rgba(0,0,0,0.1)]"
            >
                <div class="flex items-center gap-4">
                    <span class="text-lg font-semibold text-gray-700"
                        >Total:</span
                    >
                    <span class="text-2xl font-bold text-blue-600"
                        >Rp {{ total.toLocaleString("id-ID") }}</span
                    >
                </div>
                <div class="flex gap-4">
                    <button
                        @click="back"
                        class="text-blue-500 border border-blue-500 px-7 py-2 rounded-md hover:bg-blue-50 transition-colors"
                    >
                        Kembali
                    </button>

                    <Link
                        :href="route('payment')"
                        class="bg-blue-500 text-white px-9 py-2 rounded-md hover:bg-blue-600 transition-colors"
                    >
                        Bayar
                    </Link>
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
                <Link
                    :href="route('dashboard')"
                    class="text-blue-500 border border-blue-500 px-7 py-2 rounded-md hover:bg-blue-50 transition-colors inline-block"
                >
                    Kembali ke Menu
                </Link>
            </div>
        </div>

        <!-- Delete Modal -->
        <DeleteCartItem
            v-if="showDeleteModal"
            :cart="cartToDelete"
            @close="closeDeleteModal"
            @deleted="handleDeleted"
        />
    </section>
</template>

<style scoped>
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
</style>

<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import CardProduct from "@/Components/CardProduct.vue";
import DeleteProduct from "@/Components/DeleteProduct.vue";
import Notif from "@/Components/Notif.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

const props = defineProps({
    products: {
        type: Array,
        default: () => [],
    },
    categories: {
        type: Array,
        default: () => [],
    },
});

const showDeleteModal = ref(false);
const selectedProduct = ref(null);

const showNotif = ref(false);
const notifType = ref("success");
const notifMessage = ref("");

const searchQuery = ref("");
const selectedCategoryId = ref(0); // 0 = Semua

// Filtered products based on search and category
const filteredProducts = computed(() => {
    let filtered = props.products;

    // Filter by category
    if (selectedCategoryId.value !== 0) {
        filtered = filtered.filter(
            (product) => product.category_id === selectedCategoryId.value
        );
    }

    // Filter by search query
    if (searchQuery.value.trim() !== "") {
        const query = searchQuery.value.toLowerCase();
        filtered = filtered.filter((product) =>
            product.name.toLowerCase().includes(query)
        );
    }

    return filtered;
});

// Handle search from AdminLayout
const handleSearch = (query) => {
    searchQuery.value = query;
};

// Handle category selection from AdminLayout
const handleCategorySelect = (categoryId) => {
    selectedCategoryId.value = categoryId;
};

const handleDeleteClick = (product) => {
    selectedProduct.value = product;
    showDeleteModal.value = true;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    selectedProduct.value = null;
};

const handleDeleted = (notification) => {
    // Close modal first
    closeDeleteModal();

    // Show notification
    notifType.value = notification.type;
    notifMessage.value = notification.message;
    showNotif.value = true;

    setTimeout(() => {
        showNotif.value = false;
    }, 3000);
};
</script>

<template>
    <AdminLayout @search="handleSearch" @category-select="handleCategorySelect">
        <Head title="Dashboard" />
        <Notif
            v-if="showNotif"
            :type="notifType"
            :message="notifMessage"
            class="mt-12"
        />

        <section class="grid grid-cols-6 gap-5 w-full">
            <!-- Enhanced empty state for no products -->
            <div
                v-if="products.length === 0"
                class="col-span-6 flex flex-col items-center justify-center py-16"
            >
                <!-- Illustration/Icon -->
                <div
                    class="w-32 h-32 bg-blue-100 rounded-full flex items-center justify-center mb-6"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-16 w-16 text-blue-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                        />
                    </svg>
                </div>

                <!-- Main message -->
                <h3 class="text-2xl font-semibold text-gray-700 mb-2">
                    Produk Masih Kosong
                </h3>

                <!-- Description -->
                <p
                    class="text-gray-500 text-center max-w-md mb-8 leading-relaxed"
                >
                    Cobalah untuk menambahkan produk pertama atau menambahkan
                    kategori
                </p>

                <!-- Action buttons -->
                <div class="flex gap-4">
                    <Link
                        :href="route('product.add')"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-all duration-200 flex items-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4v16m8-8H4"
                            />
                        </svg>
                        Tambah Produk Pertama
                    </Link>

                    <Link
                        :href="route('category.add')"
                        class="bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition-all duration-200 flex items-center gap-2 border border-gray-200"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.99 1.99 0 013 12V7a4 4 0 014-4z"
                            />
                        </svg>
                        Buat Kategori
                    </Link>
                </div>
            </div>

            <!-- Enhanced empty state for filtered results -->
            <div
                v-else-if="filteredProducts.length === 0"
                class="col-span-6 flex flex-col items-center justify-center py-16"
            >
                <!-- Search illustration -->
                <div
                    class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-12 w-12 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                        />
                    </svg>
                </div>

                <h3 class="text-xl font-semibold text-gray-700 mb-2">
                    Produk Tidak Ditemukan
                </h3>

                <p class="text-gray-500 text-center max-w-sm mb-6">
                    Tidak ada produk yang sesuai dengan pencarian atau kategori
                    yang dipilih.
                </p>

                <Link
                    :href="route('product.add')"
                    class="bg-gray-100 flex gap-2 items-center text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors duration-200 text-sm border border-gray-200"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v16m8-8H4"
                        />
                    </svg>
                    Tambah Produk Baru
                </Link>
            </div>

            <!-- Show filtered products -->
            <CardProduct
                v-for="product in filteredProducts"
                :key="product.id"
                :product="product"
                loading="lazy"
                @delete-click="handleDeleteClick(product)"
            />
        </section>
        <DeleteProduct
            v-if="showDeleteModal"
            :product="selectedProduct"
            @close="closeDeleteModal"
            @deleted="handleDeleted"
        />
    </AdminLayout>
</template>

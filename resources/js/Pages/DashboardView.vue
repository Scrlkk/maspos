<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import CardProduct from "@/Components/CardProduct.vue";
import DeleteProduct from "@/Components/DeleteProduct.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

// Receive products from backend
const props = defineProps({
    products: {
        type: Array,
        default: () => []
    }
});

const showDeleteModal = ref(false);
const selectedProduct = ref(null);

const handleDeleteClick = (product) => {
    selectedProduct.value = product;
    showDeleteModal.value = true;
};

defineOptions({
    layout: (h, page) => h(AdminLayout, () => page),
});
</script>

<template>
    <Head title="Dashboard" />
    <section class="grid grid-cols-6 gap-5 w-full">
        <!-- Show message if no products -->
        <div v-if="products.length === 0" class="col-span-6 text-center py-10">
            <div class="text-gray-500 text-lg">Belum ada produk</div>
            <Link 
                :href="route('product.add')" 
                class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200"
            >
                Tambah Produk Pertama
            </Link>
        </div>
        
        <!-- Show products -->
        <CardProduct
            v-for="product in products"
            :key="product.id"
            :product="product"
            loading="lazy"
            @delete-click="handleDeleteClick(product)"
        />
    </section>
    <DeleteProduct
        v-if="showDeleteModal"
        :product="selectedProduct"
        @close="showDeleteModal = false"
    />
</template>

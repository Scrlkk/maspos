<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import CardProduct from "@/Components/CardProduct.vue";
import DeleteProduct from "@/Components/DeleteProduct.vue";
const products = ref([
    {
        id: 1,
        name: "Burger Spesial",
        price: "Rp 25.000",
        image: new URL("@/Assets/Misc/burger.png", import.meta.url).href,
    },
    {
        id: 2,
        name: "Kentang Goreng",
        price: "Rp 15.000",
        image: new URL("@/Assets/Misc/Kentang.png", import.meta.url).href,
    },
    {
        id: 3,
        name: "Coke Cola",
        price: "Rp 10.000",
        image: new URL("@/Assets/Misc/coke.png", import.meta.url).href,
    },
    {
        id: 4,
        name: "Pizza Papperoni",
        price: "Rp 40.000",
        image: new URL("@/Assets/Misc/papperoni.png", import.meta.url).href,
    },
    {
        id: 5,
        name: "Pizza Spesial",
        price: "Rp 45.000",
        image: new URL("@/Assets/Misc/pizza2.png", import.meta.url).href,
    },
    {
        id: 6,
        name: "Pizza Hawaiian",
        price: "Rp 55.000",
        image: new URL("@/Assets/Misc/pizza3.png", import.meta.url).href,
    },
    {
        id: 7,
        name: "Lecy tea",
        price: "Rp 15.000",
        image: new URL("@/Assets/Misc/tea.png", import.meta.url).href,
    },
    {
        id: 5,
        name: "Pizza Spesial",
        price: "Rp 45.000",
        image: new URL("@/Assets/Misc/pizza2.png", import.meta.url).href,
    },
    {
        id: 6,
        name: "Pizza Hawaiian",
        price: "Rp 55.000",
        image: new URL("@/Assets/Misc/pizza3.png", import.meta.url).href,
    },
    {
        id: 7,
        name: "Lecy tea",
        price: "Rp 15.000",
        image: new URL("@/Assets/Misc/tea.png", import.meta.url).href,
    },
    {
        id: 5,
        name: "Pizza Spesial",
        price: "Rp 45.000",
        image: new URL("@/Assets/Misc/pizza2.png", import.meta.url).href,
    },
    {
        id: 6,
        name: "Pizza Hawaiian",
        price: "Rp 55.000",
        image: new URL("@/Assets/Misc/pizza3.png", import.meta.url).href,
    },
    {
        id: 7,
        name: "Lecy tea",
        price: "Rp 15.000",
        image: new URL("@/Assets/Misc/tea.png", import.meta.url).href,
    },
    {
        id: 5,
        name: "Pizza Spesial",
        price: "Rp 45.000",
        image: new URL("@/Assets/Misc/pizza2.png", import.meta.url).href,
    },
    {
        id: 6,
        name: "Pizza Hawaiian",
        price: "Rp 55.000",
        image: new URL("@/Assets/Misc/pizza3.png", import.meta.url).href,
    },
    {
        id: 7,
        name: "Lecy tea",
        price: "Rp 15.000",
        image: new URL("@/Assets/Misc/tea.png", import.meta.url).href,
    },
]);
const showDeleteModal = ref(false);
const selectedProduct = ref(null);

const handleDeleteClick = (product) => {
    selectedProduct.value = product;
    showDeleteModal.value = true;
};
</script>

<template>
    <Head title="Dashboard" />
    <AdminLayout>
        <section class="grid grid-cols-6 gap-5 w-full">
            <CardProduct
                v-for="product in products"
                :key="product.id"
                :product="product"
                loading="lazy"
                @delete-click="handleDeleteClick(product)"
            />
        </section>
    </AdminLayout>
    <DeleteProduct
        v-if="showDeleteModal"
        :product="selectedProduct"
        @close="showDeleteModal = false"
    />
</template>

<script setup>
import { ref } from "vue";
import IconPlus from "@/Components/IconPlus.vue";
import IconMinus from "@/Components/IconMinus.vue";

const props = defineProps({
    Cart: {
        type: Object,
        required: true,
    },
});

const quantity = ref(1);

const increaseQuantity = () => {
    quantity.value++;
};

const decreaseQuantity = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
};
</script>

<template>
    <tr class="border-b border-gray-100 hover:bg-gray-50">
        <td class="px-6 py-5">
            <div class="flex gap-4 items-center">
                <img
                    :src="Cart.image"
                    alt="Product Image"
                    class="w-[120px] h-[85px] object-cover rounded-lg"
                    loading="lazy"
                />
                <div class="font-medium text-lg">{{ Cart.name }}</div>
            </div>
        </td>
        <td class="text-center px-6 py-5">
            <span class="text-gray-600"
                >Rp {{ Cart.price.toLocaleString("id-ID") }}</span
            >
        </td>
        <td class="text-center px-6 py-5">
            <div class="flex justify-center items-center gap-3">
                <button
                    @click="decreaseQuantity"
                    class="bg-gray-200 text-gray-600 px-2 py-1 rounded hover:bg-gray-300 transition-colors"
                    :disabled="quantity <= 1"
                    :class="{ 'opacity-50 cursor-not-allowed': quantity <= 1 }"
                >
                    <IconMinus class="w-3 h-3" fill="#000000" />
                </button>
                <span class="min-w-[30px] text-center font-medium">{{
                    quantity
                }}</span>
                <button
                    @click="increaseQuantity"
                    class="bg-gray-200 text-gray-600 px-2 py-1 rounded hover:bg-gray-300 transition-colors"
                >
                    <IconPlus class="w-3 h-3" fill="#000000" />
                </button>
            </div>
        </td>
        <td class="text-center px-6 py-5">
            <span class="font-medium text-gray-700"
                >Rp {{ (Cart.price * quantity).toLocaleString("id-ID") }}</span
            >
        </td>
        <td class="text-center px-6 py-5">
            <button
                class="text-red-600 hover:text-red-800 font-medium transition-colors"
            >
                Hapus
            </button>
        </td>
    </tr>
</template>

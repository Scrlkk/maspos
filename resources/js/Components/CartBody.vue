<script setup>
import { router } from "@inertiajs/vue3";
import IconPlus from "@/Components/IconPlus.vue";
import IconMinus from "@/Components/IconMinus.vue";
import { ref } from "vue";

const props = defineProps({
    cart: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["delete"]);
const imageError = ref(false);

// Tambah quantity (akan hit cart.store dengan product_id yang sama)
const increaseQuantity = () => {
    router.post(
        route("cart.store"),
        {
            product_id: props.cart.product_id,
        },
        {
            preserveScroll: true,
        }
    );
};

// Kurangi quantity atau hapus jika quantity = 1
const decreaseQuantity = () => {
    router.delete(route("cart.decrease", props.cart.id), {
        preserveScroll: true,
    });
};

// Emit event untuk membuka modal delete
const removeItem = () => {
    emit("delete", props.cart);
};

const handleImageError = () => {
    imageError.value = true;
};
</script>

<template>
    <tr class="border-b border-gray-100 hover:bg-gray-50">
        <td class="px-6 py-5">
            <div class="flex gap-4 items-center">
                <div class="w-[120px] h-[85px] rounded-lg overflow-hidden">
                    <!-- Show image if available and no error -->
                    <img
                        v-if="cart.image && !imageError"
                        :src="cart.image"
                        :alt="cart.name"
                        class="w-full h-full object-cover"
                        loading="lazy"
                        @error="handleImageError"
                    />
                    <!-- Show placeholder if no image or error -->
                    <div
                        v-else
                        class="w-full h-full bg-gray-100 flex items-center justify-center"
                    >
                        <svg
                            class="w-8 h-8 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                            />
                        </svg>
                    </div>
                </div>
                <div class="font-medium text-lg">{{ cart.name }}</div>
            </div>
        </td>
        <td class="text-center px-6 py-5">
            <span class="text-gray-600"
                >Rp {{ cart.price.toLocaleString("id-ID") }}</span
            >
        </td>
        <td class="text-center px-6 py-5">
            <div class="flex justify-center items-center gap-3">
                <!-- Tombol Kurang -->
                <button
                    @click="decreaseQuantity"
                    class="bg-gray-200 text-gray-600 px-2 py-1 rounded hover:bg-gray-300 transition-colors"
                >
                    <IconMinus class="w-3 h-3" fill="#000000" />
                </button>

                <!-- Display Quantity -->
                <span class="min-w-[30px] text-center font-medium">{{
                    cart.quantity
                }}</span>

                <!-- Tombol Tambah -->
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
                >Rp {{ cart.subtotal.toLocaleString("id-ID") }}</span
            >
        </td>
        <td
            class="text-center px-6 py-5 group hover:bg-red-200 transition-colors ease-in-out duration-200"
        >
            <button
                @click="removeItem"
                class="group-text-red-600 group-hover:text-red-800 font-medium"
            >
                Hapus
            </button>
        </td>
    </tr>
</template>

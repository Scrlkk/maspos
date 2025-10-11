<script setup>
import { router } from "@inertiajs/vue3";
import IconPlus from "@/Components/IconPlus.vue";
import { ref } from "vue";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["deleteClick"]);
const imageError = ref(false);

const addToCart = () => {
    router.post(
        route("cart.store"),
        {
            product_id: props.product.id,
            quantity: 1,
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                // Optional: Show notification
                console.log("Product added to cart");
            },
        }
    );
};

const handleImageError = () => {
    imageError.value = true;
};
</script>

<template>
    <section
        class="bg-white p-2 rounded-xl border-gray-200 border shadow-md h-[300px]"
    >
        <div class="w-full h-full flex flex-col justify-between">
            <!-- IMAGE -->
            <div class="h-[170px] w-full rounded-lg overflow-hidden relative">
                <!-- Show image if available and no error -->
                <img
                    v-if="product.image && !imageError"
                    :src="product.image"
                    :alt="product.name"
                    class="object-cover w-full h-full"
                    @error="handleImageError"
                />
                <!-- Show placeholder if no image or error -->
                <div
                    v-else
                    class="w-full h-full bg-gray-100 flex items-center justify-center"
                >
                    <svg
                        class="w-16 h-16 text-gray-400"
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

                <div
                    class="absolute bottom-2 right-2 p-1.5 bg-white/50 border border-white/50 rounded-md cursor-pointer hover:bg-white/70 transition-all"
                    @click="emit('deleteClick')"
                >
                    <svg
                        width="16"
                        height="16"
                        viewBox="0 0 12 12"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M11 2H8.5V1C8.5 0.734784 8.39464 0.48043 8.20711 0.292893C8.01957 0.105357 7.76522 0 7.5 0L4.5 0C4.23478 0 3.98043 0.105357 3.79289 0.292893C3.60536 0.48043 3.5 0.734784 3.5 1V2H1V3H2V10.5C2 10.8978 2.15804 11.2794 2.43934 11.5607C2.72064 11.842 3.10218 12 3.5 12H8.5C8.89782 12 9.27936 11.842 9.56066 11.5607C9.84196 11.2794 10 10.8978 10 10.5V3H11V2ZM4.5 1H7.5V2H4.5V1ZM9 10.5C9 10.6326 8.94732 10.7598 8.85355 10.8536C8.75979 10.9473 8.63261 11 8.5 11H3.5C3.36739 11 3.24021 10.9473 3.14645 10.8536C3.05268 10.7598 3 10.6326 3 10.5V3H9V10.5Z"
                            fill="#FF2928"
                        />
                        <path
                            d="M5.5 4.99976H4.5V8.99975H5.5V4.99976Z"
                            fill="#FF2928"
                        />
                        <path
                            d="M7.50001 4.99976H6.5V8.99975H7.50001V4.99976Z"
                            fill="#FF2928"
                        />
                    </svg>
                </div>
            </div>

            <!-- DESCRIPTION -->
            <div class="flex flex-col">
                <div class="text-lg font-medium truncate" :title="product.name">
                    {{ product.name }}
                </div>
                <div class="text-green-600 font-bold text-lg">
                    {{ product.price }}
                </div>
            </div>
            <button
                @click="addToCart"
                class="bg-blue-600 text-white px-3 py-2.5 rounded-lg flex items-center justify-center text-sm gap-2 hover:bg-blue-700 transition-colors"
            >
                <IconPlus /> Keranjang
            </button>
        </div>
    </section>
</template>

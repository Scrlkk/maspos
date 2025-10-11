<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import IconPaymentSuccess from "@/Components/IconPaymentSuccess.vue";
import IconArrow from "@/Components/IconArrow.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

const props = defineProps({
    carts: {
        type: Array,
        default: () => [],
    },
    total: {
        type: Number,
        default: 0,
    },
    isEmpty: {
        type: Boolean,
        default: false,
    },
});

const paymentSuccess = ref(false);
const isProcessing = ref(false);
const paymentDate = ref(null);

const processPayment = () => {
    isProcessing.value = true;

    setTimeout(() => {
        paymentDate.value = new Date();
        paymentSuccess.value = true;
        isProcessing.value = false;

        // Set flag di localStorage bahwa payment berhasil dan cart perlu di-clear
        localStorage.setItem("payment_success_clear_cart", "true");
    }, 1000);
};

const clearCart = () => {
    router.post(
        route("cart.clear"),
        {},
        {
            preserveState: true,
            onSuccess: () => {
                localStorage.removeItem("payment_success_clear_cart");
                console.log("Cart cleared");
            },
        }
    );
};

const backToDashboard = () => {
    if (localStorage.getItem("payment_success_clear_cart")) {
        clearCart();
    }
    setTimeout(() => {
        router.visit(route("dashboard"));
    }, 100);
};

const backToCart = () => {
    if (!paymentSuccess.value) {
        router.visit(route("cart"));
    } else {
        if (localStorage.getItem("payment_success_clear_cart")) {
            clearCart();
        }
        setTimeout(() => {
            router.visit(route("cart"));
        }, 100);
    }
};

// Event listener untuk handle navigasi manual
const handleBeforeUnload = () => {
    if (localStorage.getItem("payment_success_clear_cart")) {
        // Kirim request untuk clear cart
        navigator.sendBeacon("/cart/clear", new FormData());
        localStorage.removeItem("payment_success_clear_cart");
    }
};

onMounted(() => {
    window.addEventListener("beforeunload", handleBeforeUnload);
});

onBeforeUnmount(() => {
    window.removeEventListener("beforeunload", handleBeforeUnload);

    // Clear cart jika payment success dan belum di-clear
    if (localStorage.getItem("payment_success_clear_cart")) {
        clearCart();
    }
});

const formattedDate = computed(() => {
    if (!paymentDate.value) return "";

    const options = {
        year: "numeric",
        month: "long",
        day: "numeric",
    };
    return new Date(paymentDate.value).toLocaleDateString("id-ID", options);
});

defineOptions({
    layout: (h, page) => h(AdminLayout, { showFilter: false }, () => page),
});
</script>

<template>
    <Head title="Pembayaran" />
    <section class="w-full h-full flex items-center justify-center p-4">
        <!-- Konfirmasi Pembayaran -->
        <div
            v-if="!paymentSuccess"
            class="bg-white w-[28%] p-7 rounded-lg shadow-md overflow-y-auto flex flex-col gap-5"
        >
            <div class="text-center border-b pb-5">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">
                    Konfirmasi Pembayaran
                </h2>
                <p class="text-gray-600">
                    Pastikan total pembayaran sudah sesuai
                </p>
            </div>

            <div class="space-y-4">
                <!-- Detail Produk -->
                <div class="max-h-[300px] overflow-y-auto space-y-3">
                    <div
                        v-for="cart in carts"
                        :key="cart.id"
                        class="flex justify-between items-center p-3 bg-gray-50 rounded-lg"
                    >
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">
                                {{ cart.name }}
                            </p>
                            <p class="text-sm text-gray-600">
                                {{ cart.quantity }} x Rp
                                {{ cart.price.toLocaleString("id-ID") }}
                            </p>
                        </div>
                        <p class="font-semibold text-gray-800">
                            Rp {{ cart.subtotal.toLocaleString("id-ID") }}
                        </p>
                    </div>
                </div>

                <!-- Total -->
                <div
                    class="flex justify-between items-center p-4 bg-blue-50 rounded-lg border-2 border-blue-200"
                >
                    <span class="text-lg font-semibold text-gray-700"
                        >Total Pembayaran:</span
                    >
                    <span class="text-2xl font-bold text-blue-600"
                        >Rp {{ total.toLocaleString("id-ID") }}</span
                    >
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-3">
                <button
                    @click="backToCart"
                    :disabled="isProcessing"
                    class="w-full border border-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-50 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Batal
                </button>
                <button
                    @click="processPayment"
                    :disabled="isProcessing"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                >
                    <span v-if="isProcessing">Memproses...</span>
                    <span v-else>Bayar Sekarang</span>
                </button>
            </div>
        </div>

        <!-- Pembayaran Sukses -->
        <div
            v-else
            class="bg-white w-[28%] p-7 rounded-lg shadow-md overflow-y-auto flex flex-col items-center gap-3"
        >
            <div class="flex flex-col items-center">
                <IconPaymentSuccess class="animate-pulse ease-in-out" />
                <div
                    class="text-2xl font-bold animate-pulse text-green-600 mb-2 ease-in-out"
                >
                    Pembayaran Sukses
                </div>
            </div>
            <div class="text-center">
                <div class="text-gray-600">
                    <div>Total</div>
                    <div class="text-xl font-bold text-gray-800 py-1">
                        Rp {{ total.toLocaleString("id-ID") }}
                    </div>
                    <div>{{ formattedDate }}</div>
                </div>
            </div>
            <button
                @click="backToDashboard"
                class="w-full bg-blue-600 text-white px-4 py-2 rounded-md cursor-pointer hover:bg-blue-700 transition flex gap-2 items-center justify-center"
            >
                <IconArrow class="mt-1" />
                <p>Kembali</p>
            </button>
        </div>
    </section>
</template>

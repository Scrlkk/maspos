<script setup>
import { ref, computed } from "vue";
import IconPlus from "@/Components/IconPlus.vue";
import CategoryCols from "@/Components/CategoryCols.vue";

const props = defineProps({
    showFilter: {
        type: Boolean,
        default: true,
    },
    customHeight: {
        type: String,
        default: "h-[37rem]",
    },
});

const contentHeight = computed(() => {
    if (props.showFilter) {
        return "h-[32.5rem]";
    }
    return props.customHeight;
});

const categories = ref([
    {
        id: 1,
        name: "Semua",
        bgColor: "bg-blue-500",
        textColor: "text-white",
    },
    {
        id: 2,
        name: "Makanan",
        bgColor: "bg-blue-100",
        textColor: "text-blue-500",
    },
    {
        id: 3,
        name: "Minuman",
        bgColor: "bg-blue-100",
        textColor: "text-blue-500",
    },
    {
        id: 4,
        name: "Cemilan",
        bgColor: "bg-blue-100",
        textColor: "text-blue-500",
    },
]);
</script>

<template>
    <section class="bg-green-500 p-6 w-full h-screen relative">
        <div
            class="sticky top-6 bg-white py-4 px-6 rounded-lg shadow-md z-50 overflow-hidden"
        >
            <!-- NAVBAR -->
            <div class="grid grid-cols-[20%_80%] items-center">
                <div class="text-blue-600 font-bold text-2xl">MASPOS</div>
                <div class="flex gap-6 justify-end">
                    <button
                        class="bg-blue-500 text-white py-2 px-4 rounded-md flex items-center gap-2"
                    >
                        <IconPlus />
                        Tambah Kategori
                    </button>
                    <button
                        class="bg-blue-500 text-white py-2 px-4 rounded-md flex items-center gap-2"
                    >
                        <IconPlus />
                        Tambah Produk
                    </button>
                    <button
                        class="bg-blue-500 text-white py-2 px-4 rounded-md relative"
                    >
                        <svg
                            width="17"
                            height="16"
                            viewBox="0 0 17 16"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M3.17 10.6668V2.66683H1.83667V1.3335H3.83667C4.20486 1.3335 4.50334 1.63198 4.50334 2.00016V10.0002H12.7956L14.1289 4.66683H5.83667V3.3335H14.9828C15.351 3.3335 15.6495 3.63198 15.6495 4.00016C15.6495 4.05467 15.6428 4.10898 15.6296 4.16186L13.9629 10.8285C13.8888 11.1253 13.6221 11.3335 13.3161 11.3335H3.83667C3.46848 11.3335 3.17 11.035 3.17 10.6668ZM4.50334 15.3335C3.76696 15.3335 3.17 14.7366 3.17 14.0002C3.17 13.2638 3.76696 12.6668 4.50334 12.6668C5.23972 12.6668 5.83667 13.2638 5.83667 14.0002C5.83667 14.7366 5.23972 15.3335 4.50334 15.3335ZM12.5033 15.3335C11.7669 15.3335 11.17 14.7366 11.17 14.0002C11.17 13.2638 11.7669 12.6668 12.5033 12.6668C13.2397 12.6668 13.8367 13.2638 13.8367 14.0002C13.8367 14.7366 13.2397 15.3335 12.5033 15.3335Z"
                                fill="white"
                            />
                        </svg>
                    </button>
                    <button
                        class="bg-blue-100 text-blue-500 rounded-r-md px-2.5 -ml-8 pl-5"
                    >
                        Total Tagihan: <span class="font-bold">Rp 13.000</span>
                    </button>

                    <button
                        class="flex items-center border-l border-gray-300 pl-4"
                    >
                        <div
                            class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center text-white font-bold mr-2"
                        />
                        Aldean
                    </button>
                </div>
            </div>

            <!-- BAG 2 -->
            <template v-if="showFilter">
                <!-- BORDER -->
                <div class="mt-5 border-t border-gray-300">
                    <!-- FILTER -->
                    <div
                        class="grid grid-cols-[23%_77%] gap-4 mt-4 overflow-hidden items-center"
                    >
                        <div class="relative">
                            <input
                                type="text"
                                placeholder="Cari nama produk ..."
                                class="w-full bg-[#EDF0F2] border-none focus:ring-0 rounded-md p-2 pl-11"
                            />
                            <div
                                class="absolute left-3 top-1/2 -translate-y-1/2"
                            >
                                <svg
                                    width="18"
                                    height="18"
                                    viewBox="0 0 16 16"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M7.3335 1.33337C10.6455 1.33337 13.3335 4.02137 13.3335 7.33337C13.3335 10.6454 10.6455 13.3334 7.3335 13.3334C4.0215 13.3334 1.3335 10.6454 1.3335 7.33337C1.3335 4.02137 4.0215 1.33337 7.3335 1.33337ZM7.3335 12C9.91183 12 12.0002 9.91171 12.0002 7.33337C12.0002 4.75504 9.91183 2.66671 7.3335 2.66671C4.75516 2.66671 2.66683 4.75504 2.66683 7.33337C2.66683 9.91171 4.75516 12 7.3335 12ZM12.9904 12.0474L14.876 13.933L13.9332 14.8758L12.0476 12.9902L12.9904 12.0474Z"
                                        fill="#2C59E5"
                                    />
                                </svg>
                            </div>
                        </div>

                        <!-- CATEGORY -->
                        <div class="px-2 flex gap-4">
                            <CategoryCols
                                v-for="category in categories"
                                :key="category.id"
                                :category="category"
                            />
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Dynamic height content area -->
        <div
            :class="[
                contentHeight,
                'mt-5 overflow-hidden overflow-y-auto scrollbar-hide',
            ]"
        >
            <slot />
        </div>
    </section>
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

<script setup>
import { ref, computed, onMounted, nextTick } from "vue";
import { router, Link, usePage } from "@inertiajs/vue3";
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

const page = usePage();

// Get categories from page props
const dbCategories = computed(() => page.props.categories || []);

// Computed categories with "Semua" added at the beginning
const categories = computed(() => {
    const allCategory = {
        id: 0,
        nama: "Semua",
        bgColor: "bg-blue-500",
        textColor: "text-white",
    };

    const mappedCategories = dbCategories.value.map((cat) => ({
        id: cat.id,
        nama: cat.nama,
        bgColor: "bg-blue-100",
        textColor: "text-blue-500",
    }));

    return [allCategory, ...mappedCategories];
});

const contentHeight = computed(() => {
    if (props.showFilter) {
        return "h-[32.5rem]";
    }
    return props.customHeight;
});

// Scroll functionality
const categoryContainer = ref(null);
const showLeftArrow = ref(false);
const showRightArrow = ref(false);

const checkScrollButtons = () => {
    if (categoryContainer.value) {
        const { scrollLeft, scrollWidth, clientWidth } =
            categoryContainer.value;

        showLeftArrow.value = scrollLeft > 0;
        showRightArrow.value = scrollLeft < scrollWidth - clientWidth - 1;
    }
};

const scrollLeft = () => {
    if (categoryContainer.value) {
        categoryContainer.value.scrollBy({
            left: -200,
            behavior: "smooth",
        });
    }
};

const scrollRight = () => {
    if (categoryContainer.value) {
        categoryContainer.value.scrollBy({
            left: 200,
            behavior: "smooth",
        });
    }
};

onMounted(() => {
    nextTick(() => {
        checkScrollButtons();

        if (categoryContainer.value) {
            categoryContainer.value.addEventListener(
                "scroll",
                checkScrollButtons
            );
            window.addEventListener("resize", checkScrollButtons);
        }
    });
});

const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <section class="bg-[#EDF0F2] p-6 w-full h-screen relative">
        <div
            class="sticky top-6 bg-white py-4 px-6 rounded-lg shadow-md z-30 overflow-hidden"
        >
            <!-- NAVBAR -->
            <div class="grid grid-cols-[20%_80%] items-center">
                <Link
                    :href="route('dashboard')"
                    class="text-blue-600 font-bold text-2xl"
                    >MASPOS</Link
                >
                <div class="flex gap-6 justify-end">
                    <!-- KATEGORI -->
                    <Link
                        :href="route('category.add')"
                        class="bg-blue-500 text-white py-2 px-4 rounded-md flex items-center gap-2 hover:bg-blue-600 transition-all duration-300 ease-in-out"
                    >
                        <IconPlus />
                        Tambah Kategori
                    </Link>

                    <!-- PRODUK -->
                    <Link
                        :href="route('product.add')"
                        class="bg-blue-500 text-white py-2 px-4 rounded-md flex items-center gap-2 hover:bg-blue-600 transition-all duration-300 ease-in-out"
                    >
                        <IconPlus />
                        Tambah Produk
                    </Link>

                    <!-- CART -->
                    <Link
                        class="flex items-center relative group"
                        :href="route('cart')"
                    >
                        <div
                            class="bg-blue-500 flex items-center text-white h-full px-4 rounded-md relative hover:bg-blue-600 transition-all duration-300 ease-in-out"
                        >
                            <svg
                                class="group-hover:animate-pulse"
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
                        </div>
                        <div
                            class="bg-blue-100 text-blue-500 rounded-r-md h-full px-2.5 -ml-4 pl-7 flex items-center"
                        >
                            Total Tagihan
                            <span
                                class="font-bold pl-1.5 group-hover:text-blue-700 transition-all group-hover:animate-pulse duration-300 ease-in-out"
                            >
                                Rp 150.000</span
                            >
                        </div>
                    </Link>
                    <!-- USER -->
                    <button
                        @click="logout"
                        class="flex items-center border-l border-gray-300 pl-4"
                    >
                        <img
                            src="https://i.pravatar.cc/400"
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
                        class="grid grid-cols-[23%_77%] gap-4 mt-4 items-center"
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

                        <!-- CATEGORY  -->
                        <div class="relative flex items-center">
                            <!-- Left Arrow -->
                            <button
                                v-show="showLeftArrow"
                                @click="scrollLeft"
                                class="absolute left-0 z-10 bg-gradient-to-r from-white to-transparent w-14 h-full flex items-center justify-start"
                            >
                                <div
                                    class="bg-white shadow-lg rounded-full p-1.5 ml-1"
                                >
                                    <svg
                                        width="14"
                                        height="14"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="rotate-180"
                                    >
                                        <path
                                            d="M8.78126 8.00047L5.48145 4.70062L6.42425 3.75781L10.6669 8.00047L6.42425 12.2431L5.48145 11.3003L8.78126 8.00047Z"
                                            fill="#2C59E5"
                                        />
                                    </svg>
                                </div>
                            </button>

                            <!-- Category Container -->
                            <div
                                ref="categoryContainer"
                                class="flex gap-4 overflow-x-auto scrollbar-hide px-5"
                                :class="{
                                    'pl-12': showLeftArrow,
                                    'pr-12': showRightArrow,
                                }"
                                @scroll="checkScrollButtons"
                            >
                                <CategoryCols
                                    v-for="category in categories"
                                    :key="category.id"
                                    :category="category"
                                />
                            </div>

                            <!-- Right Arrow -->
                            <button
                                v-show="showRightArrow"
                                @click="scrollRight"
                                class="absolute right-0 z-10 bg-gradient-to-l from-white to-transparent w-14 h-full flex items-center justify-end"
                            >
                                <div
                                    class="bg-white shadow-lg rounded-full p-1.5 mr-1"
                                >
                                    <svg
                                        width="14"
                                        height="14"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M8.78126 8.00047L5.48145 4.70062L6.42425 3.75781L10.6669 8.00047L6.42425 12.2431L5.48145 11.3003L8.78126 8.00047Z"
                                            fill="#2C59E5"
                                        />
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Dynamic height content area -->
        <main
            :class="[
                contentHeight,
                'mt-5 overflow-hidden overflow-y-auto scrollbar-hide',
            ]"
        >
            <slot />
        </main>
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

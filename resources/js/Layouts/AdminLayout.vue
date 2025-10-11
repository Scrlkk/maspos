<script setup>
import { ref, computed, onMounted, nextTick, onUnmounted } from "vue";
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
const searchQuery = ref("");
const selectedCategoryId = ref(0);
const showUserMenu = ref(false);

const emit = defineEmits(["search", "categorySelect"]);

// Get authenticated user
const user = computed(() => page.props.auth?.user);

// Get cart data
const cartData = computed(() => page.props.cartData || { total: 0, count: 0 });
const cartTotal = computed(() => cartData.value.total);
const cartCount = computed(() => cartData.value.count);
const hasCartItems = computed(() => cartCount.value > 0);

const dbCategories = computed(() => page.props.categories || []);

const categories = computed(() => {
    const allCategory = {
        id: 0,
        nama: "Semua",
        bgColor: selectedCategoryId.value === 0 ? "bg-blue-600" : "bg-blue-100",
        textColor:
            selectedCategoryId.value === 0 ? "text-white" : "text-blue-600",
    };

    const mappedCategories = dbCategories.value.map((cat) => ({
        id: cat.id,
        nama: cat.nama,
        bgColor:
            selectedCategoryId.value === cat.id ? "bg-blue-600" : "bg-blue-100",
        textColor:
            selectedCategoryId.value === cat.id
                ? "text-white"
                : "text-blue-600",
    }));

    return [allCategory, ...mappedCategories];
});

const contentHeight = computed(() => {
    if (props.showFilter) {
        return "h-[32.5rem]";
    }
    return props.customHeight;
});

// Get user initials for avatar
const userInitials = computed(() => {
    if (!user.value?.name) return "U";
    return user.value.name
        .split(" ")
        .map((word) => word[0])
        .join("")
        .toUpperCase()
        .slice(0, 2);
});

// Handle search
const handleSearch = () => {
    emit("search", searchQuery.value);
};

// Handle category
const handleCategoryClick = (categoryId) => {
    selectedCategoryId.value = categoryId;
    emit("categorySelect", categoryId);
};

// User menu toggle
const toggleUserMenu = () => {
    showUserMenu.value = !showUserMenu.value;
};

// Close user menu when clicking outside
const userMenuRef = ref(null);
const handleClickOutside = (event) => {
    if (userMenuRef.value && !userMenuRef.value.contains(event.target)) {
        showUserMenu.value = false;
    }
};

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

    document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener("click", handleClickOutside);
});

const logout = () => {
    showUserMenu.value = false;

    // Check jika ada payment success yang perlu clear cart
    if (localStorage.getItem("payment_success_clear_cart")) {
        // Clear cart dulu sebelum logout
        router.post(
            route("cart.clear"),
            {},
            {
                onSuccess: () => {
                    localStorage.removeItem("payment_success_clear_cart");
                    // Baru logout setelah cart ter-clear
                    router.post(route("logout"));
                },
            }
        );
    } else {
        // Logout normal jika tidak ada payment success
        router.post(route("logout"));
    }
};
</script>

<template>
    <section class="bg-[#EDF0F2] p-6 w-full h-screen relative">
        <div class="sticky top-6 bg-white py-4 px-6 rounded-lg shadow-md z-30">
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
                            <!-- Badge Count -->
                            <span
                                v-if="cartCount > 0"
                                class="absolute -top-2 right-1.5 bg-green-400 text-white text-[11px] font-bold rounded-full w-5 h-5 flex items-center justify-center"
                            >
                                {{ cartCount }}
                            </span>

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
                        <!-- Total Tagihan - Only hide this part -->
                        <div
                            v-if="hasCartItems"
                            class="bg-blue-100 text-blue-500 rounded-r-md h-full px-2.5 -ml-4 pl-7 flex items-center"
                        >
                            Total Tagihan
                            <span
                                class="font-bold pl-1.5 group-hover:text-blue-700 transition-all group-hover:animate-pulse duration-300 ease-in-out"
                            >
                                Rp
                                {{
                                    Number(cartTotal).toLocaleString("id-ID")
                                }}</span
                            >
                        </div>
                    </Link>

                    <!-- USER MENU -->
                    <div class="relative" ref="userMenuRef">
                        <button
                            @click="toggleUserMenu"
                            class="flex items-center border-l border-gray-300 pl-4 hover:opacity-80 transition-opacity"
                        >
                            <!-- Default Avatar with Initials -->
                            <div
                                class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold mr-2"
                            >
                                {{ userInitials }}
                            </div>
                            <span class="mr-2">{{ user?.name || "User" }}</span>
                            <svg
                                :class="[
                                    'transition-transform duration-200',
                                    showUserMenu ? 'rotate-180' : '',
                                ]"
                                width="12"
                                height="12"
                                viewBox="0 0 12 12"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M6 8L2 4H10L6 8Z"
                                    fill="currentColor"
                                />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <transition
                            enter-active-class="transition ease-out duration-200"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95"
                        >
                            <div
                                v-show="showUserMenu"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50"
                            >
                                <!-- Profile Info -->
                                <div class="px-4 py-3 border-b border-gray-200">
                                    <p
                                        class="text-sm font-semibold text-gray-900"
                                    >
                                        {{ user?.name || "User" }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ user?.email || "user@example.com" }}
                                    </p>
                                </div>

                                <!-- Logout -->
                                <div class="py-1">
                                    <button
                                        @click="logout"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors flex items-center gap-2"
                                    >
                                        <svg
                                            width="16"
                                            height="16"
                                            viewBox="0 0 16 16"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M6 14H3.33333C2.97971 14 2.64057 13.8595 2.39052 13.6095C2.14048 13.3594 2 13.0203 2 12.6667V3.33333C2 2.97971 2.14048 2.64057 2.39052 2.39052C2.64057 2.14048 2.97971 2 3.33333 2H6M10.6667 11.3333L14 8M14 8L10.6667 4.66667M14 8H6"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>
                                        Keluar
                                    </button>
                                </div>
                            </div>
                        </transition>
                    </div>
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
                                v-model="searchQuery"
                                @input="handleSearch"
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
                                    @click="handleCategoryClick(category.id)"
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

        <!-- content area -->
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

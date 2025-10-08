<script setup>
import { ref } from "vue";

const showDeleteModal = ref(false);

defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["close"]);
</script>

<template>
    <section
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-30"
    >
        <!-- Content -->
        <div
            class="bg-white p-5 rounded-lg w-[400px] flex flex-col justify-between gap-4"
        >
            <div>
                <svg
                    width="64"
                    height="64"
                    viewBox="0 0 64 64"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <rect width="64" height="64" rx="32" fill="#FFA8A8" />
                    <mask
                        id="mask0_23_249"
                        style="mask-type: luminance"
                        maskUnits="userSpaceOnUse"
                        x="0"
                        y="0"
                        width="64"
                        height="64"
                    >
                        <path d="M64 0H0V64H64V0Z" fill="white" />
                    </mask>
                    <g mask="url(#mask0_23_249)">
                        <path
                            d="M32 8C45.2456 8 56 18.7544 56 32C56 45.2456 45.2456 56 32 56C18.7544 56 8 45.2456 8 32C8 18.7544 18.7544 8 32 8Z"
                            fill="#FF2928"
                        />
                        <path
                            d="M34.9988 35.2003V30.1577C34.9566 29.6723 34.5428 29.31 34.0676 29.3436C33.5924 29.31 33.1783 29.6723 33.1361 30.1577V35.2003H30.4558V30.1577C30.4135 29.6723 29.9994 29.31 29.5242 29.3436C29.049 29.31 28.6353 29.6723 28.593 30.1577V35.2003H24.6641L24.0497 26.1619H22.9137C22.2865 26.1619 21.7783 25.7235 21.7783 25.183C21.7783 24.6422 22.2865 24.2041 22.9137 24.2041H41.0868C41.714 24.2041 42.2225 24.6422 42.2225 25.183C42.2225 25.7235 41.714 26.1619 41.0868 26.1619H39.9511L39.3367 35.2003H34.9988Z"
                            fill="white"
                        />
                        <path
                            d="M39.388 34.4438L38.8945 41.6998C38.8526 42.3235 38.356 42.807 37.7585 42.8054H26.2414C25.644 42.807 25.1477 42.3235 25.1057 41.6998L24.6123 34.4438H28.5928V37.8307C28.635 38.3165 29.0488 38.6784 29.524 38.6448C29.9992 38.6784 30.4133 38.3165 30.4555 37.8307V34.4438H33.1358V37.8307C33.1781 38.3165 33.5921 38.6784 34.0673 38.6448C34.5425 38.6784 34.9563 38.3165 34.9985 37.8307V34.4438H39.388Z"
                            fill="white"
                        />
                        <path
                            d="M38.2669 15.0044L37.5043 16.0922L33.3719 13.1973L32.6094 14.2849L36.7418 17.1798L35.6108 18.7931L26.9042 12.6938C26.5022 12.4121 26.3848 11.8861 26.6422 11.5189L26.7353 11.3862C26.9926 11.0191 27.5273 10.9498 27.9294 11.2315L31.188 13.5143L32.1834 12.0944C32.3519 11.8541 32.6058 11.6881 32.8895 11.6335C33.1732 11.5788 33.4631 11.6391 33.6958 11.8022L38.2669 15.0044Z"
                            fill="white"
                        />
                        <path
                            d="M36.9583 14.085L40.7139 16.7161C41.1982 17.0554 41.3062 17.7364 40.9553 18.237L39.9599 19.6568L43.2184 21.9397C43.6204 22.2214 43.7377 22.7474 43.4804 23.1145L43.3873 23.2473C43.1299 23.6144 42.5952 23.6837 42.1932 23.402L34.3021 17.8736L35.4331 16.2604L38.7504 18.5844L39.5129 17.4968L36.1956 15.1728L36.9583 14.085Z"
                            fill="white"
                        />
                    </g>
                </svg>
            </div>
            <div class="border-b pb-5">
                <div class="text-lg font-bold">Hapus Produk</div>
                <div class="text-gray-600">
                    Apakah anda yakin ingin menghapus <br />
                    {{ product.name }}?
                </div>
            </div>
            <div class="flex justify-between gap-3 pt-1">
                <button
                    @click="emit('close')"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 hover:border-red-600 hover:text-red-600 ease-in-out duration-200"
                >
                    Batal
                </button>
                <button
                    class="w-full px-3 py-2 rounded-lg bg-red-600 text-white"
                >
                    Hapus
                </button>
            </div>
        </div>
    </section>
</template>

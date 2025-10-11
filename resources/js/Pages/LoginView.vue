<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import HeroSection from "@/Components/HeroSection.vue";

const showPassword = ref(false);
const togglePassword = () => {
    showPassword.value = !showPassword.value;
};

const form = useForm({
    name: "",
    password: "",
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Login" />

    <section class="relative w-full h-screen p-7 px-12 bg-[#EDF0F2]">
        <div class="grid grid-cols-2 gap-20 w-full h-full justify-center">
            <!-- Kiri -->
            <HeroSection />

            <!-- Kanan -->
            <div class="relative w-full">
                <div
                    class="absolute right-5 text-[39px] font-bold text-[#1963D2]"
                >
                    MASPOS
                </div>
                <div class="px-24 h-full flex flex-col justify-center gap-4">
                    <form @submit.prevent="submit" class="flex flex-col gap-4">
                        <div>
                            <div class="text-[33px] font-medium">
                                Selamat Datang di MASPOS
                            </div>
                            <div class="text-xl">
                                Masuk untuk mengelola bisnis Anda dengan mudah
                                dan efisien. MASPOS menghadirkan solusi <br />
                                point-of-sale terbaik untuk kemudahan
                                operasional sehari-hari.
                            </div>
                        </div>

                        <!-- Username input -->
                        <div class="flex flex-col gap-0.5">
                            <label>Username</label>
                            <input
                                type="text"
                                placeholder="Username"
                                v-model="form.name"
                                class="w-full p-2 px-4 rounded-lg bg-[#F5F5F5]"
                                required
                            />
                        </div>

                        <!-- Password input -->
                        <div class="flex flex-col gap-0.5">
                            <label>Password</label>
                            <div class="relative">
                                <input
                                    v-model="form.password"
                                    placeholder="Password"
                                    :type="showPassword ? 'text' : 'password'"
                                    class="w-full p-2 px-4 rounded-lg bg-[#F5F5F5]"
                                    required
                                />
                                <button
                                    type="button"
                                    class="absolute right-4 top-1/2 -translate-y-1/2"
                                    @click="togglePassword"
                                >
                                    <svg
                                        v-if="showPassword"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M0.787781 8C1.41479 4.58651 4.40543 2 8.00022 2C11.595 2 14.5856 4.58651 15.2126 8C14.5856 11.4135 11.595 14 8.00022 14C4.40543 14 1.41479 11.4135 0.787781 8ZM8.00022 11.3333C9.84115 11.3333 11.3336 9.84093 11.3336 8C11.3336 6.15905 9.84115 4.66667 8.00022 4.66667C6.15925 4.66667 4.66686 6.15905 4.66686 8C4.66686 9.84093 6.15925 11.3333 8.00022 11.3333ZM8.00022 10C6.89562 10 6.00019 9.1046 6.00019 8C6.00019 6.8954 6.89562 6 8.00022 6C9.10475 6 10.0002 6.8954 10.0002 8C10.0002 9.1046 9.10475 10 8.00022 10Z"
                                            fill="#1F1F1F"
                                        />
                                    </svg>
                                    <svg
                                        v-else
                                        width="20"
                                        height="19"
                                        viewBox="0 0 16 15"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M15.5112 5.77177C14.9096 4.7866 14.1507 3.90662 13.2647 3.16674L15.1307 1.30077C15.3864 1.03603 15.379 0.614152 15.1143 0.358466C14.856 0.109027 14.4466 0.109027 14.1883 0.358466L12.1591 2.39037C10.9012 1.64321 9.46303 1.25376 7.99998 1.26413C3.87417 1.26413 1.52304 4.08843 0.488772 5.7718C-0.162924 6.82588 -0.162924 8.15776 0.488772 9.21187C1.09039 10.197 1.84927 11.077 2.73528 11.8169L0.869318 13.6829C0.604572 13.9385 0.597231 14.3605 0.852918 14.6252C1.1086 14.8899 1.53051 14.8973 1.79522 14.6416C1.80078 14.6362 1.80625 14.6307 1.81162 14.6252L3.84553 12.5913C5.1019 13.3383 6.53831 13.7284 7.99998 13.7195C12.1258 13.7195 14.4769 10.8952 15.5112 9.21184C16.1629 8.15776 16.1629 6.82588 15.5112 5.77177ZM4.0015 7.49182C3.99772 5.28717 5.78184 3.49689 7.98649 3.49311C8.82065 3.49168 9.63431 3.75161 10.3132 4.23637L9.34552 5.20401C8.93929 4.95904 8.47437 4.82846 8.00002 4.82615C6.52781 4.82615 5.33435 6.01961 5.33435 7.49182C5.33666 7.96617 5.46724 8.43109 5.71221 8.83732L4.74457 9.80496C4.26137 9.13043 4.00153 8.32154 4.0015 7.49182ZM8.00002 11.4903C7.17029 11.4903 6.3614 11.2305 5.68687 10.7473L6.65451 9.77962C7.06074 10.0246 7.52566 10.1552 8.00002 10.1575C9.47222 10.1575 10.6657 8.96402 10.6657 7.49182C10.6634 7.01746 10.5328 6.55254 10.2878 6.14632L11.2555 5.17868C12.5366 6.97282 12.1208 9.4659 10.3267 10.7471C9.64784 11.2318 8.83417 11.4918 8.00002 11.4903Z"
                                            fill="#0F0F0F"
                                        />
                                    </svg>
                                </button>
                            </div>
                            <!-- Password error -->
                            <div
                                v-if="form.errors.password || form.errors.name"
                                class="text-red-500 text-sm"
                            >
                                Username atau password yang Anda masukkan salah
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full shadow-md p-2.5 mt-2 rounded-lg flex justify-center bg-blue-500 text-white hover:bg-blue-600 cursor-pointer disabled:opacity-75"
                        >
                            {{ form.processing ? "Memproses..." : "Masuk" }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

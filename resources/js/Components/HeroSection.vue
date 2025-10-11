<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import Pic1 from "@/Assets/Misc/heroPic.png";

const currentSlide = ref(0);
let intervalId = null;

const slides = [
    {
        image: Pic1,
        title: "Desain yang user-friendly membuat navigasi cepat dan mudah, bahkan bagi pemula.",
        background:
            "bg-gradient-to-br from-[#4288F2] from-0% via-[#113E82] via-75% to-[#0A2A5F] to-100%",
    },
    {
        image: Pic1,
        title: "Sistem POS yang powerful untuk mengelola bisnis Anda dengan efisien.",
        background:
            "bg-gradient-to-br from-[#42A5F2] from-0% via-[#1168A5] via-75% to-[#0A4A7A] to-100%",
    },
    {
        image: Pic1,
        title: "Layanan pelanggan 24/7 untuk mendukung kebutuhan Anda kapan saja.",
        background:
            "bg-gradient-to-br from-[#4250F2] from-0% via-[#2D1182] via-75% to-[#1A0A5F] to-100%",
    },
];

const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % slides.length;
};

const prevSlide = () => {
    currentSlide.value =
        currentSlide.value === 0 ? slides.length - 1 : currentSlide.value - 1;
};

const goToSlide = (index) => {
    currentSlide.value = index;
};

const startAutoPlay = () => {
    intervalId = setInterval(() => {
        nextSlide();
    }, 5000);
};

const stopAutoPlay = () => {
    if (intervalId) {
        clearInterval(intervalId);
        intervalId = null;
    }
};

onMounted(() => {
    startAutoPlay();
});

onUnmounted(() => {
    stopAutoPlay();
});
</script>

<template>
    <section
        class="rounded-3xl flex flex-col justify-center w-full overflow-hidden relative transition-all duration-500 ease-in-out"
        :class="slides[currentSlide].background"
        @mouseenter="stopAutoPlay"
        @mouseleave="startAutoPlay"
    >
        <div class="flex flex-col gap-5 relative pb-16">
            <!-- Slides Container -->
            <div class="relative overflow-hidden">
                <div
                    class="flex transition-transform duration-500 ease-in-out"
                    :style="{
                        transform: `translateX(-${currentSlide * 100}%)`,
                    }"
                >
                    <div
                        v-for="(slide, index) in slides"
                        :key="index"
                        class="w-full flex-shrink-0"
                    >
                        <img
                            :src="slide.image"
                            :alt="`Hero Picture ${index + 1}`"
                            class="-mx-20 w-[620px] object-cover select-none pointer-events-none"
                            draggable="false"
                            loading="lazy"
                        />
                    </div>
                </div>
            </div>

            <!-- Text Content dengan height yang fixed -->
            <div
                class="pl-8 max-w-lg font-medium text-2xl text-white transition-opacity duration-300 h-[60px] flex items-start"
            >
                {{ slides[currentSlide].title }}
            </div>
        </div>

        <!-- Navigation Dots -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-2">
            <button
                v-for="(slide, index) in slides"
                :key="index"
                @click="goToSlide(index)"
                class="w-3 h-3 rounded-full transition-all duration-300"
                :class="
                    currentSlide === index
                        ? 'bg-white'
                        : 'bg-white/40 hover:bg-white/60'
                "
            />
        </div>

        <!-- Navigation Arrows -->
        <button
            @click="prevSlide"
            class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/30 rounded-full p-2 transition-colors duration-200"
        >
            <svg
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M15 18L9 12L15 6"
                    stroke="white"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
        </button>

        <button
            @click="nextSlide"
            class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/30 rounded-full p-2 transition-colors duration-200"
        >
            <svg
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M9 18L15 12L9 6"
                    stroke="white"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
        </button>
    </section>
</template>

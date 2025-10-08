<script setup>
import { ref } from "vue";
import Pic1 from "@/Assets/Misc/heroPic.png";
</script>

<template>
    <section
        class="bg-gradient-to-br from-[#4288F2] from-0% via-[#113E82] via-75% to-[#0A2A5F] to-100% rounded-3xl flex flex-col justify-center w-full overflow-hidden"
    >
        <div class="flex flex-col gap-5 -mt-12">
            <img
                :src="Pic1"
                alt="Hero Picture"
                class="-mx-20 w-[620px] object-cover select-none pointer-events-none"
                draggable="false"
                loading="lazy"
            />
            <div class="pl-8 max-w-lg font-medium text-2xl text-white">
                Desain yang user-friendly membuat navigasi cepat dan mudah,
                bahkan bagi pemula.
            </div>
        </div>
    </section>
</template>

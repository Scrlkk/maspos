<script setup>
const props = defineProps({
    category: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <section
        :class="`flex items-center px-5 py-2 cursor-pointer ${category.bgColor} rounded-lg ${category.textColor}`"
    >
        {{ category.nama }}
    </section>
</template>

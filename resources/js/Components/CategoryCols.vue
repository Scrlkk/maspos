<script setup>
const props = defineProps({
    category: {
        type: Object,
        required: true,
    },
});

// Dynamic classes based on active state
const getClasses = () => {
    if (props.isActive) {
        return "bg-blue-600 text-white";
    }
    return `${props.category.bgColor} ${props.category.textColor}`;
};
</script>

<template>
    <section
        :class="`flex items-center px-5 py-2 cursor-pointer rounded-lg transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-lg whitespace-nowrap ${getClasses()}`"
    >
        {{ category.nama }}
    </section>
</template>

<script setup>
const props = defineProps({
    type: {
        type: String,
        default: "success",
        validator: (value) => ["success", "error", "info"].includes(value),
    },
    message: {
        type: String,
        default: "Operasi berhasil dilakukan",
    },
});

const notifClasses = {
    success: {
        bg: "bg-green-200",
        border: "border-green-600",
        text: "text-green-500",
        iconColor: "#23A948",
    },
    error: {
        bg: "bg-red-200",
        border: "border-red-600",
        text: "text-red-500",
        iconColor: "#DC2626",
    },
    info: {
        bg: "bg-gray-100",
        border: "border-gray-400",
        text: "text-gray-700",
        iconColor: "#6B7280",
    },
};

const currentStyle = notifClasses[props.type] || notifClasses.info;
</script>

<template>
    <section class="absolute right-6 top-[140px] z-20">
        <div
            :class="[
                currentStyle.bg,
                currentStyle.border,
                currentStyle.text,
                'py-2.5 px-4 rounded-md shadow-md border-l-[6px] flex items-center gap-2',
            ]"
        >
            <div>
                <!-- Success Icon -->
                <svg
                    v-if="type === 'success'"
                    class="mt-0.5"
                    width="16"
                    height="17"
                    viewBox="0 0 16 17"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M8.00016 15.1666C4.31826 15.1666 1.3335 12.1818 1.3335 8.49998C1.3335 4.81808 4.31826 1.83331 8.00016 1.83331C11.682 1.83331 14.6668 4.81808 14.6668 8.49998C14.6668 12.1818 11.682 15.1666 8.00016 15.1666ZM8.00016 13.8333C10.9457 13.8333 13.3335 11.4455 13.3335 8.49998C13.3335 5.55446 10.9457 3.16665 8.00016 3.16665C5.05464 3.16665 2.66683 5.55446 2.66683 8.49998C2.66683 11.4455 5.05464 13.8333 8.00016 13.8333ZM7.3335 5.16665H8.66683V6.49998H7.3335V5.16665ZM7.3335 7.83331H8.66683V11.8333H7.3335V7.83331Z"
                        :fill="currentStyle.iconColor"
                    />
                </svg>

                <!-- Error Icon -->
                <svg
                    v-else-if="type === 'error'"
                    class="mt-0.5"
                    width="16"
                    height="17"
                    viewBox="0 0 16 17"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M8.00016 15.1666C4.31826 15.1666 1.3335 12.1818 1.3335 8.49998C1.3335 4.81808 4.31826 1.83331 8.00016 1.83331C11.682 1.83331 14.6668 4.81808 14.6668 8.49998C14.6668 12.1818 11.682 15.1666 8.00016 15.1666ZM8.00016 13.8333C10.9457 13.8333 13.3335 11.4455 13.3335 8.49998C13.3335 5.55446 10.9457 3.16665 8.00016 3.16665C5.05464 3.16665 2.66683 5.55446 2.66683 8.49998C2.66683 11.4455 5.05464 13.8333 8.00016 13.8333ZM7.3335 5.16665H8.66683V6.49998H7.3335V5.16665ZM7.3335 7.83331H8.66683V11.8333H7.3335V7.83331Z"
                        :fill="currentStyle.iconColor"
                    />
                </svg>

                <!-- Info Icon -->
                <svg
                    v-else
                    class="mt-0.5"
                    width="16"
                    height="17"
                    viewBox="0 0 16 17"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M8.00016 15.1666C4.31826 15.1666 1.3335 12.1818 1.3335 8.49998C1.3335 4.81808 4.31826 1.83331 8.00016 1.83331C11.682 1.83331 14.6668 4.81808 14.6668 8.49998C14.6668 12.1818 11.682 15.1666 8.00016 15.1666ZM8.00016 13.8333C10.9457 13.8333 13.3335 11.4455 13.3335 8.49998C13.3335 5.55446 10.9457 3.16665 8.00016 3.16665C5.05464 3.16665 2.66683 5.55446 2.66683 8.49998C2.66683 11.4455 5.05464 13.8333 8.00016 13.8333ZM7.3335 7.83331H8.66683V11.8333H7.3335V7.83331ZM7.3335 5.16665H8.66683V6.49998H7.3335V5.16665Z"
                        :fill="currentStyle.iconColor"
                    />
                </svg>
            </div>
            <p>{{ message }}</p>
        </div>
    </section>
</template>

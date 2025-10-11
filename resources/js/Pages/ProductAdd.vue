<script setup>
import { Head, router, useForm } from "@inertiajs/vue3";
import Notif from "@/Components/Notif.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ref } from "vue";

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
});

const showNotif = ref(false);
const notifType = ref("success");
const notifMessage = ref("");

const selectedFile = ref(null);
const previewUrl = ref(null);
const isDragging = ref(false);
const fileInput = ref(null);

const form = useForm({
    nama: "",
    harga: "",
    category_id: "",
    gambar: null,
});

const handleFileSelect = (event) => {
    const file = event.target.files[0];
    processFile(file);
};

const handleDrop = (event) => {
    event.preventDefault();
    isDragging.value = false;

    const file = event.dataTransfer.files[0];
    processFile(file);
};

const handleDragOver = (event) => {
    event.preventDefault();
    isDragging.value = true;
};

const handleDragLeave = (event) => {
    event.preventDefault();
    isDragging.value = false;
};

const processFile = (file) => {
    if (!file) return;

    const allowedTypes = ["image/jpeg", "image/jpg", "image/png"];
    if (!allowedTypes.includes(file.type)) {
        alert(
            "Format file tidak didukung. Hanya JPG dan PNG yang diperbolehkan."
        );
        return;
    }

    const maxSize = 5 * 1024 * 1024; // 5MB
    if (file.size > maxSize) {
        alert("Ukuran file terlalu besar. Maksimal 5MB.");
        return;
    }

    selectedFile.value = file;
    form.gambar = file;

    const reader = new FileReader();
    reader.onload = (e) => {
        previewUrl.value = e.target.result;
    };
    reader.readAsDataURL(file);
};

const triggerFileInput = () => {
    fileInput.value?.click();
};

const removeFile = () => {
    selectedFile.value = null;
    previewUrl.value = null;
    form.gambar = null;
    if (fileInput.value) {
        fileInput.value.value = "";
    }
};

const back = () => {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        router.visit(route("dashboard"));
    }
};

const submitProduct = () => {
    form.post(route("products.store"), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (response) => {
            notifType.value = "success";
            notifMessage.value = "Produk berhasil ditambahkan";
            showNotif.value = true;

            // Reset form after successful submission
            form.reset();
            form.clearErrors();
            removeFile();

            setTimeout(() => {
                showNotif.value = false;
            }, 3000);
        },
        onError: (errors) => {
            notifType.value = "error";
            const errorMessage =
                Object.values(errors)[0] ||
                "Terjadi kesalahan saat menambah produk";
            notifMessage.value = errorMessage;
            showNotif.value = true;

            setTimeout(() => {
                showNotif.value = false;
            }, 4000);
        },
    });
};

defineOptions({
    layout: (h, page) => h(AdminLayout, { showFilter: false }, () => page),
});
</script>

<template>
    <Head title="Produk" />
    <Notif v-if="showNotif" :type="notifType" :message="notifMessage" />
    <section class="w-full h-full flex items-center justify-center p-4">
        <div
            class="bg-white w-[35%] p-7 rounded-lg shadow-md overflow-y-auto flex flex-col gap-4"
        >
            <div class="text-xl font-medium">Tambah Produk</div>

            <form @submit.prevent="submitProduct">
                <!-- File Upload Area -->
                <div class="relative mb-3">
                    <!-- Hidden file input -->
                    <input
                        ref="fileInput"
                        type="file"
                        accept="image/jpeg,image/jpg,image/png"
                        @change="handleFileSelect"
                        class="hidden"
                    />

                    <!-- Upload area without preview -->
                    <div
                        v-if="!previewUrl"
                        @click="triggerFileInput"
                        @drop="handleDrop"
                        @dragover="handleDragOver"
                        @dragleave="handleDragLeave"
                        :class="[
                            'border-2 border-dashed p-5 rounded-md flex flex-col items-center justify-center gap-2 cursor-pointer transition-all duration-200',
                            isDragging
                                ? 'border-blue-400 bg-blue-50'
                                : 'border-gray-300 hover:border-blue-400 hover:bg-gray-50',
                            form.errors.gambar ? 'border-red-500' : '',
                        ]"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            :class="[
                                'h-10 w-10 transition-colors duration-200',
                                isDragging ? 'text-blue-400' : 'text-gray-400',
                            ]"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                            />
                        </svg>
                        <div class="text-gray-500 text-sm text-center">
                            Seret & Letakkan atau
                            <span class="text-blue-400 font-medium"
                                >Pilih File</span
                            >
                            untuk diunggah
                        </div>
                        <div class="text-gray-500 text-xs">
                            Format yang didukung: JPG, PNG (Maks. 5MB)
                        </div>
                    </div>

                    <!-- Preview area -->
                    <div v-else class="relative">
                        <div class="border-2 border-gray-300 rounded-md p-2">
                            <img
                                :src="previewUrl"
                                alt="Preview"
                                class="w-full h-32 object-cover rounded"
                            />
                        </div>

                        <!-- File info and actions -->
                        <div class="mt-2 flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                {{ selectedFile.name }}
                                <span class="text-xs text-gray-400 ml-1">
                                    ({{
                                        (
                                            selectedFile.size /
                                            1024 /
                                            1024
                                        ).toFixed(2)
                                    }}
                                    MB)
                                </span>
                            </div>
                            <div class="flex gap-2">
                                <button
                                    type="button"
                                    @click="triggerFileInput"
                                    class="text-blue-500 text-sm hover:text-blue-600"
                                >
                                    Ganti
                                </button>
                                <button
                                    type="button"
                                    @click="removeFile"
                                    class="text-red-500 text-sm hover:text-red-600"
                                >
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                    <div
                        v-if="form.errors.gambar"
                        class="text-red-500 text-sm mt-1"
                    >
                        {{ form.errors.gambar }}
                    </div>
                </div>

                <div class="mb-2">
                    <label class="text-sm">Produk</label>
                    <input
                        v-model="form.nama"
                        type="text"
                        class="w-full bg-gray-100 border-2 border-gray-400 rounded-md p-2 mt-1 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': form.errors.nama }"
                        placeholder="Nama Produk"
                        required
                    />
                    <div
                        v-if="form.errors.nama"
                        class="text-red-500 text-sm mt-1"
                    >
                        {{ form.errors.nama }}
                    </div>
                </div>

                <div class="mb-2">
                    <label class="text-sm">Harga</label>
                    <input
                        v-model="form.harga"
                        type="number"
                        class="w-full bg-gray-100 border-2 border-gray-400 rounded-md p-2 mt-1 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': form.errors.harga }"
                        placeholder="Harga"
                        required
                    />
                    <div
                        v-if="form.errors.harga"
                        class="text-red-500 text-sm mt-1"
                    >
                        {{ form.errors.harga }}
                    </div>
                </div>

                <div class="pb-2 mb-2">
                    <label class="text-sm">Pilih kategori</label>
                    <select
                        v-model="form.category_id"
                        class="w-full bg-gray-100 border-2 border-gray-400 rounded-md p-2 mt-1 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': form.errors.category_id }"
                        required
                    >
                        <option value="" disabled>Pilih kategori</option>
                        <option
                            v-for="category in categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.nama }}
                        </option>
                    </select>
                    <div
                        v-if="form.errors.category_id"
                        class="text-red-500 text-sm mt-1"
                    >
                        {{ form.errors.category_id }}
                    </div>
                </div>

                <div class="flex justify-between gap-3 border-t pt-4">
                    <button
                        type="button"
                        @click="back"
                        class="w-full bg-gray-300 text-black py-2 rounded-md hover:bg-gray-400 transition duration-300"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300 disabled:opacity-50"
                    >
                        {{ form.processing ? "Menyimpan..." : "Tambah" }}
                    </button>
                </div>
            </form>
        </div>
    </section>
</template>

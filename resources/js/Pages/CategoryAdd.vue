<script setup>
import { Head, router, useForm } from "@inertiajs/vue3";
import Notif from "@/Components/Notif.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ref } from "vue";

const showNotif = ref(false);
const notifType = ref("success");
const notifMessage = ref("");

const form = useForm({
    nama: "",
});

const back = () => {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        router.visit(route("dashboard"));
    }
};

const submitCategory = () => {
    form.post(route("categories.store"), {
        preserveState: true, 
        preserveScroll: true, 
        onSuccess: (response) => {
            notifType.value = "success";
            notifMessage.value = "Kategori berhasil ditambahkan";
            showNotif.value = true;

            form.reset();
            form.clearErrors();

            setTimeout(() => {
                showNotif.value = false;
            }, 3000);
        },
        onError: (errors) => {
            notifType.value = "error";
            if (errors.nama) {
                notifMessage.value = errors.nama;
            } else {
                notifMessage.value = "Terjadi kesalahan saat menambah kategori";
            }
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
    <Head title="Kategori" />
    <Notif v-if="showNotif" :type="notifType" :message="notifMessage" />
    <section class="w-full h-full flex items-center justify-center p-4">
        <div
            class="bg-white w-[28%] p-7 rounded-lg shadow-md overflow-y-auto flex flex-col gap-6"
        >
            <div class="text-xl font-medium">Tambah Kategori</div>

            <form @submit.prevent="submitCategory">
                <div class="pt-3">
                    <label class="text-sm">Kategori</label>
                    <input
                        v-model="form.nama"
                        type="text"
                        class="w-full bg-gray-100 border-2 border-gray-400 rounded-md p-2 mt-1 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': form.errors.nama }"
                        placeholder="Nama Kategori"
                        required
                    />
                    <div
                        v-if="form.errors.nama"
                        class="text-red-500 text-sm mt-1"
                    >
                        {{ form.errors.nama }}
                    </div>
                </div>

                <div class="flex justify-between gap-3 border-t pt-6">
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

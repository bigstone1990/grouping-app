<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="ダッシュボード" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                ダッシュボード
            </h2>
        </template>

        <div class="py-4">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-4 text-gray-900">
                        <ul class="flex gap-4 flex-wrap">
                            <li class="DashboardButtonWrapper">
                                <Link as="button" :href="route('grouping.index')" class="DashboardButton text-white bg-indigo-500 border-0 py-4 md:py-8 px-8 hover:bg-indigo-600 rounded">グループ分け</Link>
                            </li>
                            <li class="DashboardButtonWrapper">
                                <Link as="button" :href="route('users.index')" class="DashboardButton text-white bg-indigo-500 border-0 py-4 md:py-8 px-8 hover:bg-indigo-600 rounded">ユーザー管理</Link>
                            </li>
                            <li class="DashboardButtonWrapper">
                                <Link as="button" :href="route('groups.index')" class="DashboardButton text-white bg-indigo-500 border-0 py-4 md:py-8 px-8 hover:bg-indigo-600 rounded">グループ管理</Link>
                            </li>
                            <li class="DashboardButtonWrapper">
                                <Link as="button" :href="route('members.index')" class="DashboardButton text-white bg-indigo-500 border-0 py-4 md:py-8 px-8 hover:bg-indigo-600 rounded">メンバー管理</Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="scss">
.DashboardButtonWrapper {
    flex: 0 1 calc(calc(100% - 1rem) / 2);
}

.DashboardButton {
    width: 100%;
    font-size: 1.2rem;
    font-weight: 900;

    @media screen and (min-height: 768px) {
        font-size: 2rem;
    }
}
</style>

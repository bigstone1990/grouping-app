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

        <div class="PageContainer">
            <div class="PageWrapper">
                <div class="Page">
                    <div class="PageContent">
                        <ul class="flex gap-4 flex-wrap">
                            <li class="DashboardButtonWrapper">
                                <Link as="button" :href="route('groupings.index')" class="DashboardButton">グループ分け</Link>
                            </li>
                            <li v-if="$page.props.auth.permissions.admin" class="DashboardButtonWrapper">
                                <Link as="button" :href="route('users.index')" class="DashboardButton">ユーザー管理</Link>
                            </li>
                            <li class="DashboardButtonWrapper">
                                <Link as="button" :href="route('groups.index')" class="DashboardButton">グループ管理</Link>
                            </li>
                            <li class="DashboardButtonWrapper">
                                <Link as="button" :href="route('members.index')" class="DashboardButton">メンバー管理</Link>
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

    .DashboardButton {
        width: 100%;
        font-size: 1.2rem;
        font-weight: 900;
        color: #ffffff;
        background-color: #6366f1;
        border-width: 0px;
        padding-top: 1rem;
        padding-bottom: 1rem;
        padding-left: 2rem;
        padding-right: 2rem;
        border-radius: 0.5rem;
    
        @media screen and (min-width: map.get($breakpoint-data, tablet-base)) {
            font-size: 2rem;
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
    
        &:hover {
            background-color: #4f46e5;
        }
    }
}
</style>

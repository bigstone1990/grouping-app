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
                                <Link as="button" :href="route('grouping.index')" class="DashboardButton">グループ分け</Link>
                            </li>
                            <li class="DashboardButtonWrapper">
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
@use 'sass:map';
@use '../../sass/variables.scss' as *;

.PageContainer {
    padding-top: 1rem;
    padding-bottom: 1rem;
}

.PageWrapper {
    margin-left: auto;
    margin-right: auto;
    max-width: 80rem; /* 1280px */

    @media screen and (min-width: map.get($breakpoint-data, smartphone-wide)) {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }

    @media screen and (min-width: map.get($breakpoint-data, tablet-wide)) {
        padding-left: 2rem;
        padding-right: 2rem;
    }
}

.Page {
    overflow: hidden;
    background-color: #ffffff;
    box-shadow: 0 0 #0000, 0 0 #0000, 0 1px 2px 0 rgb(0 0 0 / 0.05);

    @media screen and (min-width: map.get($breakpoint-data, smartphone-wide)) {
        border-radius: 0.5rem;
    }
}

.PageContent {
    padding: 1rem;
    color: #111827;
}

.DashboardButtonWrapper {
    flex: 0 1 calc(calc(100% - 1rem) / 2);
}

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
    border-radius: 0.25rem;

    @media screen and (min-width: map.get($breakpoint-data, tablet-base)) {
        font-size: 2rem;
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    &:hover {
        background-color: #4f46e5;
    }
}
</style>

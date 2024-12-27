<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
  <Head title="グループ分け" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="text-xl font-semibold leading-tight text-gray-800"
      >
        グループ分け
      </h2>
    </template>

    <div class="PageContainer">
      <div class="PageWrapper">
        <div class="Page">
          <div class="PageContent">
            <section class="text-gray-600">
              <div class="container mx-auto">
                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                  <div class="flex gap-4 justify-end mb-4 w-full">
                    <Link as="button" :href="route('groups.create')" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">新規作成</Link>
                    <Link as="button" :href="route('groups.ordering.edit')" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">グループ順編集</Link>
                  </div>

                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style lang="scss">
@use 'sass:map';
@use '../../../sass/variables.scss' as *;

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

</style>
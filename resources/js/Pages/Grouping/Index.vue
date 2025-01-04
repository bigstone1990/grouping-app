<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GroupList from '@/Components/GroupListFixed.vue';
import { Head, Link } from '@inertiajs/vue3';


const props = defineProps({
  'groupings': Object,
});
</script>

<template>
  <Head title="本日のグループ分け" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="text-xl font-semibold leading-tight text-gray-800"
      >
        本日のグループ分け
      </h2>
    </template>

    <div class="PageContainer">
      <div class="PageWrapper">
        <div class="Page">
          <div class="PageContent">
            <div class="flex gap-4 justify-end mb-4 w-full">
              <Link v-if="props.groupings.length === 0" as="button" :href="route('groupings.create')" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">作成</Link>
              <Link v-else as="button" :href="route('groupings.edit', {user_id: 1, date: '2024-12-28'})" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">編集</Link>
              <Link as="button" :href="route('groupings.past')" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">履歴</Link>
            </div>
            <div class="GroupingIndexPageContentLayout">
              <section id="GroupContainer" class="GroupContainer">
                <GroupList :groups="props.groupings" :options="{index: 1}" />
              </section>
            </div>
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

.GroupingIndexPageContentLayout {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  color: #ffffff;

  @media screen and (min-width: map.get($breakpoint-data, tablet-wide)) {
    flex-direction: row;
  }

  .GroupContainer {
    overflow: hidden;
    background-color: #ffffff;
    box-shadow: 0 0 #0000, 0 0 #0000, 0 1px 2px 0 rgb(0 0 0 / 0.1);
    border-radius: 0.5rem;
    
    @media screen and (min-width: map.get($breakpoint-data, tablet-wide)) {
      flex: 1 1 100%;
    }
  }
}
</style>
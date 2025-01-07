<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GroupList from '@/Components/GroupList.vue';
import { Head, Link } from '@inertiajs/vue3';

</script>

<template>
  <Head title="過去のグループ分け" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="text-xl font-semibold leading-tight text-gray-800"
      >
        過去のグループ分け
      </h2>
    </template>

    <div class="PageContainer">
      <div class="PageWrapper">
        <div class="Page">
          <div class="PageContent">
            <div class="flex gap-4 justify-between mb-4 w-full">
              <div class="flex flex-col">
                <div class="flex gap-2 items-center">
                  <button type="button" class="MoveDateButton">&lt;前日</button>
                  <div>日付</div>
                  <button type="button" class="MoveDateButton">翌日&gt;</button>
                </div>
                <p class="text-sm">※過去7日間まで閲覧できます</p>
              </div>
              <Link as="button" :href="route('groupings.index')" class="h-full text-white bg-gray-500 border-0 py-2 px-8 hover:bg-gray-600 rounded">戻る</Link>
            </div>
            <div class="GroupingIndexPageContentLayout">
              <section id="GroupContainer" class="GroupContainer">
                <!-- <GroupList :groups="props.groupings" :options="{index: 1}" :isDraggablePage="false" /> -->
              </section>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style lang="scss">
@use '../../../sass/grouping.scss';

.MoveDateButton {
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  border: 1px solid #d1d5db;
  box-shadow: 0 0 #0000, 0 0 #0000, 0 1px 2px 0 rgb(0 0 0 / 0.05);
  background-color: #ffffff;

  &:hover,
  &:focus {
    background-color: #f3f4f6;
  }

  &.IsDisabled {
    background-color: #d1d5db;
  }
}
</style>

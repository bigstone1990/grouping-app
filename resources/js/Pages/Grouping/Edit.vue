<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import MemberList from '@/Components/MemberList.vue';
import GroupList from '@/Components/GroupList.vue';
import { Head, Link } from '@inertiajs/vue3';


const props = defineProps({
  'groupings': Object,
});

const updateGrouping = () => {
  // form.put(route('groups.update', {group: id}));
};
</script>

<template>
  <Head title="本日のグループ分け 編集" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="text-xl font-semibold leading-tight text-gray-800"
      >
        本日のグループ分け 編集
      </h2>
    </template>

    <div class="PageContainer">
      <div class="PageWrapper">
        <div class="Page">
          <div class="PageContent">
            <div class="flex gap-4 justify-end mb-4 w-full">
              <Link as="button" :href="route('groupings.index')" class="text-white bg-gray-500 border-0 py-2 px-8 hover:bg-gray-600 rounded">戻る</Link>
              <button type="button" v-on:click="updateGrouping()" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">更新</button>
            </div>
            <div class="GroupingEditPageContentLayout">
              <section id="MemberContainer" class="MemberContainer">
                <MemberList :options="{index: 1}" />
              </section>
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

.GroupingEditPageContentLayout {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  color: #ffffff;

  @media screen and (min-width: map.get($breakpoint-data, tablet-wide)) {
    flex-direction: row;
  }

  .MemberContainer,
  .GroupContainer {
    overflow: hidden;
    background-color: #ffffff;
    box-shadow: 0 0 #0000, 0 0 #0000, 0 1px 2px 0 rgb(0 0 0 / 0.1);
    border-radius: 0.5rem;
  }

  .MemberContainer {
    @media screen and (min-width: map.get($breakpoint-data, tablet-wide)) {
      flex: 1 1 25%;
    }
  }

  .GroupContainer {
    @media screen and (min-width: map.get($breakpoint-data, tablet-wide)) {
      flex: 1 1 calc(100% - 25% - 1rem);
    }
  }
}
</style>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GroupListForShow from '@/Components/GroupListForShow.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { countMembers } from '@/grouping'
import FlashMessage from '@/Components/FlashMessage.vue';

const props = defineProps({
  'groupings': Object,
});

const user = usePage().props.auth.user;

const membersNumber = ref(countMembers(props.groupings));

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

    <FlashMessage />
    <div class="PageContainer">
      <div class="PageWrapper">
        <div class="Page">
          <div class="PageContent">
            <div class="flex gap-4 justify-end mb-4 w-full">
              <Link v-if="props.groupings.length === 0" as="button" :href="route('groupings.create')" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">作成</Link>
              <Link v-else as="button" :href="route('groupings.edit', {user_id: user.id, date: 'today'})" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">編集</Link>
              <Link as="button" :href="route('groupings.past')" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">履歴</Link>
            </div>
            <div class="flex gap-4 justify-start mb-4 w-full">
              <div class="bg-white border py-2 px-2 rounded">メンバー数: {{ membersNumber }}</div>
            </div>
            <div class="GroupingIndexPageContentLayout">
              <section id="GroupContainer" class="GroupContainer">
                <GroupListForShow :groups="props.groupings" />
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
</style>

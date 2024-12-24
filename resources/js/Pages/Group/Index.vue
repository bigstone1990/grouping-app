<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';

const props = defineProps({
  groups: Object,
});
</script>

<template>
  <Head title="グループ一覧" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="text-xl font-semibold leading-tight text-gray-800"
      >
        グループ一覧
      </h2>
    </template>
    
    <FlashMessage />
    <div class="py-4">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div
          class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
        >
          <div class="p-4 text-gray-900">
            <section class="text-gray-600">
              <div class="container mx-auto">
                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                  <div class="flex gap-4 justify-end mb-4 w-full">
                    <Link as="button" :href="route('groups.create')" class="text-white bg-indigo-500 border-0 py-2 px-4 focus:outline-none hover:bg-indigo-600 rounded">新規作成</Link>
                    <Link as="button" :href="route('groups.ordering.edit')" class="text-white bg-indigo-500 border-0 py-2 px-4 focus:outline-none hover:bg-indigo-600 rounded">グループ順編集</Link>
                  </div>
                  <table class="table-auto w-full text-left whitespace-no-wrap">
                    <thead>
                      <tr>
                        <th class="w-16 px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900 rounded-tl rounded-bl">順番</th>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900">グループ名</th>
                        <th class="w-24 px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900 rounded-tr rounded-br">操作</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-if="props.groups.length !== 0" v-for="group in props.groups" :key="group.id">
                        <td class="border-b-2 px-4 py-3">{{ group.order }}</td>
                        <td class="border-b-2 px-4 py-3">{{ group.name }}</td>
                        <td class="border-b-2 px-4 py-3">
                          <Link as="button" :href="route('groups.edit', {group: group.id})" class="w-full text-white bg-green-500 border-0 py-2 px-4 focus:outline-none hover:bg-green-600 rounded">編集</Link>
                        </td>
                      </tr>
                      <tr v-else>
                        <td class="border-b-2 px-4 py-3"></td>
                        <td class="border-b-2 px-4 py-3">グループがありません</td>
                        <td class="border-b-2 px-4 py-3"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

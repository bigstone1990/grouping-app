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
    <div class="PageContainer">
      <div class="PageWrapper">
        <div class="Page">
          <div class="PageContent">
            <section class="text-gray-600">
              <div class="container mx-auto">
                <div class="w-full mx-auto overflow-auto">
                  <div class="flex gap-4 justify-end mb-4 w-full">
                    <Link as="button" :href="route('groups.create')" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">新規作成</Link>
                    <Link as="button" :href="route('groups.ordering.edit')" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">グループ順編集</Link>
                  </div>
                  <div class="GroupTableContainer">
                    <table class="table-fixed w-full text-left whitespace-normal">
                      <thead>
                        <tr>
                          <th class="w-16 px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900 rounded-tl rounded-bl">順番</th>
                          <th class="w-44 px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900">グループ名</th>
                          <th class="w-24 px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900 rounded-tr rounded-br">操作</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-if="props.groups.length !== 0" v-for="group in props.groups" :key="group.id">
                          <td class="border-b-2 px-4 py-3 bg-white">{{ group.order }}</td>
                          <td class="border-b-2 px-4 py-3 bg-white">{{ group.name }}</td>
                          <td class="border-b-2 px-4 py-3 bg-white">
                            <Link as="button" :href="route('groups.edit', {group: group.id})" class="w-full text-white bg-green-500 border-0 py-2 px-4 hover:bg-green-600 rounded">編集</Link>
                          </td>
                        </tr>
                        <tr v-else>
                          <td class="border-b-2 px-4 py-3 bg-white"></td>
                          <td class="border-b-2 px-4 py-3 bg-white">グループがありません</td>
                          <td class="border-b-2 px-4 py-3 bg-white"></td>
                        </tr>
                      </tbody>
                    </table>
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

.GroupTableContainer {
  min-width: 343px;
  max-width: calc(4rem + 11rem + 6rem);
  max-height: 410px;
  overflow-x: auto;
  overflow-y: auto;
  margin-left: auto;
  margin-right: auto;

  @media screen and (min-height: map.get($breakpoint-data, tablet-base)) {
    max-height: 510px;
  }

  @media screen and (min-height: map.get($breakpoint-data, tablet-wide)) {
    max-height: 766px;
  }

  @media screen and (min-height: map.get($breakpoint-data, fhd-base)) {
    max-height: 822px;
  }
  
  table {
    border-collapse: separate;
    border-spacing: 0;
    thead {
      tr {
        th {
          overflow-wrap: break-word;
        }

        &:first-of-type {
          th {
            position: sticky;
            top: 0;

            &::before {
              content: "";
              position: absolute;
              top: 0;
              left: 0px;
              width: 100%;
              height: 100%;
              border-right: 1px solid white;
              z-index: -1;
            }
          }
        }
      }
    }

    tbody {
      tr {
        td {
          overflow-wrap: break-word;
        }
      }
    }
  }  
}
</style>
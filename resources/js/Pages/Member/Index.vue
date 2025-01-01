<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import FlashMessage from '@/Components/FlashMessage.vue';

const props = defineProps({
  members: Object,
});

const groupColumns = ref(0);

if (props.members.length !== 0) {
  groupColumns.value = props.members[0].groups_data.length;
}
</script>

<template>
  <Head title="メンバー一覧" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="text-xl font-semibold leading-tight text-gray-800"
      >
        メンバー一覧
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
                    <Link as="button" :href="route('members.create')" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">新規作成</Link>
                  </div>
                  <div class="TableContainer">
                    <table class="table-auto w-full text-left whitespace-no-wrap">
                      <thead>
                        <tr>
                          <th class="w-24 px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900 rounded-tl rounded-bl">操作</th>
                          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900">メンバー名</th>
                          <th v-if="groupColumns !== 0" v-for="group_data in props.members[0].groups_data" :key="group_data.group_id" class="w-16 px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900" :class="{ 'rounded-tr rounded-br': group_data.group_order === groupColumns }">{{ group_data.group_name }}</th>
                          <th v-else class="px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900 rounded-tr rounded-br">グループ名</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-if="props.members.length !== 0" v-for="member in props.members" :key="member.id">
                          <td class="border-b-2 px-4 py-3 bg-white">
                            <Link as="button" :href="route('members.edit', {member: member.member_id})" class="w-full text-white bg-green-500 border-0 py-2 px-4 hover:bg-green-600 rounded">編集</Link>
                          </td>
                          <td class="border-b-2 px-4 py-3 bg-white">{{ member.member_name }}</td>
                          <td v-if="groupColumns !== 0" v-for="group_data in member.groups_data" :key="group_data.group_id" class="border-b-2 px-4 py-3 bg-white">
                            <p v-if="group_data.allocatable">○</p>
                            <p v-else>-</p>
                          </td>
                          <td v-else class="border-b-2 px-4 py-3 bg-white">グループがありません</td>
                        </tr>
                        <tr v-else>
                          <td class="border-b-2 px-4 py-3 bg-white"></td>
                          <td class="border-b-2 px-4 py-3 bg-white">メンバーがいません</td>
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

.TableContainer {
  min-width: 343px;
  max-height: 410px;
  overflow-x: auto;
  overflow-y: auto;

  @media screen and (min-height: map.get($breakpoint-data, tablet-base)) {
    max-height: 510px;
  }

  @media screen and (min-height: map.get($breakpoint-data, tablet-wide)) {
    max-height: 766px;
  }
  
  table {
    border-collapse: separate;
    border-spacing: 0;
    thead {
      tr {
        th {
          white-space: nowrap;
        }

        &:first-of-type {
          th {
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

            &:first-of-type {
              position: sticky;
              top: 0;
              left: 0;
              z-index: 1;
            }

            &:nth-of-type(2) {
              position: sticky;
              top: 0;
              left: calc(6rem);
              z-index: 1;
            }

            &:not(:first-of-type, :nth-of-type(2)) {
              position: sticky;
              top: 0;
            }
          }
        }
      }
    }

    tbody {
      tr {
        td {
          white-space: nowrap;

          &:first-of-type {
            position: sticky;
            left: 0;
          }
          
          &:nth-of-type(2) {
            position: sticky;
            left: 6rem;
          }
        }
      }
    }
  }  
}  
</style>

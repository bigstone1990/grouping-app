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
                    <Link as="button" :href="route('members.calcgroupings')" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">実績</Link>
                  </div>
                  <div class="MemberTableContainer">
                    <table class="table-fixed w-full text-left whitespace-normal">
                      <thead>
                        <tr>
                          <th class="w-24 px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900 rounded-tl rounded-bl">操作</th>
                          <th class="w-40 px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900">メンバー名</th>
                          <th v-if="groupColumns !== 0" v-for="group_data in props.members[0].groups_data" :key="group_data.group_id" class="w-44 px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900" :class="{ 'rounded-tr rounded-br': group_data.group_order === groupColumns }">{{ group_data.group_name }}</th>
                          <th v-else class="w-44 px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900 rounded-tr rounded-br">グループ名</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-if="props.members.length !== 0" v-for="member in props.members" :key="member.id">
                          <td class="border-b-2 px-4 py-3 bg-white">
                            <Link as="button" :href="route('members.edit', {member: member.member_id})" class="w-full text-white bg-green-500 border-0 py-2 px-4 hover:bg-green-600 rounded">編集</Link>
                          </td>
                          <td class="border-b-2 px-4 py-3 bg-white">{{ member.member_name }}</td>
                          <td v-if="groupColumns !== 0" v-for="group_data in member.groups_data" :key="group_data.group_id" class="border-b-2 px-4 py-3 bg-white">
                            <template v-if="group_data.allocatable">○</template>
                            <template v-else>-</template>
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
.MemberTableContainer {
  min-width: 343px;
  max-height: 410px;
  overflow-x: auto;
  overflow-y: auto;

  @media screen and (min-height: map.get($breakpoint-data, tablet-base)) {
    max-height: calc(100vh - 258px);
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
              z-index: 2;
            }

            &:nth-of-type(2) {
              position: sticky;
              top: 0;
              left: calc(6rem);
              z-index: 2;
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
          overflow-wrap: break-word;

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

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
  <Head title="メンバー実績" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="text-xl font-semibold leading-tight text-gray-800"
      >
        メンバー実績
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
                    <Link as="button" :href="route('members.index')" class="ml-auto sm:ml-0 h-full text-white bg-gray-500 border-0 py-2 px-8 hover:bg-gray-600 rounded">戻る</Link>
                  </div>
                  <div class="mb-4">
                    <p class="text-sm">※現在のメンバーについて現在のグループ設定に対する過去30日間の実績です</p>
                  </div>
                  <div class="MemberAchievementTableContainer">
                    <table class="table-fixed w-full text-left whitespace-normal">
                      <thead>
                        <tr>
                          <th class="w-40 px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900 rounded-tl rounded-bl">メンバー名</th>
                          <th v-if="groupColumns !== 0" v-for="group_data in props.members[0].groups_data" :key="group_data.group_id" class="w-44 px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900" :class="{ 'rounded-tr rounded-br': group_data.group_order === groupColumns }">{{ group_data.group_name }}</th>
                          <th v-else class="w-44 px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900 rounded-tr rounded-br">グループ名</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-if="props.members.length !== 0" v-for="member in props.members" :key="member.member_id">
                          <td class="border-b-2 px-4 py-3 bg-white">{{ member.member_name }}</td>
                          <td v-if="groupColumns !== 0" v-for="group_data in member.groups_data" :key="group_data.group_id" class="border-b-2 px-4 py-3 bg-white">{{ group_data.group_calc }} %</td>
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
.MemberAchievementTableContainer {
  min-width: 343px;
  max-height: calc(410px - 56px);
  overflow-x: auto;
  overflow-y: auto;

  @media screen and (min-height: map.get($breakpoint-data, smartphone-wide)) {
    max-height: calc(100vh - 258px - 36px);
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

            &:not(:first-of-type) {
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
        }
      }
    }
  }  
}  
</style>

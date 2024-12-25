<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import FlashMessage from '@/Components/FlashMessage.vue';

const props = defineProps({
  users: Object,
});
</script>

<template>
  <Head title="ユーザー一覧" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="text-xl font-semibold leading-tight text-gray-800"
      >
        ユーザー一覧
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
                <div class="w-full mx-auto overflow-auto">
                  <div class="flex gap-4 justify-end mb-4 w-full">
                    <Link as="button" :href="route('users.create')" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">新規作成</Link>
                  </div>
                  <div class="TableContainer">
                    <table class="table-auto w-full text-left whitespace-no-wrap">
                      <thead>
                        <tr>
                          <th class="w-24 px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900 rounded-tl rounded-bl">操作</th>
                          <th class="w-24 sm:w-48 px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900">ユーザー名</th>
                          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900">メールアドレス</th>
                          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-100 text-sm bg-gray-900 rounded-tr rounded-br">権限</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-if="props.users.length !== 0" v-for="user in props.users" :key="user.id">
                          <td class="border-b-2 px-4 py-3 bg-white">
                            <Link as="button" :href="route('users.edit', {user: user.id})" class="w-full text-white bg-green-500 border-0 py-2 px-4 hover:bg-green-600 rounded">編集</Link>
                          </td>
                          <td class="border-b-2 px-4 py-3 bg-white">{{ user.name }}</td>
                          <td class="border-b-2 px-4 py-3 bg-white">{{ user.email }}</td>
                          <td class="border-b-2 px-4 py-3 bg-white">
                            <template v-if="user.role === 1">
                              管理者
                            </template>
                            <template v-else-if="user.role === 5">
                              スタッフ
                            </template>
                            <template v-else>
                              利用者
                            </template>
                          </td>
                        </tr>
                        <tr v-else>
                          <td class="border-b-2 px-4 py-3"></td>
                          <td class="border-b-2 px-4 py-3">メンバーがいません</td>
                          <td class="border-b-2 px-4 py-3"></td>
                          <td class="border-b-2 px-4 py-3"></td>
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
.TableContainer {
  min-width: 343px;
  max-height: 410px;
  overflow-x: auto;
  overflow-y: auto;

  @media screen and (min-height: 768px) {
    max-height: 510px;
  }

  @media screen and (min-height: 1024px) {
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

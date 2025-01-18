<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
  userName: '',
  email: '',
  role: '9',
});

const createUser = () => {
    form.post(route('users.store'));
};
</script>

<template>
  <Head title="ユーザー新規作成" />

  <AuthenticatedLayout>
    <template #header>
      <h2
          class="text-xl font-semibold leading-tight text-gray-800"
      >
        ユーザー新規作成
      </h2>
    </template>

    <div class="PageContainer">
      <div class="PageWrapper">
        <div class="Page">
          <div class="PageContent">
            <section class="text-gray-600 body-font relative">
              <div class="container mx-auto">
                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                  <div class="flex flex-col">
                    <form @submit.prevent="createUser">
                      <div class="p-2 w-full">
                        <div class="relative">
                          <InputLabel for="name" value="ユーザー名" class="leading-7 text-sm text-gray-600" />
                          <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            v-model="form.userName"
                            required
                            autofocus
                          />
                          <InputError class="mt-2" :message="form.errors.userName" />
                        </div>
                      </div>
                      <div class="p-2 w-full">
                        <div class="relative">
                          <InputLabel for="email" value="メールアドレス" class="leading-7 text-sm text-gray-600" />
                          <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            v-model="form.email"
                            required
                          />
                          <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                      </div>
                      <div class="p-2 w-full">
                        <div class="relative">
                          <InputLabel for="role" value="権限" class="leading-7 text-sm text-gray-600" />
                          <div class="flex gap-4">
                            <div class="UserRoleContainer" :class="{ 'IsChecked': form.role === '1' }">
                              <div class="flex items-center">
                                <input type="radio" id="roleAdmin" v-model="form.role" value="1">
                                <InputLabel for="roleAdmin" value="管理者" class="flex-auto pl-2 py-4 leading-7 text-sm text-gray-600" :class="{ 'text-white': form.role === '1' }"/>
                              </div>
                            </div>
                            <div class="UserRoleContainer" :class="{ 'IsChecked': form.role === '9' }">
                              <div class="flex items-center">
                                <input type="radio" id="roleUser" v-model="form.role" value="9">
                                <InputLabel for="roleUser" value="一般" class="flex-auto pl-2 py-4 leading-7 text-sm text-gray-600" :class="{ 'text-white': form.role === '9' }" />
                              </div>
                            </div>
                          </div>
                          <InputError class="mt-2" :message="form.errors.role" />
                        </div>
                      </div>
                      <div class="p-2 w-full flex gap-4 justify-center">
                        <Link as="button" :href="route('users.index')" class="text-white bg-gray-500 border-0 py-2 px-8 hover:bg-gray-600 rounded">戻る</Link>
                        <button class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">作成</button>
                      </div>
                    </form>
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
.UserRoleContainer {
  flex: 0 1 calc(calc(100% - 1rem) / 2);
  padding-left: 0.5rem;
  border-radius: 0.5rem;
  border: 1px solid #d1d5db;
  box-shadow: 0 0 #0000, 0 0 #0000, 0 1px 2px 0 rgb(0 0 0 / 0.05);
  background-color: #f3f4f6;

  &.IsChecked {
    background-color: #5cb85c;
    border-color: #5cb85c;
  }
}
</style>

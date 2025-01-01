<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
  user: Object,
  modifiable: Boolean,
  deletable: Boolean,
});

const form = useForm({
  role: String(props.user.role),
});

const updateUser = (id) => {
    form.put(route('users.update', {user: id}));
};

const deleteUser = (id) => {
  if (confirm('本当に削除しますか？')) {
    form.delete(route('users.destroy', {user: id}));
  }
};
</script>

<template>
  <Head title="ユーザー編集" />

  <AuthenticatedLayout>
    <template #header>
      <h2
          class="text-xl font-semibold leading-tight text-gray-800"
      >
        ユーザー編集
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
                    <form @submit.prevent="updateUser(props.user.id)">
                      <div class="p-2 w-full">
                        <div class="relative">
                          <InputLabel for="name" value="ユーザー名" class="leading-7 text-sm text-gray-600" />
                          <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            v-model="props.user.name"
                            required
                            readonly
                          />
                        </div>
                      </div>
                      <div class="p-2 w-full">
                        <div class="relative">
                          <InputLabel for="email" value="メールアドレス" class="leading-7 text-sm text-gray-600" />
                          <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            v-model="props.user.email"
                            required
                            readonly
                          />
                        </div>
                      </div>
                      <div class="p-2 w-full">
                        <div class="relative">
                          <InputLabel for="role" value="権限" class="leading-7 text-sm text-gray-600" />
                          <template v-if="props.modifiable">
                            <div class="flex gap-4">
                              <div class="RoleContainer" :class="{ 'IsChecked': form.role === '1' }">
                                <div class="flex items-center">
                                  <input type="radio" id="roleAdmin" v-model="form.role" value="1">
                                  <InputLabel for="roleAdmin" value="管理者" class="flex-auto pl-2 py-2 leading-7 text-sm text-gray-600" :class="{ 'text-white': form.role === '1' }"/>
                                </div>
                              </div>
                              <div class="RoleContainer" :class="{ 'IsChecked': form.role === '5' }">
                                <div class="flex items-center">
                                  <input type="radio" id="roleStaff" v-model="form.role" value="5">
                                  <InputLabel for="roleStaff" value="スタッフ" class="flex-auto pl-2 py-2 leading-7 text-sm text-gray-600" :class="{ 'text-white': form.role === '5' }" />
                                </div>
                              </div>
                              <div class="RoleContainer" :class="{ 'IsChecked': form.role === '9' }">
                                <div class="flex items-center">
                                  <input type="radio" id="roleUser" v-model="form.role" value="9">
                                  <InputLabel for="roleUser" value="利用者" class="flex-auto pl-2 py-2 leading-7 text-sm text-gray-600" :class="{ 'text-white': form.role === '9' }" />
                                </div>
                              </div>
                            </div>
                            <InputError class="mt-2" :message="form.errors.role" />
                          </template>
                          <template v-else>
                            <div v-if="props.user.role === 1" class="text-sm">管理者</div>
                            <div v-else-if="props.user.role === 5" class="text-sm">スタッフ</div>
                            <div v-else-if="props.user.role === 9" class="text-sm">利用者</div>
                          </template>
                        </div>
                      </div>
                      <div class="p-2 w-full flex gap-4 justify-center">
                        <Link as="button" :href="route('users.index')" class="text-white bg-gray-500 border-0 py-2 px-8 hover:bg-gray-600 rounded">戻る</Link>
                        <button v-if="props.modifiable" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">更新</button>
                        <button v-if="props.deletable" type="button" v-on:click="deleteUser(props.user.id)" class="text-white bg-red-500 border-0 py-2 px-8 hover:bg-red-600 rounded">削除</button>
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

.RoleContainer {
  flex: 0 1 calc(calc(100% - 2rem) / 3);
  padding-left: 0.5rem;
  border-radius: 0.5rem;
  border: 1px solid black;

  &.IsChecked {
    background-color: #5cb85c;
    border-color: #5cb85c;
  }
}
</style>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
  group: Object,
});

const form = useForm({
  groupName: props.group.name,
});

const updateGroup = (id) => {
    form.put(route('groups.update', {group: id}));
};

const deleteGroup = (id) => {
  if (confirm('本当に削除しますか？')) {
    form.delete(route('groups.destroy', {group: id}));
  }
};
</script>

<template>
  <Head title="グループ編集" />

  <AuthenticatedLayout>
    <template #header>
      <h2
          class="text-xl font-semibold leading-tight text-gray-800"
      >
        グループ編集
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
                    <form @submit.prevent="updateGroup(props.group.id)">
                      <div class="p-2 w-full">
                        <div class="relative">
                          <InputLabel for="groupName" value="グループ名" class="leading-7 text-sm text-gray-600" />
                          <TextInput
                            id="groupName"
                            type="text"
                            class="mt-1 block w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            v-model="form.groupName"
                            required
                            autofocus
                          />
                          <InputError class="mt-2" :message="form.errors.groupName" />
                        </div>
                      </div>
                      <div class="p-2 w-full flex gap-4 justify-center">
                        <Link as="button" :href="route('groups.index')" class="text-white bg-gray-500 border-0 py-2 px-8 hover:bg-gray-600 rounded">戻る</Link>
                        <button class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">更新</button>
                        <button type="button" v-on:click="deleteGroup(props.group.id)" class="text-white bg-red-500 border-0 py-2 px-8 hover:bg-red-600 rounded">削除</button>
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
</style>

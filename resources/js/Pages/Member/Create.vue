<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { reactive } from 'vue';

const props = defineProps({
  'groups': Object,
});

const form = useForm({
  memberName: '',
  groupAllocatable: reactive(
    props.groups.map((group) => ({
      group_id: group.id,
      group_name: group.name,
      group_allocatable: true,
    }))
  ),
});

const createMember = () => {
    form.post(route('members.store'));
};
</script>

<template>
  <Head title="メンバー新規作成" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="text-xl font-semibold leading-tight text-gray-800"
      >
        メンバー新規作成
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
                    <form @submit.prevent="createMember">
                      <div class="p-2 w-full">
                        <div class="relative">
                          <InputLabel for="memberName" value="メンバー名" class="leading-7 text-sm text-gray-600" />
                          <TextInput
                            id="memberName"
                            type="text"
                            class="mt-1 block w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            v-model="form.memberName"
                            required
                            autofocus
                          />
                          <InputError class="mt-2" :message="form.errors.memberName" />
                        </div>
                      </div>
                      <div class="p-2 w-full">
                        <div class="relative">
                          <InputLabel for="groupAllocatable" value="グループ設定" class="leading-7 text-sm text-gray-600" />
                          <div v-if="props.groups.length !== 0" class="flex gap-4 flex-wrap">
                            <div v-for="group in form.groupAllocatable" :key="group.group_id" class="GroupContainer" :class="{ 'IsChecked': group.group_allocatable }">
                              <div class="flex items-center">
                                <Checkbox :id="group.group_id" v-model:checked="group.group_allocatable" />
                                <InputLabel :for="group.group_id" :value="group.group_name" class="flex-auto pl-2 py-4 leading-7 text-sm text-gray-600" :class="{ 'text-white': group.group_allocatable }" />
                              </div>
                            </div>
                          </div>
                          <div v-else class="text-sm">グループがありません</div>
                        </div>
                      </div>
                      <div class="p-2 w-full flex gap-4 justify-center">
                        <Link as="button" :href="route('members.index')" class="text-white bg-gray-500 border-0 py-2 px-8 hover:bg-gray-600 rounded">戻る</Link>
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

.GroupContainer {
  flex: 0 1 calc(calc(100% - 1rem) / 2);
  padding-left: 1rem;
  border-radius: 0.5rem;
  border: 1px solid black;

  &.IsChecked {
    background-color: #5cb85c;
    border-color: #5cb85c;
  }
}


</style>

<script setup>
import GroupListItemForRead from './GroupListItemForRead.vue';
import { customDateStringToJP } from '@/common';

const props = defineProps({
  groups: Object,
  date: String,
});
</script>

<template>
  <article class="GroupListWrapper">
    <header class="GroupListHeader">
      <h3 v-if="props.date" v-html="customDateStringToJP(props.date) + ' のグループ分け'" class="GroupListHeading"></h3>
      <h3 v-else class="GroupListHeading">本日のグループ分け</h3>
    </header>
    <div class="GroupListContainer">
      <div class="GroupList">
        <GroupListItemForRead v-if="props.groups.length !== 0" v-for="group in props.groups" :key="group.group_id" :group="group" />
        <div v-else class="flex justify-center px-4">
          <p class="text-gray-600">グループ分けが未作成です</p>
        </div>
      </div>
    </div>
  </article>
</template>

<style lang="scss">
</style>

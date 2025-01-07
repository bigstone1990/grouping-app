<script setup>
import GroupListItem from './GroupListItem.vue';
import { customDateStringToJP } from '@/common';

const props = defineProps({
  groups: Object,
  options: Object,
  isDraggablePage: Boolean,
});
</script>

<template>
  <article :id="'GroupListWrapper' + props.options.index" class="GroupListWrapper">
    <header class="GroupListHeader">
      <h3 v-if="props.options.date" v-html="customDateStringToJP(props.options.date) + ' のグループ分け'" class="GroupListHeading"></h3>
      <h3 v-else class="GroupListHeading">本日のグループ分け</h3>
    </header>
    <div class="GroupListContainer">
      <ul class="GroupList">
        <GroupListItem v-if="props.groups.length !== 0" v-for="group in props.groups" :key="group.group_id" :group="group" :options="{index: group.group_id}" :isDraggablePage="props.isDraggablePage" />
        <div v-else class="flex justify-center px-4">
          <p class="text-gray-600">グループ分けが未作成です</p>
        </div>
      </ul>
    </div>
  </article>
</template>

<style lang="scss">
</style>

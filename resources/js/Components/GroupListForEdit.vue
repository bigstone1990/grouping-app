<script setup>
import GroupListItemForEdit from './GroupListItemForEdit.vue';
import { customDateStringToJP } from '@/common';

const props = defineProps({
  groups: Object,
});

const sortable = defineModel("sortable");
const dropzones = defineModel("dropzones");
const dropzoneContainer = defineModel("dropzoneContainer");

</script>

<template>
  <article class="GroupListWrapper">
    <header class="GroupListHeader">
      <h3 class="GroupListHeading">本日のグループ分け</h3>
    </header>
    <div class="GroupListContainer">
      <div class="GroupList">
        <GroupListItemForEdit v-for="group in props.groups" :key="group.group_id" v-model:sortable="sortable" v-model:dropzones="dropzones" v-model:dropzoneContainer="dropzoneContainer" :group="group" />
      </div>
    </div>
  </article>
</template>

<style lang="scss">
</style>

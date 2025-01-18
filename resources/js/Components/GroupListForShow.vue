<script setup>
import GroupListItemForShow from './GroupListItemForShow.vue';
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
        <GroupListItemForShow v-if="props.groups.length !== 0" v-for="group in props.groups" :key="group.group_id" :group="group" />
        <p v-else class="NoGroupingData">グループ分けが未作成です</p>
      </div>
    </div>
  </article>
</template>

<style lang="scss">
.NoGroupingData {
  flex: 1 1 auto;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  color: #4b5563;
  font-size: 1.2rem;
  font-weight: 700;
}

</style>

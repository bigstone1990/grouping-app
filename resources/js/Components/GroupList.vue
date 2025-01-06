<script setup>
import GroupListItem from './GroupListItem.vue';

const props = defineProps({
  groups: Object,
  options: Object,
  isDraggablePage: Boolean,
});
</script>

<template>
  <article :id="'GroupListWrapper' + props.options.index" class="GroupListWrapper">
    <header class="GroupListHeader">
      <h3 class="GroupListHeading">本日のグループ分け</h3>
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
.GroupListWrapper {
  display: flex;
  flex-direction: column;
  height: 100%;
}

.GroupListHeader {
  flex: 0 0 2.5rem;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0.5rem;
  background-color: #111827;
}

.GroupListHeading {
  color: currentColor;
  font-size: 1rem;
  font-weight: 700;
}

.GroupListContainer {
  flex: 1 1 auto;
  overflow: hidden;
  padding-top: 1rem;
  padding-bottom: 1rem;
}

.GroupList {
  height: 100%;
  display: flex;
  flex-direction: column;
  gap: 1rem;
  padding-left: 1rem;
  padding-right: 1rem;
}
</style>

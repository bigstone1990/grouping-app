<script setup>
import GroupListItem from './GroupListItem.vue';

const props = defineProps({
  groups: Object,
  options: Object,
});
</script>

<template>
  <article :id="'GroupListWrapper' + props.options.index" class="GroupListWrapper">
    <header class="GroupListHeader">
      <h3 class="GroupListHeading">本日の掃除当番表</h3>
    </header>
    <div class="GroupListContainer">
      <ul v-if="props.groups.length !== 0" class="GroupList">
        <GroupListItem v-for="group in props.groups" :key="group.id" :heading="group.name" :options="{index: group.id, blocks: 3}" />
      </ul>
      <div v-else class="flex justify-center items-center p-4 h-full">
        <p>グループがありません</p>
      </div>
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
  flex: 0 0 4rem;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 1rem;
  background-color: #111827;
}

.GroupListHeading {
  color: currentColor;
  font-size: 1.2rem;
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
  overflow: scroll;
  display: flex;
  flex-direction: column;
  gap: 1rem;
  padding-left: 1rem;
  padding-right: 1rem;

  @media screen and (min-width: 1024px) {
    flex-direction: row;
    flex-wrap: wrap;
  }
}
</style>
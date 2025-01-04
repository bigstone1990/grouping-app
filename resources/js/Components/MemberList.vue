<script setup>
import MemberListItem from './MemberListItem.vue';
import { ref } from 'vue';

const props = defineProps({
  options: Object,
});

// const members = ref([{id: 1, name: 'テストメンバー1'}, {id: 2, name: 'テストメンバー2'}, {id: 3, name: 'テストメンバー3'}, {id: 4, name: 'テストメンバー4'}, {id: 5, name: 'テストメンバー5'}, {id: 6, name: 'テストメンバー6'}, {id: 7, name: 'テストメンバー7'}, {id: 8, name: 'テストメンバー8'}, {id: 9, name: 'テストメンバー9'}]);
const members = ref([]);

</script>

<template>
  <article :id="'MemberListWrapper' + props.options.index" class="MemberListWrapper">
    <header class="MemberListHeader">
      <h3 class="MemberListHeading">本日のメンバー</h3>
    </header>

    <div class="MemberListContainer">
      <ul v-if="members.length !== 0" class="MemberList">
        <MemberListItem v-for="member in members" :key="member.id" :heading="member.name" :options="{index: member.id}" />
      </ul>
      <div v-else class="flex justify-center items-start px-4 h-full">
        <p class="text-gray-900">メンバーがいません</p>
      </div>
    </div>
</article>
</template>

<style lang="scss">
@use 'sass:map';
@use '../../sass/variables.scss' as *;

.MemberListWrapper {
  display: flex;
  flex-direction: column;
  height: 100%;
}

.MemberListHeader {
  flex: 0 0 2.5rem;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0.5rem;
  background-color: #111827;
}

.MemberListHeading {
  color: currentColor;
  font-size: 1rem;
  font-weight: 700;
}

.MemberListContainer {
  flex: 1 1 auto;
  overflow: hidden;
  padding-top: 1rem;
  padding-bottom: 1rem;
}

.MemberList {
  height: 100%;
  max-height: 190px;
  overflow: scroll;
  display: flex;
  flex-direction: column;
  gap: 1rem;
  padding-left: 1rem;
  padding-right: 1rem;

  @media screen and (min-width: map.get($breakpoint-data, smartphone-wide)) {
    flex-direction: row;
    flex-wrap: wrap;
    max-height: 135px;
  }

  @media screen and (min-width: map.get($breakpoint-data, tablet-wide)) {
    flex-direction: column;
    flex-wrap: nowrap;
    max-height: initial;
  }
}
</style>
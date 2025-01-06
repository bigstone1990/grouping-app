<script setup>
import MemberListItem from './MemberListItem.vue';
import { ref } from 'vue';

const props = defineProps({
  options: Object,
});

const members = ref([{id: 1, name: 'テストメンバー1'}, {id: 2, name: 'テストメンバー2'}, {id: 3, name: 'テストメンバー3'}, {id: 4, name: 'テストメンバー4'}, {id: 5, name: 'テストメンバー5'}, {id: 6, name: 'テストメンバー6'}, {id: 7, name: 'テストメンバー7'}, {id: 8, name: 'テストメンバー8'}, {id: 9, name: 'テストメンバー9'}]);
// const members = ref([]);

</script>

<template>
  <article :id="'MemberListWrapper' + props.options.index" class="MemberListWrapper">
    <header class="MemberListHeader">
      <h3 class="MemberListHeading">本日のメンバー</h3>
      <svg class="h-4 w-4 text-gray-100"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
      </svg>
    </header>

    <div class="MemberListContainer">
      <ul class="MemberList">
        <MemberListItem v-if="members.length !== 0" v-for="member in members" :key="member.id" :heading="member.name" :options="{index: member.id}" />
        <p v-else class="text-gray-600">メンバーがいません</p>
      </ul>
    </div>
</article>
</template>

<style lang="scss">
</style>

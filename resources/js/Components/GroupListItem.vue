<script setup>
import GroupMemberListItem from './GroupMemberListItem.vue';

const props = defineProps({
  group: Object,
  options: Object,
  isDraggablePage: Boolean,
});
</script>

<template>
  <li class="GroupListItem">
    <div class="GroupListItemContent">
      <header class="GroupListItemHeader">
          <h4 class="GroupListItemHeading">{{ props.group.group_name }}</h4>
      </header>
      <div class="GroupMemberListContainer">
        <ul v-if="props.group.members.length > 0" class="GroupMemberList">
          <GroupMemberListItem v-for="member in props.group.members" :key="member.member_id" :member="member" :options="{index: member.member_id}" :isDraggablePage="props.isDraggablePage" />
        </ul>
        <div v-else class="flex justify-center items-center px-4 h-full">
          <p class="text-gray-900">メンバーがいません</p>
        </div>
      </div>
    </div>
  </li>
</template>

<style lang="scss">
</style>

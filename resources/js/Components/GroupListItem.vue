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
        <ul class="GroupMemberList">
          <GroupMemberListItem v-if="props.group.members.length > 0" v-for="member in props.group.members" :key="member.member_id" :member="member" :options="{index: member.member_id}" :isDraggablePage="props.isDraggablePage" />
          <p v-else class="text-gray-600 flex items-center">
            <template v-if="props.isDraggablePage">枠を追加してください</template>
            <template v-else>メンバーがいません</template>
          </p>
        </ul>
      </div>
    </div>
  </li>
</template>

<style lang="scss">
</style>

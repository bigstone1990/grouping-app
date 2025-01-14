<script setup>
import GroupMemberListItemOnlyRead from './GroupMemberListItemOnlyRead.vue';

const props = defineProps({
  group: Object,
});

</script>

<template>
  <div class="GroupListItem">
    <div class="GroupListItemContent">
      <header class="GroupListItemHeader">
          <h4 class="GroupListItemHeading">{{ props.group.group_name }}</h4>
      </header>
      <div class="GroupMemberListContainer">
        <div class="GroupMemberList">
          <GroupMemberListItemOnlyRead v-if="props.group.members.length > 0" v-for="member in props.group.members" :key="member.member_id" :member="member" />
          <p v-else class="text-gray-600 flex items-center">メンバーがいません</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
</style>

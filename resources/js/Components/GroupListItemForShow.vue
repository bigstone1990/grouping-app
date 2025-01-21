<script setup>
import GroupMemberListItemForShow from './GroupMemberListItemForShow.vue';

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
          <GroupMemberListItemForShow v-if="props.group.members.length > 0" v-for="member in props.group.members" :key="member.member_id" :member="member" />
          <p v-else class="NoMemberData">メンバーがいません</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
.NoMemberData {
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

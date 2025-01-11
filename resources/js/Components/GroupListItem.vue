<script setup>
import GroupMemberListItem from './GroupMemberListItem.vue';

const props = defineProps({
  group: Object,
  isDraggablePage: Boolean,
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
          <button v-if="props.isDraggablePage" type="button" @click="addBlock" class="BlockAddButton">枠を追加</button>
          <GroupMemberListItem v-if="props.group.members.length > 0" v-for="member in props.group.members" :key="member.member_id" :groupId="group.group_id" :member="member" :isDraggablePage="props.isDraggablePage" />
          <p v-else class="text-gray-600 flex items-center">
            <template v-if="!props.isDraggablege">メンバーがいません</template>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
</style>

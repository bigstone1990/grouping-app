<script setup>
const props = defineProps({
  member: Object,
});
</script>

<template>
  <div class="GroupMemberListItem">
    <div class="MemberListItem Member--isDraggable">
      <div class="MemberListItemContent">
        <h4 class="MemberListItemHeading">{{ props.member.member_name }}</h4>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
</style>

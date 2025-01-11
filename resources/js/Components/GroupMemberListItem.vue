<script setup>
const props = defineProps({
  groupId: Number,
  member: Object,
  isDraggablePage: Boolean,
});
</script>

<template>
  <div class="GroupMemberListItem" :data-group-id="groupId">
    <div class="MemberListItem Member--isDraggable" :data-member-id="member.member_id">
    <div class="MemberListItemContent">
      <h4 class="MemberListItemHeading">{{ props.member.member_name }}</h4>
      <div v-if="props.isDraggablePage" class="DragHandle"></div>

      <div v-if="props.isDraggablePage" class="Pattern Pattern--typeHalftone"></div>
      <div v-if="props.isDraggablePage" class="Pattern Pattern--typePlaced"></div>
    </div>
  </div>
  </div>
</template>

<style lang="scss">
</style>

<script setup>
const props = defineProps({
  member: Object,
  options: Object,
  isDraggablePage: Boolean,
});
</script>

<template>
  <li class="GroupMemberListItem" :class="{ ['GroupMemberListItem--item' + props.options.index]: props.options.index }">
    <li class="MemberListItem Member--isDraggable" :class="{ ['MemberListItem--item' + props.options.index]: props.options.index }">
    <div class="MemberListItemContent">
      <h4 class="MemberListItemHeading">{{ props.member.member_name }}</h4>
      <div v-if="props.isDraggablePage" class="DragHandle"></div>

      <div v-if="props.isDraggablePage" class="Pattern Pattern--typeHalftone"></div>
      <div v-if="props.isDraggablePage" class="Pattern Pattern--typePlaced"></div>
    </div>
  </li>
  </li>
</template>

<style lang="scss">
</style>

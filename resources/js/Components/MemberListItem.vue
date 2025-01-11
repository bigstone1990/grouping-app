<script setup>
const props = defineProps({
  heading: String,
  memberId: Number,
});
</script>

<template>
  <div class="MemberListItem Member--isDraggable" :data-member-id="props.memberId">
    <div class="MemberListItemContent">
      <h4 class="MemberListItemHeading">{{ props.heading }}</h4>
      <div class="DragHandle"></div>

      <div class="Pattern Pattern--typeHalftone"></div>
      <div class="Pattern Pattern--typePlaced"></div>
    </div>
  </div>
</template>

<style lang="scss">
</style>

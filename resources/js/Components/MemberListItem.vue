<script setup>
const props = defineProps({
  heading: String,
  options: Object,
});
</script>

<template>
  <li class="MemberListItem Member--isDraggable" :class="{ ['MemberListItem--item' + props.options.index]: props.options.index }">
    <div class="MemberListItemContent">
      <h4 class="MemberListItemHeading">{{ props.heading }}</h4>
      <div class="DragHandle"></div>

      <div class="Pattern Pattern--typeHalftone"></div>
      <div class="Pattern Pattern--typePlaced"></div>
    </div>
  </li>
</template>

<style lang="scss">
</style>

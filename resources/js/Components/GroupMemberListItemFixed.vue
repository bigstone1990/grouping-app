<script setup>
const props = defineProps({
  member: Object,
  options: Object,
});
</script>

<template>
  <li class="GroupMemberListItem" :class="{ ['GroupMemberListItem--item' + props.options.index]: props.options.index }">
    <li class="MemberListItem Member--isDraggable" :class="{ ['MemberListItem--item' + props.options.index]: props.options.index }">
    <div class="MemberListItemContent">
      <h4 class="MemberListItemHeading">{{ props.member.member_name }}</h4>
    </div>
  </li>
  </li>
</template>

<style lang="scss">
@use 'sass:map';
@use '../../sass/variables.scss' as *;

.GroupMemberListItem {
  position: relative;
  width: 100%;
  height: 2.5rem;
  border-radius: 0.5rem;
  overflow: hidden;

  @media screen and (min-width: map.get($breakpoint-data, smartphone-wide)) {
    width: calc(calc(100% - 1rem) / 2);
  }

  &::before {
    opacity: 0;
    visibility: hidden;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    color: #111827;
    font-size: 1rem;
    font-weight: 700;
    content: "ドロップ可能";
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: white;
  }

  &:not(:has(> :not(.draggable--original))) {
    border: 1px solid #111827;

    &::before {
      opacity: 1;
      visibility: visible;
    }
  }

  .MemberListItem {
    width: 100%;
    height: 100%;

    .MemberListItemContent {
      position: relative;
      display: flex;
      align-items: center;
      padding: 0.5rem;
      background-color: #5cb85c;
      border-radius: 0.5rem;

      .MemberListItemHeading {
        flex: 1 1 auto;
        color: currentColor;
        font-size: 1rem;
        font-weight: 700;
        pointer-events: none;
        user-select: none;
      }
    }
  }
}
</style>
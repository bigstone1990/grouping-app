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
.MemberListItem {
  width: calc(calc(100% - 2rem) / 3);

  @media screen and (min-width: 1024px) {
    width: 100%;
  }
}

.MemberListItemContent {
  position: relative;
  display: flex;
  align-items: center;
  padding: 0.6rem;
  background-color: #5cb85c;
  border-radius: 0.5rem;
}

.MemberListItemHeading {
  flex: 1 1 auto;
  color: currentColor;
  font-size: 1.2rem;
  font-weight: 700;
  pointer-events: none;
  user-select: none;
}

.DragHandle {
  flex: 0 0 1rem;
  margin-left: 1rem;
  position: relative;
  width: 1rem;
  height: 1rem;
  background-color: currentColor;

  &::before,
  &::after {
    content: '';
    position: absolute;
    right: 0;
    left: 0;
    display: block;
    height: 0.2rem;
    background-color: #5cb85c;
  }

  &::before {
    top: 0.2rem;
  }

  &::after {
      bottom: 0.2rem;
  }
}

.Member--isDraggable {
  cursor: grab;

  &:focus {
    outline: none;
  }

  &:focus,
  &:hover {
    .MemberListItemContent {
      background-color: #0042ff;

      .DragHandle {
        &::before,
        &::after {
          background-color: #0042ff;
        }
      }
    }
  }

  &.draggable-source--is-dragging {
    .MemberListItemContent {
      background-color: #0042ff;

      .DragHandle {
        &::before,
        &::after {
          background-color: #0042ff;
        }
      }

      .Pattern--typeHalftone {
        opacity: 1;
        visibility: visible;
        animation-play-state: running;
      }
    }
  }

  &.draggable-source--placed {
    .MemberListItemContent {
      .Pattern--typePlaced {
        opacity: 1;
        visibility: visible;
        animation-play-state: running;
      }
    }
  }

  &.draggable-mirror {
    z-index: 9999;

    .MemberListItemContent {
      background-color: #0042ff;
      transform: scale(1.025);

      .DragHandle {
        &::before,
        &::after {
          background-color: #0042ff;
        }
      }
    }
  }
}
</style>
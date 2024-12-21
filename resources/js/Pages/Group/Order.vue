<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout100VH.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  groups: Object,
});
</script>

<template>
    <Head title="グループ順編集" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                グループ順編集
            </h2>
        </template>

        <div class="py-12 PageContent">
          <div class="h-full mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="PageContentLayout">
              <section id="GroupOrderContainer" class="GroupOrderContainer">
                <article id="GroupOrderListWrapper" class="GroupOrderListWrapper">
                  <header class="GroupOrderListHeader">
                    <h3 class="GroupOrderListHeading">グループ名</h3>
                  </header>

                  <div class="GroupOrderListContainer">
                    <ul v-if="props.groups.length !== 0" class="GroupOrderList">
                      <li v-for="group in props.groups" :key="group.id" class="GroupOrderListItem Group--isDraggable">
                        <div class="GroupOrderListItemContent">
                          <h4 class="GroupOrderListItemHeading">{{ group.name }}</h4>
                          <div class="DragHandle"></div>

                          <div class="Pattern Pattern--typeHalftone"></div>
                          <div class="Pattern Pattern--typePlaced"></div>
                        </div>
                      </li>
                    </ul>
                    <div v-else class="flex justify-center items-center px-4 h-full">
                      <p>グループがありません</p>
                    </div>
                  </div>
                </article>
              </section>
            </div>
          </div>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="scss">
.draggable--is-dragging,
.draggable--is-dragging * {
  cursor: grabbing;
}

.PageContent {
  height: calc(100% - 64px - 73px);
  color: #ffffff;
}

.PageContentLayout {
  height: 100%;
  overflow: hidden;
  background-color: #ffffff;
  box-shadow: 0 0 #0000, 0 0 #0000, 0 1px 2px 0 rgb(0 0 0 / 0.1);

  @media screen and (min-width: 640px) {
    border-radius: 0.5rem;
  }
}

.GroupOrderContainer {
  padding: 1.5rem;
  max-width: 80%;
  width: 100%;
  height: 100%;
  margin-left: auto;
  margin-right: auto;
}

.GroupOrderListWrapper {
  display: flex;
  flex-direction: column;
  height: 100%;
  width: 100%;
  border-radius: 0.5rem;
  overflow: hidden;
  box-shadow: 0 0 #0000, 0 0 #0000, 0 1px 2px 0 rgb(0 0 0 / 0.1);
}

.GroupOrderListHeader {
  flex: 0 0 4rem;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 1rem;
  background-color: #111827;
}

.GroupOrderListHeading {
  color: currentColor;
  font-size: 1.2rem;
  font-weight: 700;
}

.GroupOrderListContainer {
  flex: 1 1 auto;
  overflow: hidden;
  padding-top: 1rem;
  padding-bottom: 1rem;
}

.GroupOrderList {
  height: 100%;
  overflow: scroll;
  display: flex;
  flex-direction: column;
  flex-wrap: nowrap;
  gap: 1rem;
  padding-left: 1rem;
  padding-right: 1rem;
}

.GroupOrderListItem {
  width: 100%;
}

.GroupOrderListItemContent {
  position: relative;
  display: flex;
  align-items: center;
  padding: 0.6rem;
  background-color: #5cb85c;
  border-radius: 0.5rem;
}

.GroupOrderListItemHeading {
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

.Group--isDraggable {
  cursor: grab;

  &:focus {
    outline: none;
  }

  &:focus,
  &:hover {
    .GroupOrderListItemContent {
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
    .GroupOrderListItemContent {
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
    .GroupOrderListItemContent {
      .Pattern--typePlaced {
        opacity: 1;
        visibility: visible;
        animation-play-state: running;
      }
    }
  }

  &.draggable-mirror {
    z-index: 9999;

    .GroupOrderListItemContent {
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
